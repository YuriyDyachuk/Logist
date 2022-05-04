<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Services\GoogleService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Get place predictions
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocomplete(Request $request)
    {
        $service = new GoogleService($request->get('lang', \App::getLocale()));
        $data    = $service->autocomplete($request->get('input'));

	    if($data['status'] == 'ZERO_RESULTS'){
		    $data = $service->autocomplete_latlng($request->get('input'));
	    }

        return response()->json($data);
    }

    /**
     * Get more details about a point of interest
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function placeDetails(Request $request)
    {
        $place = Address::query()
            ->where('place_id', $request->get('place_id'))->first();

        if ($place === null) {
            $service = new GoogleService($request->get('lang', \App::getLocale()));
            $data    = $service->placeDetails($request->get('place_id'));

            $url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=".$data['result']['place_id']."&components=country:".config('google.country')."&key=".config('google.api_key').'&language='.config('google.language');
            $res = json_decode($service->getCurl($url));

            if ($res->status === 'OK') {
           $address_components=$res->result->address_components;
           $street='';
           $hous='';
           $city='';
           $country='';
           $state='';
           foreach ($address_components as $address_component)
           {
               $type=(string)$address_component->types[0];
               switch ($type)
               {
                   case 'route':
                       $street=(string)$address_component->long_name;
                   break;
                   case 'street_number':
                       $hous=(string)$address_component->long_name;
                   break;
                   case 'locality':
                       $city=(string)$address_component->long_name;
                   break;
                   case 'country':
                       $country=(string)$address_component->long_name;
                   break;
                   case 'administrative_area_level_1':
                       $state=(string)$address_component->long_name;
                   break;
               }
           }
           $amc_type=self::type_of_address($res->result);
           if ($amc_type===1)
           {
               $place_new = $city.($street?', '.$street:'').($hous?', '.$hous:'');
           }
           elseif ($amc_type===2)
           {
               $place_new = $city.', '.$res->result->name.($street?', '.$street:'').($hous?', '.$hous:'');
           }
           else
           {
               $place_new = $res->result->name;
           }

                $place = Address::query()->create([
                    'place_id' => $data['result']['place_id'],
                    'address'  => $data['result']['formatted_address'],
                    'lat'      => $data['result']['geometry']['location']['lat'],
                    'lng'      => $data['result']['geometry']['location']['lng'],
                    'name'     => $place_new,
                  'type'       => $amc_type,
                  'house'      => $hous,
                  'street'     => $street,
                  'city'       => $city,
                  'state'      => $state,
                  'country'    => $country,

                ]);
            }
        }

        return response()->json($place);
    }

   public static function type_of_address($result) {
        $amc_type = 0;
        foreach ($result->types as $item) {
            if ((string) $item == 'premise' || (string) $item == 'street_address' || (string) $item == 'route') {
                $amc_type = 1;
            }

            if ((string) $item == 'point_of_interest' || (string) $item == 'establishment') {
                $amc_type = 2;
                break;
            }
        }
        return $amc_type;
    }

}
