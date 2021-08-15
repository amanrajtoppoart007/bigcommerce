<?php
namespace App\Channels;


use Illuminate\Notifications\Notification;
use App\Library\TextLocal\TextLocal;
class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notifiable, 'routeNotificationForSms')) {
            $id = $notifiable->routeNotificationForSms($notifiable);
        } else {
            $id = $notifiable->getKey();
        }

        $data = method_exists($notification, 'toSms')
            ? $notification->toSms($notifiable)
            : $notification->toArray($notifiable);
        if (empty($data)) {
            return false;
        }


        try
        {
             $sms = new TextLocal();
             return $sms->send($data['message'], $notifiable->mobile, null);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}
