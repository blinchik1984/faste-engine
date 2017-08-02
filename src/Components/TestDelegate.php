<?php


namespace AdServer\Engine\Components;


use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestDelegate implements DelegateInterface
{
    public function process(ServerRequestInterface $request)
    {
        echo "test Delegate<br>";
    }
}