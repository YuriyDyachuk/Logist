<?php

namespace App\Services\OpenData;

class OpendatabotService {

	private $apiKey, $url;

	public function __construct() {
		$this->apiKey  = config('opendata.opendatabot_ApiKey');
		$this->url  = config('opendata.opendatabot_Url');
	}

	public function sentRequest($request){

		$url = $request->url;
		$query = $request->param;

        logger($url);

		if(is_array($url)){
			$this->url .= implode('/', $url);
		}

		if(!is_array($url)){
			$this->url .= $url;
		}

		$this->url .= '?';

		if (!empty($query)){
			$this->url .= http_build_query($query);
			$this->url .= '&';
		}

		$this->url .= 'apiKey='.$this->apiKey;

        logger($this->url);

        $data = json_decode($this->getCurl(), true);

        logger($data);

		return $data;
	}

	public function getCurl()
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$response = curl_exec($ch);

		curl_close($ch);

		return $response;
	}

}