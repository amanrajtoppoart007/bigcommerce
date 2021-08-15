<?php

namespace App\Traits;

trait FirebaseNotificationTrait {

    public function sendPushNotification($deviceTokens, $message)
    {
        $SERVER_API_KEY = 'AAAAUq-G1qw:APA91bE1OuW8z4SywDAiYbMcBpfOHEqdk12AAgWypHQxM2EggURLYTCHnOvEI4f4j1Gf56-y_D36Y75PQOkl-d7kRistINgmpmToLLB3Obf-3oeVf3NMStIC3e4gMFtuCctkry0M309S';

        $data = [
            "registration_ids" => $deviceTokens,
            "data" => $message
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
