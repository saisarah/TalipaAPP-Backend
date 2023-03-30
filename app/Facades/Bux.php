<?php

namespace App\Facades;

use App\Services\Bux\Bux as BuxBux;
use Illuminate\Support\Facades\Facade;

class Bux extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return BuxBux::class;
    }
}