<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 09/08/2017
 * Time: 14:13
 */

use JC\CacheManager;
use JC\SimpleCache;

class CacheManagerTest extends PHPUnit_Framework_TestCase
{
    public function testSetCFileName()
    {
        $cacheFileName = 'custom-cache-file-name';
        CacheManager::setCFileName($cacheFileName);
        SimpleCache::add('test', new stdClass());
        SimpleCache::remove('test');

        self::assertTrue(file_exists(CacheManager::getCFilePath()));
    }

    public function testGet()
    {
        self::assertFalse(CacheManager::get('xxx'));
    }
}