<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 09/08/2017
 * Time: 14:13
 */

use JC\Cache\BaseCache;
use JC\Cache\Manager;

class ManagerTest extends PHPUnit_Framework_TestCase
{
    public function testSetCFileName()
    {
        $cacheFileName = 'cache-list';
        Manager::setCFileName($cacheFileName);
        self::assertEquals($cacheFileName, Manager::getCFileName());

        self::assertTrue(BaseCache::add('test', new stdClass()));
        self::assertTrue(BaseCache::remove('test'));
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