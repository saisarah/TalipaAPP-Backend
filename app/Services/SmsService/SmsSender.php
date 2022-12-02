<?php

namespace App\Services\SmsService;

use Illuminate\Support\Facades\Facade;

class SmsSender extends Facade
{
    private $driver;

    // protected static $drivers = [
    //     'movider' => SmsMoviderAdapter::class,
    //     'log' => SmsLogAdapter::class,
    // ];

    // public function __construct()
    // {
    //     $this->driver = config('sms.default');
    // }

    // public function driver($driver)
    // {
    //     $this->driver = $driver;
    //     return $this;
    // }

    // public function sendMessage($to, $message)
    // {
    //     $sender = app()->make($this->drivers[$this->driver]);
    //     return $sender->sendMessage($to, $message);
    // }

    protected static function getFacadeAccessor()
    {
        return 'sms';        
    }
}
