<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 03/08/2017
 * Time: 17:17
 */

namespace JC;

use JsonMapper;
use ReflectionClass;

class SimpleCache
{

    /**
     * @param $key
     * @param $data
     * @return bool
     */
    public static function add($key, $data)
    {
        $tempFilePath = static::getTempFilePath($key) ?: self::createTempFile($key);
        return (bool)file_put_contents($tempFilePath, json_encode($data));
    }

    /**
     * @param $key
     * @param string $className
     * @return object|mixed
     */
    public static function fetch($key, $className)
    {
        $jsonString = file_get_contents(static::getTempFilePath($key));

        $mapper = new JsonMapper();
        return $mapper->map(json_decode($jsonString), (new ReflectionClass($className))->newInstanceWithoutConstructor());
    }

    public static function remove($key)
    {
        if (CacheManager::has($key)) {
            unlink(CacheManager::get($key));
            return CacheManager::remove($key);
        }

        return false;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function exists($key)
    {
        return file_exists(static::getTempFilePath($key));
    }

    protected static function getTempFilePath($key)
    {
        if (CacheManager::has($key)) {
            return CacheManager::get($key);
        }

        return false;
    }

    protected static function createTempFile($key)
    {
        $tempFilePath = tempnam(sys_get_temp_dir(), $key);
        CacheManager::set($key, $tempFilePath);

        return $tempFilePath;
    }
}