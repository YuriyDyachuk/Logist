<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\User;
use App\Models\Transport\Transport;
use App\Notifications\FillUncompletedStaff;
use App\Notifications\FillUncompletedTransport;

class CheckIfFillAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $user;

	/**
	 * to send notification if not fill
	 *
	 * @var array
	 */
	private $needToFillRemindUser = [
		'email',
	];

	/**
	 * to send notification if not fill meta_data
	 *
	 * @var array
	 */
	private $needToFillRemindUserMetaData = [
		'inn_number',
		'work_start',
		'driver_licence'
	];


	/**
	 * to send notification if not fill
	 * @used $this->checkIfFill
	 *
	 * App\Http\Job\CheckIfFillAccount
	 *
	 * @var array
	 */
	private $needToFillRemindTransport = [
		//'insurance_id', // can NULL
		//'condition', // can NULL
		//'status',
		'loading_type_id',
		'rolling_stock_type_id'
		//'gps_id', // can NULL
		//'tracker_imei' // can NULL
	];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
	    $this->user = User::find($userId);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	    $this->checkIfFillStaff();
	    $this->checkIfFillTransport();
    }

	private function checkIfFillStaff(){

		$needToFill = $this->needToFillRemindUser;
		$needToFillMetaData = $this->needToFillRemindUserMetaData;

		$users = User::where(function($query) use($needToFill, $needToFillMetaData)
		{
			foreach ($needToFill as $key => $val){
				$query->orWhere($val, null);
			}

			foreach ($needToFillMetaData as $key => $val){
				$query->orWhere('meta_data', 'like', '%"'.$val.'":null%');
			}

		})->get();

		if($users->isNotEmpty()){
			foreach ($users as $user){

				$notifications = $this->user->notifications()->where('type', 'App\Notifications\FillUncompletedStaff')->where('data', 'like', '%"user_id":'.$user->id.',%')->get();

				if($notifications->isEmpty())
					return;

				foreach ($notifications as $notification){
					if($notification)
						$notification->markAsRead();
				}

				$this->user->notify(new FillUncompletedStaff($user->id));
			}
		}
	}

	public function checkIfFillTransport()
	{
		$needToFill = $this->needToFillRemindTransport;
		$userId = $this->user->id;
		$transports = Transport::where(function($query) use($needToFill, $userId)
		{
			foreach ($needToFill as $key => $val){
				$query->orWhere($val, null);
			}

		})
		->whereUserId($userId)
		->get();


		if($transports->isNotEmpty()){
			foreach ($transports as $transport){

				$notifications = $this->user->notifications()->where('type', 'App\Notifications\FillUncompletedTransport')->where('data', 'like', '%"transport_id":'.$transport->id.',%')->get();

				if($notifications->isNotEmpty()){
					foreach ($notifications as $notification){
						$notification->markAsRead();
					}
				}

				$this->user->notify(new FillUncompletedTransport($transport->id));
			}
		}

		return $transports;
	}
}
