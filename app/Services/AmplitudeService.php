<?php

namespace App\Services;


class AmplitudeService
{

    private $baseUrl = 'https//api.amplitude.com/2/httpapi';
    private $apiKey;
    private $api;

    public function __construct($language = 'ru')
    {
        $this->api  = config('amplitude.amplitude_api');
        $this->apiKey  = config('amplitude.amplitude_api_key');
        $this->baseUrl  = config('amplitude.amplitude_base_url');
    }

    public function simpleRequest($event_type){
        return $this->request($event_type);
    }

    public function request($event_type, $event_properties = false)
    {
		if($this->api === false)
			return false;

        $ch = curl_init($this->baseUrl);

        $data_array = [
            'api_key' => $this->apiKey,
            'events' => [
                'user_id' => auth()->user() ? auth()->user()->email : 'unregistered',
                'event_type' => $event_type,
            ],
        ];

        if($event_properties && is_array($event_properties)){
            $data_array['events']['user_properties'] = $event_properties;
        }

        $payload = json_encode( $data_array );

        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

//        logger(print_r($response,1));

        return ['code' => $httpcode, 'responce' => $response];
    }
}