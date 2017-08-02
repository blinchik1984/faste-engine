<?php


namespace AdServer\Engine\Components;


use FastRoute\RouteCollector;
use Symfony\Component\Yaml\Yaml;

class YamlRoutesLoader
{
    protected $routeCollector;

    public function __construct(
        RouteCollector $routeCollector
    )
    {
        $this->routeCollector = $routeCollector;
    }

    public function loadRoutes(string $configPath, string $prefix = '') : RouteCollector
    {
        $parsed = Yaml::parse(file_get_contents($configPath));

        if (empty($parsed)) {
            return $this->routeCollector;
        }

        if (!empty($prefix)) {
            $this->routeCollector->addGroup($prefix, function(RouteCollector $routeCollector) use ($parsed) {
                $this->addRoutes($parsed, $routeCollector);
            });
        } else {
            $this->addRoutes($parsed, $this->routeCollector);
        }

        return $this->routeCollector;
    }


    protected function addRoutes(array $routes, RouteCollector $routerCollector)
    {
        foreach ($routes as $routeConfig) {
            $routerCollector->addRoute($routeConfig['method'], $routeConfig['route'], $routeConfig['handle']);
        }
    }
}