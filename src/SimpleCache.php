<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 09/08/2017
 * Time: 16:22
 */

namespace JC\Cache;

/**
 * Class EncryptCache
 * @package JC
 */
class SimpleCache extends BaseCache
{
    /**
     * @return string
     */
    public static function getEncryptKey()
    {
        return Manager::getEncryptKey();
    }

    /**
     * @param string $encryptKey
     */
    public static function setEncryptKey($encryptKey)
    {
        Manager::setEncryptKey($encryptKey);
    }

    /**
     * @param string $cacheDirectory
     */
    public static function setCacheDirectory($cacheDirectory) {
        self::$cacheDirectory = $cacheDirectory;
        Manager::setCacheDirectory($cacheDirectory);
    }

    /**
     * @param object $object
     * @return string
     */
    protected static function encode($object)
    {
        return Manager::encrypt(json_encode($object));
    }

    /**
     * @param string $string
     * @return object
     */
    protected static function decode($string)
    {
        return json_decode(Manager::decrypt($string));
    }
}
