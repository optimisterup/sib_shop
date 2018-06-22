<?php

namespace AppBundle\PayPal;

use GuzzleHttp\Client;

class PayPalHttpsConnection
{
    private $paypalClientId = "AV8vlKKAWcwNlGjfMNP9rlzulukC6u6JvKg0iKxuEZ3dVwsmjJE7yuu2otp8q9y-NCGG6kUUlsu36eWd";
    private $paypalClientSecret = "EFjvW5QInZHBeZtbTi5-EL7y0JP1UsUrkUqHKng8EOvuR_iui7pjtpo_vj_3pEXZxcorhasaTQyjzian";


    public function connect()
    {
        $client = new Client();

        $request = $client->post(
            'https://api.sandbox.paypal.com/v1/oauth2/token',[
                'headers'=>[
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'body' => 'grant_type=client_credentials',
                'auth'=> [$this->paypalClientId, $this->paypalClientSecret],
                ]);

        return $request->getHeaders()['X-PAYPAL-TOKEN-SERVICE'][0];
    }

//    public function pay()
//    {
//
//        $token=$this->connect();
//        $client = new Client();
//        $request = $client->post(
//            'https://api.sandbox.paypal.com/v1/payments/payment/',[
//            'headers'=>[
//                'Accept' => 'application/json',
//                'Accept-Language' => 'en_US',
//                'Content-Type' => 'application/x-www-form-urlencoded'
//            ],
//            'body' => 'grant_type=client_credentials',
//            'token'=> [$token],
//        ]);
//
//        return $request;
//    }


}


