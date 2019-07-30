<?php


namespace iyoule\Reflection;


use iyoule\Reflection\Traits\ReflectionDeclaringFunctionTrait;

class ReflectionParameter extends \ReflectionParameter
{
    use ReflectionDeclaringFunctionTrait;

    /**
     * @return ReflectionType|NULL|\ReflectionType
     */
    public function getType()
    {
        $type = new ReflectionType();
        $type->originalType = parent::getType();
        if (($doc = $this->getDeclaringFunction()->getDocComment()) &&
            preg_match(sprintf(
                "#@param\s+([^\s]+)\$%s#i",
                $this->getName()
            ), $doc, $ary)) {
            $type->annoType = $ary[1];
        }
        return $type;
    }

}