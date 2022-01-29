<?php

namespace app\factory;


use app\models\User;
use app\models\PayPalClient;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class PayPalClientFactory {
    
    private static $user;

    public static function createNewClient($user){
        if(is_null($user))return null;
        self::$user = $user;

        return self::client();
    }

    private static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    private static function environment()
    {
        if(self::$user -> isTest == 1){
            return new SandboxEnvironment(PayPalClient::$clientIdTest, PayPalClient::$clientSecretTest);
        } else if(self::$user -> isTest == 0) {
            return new ProductionEnvironment(PayPalClient::$clientId, PayPalClient::$clientSecret);
        }
        return null;
    }
}