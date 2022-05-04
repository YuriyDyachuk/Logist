<?php

namespace App\Transformers;

use App\Enums\DocumentTypes;
use App\Models\Order\Order;
use App\Services\DataArraySerializer;
use App\Services\MobileIdService;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use App\Models\Address;

class OrderTransformer extends TransformerAbstract
{
    protected $user;
    protected $documents;

    protected $defaultIncludes = [
        'cargo', 'addresses',
    ];

    public function transform(Order $order)
    {
        $this->user      = \Auth::user();
        $this->documents = $order->documents;

        $progress_items = [];

//	    $progress_download_complete = false; // загрузка
//	    $progress_upload_complete = false; // выгрузка
//	    $progress_sign = null;

        //Add lat, lng to every progress point, if it have a correct address in DB, and transform to address model
        foreach($order->progress as $key => $item){
            /* if progress has address_id, then search by id, if not - then by address itself*/
            if(isset($item["address_id"]))
                $address = Address::where("id", $item["address_id"])->first();
            else
                $address = Address::where("address", $item["address"])->first();

            $progress_item = [
                'address' => [
                    "type"      => $item["type"],
                    "address"   => "",
                    'date_at'   => "",
                    'lat'       => null,
                    'lng'       => null,
                ],
                "completed" => $item['completed'],
                "name"      => $item['name'],
                "type"      => $item['type'],
                "position"  => $key,
            ];

            if(isset($item["position"]))    $progress_item["position"]  = $item["position"];
            if(isset($item["address"]["address"]))
                $progress_item["address"]["address"] = $item["address"]["address"];

            if(!is_null($address)){
                if(isset($item["date_at"]))
                    $progress_item["address"]["date_at"] = $item["date_at"];
                $progress_item["address"]["address"] = $address->address;
                $progress_item["address"]["lat"] = $address->lat;
                $progress_item["address"]["lng"] = $address->lng;
            } else {
                $progress_item["address"]["address"] = $item["address"];
                if(isset($item["date_at"]))
                    $progress_item["address"]["date_at"] = $item["date_at"];
            }
            $progress_items[] = $progress_item;

//            if($progress_item['type'] == 'download' && $progress_item['completed'] == 1)
//	            $progress_download_complete = true;
//
//	        if($progress_item['type'] == 'upload' && $progress_item['completed'] == 1)
//		        $progress_upload_complete = true;
        }

//        if($progress_download_complete === true && $progress_upload_complete === false){
//	        $progress_sign = 'loader';
//	        $doc = ['type' => DocumentTypes::WAYBILL, 'stage' => $progress_sign];
//        }
//
//	    if($progress_download_complete === true && $progress_upload_complete === true){
//		    $progress_sign = 'receiver';
//		    $doc = ['type' => DocumentTypes::WAYBILL, 'stage' => $progress_sign];
//	    }

        return [
            'id'            => $order->id,
            'inner_id'      => '#'.$order->inner_id.'('.$order->id.')',
            'current_price' => $order->amount_fact ?? $order->amount_plan,
            'currency'      => $order->currency,
            'payment_type'  => $order->payment_type,
            'payment_terms' => $order->payment_terms,
            'meta_data'     => $order->meta_data,
            'progress'      => $progress_items,
            'status'        => $order->status->name,
            'documents'     => [
                'templates' => [],
                'data'      => $this->getDataDocuments($doc ?? []),
                'files'     => $this->getFilesDocuments(),
            ],
            'client'        => [
                'name'  => $order->client->name,
                'phone' => $order->client->phone,
            ],
            'directions'    => $order->directions,
            'updated_at'    => $order->updated_at->timestamp,
        ];
    }

    /**
     * @param Order $order
     * @return \League\Fractal\Resource\Item
     */
    public function includeCargo(Order $order)
    {
        return $this->item($order->cargo, new CargoTransformer, false);
    }

    /**
     * @param Order $order
     * @return \League\Fractal\Resource\Collection
     */
    public function includeAddresses(Order $order)
    {
        return $this->collection($order->addresses, new AddressTransformer(), false);
    }

    /**
     * @param Order $order
     * @return array
     */
    public function getDataDocuments($data = [])
    {
        $manager = new Manager;
        $manager->setSerializer(new DataArraySerializer);

        if(!empty($data) && isset($data['documents'])){
			$this->documents = $data['documents'];
        }

	    if(!empty($data) && isset($data['documents'])){
			$this->user = $data['user'];
	    }

        $documents = $this->documents->filter(function ($doc) {
            return $doc->user_id_added != $this->user->id;
        });


        if(auth()->user()->getTable() == 'transports'){

			$docs_for_driver = [
				4, //OrderWaybill
	        ];

	        $documents = $this->documents->filter(function ($doc) use ($docs_for_driver) {
		        return in_array($doc->template_id, $docs_for_driver);
	        });
        }

//        foreach ($documents as $document){
//        	if($document->template_id === \App\Enums\DocumentTypes::WAYBILL) // TODO update in future
//            $document->status_sign = (new MobileIdService())->isSignedMobileId($document->id, $document->template_id);
//        }

        $resource = $this->collection($documents, new DocumentCollectionTransformer, false);

        return $manager->createData($resource)->toArray();
    }

    /**
     * @param Order $order
     * @return array
     */
    public function getFilesDocuments()
    {
        $manager = new Manager;
        $manager->setSerializer(new DataArraySerializer);

        $documents = $this->documents->filter(function ($doc) {
            return $doc->user_id_added == $this->user->id && $doc->template_id === 0;
        });

        $resource = $this->collection($documents, new DocumentItemTransformer, false);

        return $manager->createData($resource)->toArray();
    }
}