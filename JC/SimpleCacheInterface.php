<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 03/08/2017
 * Time: 17:14
 */

interface SimpleCacheInterface
{
    /**
     * @param $key
     * @param $data
     * @param int $ttl
     * @return bool
     */
    function add($key, $data, $ttl = 0);

    /**
     * @param $key
     * @return object|mixed
     */
    function fetch($key);

    /**
     * @param $key
     * @return bool
     */
    function exists($key);
}