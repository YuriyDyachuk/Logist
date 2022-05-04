<?php

namespace App\Validators;

use GuzzleHttp\Client as GuzzleClient;

class ReCaptcha
{
    public function validate($attribute, $value, $parameters, $validator){

        $parameter = $parameters[0];

        $client = new GuzzleClient();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify',
            ['form_params'=>
                [
                    'secret'=>$parameter,
                    'response'=>$value
                ]
            ]
        );
        $recaptcha  = json_decode((string)$response->getBody());

        logger($response->getBody());

        /* ReCaptcha v3 start*/
        if(isset($recaptcha->score) && $recaptcha->score >= 0.5)
            return true;

        if(isset($recaptcha->score) && $recaptcha->score < 0.5)
            return false;
        /* ReCaptcha v3 end*/

        if (isset($recaptcha->success) && $recaptcha->success == true) return true;

        return false;
//        return ($recaptcha->score >= 0.5) ? true : false;
    }
}