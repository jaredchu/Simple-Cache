<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 09/08/2017
 * Time: 16:00
 */

use JC\EncryptCache;

class EncryptCacheTest extends PHPUnit_Framework_TestCase
{
    public static $key;
    public static $encryptKey;

    /**
     * @var Person
     */
    public static $person;

    public static function setUpBeforeClass()
    {
        self::$encryptKey = '123456';
        self::$key = 'mr.encrypt';
        self::$person = new Person('', 27);
    }

    public function testAdd()
    {
        EncryptCache::setEncryptKey(self::$encryptKey);
        self::assertTrue(EncryptCache::add(self::$key, self::$person));
    }

    public function testFetch()
    {
        $jared = EncryptCache::fetch(self::$key, Person::class);
        self::assertEquals(self::$person->name, $jared->name);
        self::assertEquals(self::$person->age, $jared->age);
        self::assertEquals(self::$person->sayHi(), $jared->sayHi());

        self::assertFalse(EncryptCache::fetch('xxx', Person::class));
    }
}