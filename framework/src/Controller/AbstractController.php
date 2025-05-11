<?php

namespace NamCao\Framework\Controller;

use NamCao\Framework\Http\Response;
use Psr\Container\ContainerInterface;

abstract class AbstractController {

    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function render(string $template, array $parameters = [], ?Response $response = null): Response
    {
        $twig = $this->container->get('twig');
        $content = $twig->render($template,$parameters);

        $response ??= new Response();

        $response->setContent($content);

        return $response;
    }
}