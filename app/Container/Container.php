<?php

namespace App\Container;

use Exception;
use ReflectionClass;
use ReflectionException;

class Container
{
    private $instances;

    /**
     * @param $abstract
     * @param $arguments
     * @param null $concrete
     */
    public function set($abstract, $arguments, $concrete = null)
    {
        if ($concrete == null) {
            $concrete = $abstract;
        }

        $this->instances[$abstract] = ['class' => $concrete, 'arguments' => $arguments];
    }

    /**
     * @param $class
     * @return object
     * @throws Exception
     */
    public function get($class)
    {
        return $this->resolve($class);
    }

    /**
     * @param $class
     * @return object
     * @throws ReflectionException
     */
    private function resolve($class)
    {
        $reflectionClass = new ReflectionClass($this->instances[$class]['class']);

        if (!$reflectionClass->isInstantiable()) {
            throw new Exception(sprintf("Class %s cannot be instantiated", $class));
        }

        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return $reflectionClass->newInstance();
        }

        $dependencies = $constructor->getParameters();

        $resolvedDependencies = $this->resolveDependencies($class, $dependencies);

        return $reflectionClass->newInstanceArgs($resolvedDependencies);

    }

    /**
     * @param $className
     * @param $dependencies
     * @return array
     * @throws ReflectionException
     */
    private function resolveDependencies($className, $dependencies)
    {

        $resolvedDependencies = [];

        foreach ($dependencies as $class) {
            $dependency = $class->getClass();

            if ($dependency !== null) {
                $resolvedDependencies[] = $this->resolve($class->getClass()
                    ->name);
            } else {
                if (isset($this->instances[$className]['arguments'][$class->getName()])) {
                    $resolvedDependencies[] = $this->instances[$className]['arguments'][$class->getName()];
                } else {
                    throw new Exception("cannot autowire argument " . $class->getName() . " of class " . $className);
                }
            }
        }

        return $resolvedDependencies;
    }

}

