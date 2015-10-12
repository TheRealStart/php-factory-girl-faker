<?php

namespace TRS\FactoryGirl\Faker\ExtraProviders;
use Faker\Provider\Base;
use Imagick;

/**
 * Depends on image generation from http://lorempixel.com/
 */
class StaticImage extends Base
{
    /**
     * Download a remote random image to disk and return its location
     *
     * Requires curl, or allow_url_fopen to be on in php.ini.
     *
     * @example '/path/to/dir/13b73edae8443990be1aa8f1a483bc27.jpg'
     */
    public static function staticImage($source = null, $dir = null, $width = 640, $height = 480, $category = null, $fullPath = true, $randomize = true, $word = null)
    {
        if (!file_exists($source)) {
            throw new \InvalidArgumentException(sprintf('No such file or directory "%s"', $source));
        }
        $dir = is_null($dir) ? sys_get_temp_dir() : $dir; // GNU/Linux / OS X / Windows compatible
        // Validate directory path
        if (!is_dir($dir) || !is_writable($dir)) {
            throw new \InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
        }

        // Generate a random filename. Use the server address so that a file
        // generated at the same time on a different server won't have a collision.
        $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
        $filename = $name .'.jpg';
        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        $im = new Imagick($source);
        $im->resizeImage($height, $width, Imagick::FILTER_CUBIC, 1);
        $im->writeImage($filepath);
        $im->destroy();

        return $fullPath ? $filepath : $filename;
    }
}
