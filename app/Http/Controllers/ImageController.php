<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{


    public static $publicPath = 'storage/';

//    public static function uploadClientAvatar($files, $tableId, $tableType, $parentId = null){
//        self::upload($files, $tableId, $tableType, 'users', 'file', $parentId);
//    }

    /**
     * @param array $files
     * @param int $tableId
     * @param string $tableType
     * @param string $path
     */
    public static function upload($files, $tableId, $tableType, $path = '/images', $type = 'file', $parentId = null)
    {
        foreach ($files as $k => $file) {
            $filename = time() . '_' . self::encodeCyrillicToLatin($file->getClientOriginalName());
            $file->move(public_path(self::$publicPath . '/'. $path . '/'), $filename);

            if ($type !== 'document') {
                Image::create([
                    'filename' => $filename,
                    'imagetable_id' => $tableId,
                    'imagetable_type' => $tableType,
                    'image_type' => $type,
//                    'parent_id' => $parentId,
                ]);
            }
        }
    }


    public static function getRequiredImages($user_id) {
        return [];
    }


    /**
     * @param string $directory
     * @param string $fileName
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public static function getPath($directory, $fileName)
    {
        return url(self::$publicPath . $directory . '/' . $fileName);
    }

    /**
     * @param $filename
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public static function download($filename)
    {
        $file = public_path() .'/'. self::$publicPath . 'documents/' . $filename;
        $headers = [
            'Content-Type: application/download',
        ];

        return response()->download($file, $filename, $headers);
    }

    /**
     * @param $string
     * @return string
     */
    public static function encodeCyrillicToLatin($string): string
    {
        $cyr = [
            'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я', ' ', '/', '='
        ];
        $lat = [
            'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
            'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya', '_', '_', '_'
        ];

        return str_replace($cyr, $lat, $string);
    }


//    public static function get_images_list($user_id, $is_car)
//    {
//        $user_data = User::where('id', $user_id);
//        if ($user_data->count() > 0) {
//            $user = $user_data->first();
//            $images_data = Image::where('user_id', $user->id)
//                ->where('is_car', $is_car)->get();
//            return $images_data;
//        } else {
//            return [];
//        }
//    }
//
//
//    public static function get_file_path($file_id)
//    {
//        $image = Image::where('id', $file_id)->first();
//        if (count($image) > 0) {
//            return SELF::get_image_dir($file_id) . $image->filename;
//        } else
//            return '';
//
//    }
//
//    public static function get_image_dir($file_id)
//    {
//        $image = Image::where('id', $file_id)->first();
//        $path = public_path();
//        if (count($image) > 0) {
//            switch ($image->is_car) {
//                case 1:
//                    $path = public_path() . '/images/cars/';
//                    break;
//                case 0:
//                    $path = public_path() . '/images/photos/';
//                    break;
//
//            }
//
//            return $path;
//        } else {
//            return '';
//        }
//    }
//
//
//    public static function remove_images($user_id, $type = null, $is_car = null, $car_id = null, $image_id = null)
//    {
//        $data = Image::where('user_id', $user_id);
//
//        if ($image_id != null)
//            $data = $data->where('id', $image_id);
//
//        if ($type != null)
//            $data = $data->where('type', $type);
//
//        if ($is_car != null)
//            $data = $data->where('is_car', $is_car);
//
//        if ($car_id != null)
//            $data = $data->where('car_id', $car_id);
//
//
//        $images = $data->get();
//        foreach ($images as $image) {
//            $file_path = SELF::get_file_path($image->id);
//            if (file_exists($file_path))
//                unlink($file_path);
//            $image->delete();
//        }
//        return true;
//    }
//
//
//    public static function get_images_by_type($user_id, $type)
//    {
//        $user_data = User::where('id', $user_id);
//        if ($user_data->count() > 0) {
//            $user = $user_data->first();
//            $images_data = Image::where('user_id', $user->id)->where('type', $type)->get();
//            return $images_data;
//        } else {
//            return [];
//        }
//    }
//
//    public static function get_car_image_list($car_id)
//    {
//        $car_images = Image::where('car_id', $car_id)->get();
//        return $car_images;
//    }
//
//    public static function get_user_car($user_id, $car_id, $type)
//    {
//        $images_data = Image::where('user_id', $user_id)
//            ->where('car_id', $car_id)
//            ->where('type', $type)
//            ->get();
//        return $images_data;
//    }
//
//
//    public static function generate_filename($filename, $user_id, $car_id = false)
//    {
//        if ($car_id)
//            return time() . rand(10000, 99999) . "_" . $car_id . "_" . $user_id . "_" . $filename;
//        else
//            return time() . rand(10000, 99999) . "_" . $user_id . "_" . $filename;
//    }
//
//    /*
//     * AFTER UPLOAD IMAGE FILTER FUNCTION
//     */
//    public static function after_upload($file_id)
//    {
//        /*
//        $path = SELF::get_file_path($file_name);
//        */
//    }

}
