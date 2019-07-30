<?php


namespace iyoule\Reflection;


use iyoule\Reflection\Traits\ReflectionClassTrait;
use iyoule\Reflection\Traits\ReflectionTrait;

class ReflectionMethod extends \ReflectionMethod
{
    use ReflectionTrait, ReflectionClassTrait;

    public function getParameters()
    {
        return array_map(function (ReflectionParameter $param) {
            $object = new ReflectionParameter($this->getName(), $param->getName());
            $object->setDeclaringFunction($this);
            return $object;
        }, parent::getParameters());
    }

    public function getPrototype()
    {
        return clone $this;
    }

    /**
     * @return NULL|ReflectionType
     */
    public function getReturnType()
    {
        $type = new ReflectionType();
        $type->originalType = parent::getReturnType();
        if (($doc = $this->getDocComment()) &&
            preg_match("#@return\s([^\s\"\n\r]+)#i", $doc, $ary)) {
            $type->annoType = $ary[1];
        }
        return $type;
    }

}