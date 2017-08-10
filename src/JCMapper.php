<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 10/08/2017
 * Time: 11:50
 */

namespace JC;

use JsonMapper;

class JCMapper extends JsonMapper
{
    public function createInstance(
        $class, $useParameter = false, $parameter = null
    )
    {
        if (isset($this->classMap[$class])) {
            $class = $this->classMap[$class];
        }
        if ($useParameter) {
            return new $class($parameter);
        } else {
            return (new \ReflectionClass($class))->newInstanceWithoutConstructor();
        }
    }

}