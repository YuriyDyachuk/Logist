<?php

namespace App\Services;


class GoogleService
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $language;

    /**
     * GoogleService constructor.
     *
     * @param string $language
     */
    public function __construct($language = 'ru')
    {
        $this->apiKey  = config('google.api_key');
        $this->baseUrl = config('google.base_url');

        $this->setLanguage($language);
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language)
    {
        $lang = $this->getLanguages();
        $key  = array_search($language, $lang);

        if ($key !== false) {
            $this->language = $lang[$key];
        } else {
            $this->language = config('google.language');
        }
    }

    /**
     * Supported Languages
     *
     * @link https://developers.google.com/maps/faq#languagesupport
     *
     * @return array
     */
    public function getLanguages(): array
    {
        return ['uk', 'ru', 'en'];
    }

    /**
     * The Place Autocomplete service is a web service that returns
     * place predictions in response to an HTTP request.
     * The request specifies a textual search string.
     *
     * @link https://developers.google.com/places/web-service/autocomplete)
     *
     * @param string $input
     * @return array
     */
    public function autocomplete($input)
    {
        $query = [
            'key'        => $this->apiKey,
            'type'       => 'geocode',
            'language'   => $this->language,
            'input'      => $input,
        ];

	    innlogger_google('autocomplete');

        $url = $this->baseUrl . 'place/autocomplete/json?' . http_build_query($query);

        return json_decode($this->getCurl($url), true);
    }

	public function autocomplete_latlng($input)
	{
		$input = str_replace(' ', '', $input);

		$query = [
			'key'        => $this->apiKey,
			'language'   => $this->language,
			'latlng'      => $input,
		];

		innlogger_google('autocomplete_latlng');

		$url = $this->baseUrl . 'geocode/json?' . http_build_query($query);

		return json_decode($this->getCurl($url), true);
	}

    /**
     * Once you have a place_id from a Place Search, you can request more details
     * about a point of interest by initiating a Place Details request.
     *
     * @link https://developers.google.com/places/web-service/details
     *
     * @param $place
     * @return mixed
     */
    public function placeDetails($place)
    {
        $query = [
            'key'        => $this->apiKey,
            'language'   => $this->language,
            'placeid'    => $place,
        ];

	    innlogger_google('placeDetails');

        $url = $this->baseUrl . 'place/details/json?' . http_build_query($query);

        return json_decode($this->getCurl($url), true);
    }

    /**
     * The Distance Matrix API is a service that provides travel distance and time for a matrix of origins
     * and destinations, based on the recommended route between start and end points.
     *
     * @link https://developers.google.com/maps/documentation/distance-matrix/intro
     * @param string $origins
     * @param string $destinations
     * @param string $mode
     * @return integer Meters
     */
    function getDrivingDistance($origins = 'lat,lng', $destinations = 'lat,lng', $mode = 'driving')
    {
        $query = [
            'key'          => $this->apiKey,
            'origins'      => $origins,
            'destinations' => $destinations,
            'mode'         => $mode,
        ];

        $url  = $this->baseUrl . 'distancematrix/json?' . http_build_query($query);
        $data = json_decode($this->getCurl($url), true);

        if ($data['status'] == 'OK') {
            return $data['rows'][0]['elements'][0]['distance']['value'];
        }
    }

    function getDrivingDistanceTime($origins = 'lat,lng', $destinations = 'lat,lng', $mode = 'driving')
    {
        $query = [
            'key'          => $this->apiKey,
            'origins'      => $origins,
            'destinations' => $destinations,
            'mode'         => $mode,
        ];

        $url  = $this->baseUrl . 'distancematrix/json?' . http_build_query($query);
        $data = json_decode($this->getCurl($url), true);

        if ($data['status'] == 'OK') {
            if($data['rows'][0]['elements'][0]['status'] == 'OK') {
                return [
                    'distance' => $data['rows'][0]['elements'][0]['distance']['value'],
                    'duration' => $data['rows'][0]['elements'][0]['duration']['value'],
                ];
            } else {
                return [
                    'distance' => 0,
                    'duration' => 0,
                ];
            }
        }
    }

    /**
     * @param $url
     * @return mixed
     */
    public function getCurl($url)
    {
	    innlogger_google($url);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    /**
     * Reverse Google Polyline algorithm on encoded string.
     *
     * @link https://github.com/emcconville/google-map-polyline-encoding-tool/blob/master/src/Polyline.php
     *
     * @param string $string Encoded string to extract points from.
     * @return array points
     */
    public static function polylineDecode($string)
    {
        $precision = 5;

        $points   = array();
        $index    = $i = 0;
        $previous = [0, 0];

        while ($i < strlen($string)) {
            $shift = $result = 0x00;
            do {
                $bit    = ord(substr($string, $i++)) - 63;
                $result |= ($bit & 0x1f) << $shift;
                $shift  += 5;
            } while ($bit >= 0x20);

            $diff                 = ($result & 1) ? ~($result >> 1) : ($result >> 1);
            $number               = $previous[$index % 2] + $diff;
            $previous[$index % 2] = $number;
            $index++;
            $points[] = $number * 1 / pow(10, $precision);
        }

        return is_array($points) ? array_chunk($points, 2) : array();
    }

    public function getAddressByCoordinates($lat,$lng){

	    $query = [
		    'key'          => $this->apiKey,
		    'language'   => $this->language,
		    'latlng'       => $lat.','.$lng,
	    ];

	    innlogger_google('getAddressByCoordinates');

	    $url  = $this->baseUrl . 'geocode/json?' . http_build_query($query);
	    $data = json_decode($this->getCurl($url), true);
	    if($data['results']){
			return $data['results'][1]['formatted_address'];
	    }
	    return false;
    }

    public function getRoutePoints($origin = 'lat,lng', $destination = 'lat,lng'){

        $query = [
            'key'          => $this->apiKey,
            'origin'       => $origin,
            'destination'  => $destination,
        ];

        $url  = $this->baseUrl . 'directions/json?' . http_build_query($query);
        $data = json_decode($this->getCurl($url), true);

        $points=[];

        if ($data['status'] == 'OK') {

            $encoded = $data['routes'][0]['overview_polyline']['points'];
            $points = array_merge($points, self::polylineDecode($encoded));
        }

        return $points;
    }

    /**
     * Rebuild route from $origin to $destination, and include waypoints
     * Return directions points and waypoints in optimized order
     *
     * @param $origin
     * @param $destination
     * @param $waypoints
     * @return array|bool
     */
    public function rebuildRoute($origin, $destination, $waypoints)
    {
        $waypointsQuery = '';
        foreach ($waypoints as $waypoint) {
            $waypointsQuery .= '|' . $waypoint[0] . ',' .$waypoint[1];
        }
        $query = [
            'key'          => $this->apiKey,
            'origin'       => $origin,
            'destination'  => $destination,
        ];
        if (!empty($waypoints)) {
            $query['waypoints'] = 'optimize:true' . $waypointsQuery;
        }

	    innlogger_google('rebuildRoute');

        $url  = $this->baseUrl . 'directions/json?' . http_build_query($query);
        $data = json_decode($this->getCurl($url), true);

        if ($data['status'] === 'OK') {
            $overviewPolyline = $this->buildPolyLine($data);
            $directions = $this->getDirectionsFromPolyLine($overviewPolyline);

            if (!empty($directions)) {
                $orderedWaypoints = $this->reorderWayPoints($waypoints, $data['routes'][0]['waypoint_order']);

                return [
                    'directions' => $directions,
                    'waypoints' => $orderedWaypoints
                ];
            }

            return false;
        }

        return false;
    }

    /**
     * @param        $overviewPolyline
     * @param string $delimiter
     * @return array
     */
    private function getDirectionsFromPolyLine($overviewPolyline, $delimiter = ':::'): array
    {
        $directions = [];
        $legs       = explode($delimiter, $overviewPolyline);
        foreach ($legs as $leg) {
            if (empty($leg)) {
                continue;
            }

            $path = self::polylineDecode($leg);
            $directions = array_merge($directions, $path);
        }

        return $directions;
    }

    /**
     * @param        $data
     * @param string $delimiter
     * @return bool|string
     */
    private function buildPolyLine($data, $delimiter = ':::')
    {
        $overviewPolyline = '';

        if (isset($data['routes'][0]['legs'])) {
            foreach ($data['routes'][0]['legs'] as $leg) {
                foreach ($leg['steps'] as $step) {
                    $overviewPolyline .= $step['polyline']['points'] . $delimiter;
                }
            }

            return $overviewPolyline;
        }

        return false;
    }

    /**
     * @param $waypoints
     * @param $order
     * @return array
     */
    private function reorderWayPoints($waypoints, $order): array
    {
        $orderedWaypoints = [];
        foreach ($order as $position => $index) {
            $orderedWaypoints[$position] = $waypoints[$index];
        }

        return $orderedWaypoints;
    }
}