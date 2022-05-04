<?php

namespace App\Traits;

trait OrderRelations
{
    /**
     * @param array $data
     * @return void
     */
    public function relationships($data)
    {
        $countData = count($data);

        for ($i = 0; $i < $countData; $i++) {
//            $data[$i]['payment']             = $data[$i]->payment;
//            $data[$i]['cargo']               = $data[$i]->cargo();
//            $data[$i]['places']              = $data[$i]->placesDelivery();
            $data[$i]['client']              = $data[$i]->client()->first();
            $data[$i]['offers_count']        = $data[$i]->offers->count();
            $data[$i]['suitable_count']      = $data[$i]->suitable->count();

            if ($ex = $data[$i]->performers()->first()) {
                $data[$i]['additional_download'] = $data[$i]->performers()->first()->pivot->additional_download;
            }

            // Get transport's number
            if ($data[$i]->transports->count()) {
                $data[$i]->transport_number = $data[$i]->transports[0]->getNumber();
            } else {
                $data[$i]->transport_number = null;
            };
        }
    }
}