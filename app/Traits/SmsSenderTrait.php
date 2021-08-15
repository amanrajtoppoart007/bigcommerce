<?php
namespace App\Traits;

use App\Library\TextLocal\TextLocal;

trait SmsSenderTrait {

    public function sendRegisteredHelpCenterSms($data)
    {
        $message = "Welcome to KV PRO. Your username is ". $data['username'];
        $message .= " and your password is " . $data['password'];
        $message .= " Do not share your credentials with anyone";
        $sms = new TextLocal();
        $sms->send($message, $data['mobile'], 'KSVPRO');
    }

    public function sendRegisteredFranchiseeSms($data)
    {
        $message = "Welcome to KV PRO. Your username is ". $data['username'];
        $message .= " and your password is " . $data['password'];
        $message .= " Do not share your credentials with anyone";
        $sms = new TextLocal();
        $sms->send($message, $data['mobile'], 'KSVPRO');
    }

    public function sendRegisteredUserSms($data)
    {
        $message = "Welcome to KV PRO. Your username is ". $data['username'];
        $message .= " and your password is " . $data['password'];
        $message .= " Do not share your credentials with anyone";
        $sms = new TextLocal();
        $sms->send($message, $data['mobile'], 'KSVPRO');
    }

    public function sendFranchiseeOrderPlacedSms($data)
    {
        $message = "Dear, " . $data['name'] . ' Your order has been place.';
        $message .= "Order # " . $data['order_number'] . ' on ' . $data['date'];
        $message .= "\r\n Regards, KV PRO";
        $sms = new TextLocal();
        $sms->send($message, $data['mobile'], 'KSVPRO');
    }

    public function sendUserOrderPlacedSms($data)
    {
        $message = "Dear, " . $data['name'] . ' Your order has been place.';
        $message .= "Order # " . $data['order_number'] . ' on ' . $data['date'];
        $message .= "\r\n Regards, KV PRO";
        $sms = new TextLocal();
        $sms->send($message, $data['mobile'], 'KSVPRO');
    }

    public function sendOtpSms($data)
    {
        $message = "Your KV PRO OTP for " . $data['service_type'] . " ";
        $message .= "is ". $data['otp'] ." Please do not share your OTP with anyone";
        $sms = new TextLocal();
        return $sms->send($message, $data['mobile'], 'KSVPRO');
    }


}
