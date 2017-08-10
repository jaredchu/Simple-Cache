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
    /**
     *
     */
    const ENCRYPT_METHOD = 'AES256';

    /**
     * @var string
     */
    public static $encryptKey;

    /**
     * @return string
     */
    public static function getEncryptKey()
    {
        return self::$encryptKey;
    }

    /**
     * @param string $encryptKey
     */
    public static function setEncryptKey($encryptKey)
    {
        self::$encryptKey = $encryptKey;
    }

    /**
     * @param object $object
     * @return string
     */
    protected static function encode($object)
    {
        return openssl_encrypt(json_encode($object), self::ENCRYPT_METHOD, self::getEncryptKey(), 0, self::getIv());
    }

    /**
     * @param string $string
     * @return object
     */
    protected static function decode($string)
    {
        return json_decode(openssl_decrypt($string, self::ENCRYPT_METHOD, self::getEncryptKey(), 0, self::getIv()));
    }

    /**
     * @return bool|string
     */
    protected static function getIv()
    {
        return substr(md5(self::getEncryptKey()), 0, 16);
    }

}