<?php // config/services.php

use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\ReflectionContainer;
use NamCao\Framework\Controller\AbstractController;
use NamCao\Framework\Http\Kernel;
use NamCao\Framework\Routing\Router;
use NamCao\Framework\Routing\RouterInterface;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$container = new \League\Container\Container();

$container->delegate(new ReflectionContainer(true));

$routes = include BASE_PATH . '/routes/web.php';
$templatesPath = BASE_PATH . '/templates';

$appEnv = $_SERVER['APP_ENV'];

$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall('setRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)->addArgument(RouterInterface::class)->addArgument($container);

$container->addShared('filesystem-loader', \Twig\Loader\FilesystemLoader::class)
    ->addArgument(new \League\Container\Argument\Literal\StringArgument($templatesPath));

$container->addShared('twig', \Twig\Environment::class)
    ->addArgument('filesystem-loader');

$container->inflector(AbstractController::class)->invokeMethod('setContainer', [$container]);

return $container;