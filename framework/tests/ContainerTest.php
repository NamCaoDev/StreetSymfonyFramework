<?php 

namespace NamCao\Framework\Tests;

use PHPUnit\Framework\TestCase;
use NamCao\Framework\Container\Container;
use NamCao\Framework\Container\ContainerException;


class ContainerTest extends TestCase {

    /** @test */
    public function a_service_can_be_retrieved_from_the_container()
    {
        $container = new Container();
        
        $container->add('dependant-class', DependantClass::class);

        // Make assertions
        $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
      
    }

    /** @test */
    public function a_ContainerException_is_thrown_if_a_service_cannot_be_found()
    {
        // Setup
        $container = new Container();

        // Expect exception
        $this->expectException(ContainerException::class);

        // Do something
        $container->add('foobar');
    }

    /** @test */
    public function can_check_if_the_container_has_a_service()
    {
        // Setup
        $container = new Container();

        $container->add('dependant-class', DependantClass::class);

        $this->assertTrue($container->has('dependant-class'));
        $this->assertFalse($container->has('non-existent-class'));
    }

       /** @test */
       public function services_can_be_recursively_autowired()
       {
           $container = new Container();
   
           $dependantService = $container->get(DependantClass::class);
   
           $dependancyService = $dependantService->getDependency();
   
           $this->assertInstanceOf(DependencyClass::class, $dependancyService);
           $this->assertInstanceOf(SubDependencyClass::class, $dependancyService->getSubDependency());
       }
}