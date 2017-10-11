<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 10/08/2017
 * Time: 15:52
 */

namespace JC\Cache;


class Manager extends BaseManager
{
    /**
     * @var string
     */
    const ENCRYPT_METHOD = 'AES256';

    /**
     * @var string
     */
    public static $encryptKey;

    /**
     * @return string
     */
    public static function getCFileName()
    {
        return parent::getCFileName() ?: self::getUniqueString(is_null(self::$encryptKey) ? 'encrypt' : self::$encryptKey);
    }

    /**
     * @return string
     */
    public static function getEncryptKey()
    {
        return self::$encryptKey ?: self::getUniqueString('encryptKey');
    }

    /**
     * @param string $encryptKey
     */
    public static function setEncryptKey($encryptKey)
    {
        self::$encryptKey = $encryptKey;
    }

    /**
     * @param $string
     * @return string
     */
    public static function encrypt($string)
    {
        return openssl_encrypt($string, self::ENCRYPT_METHOD, self::getEncryptKey(), 0, self::getIv());
    }

    /**
     * @param $string
     * @return string
     */
    public static function decrypt($string)
    {
        return openssl_decrypt($string, self::ENCRYPT_METHOD, self::getEncryptKey(), 0, self::getIv());
    }

    /**
     * @return bool|string
     */
    protected static function getIv()
    {
        return substr(md5(self::getEncryptKey()), 0, 16);
    }

    /**
     * @param $array
     * @return string
     */
    protected static function encode($array)
    {
        return self::encrypt(parent::encode($array));
    }

    /**
     * @param $string
     * @return array
     */
    protected static function decode($string)
    {
        return parent::decode(self::decrypt($string));
    }

}