<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 04/08/2017
 * Time: 10:56
 */

use JC\SimpleCache;

class SimpleCacheTest extends PHPUnit_Framework_TestCase
{
    public static $key;

    /**
     * @var Person
     */
    public static $person;

    public static function setUpBeforeClass()
    {
        self::$key = 'mr.chu';
        self::$person = new Person('Jared', 27);
    }

    public function testAdd()
    {
        self::assertTrue(SimpleCache::add(self::$key, self::$person));
    }

    public function testExists()
    {
        $otherKey = 'mr.trump';

        self::assertTrue(SimpleCache::exists(self::$key));
        self::assertFalse(SimpleCache::exists($otherKey));

        self::assertTrue(SimpleCache::add($otherKey, new Person('Donald', 70)));
        self::assertTrue(SimpleCache::exists($otherKey));

        self::assertTrue(SimpleCache::remove($otherKey));
    }

    public function testFetch()
    {
        $jared = SimpleCache::fetch(self::$key, Person::class);
        self::assertEquals(self::$person->name, $jared->name);
        self::assertEquals(self::$person->age, $jared->age);
        self::assertEquals(self::$person->sayHi(), $jared->sayHi());
    }

    public function testRemove()
    {
        self::assertTrue(SimpleCache::remove(self::$key));
        self::assertFalse(SimpleCache::exists(self::$key));
    }
}

class Person
{
    public $name;
    public $age;

    /**
     * Person constructor.
     * @param $name
     * @param $age
     */
    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function sayHi()
    {
        return 'Hi';
    }
}