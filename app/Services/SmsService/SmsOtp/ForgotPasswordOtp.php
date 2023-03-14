<?php

namespace App\Services\SmsService\SmsOtp;

class ForgotPasswordOtp extends SmsOtp
{
    protected $message_template = "OTP_CODE is your TalipaAPP Verification Code.";
    protected $type = "forgot-password";
    protected $digit = 6;
}
