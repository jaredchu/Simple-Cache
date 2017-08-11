<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 09/08/2017
 * Time: 14:13
 */

use JC\BaseCache;
use JC\Manager;

class ManagerTest extends PHPUnit_Framework_TestCase
{
    public function testSetCFileName()
    {
        BaseCache::add('test', new stdClass());
        BaseCache::remove('test');

        self::assertTrue(file_exists(Manager::getCFilePath()));
    }

    public function testGet()
    {
        self::assertFalse(Manager::get('xxx'));
    }

    public function testUniqueString()
    {
        self::assertEquals(Manager::getUniqueString(), Manager::getUniqueString());
        self::assertNotEquals(Manager::getUniqueString('a'), Manager::getUniqueString());
        self::assertEquals(Manager::getUniqueString('a'), Manager::getUniqueString('a'));
        self::assertNotEquals(Manager::getUniqueString('a'), Manager::getUniqueString('b'));
    }
}