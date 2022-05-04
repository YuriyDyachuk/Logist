<?php

namespace App\Http\Controllers\Api\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

use App\Models\Order\Order;
use App\Models\Document\Document;
use App\Models\Order\OrderPerformer;
use App\Models\Status;

use App\Http\Controllers\ImageController as Image;

use App\Transformers\DocumentItemTransformer;
use App\Transformers\OrderTransformer;

use App\Enums\OrderStatus;


class DocumentController extends ApiController
{
	/**
	 * @OA\Post(
	 *      path="/api/v2/documents",
	 *      operationId="getDocuments",
	 *      tags={"Documents"},
	 *      summary="Get documents",
	 *      description="Returns documents",
	 *      @OA\Parameter(
	 *          name="order_id",
	 *          description="",
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
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getDocuments(Request $request){

		$transport = auth()->user();
		$status_id = Status::getStatusIdOrder(OrderStatus::ACTIVE);

		$order_transport = OrderPerformer::where('transport_id', $transport->id)
						->where('order_id', $request->order_id)
		                ->whereHas('order', function($q) use ($status_id){
							return $q->status($status_id);
		                })
						->with('order.documents')
						->first();

		if(!$order_transport)
			return $this->sendNotFoundResponse('Documents not found');

		$order = $order_transport->order;

		$orderTransformer = new OrderTransformer();
		$docs = $orderTransformer->getDataDocuments(['documents' => $order->documents, 'user' => $transport]);

		return $this->respondWithArray($docs);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function create(Request $request)
    {
        // Validation
        $validator = \Validator::make($request->all(), [
            'file'        => 'required',
            'template_id' => 'required',
            'order_id'    => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendInvalidFieldResponse($validator->errors());
        }

        // Upload file
        $file     = $request->file('file');
        $filename = time() . '_' . Image::encodeCyrillicToLatin($file->getClientOriginalName());
        $file->move(public_path('upload/documents/'), $filename);

        // Create document
        $document = Document::query()->create([
            'name'            => $request->name ?? 'template ' . $request->template_id,
            'filename'        => $filename,
            'template_id'     => $request->template_id,
            'user_id_added'   => \Auth::id(),
            'imagetable_id'   => $request->order_id,
            'imagetable_type' => Order::class,
        ]);

        return $this->respondWithItem($document, new DocumentItemTransformer);
    }

    /**
     * @param Request $request
     * @param $documentId
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(Request $request, $documentId)
    {
        // Validation
        $validator = \Validator::make($request->all(), ['file' => 'required']);

        if ($validator->fails()) {
            return $this->sendInvalidFieldResponse($validator->errors());
        }

        $file     = $request->file('file');
        $filename = time() . '_' . Image::encodeCyrillicToLatin($file->getClientOriginalName());
        $file->move(public_path('upload/documents/'), $filename);

        if ($documentId > 0) {
            $doc = Document::findOrFail($documentId);

            \File::delete(public_path() . '/upload/documents/' . $doc->filename);

            $doc->update(['filename' => $filename]);
            $doc->path = url('download/' . $filename);

            return $this->respondWithItem($doc, new DocumentItemTransformer);
        }

        return $this->sendInvalidFieldResponse('document_id');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        if ($document = Document::find($id)) {
            //Todo: can a driver delete the document?
            if ($document->user_id_added != \Auth::id()) {
                return $this->sendForbiddenResponse();
            }

            if ($document->filename) {
                \File::delete(public_path() . '/upload/documents/' . $document->filename);
            }

            $document->delete();

            return $this->sendCustomResponse(200, 'Deleted successfully.');
        }

        return $this->sendNotFoundResponse('Document not found');
    }
}
