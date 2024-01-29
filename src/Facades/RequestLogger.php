<?php

namespace GregPriday\RobustOpenAI\Facades;

use Closure;
use GregPriday\RobustOpenAI\RequestLogger as RequestLoggerClass;
use Illuminate\Support\Facades\Facade;

class RequestLogger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RequestLoggerClass::class;
    }

    public static function start(Closure $closure = null): RequestLoggerClass
    {
        $logger = new RequestLoggerClass(true);
        app()->instance(RequestLoggerClass::class, $logger);

        if ($closure) {
            // If a closure is provided, execute it and then stop the logger
            $closure();
            static::stop();
        }

        return $logger;
    }

    public static function stop(): ?RequestLoggerClass
    {
        $logger = app()->make(RequestLoggerClass::class);
        app()->forgetInstance(RequestLoggerClass::class);
        return $logger;
    }
}
