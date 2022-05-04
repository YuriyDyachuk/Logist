<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ProgressTransformer extends TransformerAbstract
{
	private static $langs = [
		'accepted' => 'progress_accepted',
		'download' => 'progress_loading',
		'inway' => 'progress_to_flight',
		'upload' => 'progress_unloading',
		'delivered' => 'progress_delivered',
	];


    public static function transform($progress)
    {

        foreach($progress as $key => $item){
            // TODO Remove in future START
            isset($item["address"]["address"]) && !is_null($item["address"]["address"]) ? $progress[$key]["address"] = $item["address"]["address"] : $progress[$key]["address"] = '---';

            isset($item["address"]["date_at"]) && !is_null($item["address"]["date_at"]) ? $progress[$key]["date_at"] = $item["address"]["date_at"] : $progress[$key]["date_at"] = '__/__/____';
            // TODO Remove in future END

            $progress[$key]["address"] = (isset($item["address"]) && !is_null($item["address"])) ? $item["address"] : $progress[$key]["address"] = '---';

            // TODO remove in future - for app
	        $progress[$key]["name"] = \Lang::get('all.'.self::$langs[$item['type']], [], 'ru');

            $progress[$key]["date_at"] = (isset($item["date_at"]) && !is_null($item["date_at"])) ?  $item["date_at"] : '__/__/____';

            $progress[$key]["lat"] = isset($item["lat"]) && !is_null($item["lat"]) ?  $item["lat"] : '';
            $progress[$key]["lng"] = isset($item["lng"]) && !is_null($item["lng"]) ?  $item["lng"] : '';
        }

        return $progress;
    }


	/**
	 * Update lang
	 *
	 * @param $progress
	 *
	 * @return array
	 */
	public static function transformLang($progress, $lang = null){

		foreach ($progress as $key => $item){
			if(isset($item['type']) && isset(self::$langs[$item['type']])){

				if($lang){
					$progress[$key]['name'] = \Lang::get('all.'.self::$langs[$item['type']], [], $lang);
				} else {
					$progress[$key]['name'] = trans('all.'.self::$langs[$item['type']]);
				}

			}
		}

		return $progress;
	}

}