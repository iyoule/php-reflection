<?php

namespace iyoule\Reflection;


class ReflectionType extends \ReflectionType
{

    /**
     * @var \ReflectionType
     */
    public $originalType;
    public $annoType;
    public $allowsNull;
    public $isBuiltin;
    //public $name;

    /**
     * @return bool
     */
    public function allowsNull()
    {
        if ($this->allowsNull === null) {
            if ($this->annoType && strpos($this->annoType, 'null') !== false) {
                $this->allowsNull = true;
            } else if ($this->originalType) {
                $this->allowsNull = $this->originalType->allowsNull();
            }
        }
        return $this->allowsNull = $this->allowsNull === true;
    }

    /**
     * @return bool
     */
    public function isBuiltin()
    {
        if ($this->originalType) {
            $this->isBuiltin = $this->originalType->isBuiltin();
        }
        return $this->isBuiltin === true;
    }

    /**
     * To string
     * @link https://php.net/manual/en/reflectiontype.tostring.php
     * @return string Returns the type of the parameter.
     * @since 7.0
     * @deprecated 7.1.0:8.0.0 Please use getName()
     * @see \ReflectionType::getName()
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get type of the parameter.
     * @return mixed string Returns the type of the parameter.
     * @since 7.1.0
     */
    public function getName()
    {
        if ($this->annoType) {
            if (strpos($this->annoType, '|') !== false) {
                $this->name = 'mixed';
            } else {
                $this->name = $this->annoType;
            }
        }
        return $this->name;
    }

}