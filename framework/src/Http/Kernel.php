<?php

namespace NamCao\Framework\Http;

use NamCao\Framework\Routing\RouterInterface;

class Kernel {

    public function __construct(private RouterInterface $router) {
       
    }
    public function handle(Request $request): Response 
    {
       try {

            [$routerHandler, $vars] = $this->router->dispatch($request);

            $response = call_user_func_array($routerHandler, $vars);

            // Call the handler, provided by the route info, in order to create a Response
            return $response;

       } 
       catch(HttpException $e) {
            return new Response($e->getMessage(), $e->getStatusCode());
       }
       catch (\Exception $e) {
            return new Response($e->getMessage(), 400);
       }
    }
}