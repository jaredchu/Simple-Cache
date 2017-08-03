<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 03/08/2017
 * Time: 17:17
 */

class SimpleCache implements SimpleCacheInterface
{

    /**
     * @param $key
     * @param $data
     * @param int $ttl
     * @return bool
     */
    function add($key, $data, $ttl = 0)
    {
        // TODO: Implement add() method.
    }

    /**
     * @param $key
     * @return object|mixed
     */
    function fetch($key)
    {
        // TODO: Implement fetch() method.
    }

    /**
     * @param $key
     * @return bool
     */
    function exists($key)
    {
        // TODO: Implement exists() method.
    }
}