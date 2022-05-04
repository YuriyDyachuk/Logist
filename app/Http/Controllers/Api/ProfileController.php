<?php

namespace App\Http\Controllers\Api;


use App\Models\Transport\Category;
use App\Models\Transport\RollingStockType;
use App\Transformers\ProfileTransformer;
use App\Models\User;
use JWTAuth;
use App\Models\Document\DocumentType;

use Illuminate\Http\Request;
use App\Http\Controllers\ImageController;

class ProfileController extends ApiController
{

	/**
	 * @OA\Get(
	 *      path="/api/v2/profile",
	 *      operationId="getProfileInfo",
	 *      tags={"Profile"},
	 *      summary="Get profile info",
	 *      description="Returns profile info",
	 *      @OA\Response(
	 *          response=200,
	 *          description="Driver Info",
	 *       )
	 *     )
	 */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transport = \Auth::user();
        $driver    = $transport->drivers()
            ->with('images')
            ->with('documents')->first()->toArray();
//            ->with('documents')->first();

        // Additional
        $transport->company            = User::find($transport->user_id)->value('name');
        $transport->type               = trans('handbook.' . Category::getName($transport->category_id));
        $transport->rolling_stock_type = $transport->rolling_stock_type_id
            ? trans('handbook.' . RollingStockType::getName($transport->rolling_stock_type_id))
            : '';

	    $transport->rolling_stock_number = null;

	    $trailer = $transport->getAttachTrailer()->first();

	    if($trailer){
		    $transport->rolling_stock_number = $trailer->number;
	    }

	    $driver['avatar'] = '';
        if (!empty($driver['images'])) {
            $driver['avatar'] = ImageController::getPath('users', $driver['images'][0]['filename']);
            unset($driver['images']);
        }

        foreach ($driver['documents'] as $key => &$document) {
            $driver['documents'][$key]['name'] = DocumentType::find($document['document_type_id'])->value('name');
            $document['images'][$key] = ImageController::getPath('documents', $document['filename']);
        }

        $transport_image    = $transport->images()->first();
        $transport->avatar  = $transport_image ? url('storage/transports/'. $transport_image->filename) : null;

        return $this->respondWithItem(['transport' => $transport, 'driver' => $driver, 'lang' => $driver['locale']], new ProfileTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json('Not found', 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json('Not found', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json('Not found', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json('Not found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->json('Not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json('Not found', 404);
    }
}
