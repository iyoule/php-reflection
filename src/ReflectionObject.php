<?php


namespace iyoule\Reflection;


class ReflectionObject extends ReflectionClass
{
    public function __construct($argument)
    {
        $className = get_class($argument);
        parent::__construct($className);
    }
}