<?php

namespace app\Exceptions;

class RouteNotFoundException extends \Exception
{
    protected $message = "URL не найден";
}