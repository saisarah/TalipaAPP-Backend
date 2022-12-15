<?php

namespace App\Services\SmsService\SmsOtp;

class RegisterOtp extends SmsOtp
{
    protected $message_template = "Good Day! Thank you for signing up, to verify your account, please enter this OTP: OTP_CODE to continue using Talipaapp.";
    protected $type = "register";
}
