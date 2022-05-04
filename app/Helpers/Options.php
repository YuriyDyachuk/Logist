<?php

namespace App\Helpers;

use App\Option;
use App\Http\Controllers\NotificationController;
use App\Models\User;
use Auth;
use App\Roles;
use App\Models\Image;
use App\Http\Controllers\ImagesConroller;

use App\Services\UserDataService;

class Options
{
    public static function get($name)
    {
        $op = Option::where('name', $name)->first();
        if (count($op) > 0) {
            return $op->value;
        } else {
            return '';
        }
    }

    public static function input_option($name, $value, $type, $params)
    {

        $p = [];
        if (!empty($params)) {
            $p_array = explode(';', $params);
            foreach ($p_array as $item) {
                $d = explode(':', $item);
                if (isset($d[1])) {
                    $p[$d[0]] = $d[1];
                }
            }
        }

        switch ($type) {
            case 1:
                return Options::generate_text_input($name, $value, $p);
                break;
            case 2:
                return Options::generate_number_input($name, $value, $p);
                break;
            case 3:
                return Options::generate_textarea_input($name, $value, $p);
                break;
            case 4:
                return Options::generate_select_input($name, $value, $p);
                break;
        }

        return '';
    }

    public static function generate_text_input($name, $value, $p)
    {
        $html = '<input type="text" id="input_' . $name . '" value="' . $value . '" name="' . $name . '"';
        foreach ($p as $key => $item) {
            $html .= $key . '="' . $item . '"';
        }
        $html .= '>';
        return $html;
    }

    public static function generate_number_input($name, $value, $p)
    {
        $html = '<input type="number" id="input_' . $name . '" value="' . $value . '" name="' . $name . '"';
        foreach ($p as $key => $item) {
            $html .= $key . '="' . $item . '"';
        }
        $html .= '>';
        return $html;
    }

    public static function generate_textarea_input($name, $value, $p)
    {
        $html = '<textarea type="number" id="input_' . $name . '" name="' . $name . '"';
        foreach ($p as $key => $item) {
            $html .= $key . '="' . $item . '"';
        }
        $html .= '>' . $value . '</textarea>';
        return $html;
    }

    public static function generate_select_input($name, $value, $p)
    {
        $html = '<select id="input_' . $name . '" name="' . $name . '"';
        foreach ($p as $key => $item) {
            if ($key != 'options')
                $html .= $key . '="' . $item . '"';
        }

        $html .= '>';

        $options = explode("||", $p['options']);
        foreach ($options as $option) {
            $data = explode('|', $option);
            if ($data[0] != $value) {
                $html .= '<option value="' . $data[0] . '">' . $data[1] . '</option>';
            } else {
                $html .= '<option value="' . $data[0] . '" selected>' . $data[1] . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    public static function have_notification($type)
    {
        $user = Auth::user();
        return NotificationController::is_have_unreaded($user->id, $type);
    }


    public static function is_user_role($type, $is_personal, $user_id = null)
    {
        if($user_id == null)
            $user = Auth::user();
        else
            $user = User::where('id', $user_id)->first();

        $role = Roles::where('id', $user->role_id)->first();
        if($role->type == $type && $role->is_personal == $is_personal)
            return true;
        else
            return false;
    }

    public static function is_user_personal($user_id = null)
    {
        if($user_id == null)
            $user = Auth::user();
        else
            $user = User::where('id', $user_id)->first();

        $role = Roles::where('id', $user->role_id)->first();
        if($role->is_personal==0)
            return false;
        else
            return true;
    }

    public static function is_client($user_id = null)
    {
        if($user_id == null)
            $user = Auth::user();
        else
            $user = User::where('id', $user_id)->first();

        $role = Roles::where('id', $user->role_id)->first();
        if($role->type==1)
            return true;
        else
            return false;
    }

    public static function transportUrl($file_name = '')
    {
        return url("upload/transports/".$file_name);
    }

    public static function imageUrl($file_name = '', $path = 'images')
    {
        return url("upload/".$path.'/'.$file_name);
    }

    public static function documentUrl($file_name = '', $path = 'documents')
    {
        return url("storage/".$path.'/'.$file_name);
    }

    public static function get_max_cars()
    {
        $max_cars = 0;
        if(!SELF::is_client()) {
            $max_cars = 1;
            if (SELF::is_user_role(2, 0)) {
                $user = Auth::user();
                $current =(new UserDataService)->get($user->id, 'cars_count');
                if($current!=false)
                    $max_cars = $current;
            }
        }
        return $max_cars;
    }


    public static function is_allowed_edit_cars_and_personal()
    {
        $user = Auth::user();

        if(!SELF::is_client())
        {

            if (SELF::is_user_role(2, 0))
            {
                $options = (new UserDataService)->all($user->id);
                if(!isset($options['new_sp_description']) && !isset($options['sp_description']))
                    return false;

                $images['reg_docs'] = ImagesConroller::get_images_by_type($user->id, 'reg_docs');
                $images['passport'] = ImagesConroller::get_images_by_type($user->id, 'passport');
                $images['bank'] = ImagesConroller::get_images_by_type($user->id, 'bank');

                if( count($images['reg_docs']) == 0 && count($images['passport']) == 0 && count($images['bank']) == 0 )
                    return false;

                if(!isset($options['egrpou_or_inn']) && !isset($options['new_egrpou_or_inn']))
                    return false;

                return true;
            }
            else
            {
                return true;
            }

        }
        else
            return false;

    }

    public static function generate_social_link($network, $id)
    {

        $link = '';
        if($network == 'facebook')
            $link = 'https://www.facebook.com/profile.php?id='.$id;
        if($network == 'google')
            $link = 'https://plus.google.com/'.$id;

        if($network == 'linkedin')
            $link = 'https://www.linkedin.com/in/'.$id.'/';

        return $link;
    }
}