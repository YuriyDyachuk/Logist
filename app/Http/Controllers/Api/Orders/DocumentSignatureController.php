<?php

namespace App\Http\Controllers\Api\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\MobileIdService;
use App\Models\Document\Document;

use App\Models\Signature;

class DocumentSignatureController extends Controller
{

	public function __construct() {

	}

	/**
	 * @OA\Post(
	 *      path="/api/v2/signature",
	 *      operationId="signature",
	 *      tags={"Signature"},
	 *      summary="signature",
	 *      description="",
	 *      @OA\Parameter(
	 *          name="document_id",
	 *          description="document_id",
	 *          required=true,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Parameter(
	 *          name="phone",
	 *          description="phone",
	 *          required=false,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Response(
	 *          response=200,
	 *          description="Successful operation",
	 *       ),
	 *      @OA\Response(
	 *          response=404,
	 *          description="Not found",
	 *      ),
	 *      @OA\Response(
	 *          response=500,
	 *          description="Error in gateway connection: Request delivery failed: timeout when waiting for response",
	 *      )
	 *     )
	 */
	public function index(Request $request, MobileIdService $mobile_service) {

        $validator = \Validator::make($request->all(), [
            'phone' => 'nullable',
            'role_id' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'erorrs' => $validator->errors()], 404);
        }

		if($request->document_id){
			$document = Document::find($request->document_id);

			if(!$document){
				return response()->json(['result' => 'Not found'], 404);
			}

			$user = auth()->user()->drivers->first();
			$transaction_id = $mobile_service->sendNew($user, $document, $request->phone, $request->role_id);

			if(is_array($transaction_id)){
				return response()->json(['result' => false, 'status' => $transaction_id[0]], 500);
			}

			return response()->json(['result' => true, 'transaction_id' => $transaction_id], 200);
		}

		return response()->json(['result' => false], 404);
	}

	/**
	 * @OA\Post(
	 *      path="/api/v2/signature/check",
	 *      operationId="signatureCheck",
	 *      tags={"Signature"},
	 *      summary="signature check Kyivstar",
	 *      description="",
	 *      @OA\Parameter(
	 *          name="sign",
	 *          description="signature id",
	 *          required=true,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Response(
	 *          response=200,
	 *          description="Successful operation",
	 *       ),
	 *      @OA\Response(
	 *          response=404,
	 *          description="Not found",
	 *      )
	 *     )
	 */
	public function check(Request $request, MobileIdService $mobile_service){
		$time = $request->time !== null ? $request->time : false;
		$attempt = $request->attempt !== null? $request->attempt : 0;

		$response = $mobile_service->checkStatus($request->sign, $attempt, $time);

		return response()->json($response);
	}

	/**
	 * @OA\Post(
	 *      path="/api/v2/signature/is_signed",
	 *      operationId="signatureIsSigned",
	 *      tags={"Signature"},
	 *      summary="document signature check",
	 *      description="",
	 *      @OA\Parameter(
	 *          name="document_id",
	 *          description="document_id",
	 *          required=true,
	 *          in="header",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
	 *      @OA\Response(
	 *          response=200,
	 *          description="Successful operation",
	 *       ),
	 *      @OA\Response(
	 *          response=404,
	 *          description="Not found",
	 *      ),
	 *      @OA\Response(
	 *          response=500,
	 *          description="Error message",
	 *      )
	 *     )
	 */
	public function isSigned(Request $request){
		// TODO update in future

		$user = auth()->user()->drivers->first();

		$result = Signature::whereUserId($user->id)->where('document_id', $request->document_id)->get();
		$result->makeHidden(['mssp_transaction_id' , 'transaction_id', 'signature']);

		if($result->isNotEmpty()){
			return response()->json($result);
		}

		return response()->json(['result' => false], 404);
	}
}
