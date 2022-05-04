<?php

namespace App\Services;


use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class ImageService
{
    public static $publicPath = 'storage/';

    /**
     * @param Model $model
     * @param array $files
     * @param string $path
     * @param string $type
     */
    public static function save(Model $model, $files, $path = 'images', $type = 'file')
    {
        foreach ($files as $k => $file) {
            $filename = time() . '_' . self::encodeCyrillicToLatin($file->getClientOriginalName());
            $file->move(public_path('storage/'. $path . '/'), $filename);

            if ($type !== 'document') {
                Image::query()->create([
                    'filename' => $filename,
                    'imagetable_id' => $model->id,
                    'imagetable_type' => get_class($model),
                    'image_type' => $type
                ]);
            }
        }
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
}