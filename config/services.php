<?php // config/services.php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\ReflectionContainer;
use NamCao\Framework\Http\Kernel;
use NamCao\Framework\Routing\Router;
use NamCao\Framework\Routing\RouterInterface;

$container = new \League\Container\Container();

$container->delegate(new ReflectionContainer(true));

$routes = include BASE_PATH . '/routes/web.php';

$appEnv = 'prod';

$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('setRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)->addArguments([RouterInterface::class, $container]);

return $container;