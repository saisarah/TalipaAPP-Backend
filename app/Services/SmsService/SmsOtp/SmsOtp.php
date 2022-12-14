<?php

namespace App\Services\SmsService\SmsOtp;

use App\Services\SmsService\SmsSender;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SmsOtp
{
    private $ttl = 10 * 60; //10minutes

    protected $message_template = "Welcome to Talipaapp, this is your verification code: OTP_CODE";

    protected $to;

    protected $digit = 4;

    protected $type = "general";

    protected $code;

    public function __construct($to)
    {
        $this->to = $to;
        $this->code = $this->generateCode();
    }

    public function send()
    {
        Cache::put($this->getCacheKey(), $this->code, $this->ttl);
        SmsSender::sendMessage($this->to, $this->getMessage());
    }

    public function verify($code)
    {
        return $this->generateCode() == $code;
    }

    private function getCacheKey()
    {
        return "sms-otp:{$this->type}:{$this->to}";
    }

    private function getMessage()
    {
        return Str::replace("OTP_CODE", $this->code, $this->message_template);
    }

    private function generateCode()
    {
        return Cache::get($this->getCacheKey(), function() {
            $digits = $this->digit;
            return rand(pow(10, $digits-1), pow(10, $digits)-1);
        });
    }
}