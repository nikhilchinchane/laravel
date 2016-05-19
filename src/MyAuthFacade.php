<?php

namespace Nikhil\Authentication;
use Illuminate\Support\Facades\Facade;
class MyAuthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MyAuth';
    }
}