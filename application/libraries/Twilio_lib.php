<?php 

// application/libraries/Twilio_lib.php

use Twilio\Rest\Client;
#[\AllowDynamicProperties]

class Twilio_lib {
    
    private $twilio;

    public function __construct() {
        // Initialize Twilio client
        $accountSid = 'AC0d0dffe9c8e7b390bfcb237aacf29fa2';
        $authToken = '828541afc98968bebd4a51c5b7362ff2';
        $this->twilio = new Client($accountSid, $authToken);
    }

    public function sendVerificationCode($phoneNumber) {
        // pr('hi');
        $verify_service_sid = 'VA6253af5e960831ae164162c613ca8e96';
        
        try{
            $verification = $this->twilio->verify->v2->services($verify_service_sid)
            ->verifications
            ->create($phoneNumber, 'sms');
    
            return $verification;
        }catch (Exception $e){
            return 'Error: ' . $e->getMessage();
        }
        

    }

    public function verifyCode($phoneNumber, $code) {
        $verify_service_sid = 'VA6253af5e960831ae164162c613ca8e96';
    
        try {
            $verificationCheck = $this->twilio->verify->v2->services($verify_service_sid)
                ->verificationChecks
                ->create([
                             "to" => $phoneNumber,
                             "code" => $code
                         ]
                );

            return $verificationCheck;

        } catch (Exception $e) {
            // Handle exception
            return $e->getMessage();
        }
    }

    public function send_sms($to, $msg) {
        // Send SMS using Twilio
        // pr($to);
        try {
            $message = $this->twilio->messages
            ->create($to, // to
                     ["from" => "+447723472308", "body" => $msg]
            );

            // You can log or handle the success response as needed
            return $message;
        } catch (Exception $e) {
            // pr($e->getMessage());
            log_message('error', 'Twilio SMS Error: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    // Your existing phone verification methods go here
}



?>