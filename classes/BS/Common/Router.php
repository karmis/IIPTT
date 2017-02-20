<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 18.02.2017
 * Time: 20:33
 */

namespace BS\Common;

class Router
{
    private $routes;

    public function __construct()
    {
        $this->request = new Request();
        $this->routes = Config::get('routes');
    }

    public function go()
    {
        $route = $this->getRoute(); // requested route
        $exec = explode('::', $this->getExecPath($route)); // execution params for exec controller
//        die($route);
        $exec[1] .= Config::get('methodsPostfix'); // postfix for names of methods

        $reflectionMethod = new \ReflectionMethod(
            $exec[0], // namespace
            $exec[1] // method name
        );

        return $reflectionMethod->invokeArgs(new $exec[0](), array($this->getParameters()));
    }

    /**
     * Return route params as array
     * @return array
     */
    public function getRouteAsArray(): array
    {
        $route = [];
        $route['method'] = strtolower($this->request->getRequestMethod());
        $route['guarded'] = !empty($_SESSION['user'])?'guarded':'free';
        $paths = explode('/', $this->getUri());
        unset($paths[0]); // remove first item of paths list
        $route['paths'] = $paths;

        return $route;
    }

    /**
     * Return route params as string
     * @return string
     */
    public function getRoute(): string
    {
        $route = $this->getRouteAsArray();
        $route['paths'] = implode('/', $route['paths']);

        return implode('::', $route);
    }

    public function getParameters(): array
    {
        $res = [];
        $res['route'] = $this->getRouteAsArray();
        $res['server'] = $this->request->getServerParams();
        $res['body'] = $this->request->getRequestBody();

        return $res;
    }

    /**
     * Get uri
     * @return string
     */
    public function getUri(): string
    {
        $uri = substr($_SERVER['REQUEST_URI'], strlen($this->request->getBasePath()));
        // removing incorrect params
        if (strstr($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        };

        return '/' . trim($uri, '/');
    }

    /**
     * Get route as array of paths
     * @return array
     */
    public function getUriAsArray(): array
    {
        return explode('/', $this->getUri());
    }

    /**
     * Return exec path from list of routes
     * @param $route
     * @return string
     */
    private function getExecPath($route): string
    {
        $execPath = end($this->routes);
        foreach ($this->routes as $pattern => $exec) {
            preg_match('/' . $pattern . '/', $route, $matches);
            if (count($matches) > 0) {
                $execPath = $exec;
                break;
            }
        }

        return $execPath;

    }
}