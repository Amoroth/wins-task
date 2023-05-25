<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Transform image to a sepia version
     * 
     * @param string $imageData Image data
     * @return \GdImage
     */
    public static function sepia($imageData): \GdImage
    {
        $imageResource = imagecreatefromstring($imageData);
        imagefilter($imageResource, IMG_FILTER_GRAYSCALE);
        imagefilter($imageResource, IMG_FILTER_BRIGHTNESS, -40);
        imagefilter($imageResource, IMG_FILTER_COLORIZE, 90, 55, 30);

        return $imageResource;
    }
}