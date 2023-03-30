<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Transportify extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'transportify';
    }
}