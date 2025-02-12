<?php

namespace NamCao\Framework\Container;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface {

    private array $services = [];

    public function add(string $id, string|object $concrete = null)
    {
        if(null === $concrete) {
            $concrete = $id;
            if(!class_exists($concrete)) {
                throw new ContainerException("Service $id could not be found");
            }
        }
        $this->services[$id] = $concrete;
    }
    
    public function get(string $id) {
        if(!$this->has($id)) {
            if(!class_exists($id)) {
                throw new ContainerException("Service $id could not be found");
            }
            $this->add($id);
        }
       
        $object = $this->resolve($this->services[$id]);

        return $object;
    }

    private function resolve($class) {
        
        $reflection = new \ReflectionClass($class);

        $contructor = $reflection->getConstructor();

        if(null === $contructor) {
            return $reflection->newInstance();
        }

        $constructorParams = $contructor->getParameters();

        $classDependencies = $this->resolveClassDependencies($constructorParams);

        $service = $reflection->newInstanceArgs($classDependencies);

        return $service;
        // dd($contructor);
    }

    private function resolveClassDependencies($constructorParams): array {
        $classDependencies = [];

        /** @var \ReflectionParameter $parameter */
        foreach ($constructorParams as $parameter) {

            // Get the parameter's ReflectionNamedType as $serviceType
            $serviceType = $parameter->getType();

            // Try to instantiate using $serviceType's name
            $service = $this->get($serviceType->getName());

            // Add the service to the classDependencies array
            $classDependencies[] = $service;
        }

        return $classDependencies;
    }

    public function has(string $id): bool {
        return array_key_exists($id, $this->services);
    }
}