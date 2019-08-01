<?php


namespace iyoule\Reflection;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class ReflectionAnnotation
{


    private $name;

    private $shortName;

    private $object;

    private static $instance;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }






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


    private static function __construct__($object)
    {
        $model = new self();
        $model->name = get_class($object);
        $model->shortName = basename($model->name);
        $model->object = $object;
        return $model;
    }


    /**
     * @param ReflectionProperty $reflection
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public static function fromPhpReflectionProperty(ReflectionProperty $reflection)
    {
        return array_map(function ($object) {
            return self::__construct__($object);
        }, self::getAnnotationReader()->getPropertyAnnotations($reflection));
    }

    /**
     * @param ReflectionClass $reflection
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public static function fromPhpReflectionClass(ReflectionClass $reflection)
    {
        return array_map(function ($object) {
            return self::__construct__($object);
        }, self::getAnnotationReader()->getClassAnnotations($reflection));
    }

    /**
     * @param ReflectionMethod $reflection
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public static function fromPhpReflectionMethod(ReflectionMethod $reflection)
    {
        return array_map(function ($object) {
            return self::__construct__($object);
        }, self::getAnnotationReader()->getMethodAnnotations($reflection));
    }

}