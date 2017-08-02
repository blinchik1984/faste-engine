<?php


namespace AdServer\Engine\Components;


use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Router
{
    protected $dispatcher;
    protected $container;
    public function __construct(
        Dispatcher $dispatcher,
        ContainerInterface $container
    )
    {
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }

    public function handle(RequestInterface $request) : ResponseInterface
    {
        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $response = new \GuzzleHttp\Psr7\Response(404);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                $response = new \GuzzleHttp\Psr7\Response(405);
                break;
            case Dispatcher::FOUND:
                $response = $this->runController($routeInfo, $request);
                break;
        }

        return $response;
    }

    protected function runController($routeInfo, RequestInterface $request) : ResponseInterface
    {
        $handler = $routeInfo[1];
        $arguments = $routeInfo[2];

        $class = $handler['controller'];
        $method = $handler['action'];

        if (!empty($handler['before'])) {
            $this->container->get($handler['before']['middlware'])
                ->process($request, $this->container->get($handler['before']['delegate']));
        }

        return new \GuzzleHttp\Psr7\Response(
            200,
            [] ,
            json_encode((new $class)->$method($arguments))
        );
    }
}