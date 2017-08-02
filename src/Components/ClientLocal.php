<?php


namespace AdServer\Engine\Components;


use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientLocal
{
    protected $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function request(RequestInterface $request) : ResponseInterface
    {
        return Engine::getRouter()->handle(new Request($request->getMethod(), $this->prefix . $request->getUri()->getPath()));
    }
}