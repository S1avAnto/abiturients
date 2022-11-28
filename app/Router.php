<?php
declare(strict_types=1);

namespace app;

use app\Exceptions\RouteNotFoundException;
use app\Controllers;
class Router {

    private array $routes;

    public function get(string $route, array|callable $action) : self {
        $this->routes["GET"][$route] = $action;
        return $this;
    }

    public function post(string $route, array|callable $action) : self {
        $this->routes["POST"][$route] = $action;
        return $this;
    }

    // Какие секции совпадают с запросом
    private function dynamicRouteMatchSections($uriSplit, $routeSplit) : bool {
        foreach ($uriSplit as $key => $uriSection) {
            if (str_contains($routeSplit[$key], ":")) continue;
            if ($routeSplit[$key] !== $uriSection) return false;
        }
        return true;
    }
    // Ищет индексы входных параметров
    private function dynamicRouteFindParams($uriSplit, $routeSplit) : array {
        $sectionParamsMatches = [];
        foreach ($uriSplit as $key => $uriSection){
            if (str_contains($routeSplit[$key], ":")) {
                $sectionParamsMatches[] = $key;
            }
        }
        return $sectionParamsMatches;
    }

    public function resolve(string $method, string $uri) {

        $uri = explode("?", $uri)[0];
        $action = $this->routes[$method][$uri] ?? null;

        $routeParams = [];
        if (!$action) {

            $uriSplit = explode("/", $uri);
            foreach ($this->routes[$method] as $route => $keys) {

                $routeSplit = explode("/", $route);
                // Проверяем кол-во эл-в в массивах и совпадение секций
                if (count($uriSplit) !== count($routeSplit) ||
                    !$this->dynamicRouteMatchSections($uriSplit, $routeSplit)) continue;

                // Индексы элементов, которые входят в url
                $indices = $this->dynamicRouteFindParams($uriSplit, $routeSplit);

                $action = $this->routes[$method][$route]; // класс и метод с параметрами

                foreach ($indices as $index) {
                    $routeParams += [ str_replace(":", "", $routeSplit[$index]) => $uriSplit[$index] ];
                }

                break;
            }

            if (empty($routeParams)) {
                throw new RouteNotFoundException();
            }

        }

        if (is_array($action)) {

            [$class, $method] = $action;

            if (class_exists($class)) {

                $class = new $class();

                if (method_exists($class, $method)) {
                    empty($routeParams) ? $class->$method() : $class->$method($routeParams);
                }
            }

        }

    }

}