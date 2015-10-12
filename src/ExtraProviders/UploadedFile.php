<?php
/**
 * Created by IntelliJ IDEA.
 * User: chestr
 * Date: 23.09.15
 * Time: 21:42
 */

namespace TRS\FactoryGirl\Faker\ExtraProviders;
use Faker\Provider\Base;

/**
 * Depends on image generation from http://lorempixel.com/
 */
class UploadedFile extends Base
{

    public static function uploadedFile($source = null, $name = 'file', $dir = '/tmp', $name = null, $type = null) {
        $fileName = $name ? $name : self::lexify('???????????.jpg');
        $filePath = StaticImage::staticImage($source, $dir);
        $_FILES = [
            'image' => [
                'name' => $fileName,
                'tmp_name' => $filePath,
                'type' => $type,
                'size' => filesize($filePath),
                'error' => 0
            ]
        ];
    }

    public static function uploadedImage($source = null, $key = 'image', $dir = '/tmp', $type = 'image/jpeg', $width = 640, $height = 480, $name = null) {
        $fileName = $name ? $name : self::lexify('???????????.jpg');
        $filePath = StaticImage::staticImage($source, $dir, $width, $height);
        $_FILES = [
            'image' => [
                'name' => $fileName,
                'tmp_name' => $filePath,
                'type' => $type,
                'size' => filesize($filePath),
                'error' => 0
            ]
        ];
    }

    public static function yiiUploadedImage($source = null, $dir = '/tmp', $type = 'image/jpeg', $width = 640, $height = 480, $name = null) {
        self::uploadedImage($source, 'image', $dir, $type, $height, $width, $name);
        return \yii\web\UploadedFile::getInstanceByName('image');
    }
}
