<?php


namespace iyoule\Reflection;


use iyoule\Reflection\Traits\ReflectionClassTrait;
use iyoule\Reflection\Traits\ReflectionTrait;

class ReflectionProperty extends \ReflectionProperty
{
    use ReflectionTrait, ReflectionClassTrait;

    public function __construct($class, $name)
    {
        parent::__construct($class, $name);
    }


    /**
     * @return ReflectionType
     */
    public function getType()
    {
        $type = new ReflectionType();
        if (($doc = $this->getDocComment()) &&
            preg_match("#@var\s([^\s\"\n\r]+)#i", $doc, $ary)) {
            $type->annoType = $ary[1];
        }
        return $type;
    }

}