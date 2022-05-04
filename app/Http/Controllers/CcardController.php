<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ccards;
use Auth;
use Illuminate\Support\Facades\Crypt;

class CcardController extends Controller
{
    function is_valid_credit_card($s) {
        // оставить только цифры
        $s = strrev(preg_replace('/[^d]/','',$s));

        // вычисление контрольной суммы
        $sum = 0;
        for ($i = 0, $j = strlen($s); $i < $j; $i++) {
            // использовать четные цифры как есть
            if (($i % 2) == 0) {
                $val = $s[$i];
            } else {
                // удвоить нечетные цифры и вычесть 9, если они больше 9
                $val = $s[$i] * 2;
                if ($val > 9)  $val -= 9;
            }
            $sum += $val;
        }

        // число корректно, если сумма равна 10
        return (($sum % 10) == 0);
    }

    public static function get_cards_list($user_id)
    {
        $cards = Ccards::where('user_id', $user_id)->get();
        $data = [];
        foreach($cards as $key => $card)
        {
            $number = SELF::decode($card->n);
            $data[$key]['id'] = $card->id;
            $data[$key]['em'] = SELF::decode($card->em);
            $data[$key]['ey'] = SELF::decode($card->ey);
            $data[$key]['cvv'] = SELF::decode($card->cvv);
            $data[$key]['n_full'] = $number;
            $data[$key]['n'] = SELF::mask_card_number($number);
        }

        return $data;
    }

    public static function mask_card_number($number, $maskingCharacter = 'X')
    {
        return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
    }

    public function add_cc_ajax(request $request)
    {
        $n = $request->get('n');
        $em = $request->get('em');
        $ey = $request->get('ey');
        $cvv = $request->get('cvv');

        $user = Auth::user();

        $card = new Ccards();
        $card->n = SELF::encode($n);
        $card->em = SELF::encode($em);
        $card->ey = SELF::encode($ey);
        $card->cvv = SELF::encode($cvv);
        $card->user_id = $user->id;

        $card->save();
        $json = ['result' => true, 'msg' => 'ok'];
        return $json;
    }


    public function remove_cc_ajax(request $request)
    {
        $id = $request->get('id');
        $user = Auth::user();

        $card = Ccards::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
        if(count($card)>0)
        {
            $card->delete();
            $json = ['result' => true, 'msg' => 'ok'];
        }
        else
        {
            $json = ['result' => false, 'msg' => "Card not found"];
        }
        return $json;
    }


    public function edit_cc_ajax(request $request)
    {
        $id = $request->get('id');
        $n = $request->get('n');
        $em = $request->get('em');
        $ey = $request->get('ey');
        $cvv = $request->get('cvv');
        $user = Auth::user();

        $card = Ccards::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        $card->n = SELF::encode($n);
        $card->em = SELF::encode($em);
        $card->ey = SELF::encode($ey);
        $card->cvv = SELF::encode($cvv);
        $card->user_id = $user->id;

        $card->save();
        $json = ['result' => true, 'msg' => 'ok'];
        return $json;
    }



    /*
    * ENCODER\DECODER
    */

    public static function encode($str)
    {
        $encrypted = Crypt::encryptString($str);
        return $encrypted;
    }

    public static function decode($str)
    {
        $decrypted = Crypt::decryptString($str);
        return $decrypted;
    }

    /*
     * ENCODER\DECODER END
     */



}
