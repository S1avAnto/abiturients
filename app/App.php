<?php
declare(strict_types=1);

namespace app;

use app\Exceptions\RouteNotFoundException;
use app\Exceptions\ViewNotFoundException;

class App {

    private static DB $db;

    public function __construct(protected Router $router, protected array $request, protected array $config) {
        static::$db = new DB($config);
    }

    public static function db() : DB {
        return static::$db;
    }

    public function run() {
        try {
            $this->router->resolve($this->request['method'], $this->request['uri']);
        }
        catch (RouteNotFoundException $message) {
            http_response_code(404);
            echo $message;
        }
        catch (ViewNotFoundException $message) {
            echo $message;
        }
    }

}