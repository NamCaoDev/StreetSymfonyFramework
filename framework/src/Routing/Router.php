<?php 

namespace NamCao\Framework\Routing;

use FastRoute\Dispatcher;
use NamCao\Framework\Http\Request;
use FastRoute\RouteCollector;
use NamCao\Framework\Http\HttpRequestMethodException;
use NamCao\Framework\Http\HttpException;
use Psr\Container\ContainerInterface;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface {

  private $routes = [];
  public function dispatch(Request $request, ContainerInterface $container): array {
    [$handler, $vars] = $this->extractRouteInfo($request); 

    if(is_array($handler)) {
        [$controllerId, $method] = $handler;
        $controller = $container->get($controllerId);
        $handler = [new $controller, $method];
    };
    
    return [$handler, $vars];
  }

  public function setRoutes(array $routes)
  {
    $this->routes = $routes;
  }

  private function extractRouteInfo(Request $request): array {
    $dispatcher = simpleDispatcher(function(RouteCollector $routeCollector) {
        foreach($this->routes as $route) {
            $routeCollector->addRoute(...$route);
        }
    });

    $routeInfo = $dispatcher->dispatch(
        $request->getMethod(), 
        $request->getPathInfo()
    );
    
    switch($routeInfo[0]) {
        case Dispatcher::FOUND:
            return [$routeInfo[1], $routeInfo[2]];
        case Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = implode(', ', $routeInfo[1]);
            $e = new HttpRequestMethodException("The allowed methods are $allowedMethods");
            $e->setStatusCode(400);
            throw $e;
        default:
            $e = new HttpException('Not found');
            $e->setStatusCode(404);
            throw $e;
    }
  }
}