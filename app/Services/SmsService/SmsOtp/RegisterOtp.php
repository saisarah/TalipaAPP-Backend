<?php

namespace App\Services\SmsService\SmsOtp;

class RegisterOtp extends SmsOtp
{
    protected $message_template = "Thank you for signing up, here is your Talipaapp registration code OTP_CODE ";
    protected $type = "register";
}
