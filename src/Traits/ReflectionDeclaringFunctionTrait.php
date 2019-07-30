<?php


namespace iyoule\Reflection\Traits;


trait ReflectionDeclaringFunctionTrait
{


    private $_declaringFunction;

    /**
     * @return mixed
     */
    public function getDeclaringFunction()
    {
        return $this->_declaringFunction;
    }

    /**
     * @param mixed $declaringFunction
     */
    public function setDeclaringFunction($declaringFunction)
    {
        $this->_declaringFunction = $declaringFunction;
    }


}