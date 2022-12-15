<?php

namespace App\Services\SmsService\SmsOtp;

class LoginOtp extends SmsOtp
{
    protected $message_template = "Hello, this is your Talipaapp OTP login code OTP_CODE";
    protected $type = "login";

}