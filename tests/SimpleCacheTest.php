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

    public function testCreateTempFile()
    {
        self::assertTrue(is_string(SimpleCache::createTempFile(self::$key, 0)));
    }

    public function testGetTempFile()
    {
        self::assertTrue(is_string(SimpleCache::getTempFile(self::$key)));
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

        self::assertFalse(SimpleCache::fetch('xxx', Person::class));
    }

    public function testRemove()
    {
        self::assertTrue(SimpleCache::remove(self::$key));
        self::assertFalse(SimpleCache::exists(self::$key));

        self::assertFalse(SimpleCache::remove('xxx'));
    }

    public function testLoop()
    {
        $i = 0;
        while ($i++ < 100) {
            $newKey = 'key' . $i;
            $newPerson = new Person(md5($i), $i);
            $newPerson->des = hash('sha512', $newPerson->name);

            self::assertTrue(SimpleCache::add($newKey, $newPerson, rand(10, 100)));
            self::assertTrue(SimpleCache::exists($newKey));

            $fetchPerson = SimpleCache::fetch($newKey, Person::class);
            self::assertEquals($newPerson->name, $fetchPerson->name);
            self::assertEquals($newPerson->age, $fetchPerson->age);
            self::assertEquals($newPerson->sayHi(), $fetchPerson->sayHi());

            self::assertTrue(SimpleCache::remove($newKey));
        }
    }

    public function testTTL()
    {
        $ttlKey = 'ttlKey';
        SimpleCache::add($ttlKey, new stdClass(), 1);
        sleep(2);

        self::assertFalse(SimpleCache::exists($ttlKey));
    }

    public function testFetchComplexObject()
    {
        $eKey = 'employee';
        $employee = new Employee(self::$person);

        self::assertTrue(SimpleCache::add($eKey, $employee));
        $fetchEmployee = SimpleCache::fetch($eKey, Employee::class);

        self::assertEquals($employee->person->name, $fetchEmployee->person->name);
        self::assertEquals($employee->person->age, $fetchEmployee->person->age);
        self::assertEquals($employee->person->sayHi(), $fetchEmployee->person->sayHi());
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