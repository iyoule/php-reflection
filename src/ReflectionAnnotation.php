<?php


namespace iyoule\Reflection;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

abstract class ReflectionAnnotation
{

    private static $instance;

    /**
     * @return AnnotationReader
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    private static function getAnnotationReader()
    {
        if (self::$instance === null) {
            AnnotationRegistry::registerLoader(function ($class) {
                return class_exists($class);
            });
            self::$instance = new AnnotationReader();
        }
        return self::$instance;
    }


    /**
     * @param ReflectionProperty $reflection
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public static function fromPhpReflectionProperty(ReflectionProperty $reflection)
    {
        return self::getAnnotationReader()->getPropertyAnnotations($reflection);
    }

    /**
     * @param ReflectionClass $reflection
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public static function fromPhpReflectionClass(ReflectionClass $reflection)
    {
        return self::getAnnotationReader()->getClassAnnotations($reflection);
    }

    /**
     * @param ReflectionMethod $reflection
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public static function fromPhpReflectionMethod(ReflectionMethod $reflection)
    {
        return self::getAnnotationReader()->getMethodAnnotations($reflection);
    }

}