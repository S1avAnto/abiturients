<?php

namespace app\Exceptions;

class JWTInvalidStructure extends \Exception
{
    protected $message = "Invalid JWT structure";
}