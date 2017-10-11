<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 10/08/2017
 * Time: 11:50
 */

namespace JC\Cache;

use JsonMapper;

class JCMapper extends JsonMapper
{
    public function createInstance(
        $class, $useParameter = false, $parameter = null
    )
    {
        return (new \ReflectionClass($class))->newInstanceWithoutConstructor();
    }

}