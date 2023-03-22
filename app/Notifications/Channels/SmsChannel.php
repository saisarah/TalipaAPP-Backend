<?php

namespace App\Notifications\Channels;

use App\Services\SmsService\SmsSender;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        SmsSender::sendMessage($notifiable->contact_number, $message);
    }
}