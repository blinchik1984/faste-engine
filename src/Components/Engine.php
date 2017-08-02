<?php


namespace AdServer\Engine\Components;


use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerInterface;

class Engine
{
    protected static $router;
    protected static $container;

    public static function run(
        Router $router,
        ContainerInterface $container
    )
    {
        self::$router = $router;
        self::$container = $container;

        echo self::$router->handle(ServerRequest::fromGlobals())->getBody()->getContents();
    }

    public static function getRouter() : Router
    {
        return self::$router;
    }

    public static function getContainer() : ContainerInterface
    {
        return self::$container;
    }
}