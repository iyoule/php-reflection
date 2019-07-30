<?php


namespace iyoule\Reflection;


class ReflectionFunction extends \ReflectionFunction
{


    /**
     * @return NULL|\ReflectionType
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