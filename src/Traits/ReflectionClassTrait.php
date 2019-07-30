<?php


namespace iyoule\Reflection\Traits;


use iyoule\Reflection\ReflectionClass;

trait ReflectionClassTrait
{


    /**
     * @return ReflectionClass
     * @throws \ReflectionException
     */
    public function getDeclaringClass()
    {
        $class = parent::getDeclaringClass();
        return new ReflectionClass($class->getName());
    }


}