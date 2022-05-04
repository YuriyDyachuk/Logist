<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;

use App\Services\LiqPayService;
use App\Services\SubscriptionService;
use App\Services\AmplitudeService;

use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionStatus;
use Rinvex\Subscriptions\Models\Plan;

use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccess;

use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
	private $paypal;
	private $liqpay;
	private $planDefault = 1;

	/**
	 * PaymentController constructor.
	 */
	public function __construct() {
		$this->liqpay = new LiqPayService();
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request){

		$user = Auth::user();
		$subscriptions = Plan::with('features')->get();

		$date_at = '';

		$active_subscription = $user->company->subscription(SubscriptionService::getSlug($user));

		$activa_plan = Plan::find($active_subscription->plan_id);
		$selected_subscription = $activa_plan;
		$as_id=$activa_plan['id'];
		$as_prica_by_car=$activa_plan['price'];
		$as_month_count=1;
//		$as_count_car=$active_subscription->getFeatureValue('tms_control_transports');
		$as_count_car = SubscriptionService::checkFeatureUsage('transports');
		$date_at = date('d.m.Y', strtotime($active_subscription->ends_at));

		$transaction = null;
		if($user->isLogistic()) {
			$transaction = Transaction::whereUserId( $user->id )->get();
		}

		return view('pay.index', compact('subscriptions', 'user', 'selected_subscription', 'active_subscription', 'as_id', 'as_prica_by_car', 'as_month_count', 'as_count_car', 'date_at', 'transaction'));
	}

	public function getById(Request $request){
		$subscription = Plan::find($request->id);

		return response()->json($subscription);
	}

	public function change(Request $request, $planid, $userid = null) {
		$plan = Plan::find($planid);

		if(!$plan){
			return redirect()->route('orders.index');
		}

		$user = Auth::user();
		SubscriptionService::addUpdateSubscription($user->id, $planid);

		if($planid == $this->planDefault){
			$this->getLiqPayCancel();
		}

		return redirect()->route('pay.index');
	}

	public function getParamForFormLiqPay(Request $request) {

		$subscription = Plan::find($request->get('subscription_id'));

		$order_id = SubscriptionService::getSubscription()->id.'__'.bin2hex(random_bytes(5));

		$this->getLiqPayCancel();

		$transaction = Transaction::create([
			'user_id' => Auth::user()->id,
			'count_transport' => $request->get('transport_input'),
			'payment_status_id' => 1,
			'amount' => $request->get('amount'),
			'plan_id' => $request->get('subscription_id'),
			'currency'       => 'UAH',
			'description'    => 'Оплата плана `' . $subscription->name . '` стоимоть: ' . $subscription->price . '/авто; кол-во: '.$request->get('transport_input'),
			'order_id' => $order_id
		]);

		$liqPayArray = [
			'action'         => 'subscribe',
			'amount'         => $request->get('amount'),
			'currency'       => 'UAH',
			'description'    => 'Оплата плана `' . $subscription->name . '` стоимость: ' . $subscription->price . '/авто; кол-во: '.$request->get('transport_input'),
			'order_id'       => $order_id,
			'version'        => '3',
			'subscribe'      => 1,
			'subscribe_periodicity' => 'month',
			'subscribe_date_start'  => date('Y-m-d H:i:00'),
			'result_url'     => \Config::get('app.url') . '/pay/liqpay/callback',
			'server_url'     => \Config::get('app.url') . '/pay/liqpay/callback'
		];

		innlogger_pay('TO liqPay------------------------'); //TODO TEST
		innlogger_pay(print_r($liqPayArray,1));

		$data = $this->liqpay->cnb_form_raw($liqPayArray);

		return response()->json($data);
	}

	public function getLiqPayCancel(){
		$user = auth()->user();

		$transaction = Transaction::whereUserId($user->id)->whereType('regular')->get()->last();

		$result = false;

		if($transaction){

			$orderId = $transaction->order_id;

			$data = [
				'version' => 3,
				'action' => 'unsubscribe',
				'order_id' => $orderId
			];

			$result = $this->liqpay->api('request', $data);

			if($result->result == 'error'){
				innlogger_pay('FROM liqPay ERROR------------------------'); //TODO TEST
				innlogger_pay(print_r( $result ,1));
				return;
			}

			$data = $this->liqpay->decode_params($result);

			$transaction_id = $data['transaction_id'];
			$order_id_full = $data['order_id'];
			$order_id = explode('__', $data['order_id'])[0];

			$create_date_str = strlen($data['create_date']);

			if( $create_date_str > 10)
				$data['create_date'] = date('Y-m-d H:i:s', mb_substr($data['create_date'], -$create_date_str, 10));

			$this->transactionStatus($transaction_id, $order_id, $data['status'], $data);

			$transaction = Transaction::whereOrderId($order_id_full)->get()->last();
			$transaction->update($data);

		}

		return response()->json(['result' => $result]);
	}

	public function callbackLiqPay(Request $request) {
		innlogger_pay('FROM liqPay------------------------'); //TODO TEST
		innlogger_pay(print_r(json_decode(base64_decode( $request->data )),1));

		if (!$this->liqpay->check_signature($request->all())) {
			innlogger_pay('invalid signature');
			return;
		}

		$data = $this->liqpay->decode_params($request->data);

//		$transaction_id = explode('__', $data['order_id'])[0];

		$order_id_full = $data['order_id'];
		$order_id = explode('__', $data['order_id'])[0];

		$transaction_id = isset($data['transaction_id']) ? $data['transaction_id'] : null;

		$create_date_str = strlen($data['create_date']);

		if( $create_date_str > 10)
			$data['create_date'] = date('Y-m-d H:i:s', mb_substr($data['create_date'], -$create_date_str, 10));

		$this->transactionStatus($transaction_id, $order_id, $data['status'], $data);

		$transaction = Transaction::whereOrderId($order_id_full)->get()->last();

		$transaction->update($data);

		switch ($data['status']) {
			case 'error':
			break;
			case 'failure':
				return redirect()->route('pay.index');
			break;
			case 'reversed':
			break;
			case 'subscribed':
				SubscriptionService::addUpdateSubscription($transaction->user_id, $transaction->plan_id, $transaction->count_transport);
				$this->sendMailMsg('subscribed', $transaction->user_id);
				(new AmplitudeService())->simpleRequest('Subscription paid');
			break;
			case 'success':
				SubscriptionService::addUpdateSubscription($transaction->user_id, $transaction->plan_id, $transaction->count_transport);
				$this->sendMailMsg('success', $transaction->user_id);
				(new AmplitudeService())->simpleRequest('Subscription paid');
			break;
			case 'unsubscribed':
				SubscriptionService::cancelSubscription($transaction->user_id);
			break;
		}

		return redirect()->route('pay.index');
	}

	/**
	 * Send Email MSG
	 *
	 * @param $type
	 * @param $user_id
	 */
	private function sendMailMsg($type, $user_id){

		$user = User::findOrFail($user_id);

		if($type == 'subscribed' || $type == 'success'){
			Mail::to($user->email)->send(new PaymentSuccess($user));
		}
	}

	private function transactionStatus($transaction_id, $order_id, $status, $data){
		TransactionStatus::create([
			'transaction_id' => $transaction_id,
			'order_id' => $order_id,
			'status' => $status,
			'responce' => json_encode($data),
		]);
	}
}
