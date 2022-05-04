<?php

namespace App\Http\Controllers\Order;

use App\Models\Order\Order;
use App\Models\Image as ImageModel;
use App\Models\Status;
use App\Models\Document\Document;
use App\Http\Controllers\ImageController as Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem as File;
use App\Services\PDFService;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function create(Request $request)
    {

        if($request->hasFile('image')){
            // Upload file
            $file     = $request->file('image');
            $filename = time() . '_' . Image::encodeCyrillicToLatin($file[0]->getClientOriginalName());
            $file[0]->move(public_path('storage/documents/'), $filename);

            // Create document from upload file
            Document::query()->create([
                'name'            => $request->documentName,
                'filename'        => $filename,
                'user_id_added'   => \Auth::id(),
                'imagetable_id'   => $request->orderId,
                'imagetable_type' => Order::class,
            ]);
        }

        if($request->has('form_id')) {
          if($request->form_id !== "0") {

          PDFService::storeDocumentToFile($request->orderId, $request->form_id);
          }
        }

        $order = Order::query()->findOrFail($request->orderId);
        $html  = view('orders.partials.show.includes.list-documents')->with('order', $order)->render();

        return response()->json(['status' => 'success', 'html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $documentId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $documentId)
    {
        if ($file = $request->file('images')) {
            $filename = time() . '_' . Image::encodeCyrillicToLatin($file[0]->getClientOriginalName());
            $file[0]->move(public_path('storage/documents/'), $filename);

            if ($documentId > 0) {
                $doc = Document::findOrFail($documentId);

                app(File::class)->delete(public_path() . 'storage/documents/' . $doc->filename);

                $doc->update(['filename' => $filename]);
                $doc->path = url('download/' . $filename);
            }

            return response()->json(['status' => 'success', 'image' => $doc, 'msg' => trans('all.document_updated')]);
        }

        return response()->json(['status' => 'error', 'msg' => trans('all.document_not_updated')]);
    }
}
