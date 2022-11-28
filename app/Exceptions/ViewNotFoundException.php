<?php

namespace app\Exceptions;

class ViewNotFoundException extends \Exception
{
    protected $message = "Шаблон для url не найден";
}