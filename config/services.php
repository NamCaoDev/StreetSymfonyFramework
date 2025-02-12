<?php // config/services.php

use NamCao\Framework\Http\Kernel;
use NamCao\Framework\Routing\Router;
use NamCao\Framework\Routing\RouterInterface;

$container = new \League\Container\Container();

$container->add(RouterInterface::class, Router::class);

$container->add(Kernel::class)->addArguments([RouterInterface::class]);

return $container;