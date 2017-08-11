<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 04/08/2017
 * Time: 10:56
 */

use JC\BaseManager;
use JC\BaseCache;

class BaseCacheTest extends PHPUnit_Framework_TestCase
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
        self::assertTrue(BaseCache::add(self::$key, self::$person));
    }

    public function testExists()
    {
        $otherKey = 'mr.trump';

        self::assertTrue(BaseCache::exists(self::$key));
        self::assertFalse(BaseCache::exists($otherKey));

        self::assertTrue(BaseCache::add($otherKey, new Person('Donald', 70)));
        self::assertTrue(BaseCache::exists($otherKey));

        self::assertTrue(BaseCache::remove($otherKey));
    }

    public function testFetch()
    {
        $jared = BaseCache::fetch(self::$key, Person::class);
        self::assertEquals(self::$person->name, $jared->name);
        self::assertEquals(self::$person->age, $jared->age);
        self::assertEquals(self::$person->sayHi(), $jared->sayHi());

        self::assertFalse(BaseCache::fetch('xxx', Person::class));
    }

    public function testRemove()
    {
        self::assertTrue(BaseCache::remove(self::$key));
        self::assertFalse(BaseCache::exists(self::$key));

        self::assertFalse(BaseCache::remove('xxx'));
    }

    public function testLoop()
    {
        $i = 0;
        while ($i++ < 100) {
            $newKey = 'key' . $i;
            $newPerson = new Person(md5($i), $i);
            $newPerson->des = hash('sha512', $newPerson->name);

            self::assertTrue(BaseCache::add($newKey, $newPerson, rand(10, 100)));
            self::assertTrue(BaseCache::exists($newKey));

            $fetchPerson = BaseCache::fetch($newKey, Person::class);
            self::assertEquals($newPerson->name, $fetchPerson->name);
            self::assertEquals($newPerson->age, $fetchPerson->age);
            self::assertEquals($newPerson->sayHi(), $fetchPerson->sayHi());

            self::assertTrue(BaseCache::remove($newKey));
        }
    }

    public function testTTL()
    {
        $ttlKey = 'ttlKey';
        BaseCache::add($ttlKey, new stdClass(), 1);
        sleep(2);

        self::assertFalse(BaseCache::exists($ttlKey));
    }

    public function testFetchComplexObject()
    {
        $eKey = 'employee';
        $employee = new Employee(self::$person);

        self::assertTrue(BaseCache::add($eKey, $employee));
        $fetchEmployee = BaseCache::fetch($eKey, Employee::class);

        self::assertEquals($employee->person->name, $fetchEmployee->person->name);
        self::assertEquals($employee->person->age, $fetchEmployee->person->age);
        self::assertEquals($employee->person->sayHi(), $fetchEmployee->person->sayHi());

        self::assertTrue(BaseCache::remove($eKey));
    }
}

class Person
{
    public $name;
    public $age;
    public $des = '';

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

class Employee
{
    /**
     * @var Person
     */
    public $person;

    /**
     * Employee constructor.
     * @param Person $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

}