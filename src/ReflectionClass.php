<?php


namespace iyoule\Reflection;


use iyoule\Reflection\Traits\ReflectionTrait;

class ReflectionClass extends \ReflectionClass
{

    use ReflectionTrait;


    /**
     * @return ReflectionMethod|\ReflectionMethod|null
     * @throws \ReflectionException
     */
    public function getConstructor()
    {
        foreach (['__construct', $this->getShortName()] as $item) {
            if (method_exists($className = $this->getName(), $item)) {
                return $this->getMethod($item);
            }
        }
        return null;
    }


    /**
     * @param string $name
     * @return ReflectionMethod|\ReflectionMethod
     * @throws \ReflectionException
     */
    public function getMethod($name)
    {
        return (new ReflectionMethod($this->getName(), $name));
    }


    /**
     * @return false|ReflectionClass|\ReflectionClass
     * @throws \ReflectionException
     */
    public function getParentClass()
    {
        $class = parent::getParentClass();
        return new ReflectionClass($class->getName());
    }

    public function getReflectionConstant($name)
    {
        foreach ($this->getReflectionConstants() as $classConstant) {
            if ($classConstant->getName() === $name) {
                return $classConstant;
            }
        }
        return null;
    }

    public function getReflectionConstants()
    {
        $data = [];
        foreach (parent::getReflectionConstants() as $classConstant) {
            $data[] = new ReflectionClassConstant($this->getName(), $classConstant->getName());
        }
        return $data;
    }

    /**
     * @param null $filter
     * @return ReflectionProperty[]
     */
    public function getProperties($filter = null)
    {
        return array_map(function ($property) {
            return new ReflectionProperty($property->class, $property->getName());
        }, parent::getProperties($filter));
    }

    /**
     * @param string $name
     * @return ReflectionProperty
     * @throws \ReflectionException
     */
    public function getProperty($name)
    {
        return new ReflectionProperty($this->getName(), $name);
    }


}