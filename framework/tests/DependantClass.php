<?php 

namespace NamCao\Framework\Tests;

class DependantClass {
    public function __construct(private DependencyClass $dependency) {

    }

    public function getDependency(): DependencyClass
    {
        return $this->dependency;
    }
}