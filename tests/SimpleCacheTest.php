<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 09/08/2017
 * Time: 16:00
 */

use JC\Cache\SimpleCache;

class SimpleCacheTest extends PHPUnit_Framework_TestCase
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
        SimpleCache::setEncryptKey(self::$encryptKey);
        self::assertTrue(SimpleCache::add(self::$key, self::$person));
    }

    public function testFetch()
    {
        $jared = SimpleCache::fetch(self::$key, Person::class);
        self::assertEquals(self::$person->name, $jared->name);
        self::assertEquals(self::$person->age, $jared->age);
        self::assertEquals(self::$person->sayHi(), $jared->sayHi());

        self::assertTrue(SimpleCache::remove(self::$key));
        self::assertFalse(SimpleCache::fetch('xxx', Person::class));
    }

    public function testEncryptionKey()
    {
        $encrytionKey = 'encrytionKey';
        SimpleCache::setEncryptKey($encrytionKey);
        self::assertEquals($encrytionKey, SimpleCache::getEncryptKey());
        self::assertTrue(SimpleCache::add('test', 'test'));
    }
}