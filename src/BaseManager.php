<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 04/08/2017
 * Time: 11:36
 */

namespace JC\Cache;

/**
 * Class CacheManager
 * @package JC
 *
 * Manage the list of caching file and object
 * Save in $cFilename
 */
abstract class BaseManager
{
    /**
     * @var string
     */
    protected static $cFileName;

    /**
     * @param $cFileName
     */
    public static function setCFileName($cFileName)
    {
        static::$cFileName = $cFileName;
    }

    /**
     * @return string
     */
    public static function getCFileName()
    {
        return static::$cFileName;
    }

    /**
     * @return string
     *
     * Return absolute file path which store cache list
     */
    public static function getCFilePath()
    {
        return sys_get_temp_dir() . '/' . static::getCFileName();
    }

    /**
     * Unique string for each server
     * @param string $salt
     * @return string
     */
    public static function getUniqueString($salt = '')
    {
        $uniqueString = isset($_SERVER['SERVER_SIGNATURE']) ? $_SERVER['SERVER_SIGNATURE'] . __DIR__ : __DIR__;
        return md5($uniqueString . $salt);
    }

    /**
     * @param $key
     * @return bool|string
     *
     * Return absolute file path of caching object
     */
    public static function get($key)
    {
        $cacheList = static::getCacheList();
        if (isset($cacheList[$key])) {
            if (($cacheList[$key][0] == 0 || $cacheList[$key][0] >= time())) {
                return $cacheList[$key][1];
            } else {
                unlink($cacheList[$key][1]);
                static::remove($key);
            }
        }

        return false;
    }

    /**
     * @param $key
     * @param $filePath
     * @return bool
     *
     * Save $key and $filePath in cacheList
     */
    public static function set($key, $filePath, $ttl)
    {
        $cacheList = static::getCacheList();

        if ($ttl != 0) {
            $ttl += time();
        }
        $cacheList[$key] = [$ttl, $filePath];

        return static::setCacheList($cacheList);
    }

    /**
     * @param $key
     * @return bool
     *
     * Remove caching object file and remove from cache list
     */
    public static function remove($key)
    {
        $cacheList = static::getCacheList();
        unset($cacheList[$key]);

        return static::setCacheList($cacheList);
    }

    /**
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        $cacheList = static::getCacheList();
        if (is_array($cacheList)) {
            return array_key_exists($key, $cacheList);
        }

        return false;
    }

    /**
     * @return array
     *
     * Return cache list in array
     */
    protected static function getCacheList()
    {
        if (file_exists(static::getCFilePath())) {
            return static::decode(file_get_contents(static::getCFilePath()));
        }

        return array();
    }

    /**
     * @param $cacheList
     * @return bool
     */
    protected static function setCacheList($cacheList)
    {
        return (bool)file_put_contents(static::getCFilePath(), static::encode($cacheList));
    }

    /**
     * @param $array
     * @return string
     */
    protected static function encode($array)
    {
        return json_encode($array);
    }

    /**
     * @param $string
     * @return array
     */
    protected static function decode($string)
    {
        return json_decode($string, true);
    }
}