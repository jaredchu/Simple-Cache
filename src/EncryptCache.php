<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 09/08/2017
 * Time: 16:22
 */

namespace JC;

/**
 * Class EncryptCache
 * @package JC
 */
class EncryptCache extends SimpleCache
{
    const MANAGER = EncryptManager::class;

    /**
     * @return string
     */
    public static function getEncryptKey()
    {
        return (self::MANAGER)::getEncryptKey();
    }

    /**
     * @param string $encryptKey
     */
    public static function setEncryptKey($encryptKey)
    {
        (self::MANAGER)::setEncryptKey($encryptKey);
    }

    /**
     * @param object $object
     * @return string
     */
    protected static function encode($object)
    {
        return (self::MANAGER)::encrypt(json_encode($object));
    }

    /**
     * @param string $string
     * @return object
     */
    protected static function decode($string)
    {
        return json_decode((self::MANAGER)::decrypt($string));
    }
}