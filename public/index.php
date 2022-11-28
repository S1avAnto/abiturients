<?php

use app\Controllers\AuthController;
use app\Controllers\ProfileController;
use app\Router;
use app\App;
use app\Controllers\HomeController;

define("__VIEW_PATH__", dirname(__DIR__) . "/app/Views/");
define("__UPLOADS_PATH__", dirname(__DIR__) . "/uploads/img/");
const __ADMIN__ = "x";
const __USER__ = "y";

spl_autoload_register(function ($class) {
    $className = str_replace("\\","/", dirname(__DIR__) . "/" . $class . ".php");
    if (file_exists($className)) {
        require_once $className;
    }
});
session_start();

//echo data_uri('../img/haise.jpg','image/jpeg');

//file_get_contents('/var/www/img/haise.jpg');
//echo "<pre>";

$route = new Router();

$route
    ->get('/', [HomeController::class, 'index'])
    ->get('/registration', [AuthController::class, 'registerView'])
    ->post('/registration', [AuthController::class, 'register'])
    ->get('/login', [AuthController::class, 'loginView'])
    ->post('/login', [AuthController::class, 'login'])
    ->get('/logout', [AuthController::class, 'logout'])
    ->get('/profile', [ProfileController::class, 'ProfileView'])
    ->post('/profile/addEgeResults', [ProfileController::class, 'addEgeResults'])
    ->post('/profile/addRequest', [ProfileController::class, 'addRequest'])
    ->post('/profile/changeUserFullname', [ProfileController::class, 'changeUsername']);
    //->get('/profile/:userId/13/:randomVariable', [ProfileController::class, 'index']); // Динамический роут работает

(new App($route, [ "method" => $_SERVER["REQUEST_METHOD"], "uri" => $_SERVER["REQUEST_URI"]],
    [
    "driver"=>"mysql",
    "host"=>"db",
    "database"=>"abiturients",
    "user"=>"root",
    "password"=>"root"
    ]
))->run();
//echo "</pre>";