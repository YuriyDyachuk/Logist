<?php

namespace App\Services\ExternalFreight;

class LardiTransService {

    public static function getList($name) {

        include('simple_html_dom.php');

        switch ($name) {

            case 'larditrans_country':

             $html = simplexml_load_file('http://api.lardi-trans.com/api/?method=auth&login=volodia-1&password=d89d84e1bbced1e2c5d0ef39a6eeefa7');

             $country = simplexml_load_file('http://api.lardi-trans.com/api/?method=base.country&sig='.$html->sig);

             $areas = json_decode(json_encode($country), TRUE);

             $item = [];

              foreach ($areas['item'] as $key=>$area) {

	         $item[$area['id']] = $area['name'].'('.$area['sign'].')';

               }

                break;

            case 'larditrans_sities':

              $item = file_get_contents ('https://lardi-trans.com/distance/ajax/?q='.$_GET['q'].
                      '&countrySIGN='.substr($_GET['countrySIGN'], (stripos($_GET['countrySIGN'], '('))+1, 2).
                      '&areaId='.$_GET['areaId']);

              $item = explode("\n", str_replace("\r", '', $item));

              $last = array_pop($item);

              $item2 = [];

              for($i=0, $col=count($item); $i < $col; $i++)
              {
                  $item2[] = explode("|", $item[$i]);
              }

              $item = $item2;

                break;

            case 'larditrans_avto':

             $html = simplexml_load_file('http://api.lardi-trans.com/api/?method=auth&login=volodia-1&password=d89d84e1bbced1e2c5d0ef39a6eeefa7');

             $country = simplexml_load_file('http://api.lardi-trans.com/api/?method=body.type&sig='.$html->sig);

             $areas = json_decode(json_encode($country), TRUE);

             $item = [];

              foreach ($areas['item'] as $key=>$area) {

	         $item[$area['id']] = $area['name'];

               }

                break;

            case 'larditrans_areas':

               $html = simplexml_load_file('http://api.lardi-trans.com/api/?method=auth&login=volodia-1&password=d89d84e1bbced1e2c5d0ef39a6eeefa7');
               $country = simplexml_load_file('http://api.lardi-trans.com/api/?method=base.country&sig='.$html->sig);
               $areas = json_decode(json_encode($country), TRUE);

               $item = [];

               foreach ($areas['item'] as $key=>$area) {

                   if(isset($area['areas']['area'])) {
                       foreach ($area['areas']['area'] as $key2=>$oblast) {

                           $item[$area['id']][$key2]['id'] = $oblast['id'];
                           $item[$area['id']][$key2]['name'] = $oblast['name'];

                        }
                    }
                }

                break;

            case 'larditrans_orders':

                $html = file_get_html('https://lardi-trans.com/gruz/?foi=&filter_marker=new&countryfrom='.
                        substr($_GET['countryfrom'], (stripos($_GET['countryfrom'], '('))+1, 2).'&countryto='.
                        substr($_GET['countryto'], (stripos($_GET['countryto'], "("))+1, 2).'&areafrom='.
                        $_GET['areafrom'].'&areato='.
                        $_GET['areato'].'&cityFrom='.
                        $_GET['cityFrom'].'&cityIdFrom='.
                        $_GET['cityFromId'].'&cityTo='.
                        $_GET['cityTo'].'&cityIdTo='.
                        $_GET['cityToId'].'&dateFrom='.
                        $_GET['dateFrom'].'&dateTo='.
                        $_GET['dateTo'].'&bt_chbs_slc=&strictBodyTypes=on&mass='.
                        $_GET['mass'].'&mass2='.
                        $_GET['mass2'].'&value='.
                        $_GET['value'].'&value2='.
                        $_GET['value'].'&gabDl=&gabSh=&gabV=&zagruzFilterId=&adr=-1&showType=all&sortByCountriesFirst=on&startSearch=%D0%A1%D0%B4%D0%B5%D0%BB%D0%B0%D1%82%D1%8C+%D0%B2%D1%8B%D0%B1%D0%BE%D1%80%D0%BA%D1%83&notFirstLoad=done&page=1');

                  foreach ($html->find('.find-count') as $count) {

                      preg_match_all("/\d+/", $count->innertext, $matches);

                    if(!isset($matches[0][1])) {
                       $item = array (
                                   'status' => 'error',
                                   'message' => 'Data is empty!'
                               );
                        return $item;

                    }
                    $count_pages = $matches[0][0] / $matches[0][1];
                  }

                    if(!isset($count_pages)) {
                       $item = array (
                                   'status' => 'error',
                                   'message' => 'Filter is empty!'
                               );
                        return $item;
                    }

                $i      = 0;
                $item   = [];
                $params = array(
                    0  => "country",
                    1  => "date",
                    2  => "type",
                    3  => "from",
                    4  => "from_area",
                    5  => "to",
                    6  => "to_area",
                    7  => "gruz",
                    8  => "oplata",
                    9  => "empty2",
                    10 => "empty3",
                    11 => "empty4",
                    12 => "empty5",
                    13 => "empty6",
                );

                for ($page = 1; $page <= $count_pages; $page++) {

                $html = file_get_html('https://lardi-trans.com/gruz/?foi=&filter_marker=new&countryfrom='.
                        substr($_GET['countryfrom'], (stripos($_GET['countryfrom'], '('))+1, 2).'&countryto='.
                        substr($_GET['countryto'], (stripos($_GET['countryto'], '('))+1, 2).'&areafrom='.
                        $_GET['areafrom'].'&areato='.
                        $_GET['areato'].'&cityFrom='.
                        $_GET['cityFrom'].'&cityIdFrom='.
                        $_GET['cityFromId'].'&cityTo='.
                        $_GET['cityTo'].'&cityIdTo='.
                        $_GET['cityToId'].'&dateFrom='.
                        $_GET['dateFrom'].'&dateTo='.
                        $_GET['dateTo'].'&bt_chbs_slc=&strictBodyTypes=on&mass='.
                        $_GET['mass'].'&mass2='.
                        $_GET['mass2'].'&value='.
                        $_GET['value'].'&value2='.
                        $_GET['value2'].'&gabDl=&gabSh=&gabV=&zagruzFilterId=&adr=-1&showType=all&sortByCountriesFirst=on&startSearch=%D0%A1%D0%B4%D0%B5%D0%BB%D0%B0%D1%82%D1%8C+%D0%B2%D1%8B%D0%B1%D0%BE%D1%80%D0%BA%D1%83&notFirstLoad=done&page='.$page);

                    foreach ($html->find('.predl-search-res') as $element) {

                        foreach ($element->find('tbody') as $body) {
                            foreach ($body->find('tr.predlInfoRow') as $row) {

                                if (($row->find('br', 0)))
                                    continue;

                                foreach ($row->find('td.uiPredlClickableCell span') as $key2 => $td) {
                                    if ($key2 === 7) {

                                        $gruz = explode(',', $td->innertext);

                                        foreach ($gruz as $key_gruz => $gruz_detal) {
                                            if ($key_gruz === 0) {
                                                $gruz2['name'] = $gruz_detal;
                                                continue;
                                            }
                                            if ($key_gruz === 1) {
                                                $gruz_detal = str_replace("т", "", $gruz_detal);
                                                $gruz2['weight'] = $gruz_detal;
                                                continue;
                                            }
                                            if ($key_gruz === 2 && stristr($gruz_detal, 'м3')) {
                                                $gruz_detal = str_replace("м3", "", $gruz_detal);
                                                $gruz2['volume'] = $gruz_detal;
                                                continue;
                                            }

                                            if (stristr($gruz_detal, 'дл.')) {
                                                $gruz_detal = str_replace("дл.", "", $gruz_detal);
                                                $gruz2['length'] = preg_replace("/[^,.0-9]/", '', $gruz_detal);
                                                continue;
                                            }

                                            if (stristr($gruz_detal, 'шир.')) {
                                                $gruz_detal = str_replace("шир.", "", $gruz_detal);
                                                $gruz2['width'] = preg_replace("/[^,.0-9]/", '', $gruz_detal);
                                                continue;
                                            }

                                            if (stristr($gruz_detal, 'выс.')) {
                                                $gruz_detal = str_replace("выс.", "", $gruz_detal);
                                                $gruz2['height'] = preg_replace("/[^,.0-9]/", '', $gruz_detal);
                                                continue;
                                            }

                                            if (stristr($gruz_detal, 'загрузка')) {
                                                $gruz2['loading_type'] = $gruz_detal;
                                                continue;
                                            }


                                            $gruz2['other'] = $gruz_detal;

                                        }
                                        if(!isset($gruz2['volume'])) $gruz2['volume'] = '';
                                        if(!isset($gruz2['length'])) $gruz2['length'] = '';
                                        if(!isset($gruz2['width'])) $gruz2['width'] = '';
                                        if(!isset($gruz2['height'])) $gruz2['height'] = '';
                                        if(!isset($gruz2['loading_type'])) $gruz2['loading_type'] = '';
                                        if(!isset($gruz2['other'])) $gruz2['other'] = '';

                                        $item[$i][$params[$key2]] = $gruz2;
                                    }
                                    else {

                                        $item[$i][$params[$key2]] = $td->innertext;
                                    }
                                    //$item[$i][$params[$key2]] = ($key2 === 7) ? explode(',', $td->innertext) : $td->innertext;
                                }
                                foreach ($row->find('a.sm1') as $link) {
                                    $item[$i]['link'] = 'https://lardi-trans.com' . $link->href;
                                }

                                if(!isset($item[$i]['link'])) $item[$i]['link'] = '';

                                $i++;
                                $gruz2=[];
                            }
                        }
                    }
                }

                $html->clear();

                break;

            default:

                 $item = array (
                     'status' => 'error',
                     'message' => 'Invalid parameter: '.$name
                 );
        }

        //$item = json_encode($item, JSON_UNESCAPED_UNICODE);

        unset($html);

        return $item;
    }

}
