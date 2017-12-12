<?php
namespace ExpressiveProvider;

abstract class RouterProvider implements ProviderContract
{
    /**
     * @var array
     */
    private $routes = [];

    public function __invoke()
    {
        $this->register();
        return [
            'routes' => $this->routes
        ];
    }

    /**
     * @param string $path
     * @param array $middleware
     * @param array $methods
     */
    protected function addRoute(string $path, $middleware = [], array $methods)
    {
        $this->routes[] = [
          'path' => $path,
          'middleware' => $middleware,
          'allowed_methods' => $methods
        ];
    }
}
