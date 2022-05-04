<?php

namespace App\Http\Controllers;

use App\Translate;
use Illuminate\Http\Request;
use Cookie;
use Crypt;

class TranslateDBController extends Controller
{
//    public static function translate_specialization($items, $type)
//    {
//        foreach($items as $key => $item)
//        {
//            $lang = SELF::get_lang();
//
//            $data = Translate::where('type', $type)
//                ->where('lang', $lang)
//                ->where('item_id', $item['id']);
//
//            if($data->count()>0)
//            {
//                $translate = $data->first();
//                $items[$key]['name'] =   $translate->value;
//            }
//
//        }
//        return $items;
//    }
//
//    public static function translate_item($item, $type, $name)
//    {
//        $lang = SELF::get_lang();
//        $data = Translate::where('type', $type)
//            ->where('lang', $lang)
//            ->where('item_id', $item);
//        if($data->count()>0)
//        {
//            $translate = $data->first();
//            $item = $translate->value;
//        }
//        else
//        {
//            $item = $name;
//        }
//        return $item;
//    }
//
//    public static function get_lang()
//    {
//        $var = Cookie::get('locale_lang');
//        if($var==null)
//            $lang = 'ru';
//        else
//            $lang = $var;
//        return $lang;
//    }
}
