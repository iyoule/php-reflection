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

    private static $_annotationCache = [];

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


    public static function exportCache()
    {
        return serialize(self::$_annotationCache);
    }


    public static function importCache($cacheString)
    {
        self::$_annotationCache = unserialize($cacheString);
        return true;
    }

    public static function importCacheFileOfPHP($file)
    {
        self::$_annotationCache = require($file);
        return true;
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
     * @return mixed
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public static function fromPhpReflectionProperty(ReflectionProperty $reflection)
    {
        $class = $reflection->getDeclaringClass()->getName();
        $property = $reflection->getName();
        if (!isset(self::$_annotationCache["$class::\$$property"])) {
            self::$_annotationCache["$class::\$$property"] = array_map(function ($object) {
                return self::__construct__($object);
            }, self::getAnnotationReader()->getPropertyAnnotations($reflection));
        }
        return self::$_annotationCache["$class::\$$property"];
    }

    /**
     * @param ReflectionClass $reflection
     * @return mixed
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public static function fromPhpReflectionClass(ReflectionClass $reflection)
    {
        $class = $reflection->getName();
        if (!isset(self::$_annotationCache["$class::"])) {
            self::$_annotationCache["$class::"] = array_map(function ($object) {
                return self::__construct__($object);
            }, self::getAnnotationReader()->getClassAnnotations($reflection));
        }
        return self::$_annotationCache["$class::"];
    }

    /**
     * @param ReflectionMethod $reflection
     * @return mixed
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public static function fromPhpReflectionMethod(ReflectionMethod $reflection)
    {
        $class = $reflection->getDeclaringClass()->getName();
        $method = $reflection->getName();
        if (!isset(self::$_annotationCache["$class::$method"])) {
            self::$_annotationCache["$class::$method"] = array_map(function ($object) {
                return self::__construct__($object);
            }, self::getAnnotationReader()->getMethodAnnotations($reflection));
        }
        return self::$_annotationCache["$class::$method"];
    }

}