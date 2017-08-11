<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 09/08/2017
 * Time: 14:13
 */

use JC\BaseManager;
use JC\BaseCache;

class ManagerTest extends PHPUnit_Framework_TestCase
{
    public function testSetCFileName()
    {
        BaseCache::add('test', new stdClass());
        BaseCache::remove('test');

        self::assertTrue(file_exists(BaseManager::getCFilePath()));
    }

    public function testGet()
    {
        self::assertFalse(BaseManager::get('xxx'));
    }
}