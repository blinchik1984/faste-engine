<?php


namespace AdServer\Engine\Components;


use GuzzleHttp\Psr7\Request;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Test implements MiddlewareInterface
{
    public function __construct()
    {
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        echo "test Middleware<br>";
        $delegate->process($request);
    }
}