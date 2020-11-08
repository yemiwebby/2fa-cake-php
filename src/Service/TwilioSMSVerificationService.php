<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioSMSVerificationService
{
    private string $phoneNumber;
    private string $serviceSid;
    private Client $twilio;

    public function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $this->serviceSid = (string)env('TWILIO_SERVICE_SID');
        $this->twilio = new Client($sid, $token);
    }


    public function sendVerificationToken()
    {
        $this
            ->twilio
            ->verify
            ->v2
            ->services($this->serviceSid)
            ->verifications
            ->create($this->phoneNumber, 'sms');
    }


    public function isValidToken(string $token): bool
    {
        $verificationResult =
            $this
                ->twilio
                ->verify
                ->v2
                ->services($this->serviceSid)
                ->verificationChecks
                ->create($token,
                    ['to' => $this->phoneNumber]
                );
        return $verificationResult->status === 'approved';
    }
}
