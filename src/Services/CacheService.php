<?php

namespace App\Services;

class CacheService
{
    // cache lifetime in seconds set to 120 minutes
    const FILE_LIFETIME = 1 * 60;

    const CACHE_DIR_NAME = 'cache';
    const CACHE_DIR = 'public';

    /**
     * Cache image for a given lifetime
     * 
     * @param int $lifetime Lifetime in seconds
     * @return string|false Path to cached image or false if file could not be saved
     */
    public static function cacheImage(string $cacheKey, $contents)
    {
        $asdjasi = __DIR__ . '/../../' . self::CACHE_DIR;
        $cacheFile = realpath(__DIR__ . '/../../' . self::CACHE_DIR);

        // open file handler
        if (!file_exists($cacheFile . '/' . self::CACHE_DIR_NAME)) {
            mkdir($cacheFile . '/' . self::CACHE_DIR_NAME);
        }

        if (is_a($contents, \GdImage::class)) {
            ob_start();
            imagejpeg($contents);
            $contents = ob_get_clean();
        }

        $file = fopen($cacheFile . '/' . self::CACHE_DIR_NAME . '/' . $cacheKey . '.jpg', 'w');

        // write contents to file
        $writeResult = fwrite($file, $contents);

        if ($writeResult === false) {
            return false;
        }

        // close file handler
        fclose($file);

        return '/' . self::CACHE_DIR_NAME . '/' . $cacheKey . '.jpg';
    }

    /**
     * Get image from cache
     * 
     * @param string $cacheKey Cache key
     * @return string|false Path to cached image or false if not found
     */
    public static function getImage(string $cacheKey)
    {
        $cacheFile = realpath(__DIR__ . '/../../' . self::CACHE_DIR . '/' . self::CACHE_DIR_NAME . '/' . $cacheKey . '.jpg');

        if (!file_exists($cacheFile)) {
            return false;
        }

        if (time() - self::FILE_LIFETIME > filemtime($cacheFile)) {
            unlink($cacheFile);
            return false;
        }

        return '/' . self::CACHE_DIR_NAME . '/' . $cacheKey . '.jpg';
    }
}