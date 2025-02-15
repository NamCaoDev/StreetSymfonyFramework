<?php

namespace NamCao\Framework\Http;

use NamCao\Framework\Routing\RouterInterface;
use Psr\Container\ContainerInterface;

class Kernel {

    private string $appEnv;

    public function __construct(private RouterInterface $router, private ContainerInterface $container) {
        $this->appEnv = $container->get('APP_ENV');
    }
    public function handle(Request $request): Response 
    {
       try {
            
            [$routerHandler, $vars] = $this->router->dispatch($request, $this->container);

            $response = call_user_func_array($routerHandler, $vars);

            // Call the handler, provided by the route info, in order to create a Response

       } 
       catch(\Exception $e) {
            $response = $this->createExceptionResponse($e);
       }
       return $response;
    }

     /**
     * @throws  \Exception $exception
     */
    private function createExceptionResponse(\Exception $e): Response {
       if(in_array($this->appEnv, ['dev', 'test'])) {
          throw $e;
       }
       if($e instanceof HttpException) {
          return new Response($e->getMessage(), $e->getStatusCode());
       }
       return new Response('Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}