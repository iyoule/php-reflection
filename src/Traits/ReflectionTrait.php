<?php


namespace iyoule\Reflection\Traits;


use iyoule\Reflection\{
    ReflectionAnnotation,
    ReflectionClass,
    ReflectionProperty,
    ReflectionMethod
};


trait ReflectionTrait
{


    /**
     * @return ReflectionAnnotation[]
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function getAnnotations()
    {
        if ($this instanceof ReflectionProperty) {
            return ReflectionAnnotation::fromPhpReflectionProperty($this);
        } else if ($this instanceof ReflectionClass) {
            return ReflectionAnnotation::fromPhpReflectionClass($this);
        } else if ($this instanceof ReflectionMethod) {
            return ReflectionAnnotation::fromPhpReflectionMethod($this);
        }
        return null;
    }


    /**
     * @param $name
     * @return ReflectionAnnotation
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function getAnnotation($name)
    {
        if ($annotations = $this->getAnnotations()) {
            foreach ($annotations as $annotation) {
                if ($annotation->getName() == $name || $annotation->getShortName() == $name) {
                    return $annotation;
                }
            }
        }
        return null;
    }


}