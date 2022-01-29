<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use yii\filters\auth\HttpBasicAuth;

use app\component\Security;
use app\observers\PaymentObserver;
use app\observers\RegistrationObserver;


use app\models\Payment;
use app\models\User;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;


use app\factory\PayPalClientFactory;
use app\facade\PayPalClientFacade;



class TestController extends Controller {

    private $clientId = "AcAA5xlX4REfJCRhOLo5vxxVaPIrAgi1RIuot_RFBulC39GgSaul7380M3ycUQ2tYjX2w_x-0ol7ir4g";
    private $clientSecret = "EF6ClrZy0swWLp2xmMdQWHs3fR4DX0p2zOCOXuS-ic3tOSUEjgbkiA7USVqp4VPiri9uStPmNeUvhq10";

    public function actionIndex(){
        
        $json = array();
        //$json["ip"] = Yii::$app->request->userIP;

        //return $this -> asJson($json);
        //return "index";

        $payment = Payment::find()
        -> where(["id" => 107])
        -> one();
        if(is_null($payment))return "no payment";

        /*
        $apiContext;

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $this -> clientId,     // ClientID
                $this -> clientSecret      // ClientSecret
            )
        );
        $apiContext->setConfig(
            array(
            'mode' => 'live'
            )
        );

        $paymentPayPal = new \PayPal\Api\Payment();
        $resultCheck = $paymentPayPal -> get($payment -> paypal_payment_id, $apiContext);

        return $resultCheck;
        */

        //$environment = new ProductionEnvironment($this -> clientId, $this -> clientSecret);
        //$client = new PayPalHttpClient($environment);

        $user = User::find()
        -> where(["id" => Yii::$app->user->id])
        -> one();
        $client = PayPalClientFactory::createNewClient($user);




        //$client = PayPalClient::client();
        //$response = $client->execute(new OrdersGetRequest("L7SSEXY96X343546H5347229"));
        /**
         *Enable the following line to print complete response as JSON.
        */
        //return self::createOrder(true, $client);
        //return self::getOrder("53842410H30086446", $client);

        //return PayPalClientFacade::getOrder(true, "6TB83933AF663843K", $client);
        //return PayPalClientFacade::getOrder(true, $payment -> paypal_payment_id, $client);
        return PayPalClientFacade::captureOrder($payment -> paypal_payment_id, $client, true);

        //return null;
    }
    


    
    
    public static function getOrder($orderId, $client)
    {

        // 3. Call PayPal to get the transaction details
        //$client = PayPalClient::client();

        $response = $client->execute(new OrdersGetRequest($orderId));
        /**
         *Enable the following line to print complete response as JSON.
        */
        //print json_encode($response->result);
        print "Status Code: {$response->statusCode}\n";
        print "Status: {$response->result->status}\n";
        print "Order ID: {$response->result->id}\n";
        print "Intent: {$response->result->intent}\n";
        print "Links:\n";
        foreach($response->result->links as $link)
        {
        print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
        }
        // 4. Save the transaction in your database. Implement logic to save transaction to your database for future reference.
        print "Gross Amount: {$response->result->purchase_units[0]->amount->currency_code} {$response->result->purchase_units[0]->amount->value}\n";

        // To print the whole response body, uncomment the following line
        // echo json_encode($response->result, JSON_PRETTY_PRINT);
    }



    public static function createOrder($debug=false, $client)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = self::buildRequestBody();
    // 3. Call PayPal to set up a transaction

        //$client = PayPalClient::client();

        $response = $client->execute($request);
        if ($debug)
        {
        print "Status Code: {$response->statusCode}\n";
        print "Status: {$response->result->status}\n";
        print "Order ID: {$response->result->id}\n";
        print "Intent: {$response->result->intent}\n";
        print "Links:\n";
        foreach($response->result->links as $link)
        {
            print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
        }

        // To print the whole response body, uncomment the following line
        // echo json_encode($response->result, JSON_PRETTY_PRINT);
        }

        // 4. Return a successful response to the client.
        return $response;
    }

  /**
     * Setting up the JSON request body for creating the order with minimum request body. The intent in the
     * request body should be "AUTHORIZE" for authorize intent flow.
     *
     */
    private static function buildRequestBody()
    {
        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => 'https://stasymad.com/payment/check',
                    'cancel_url' => 'https://stasymad.com/payment/cansel'
                ),
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'amount' =>
                                array(
                                    'currency_code' => 'RUB',
                                    'value' => '221.00'
                                )
                        )
                )
        );
    }
}


/*
https://developer.paypal.com/docs/checkout/reference/server-integration/set-up-transaction/

Пример


Status Code: 201 Status: CREATED
Order ID: 7VU60210NP657120H
Intent: CAPTURE
Links: self: https://api.paypal.com/v2/checkout/orders/7VU60210NP657120H
Call Type: GET approve: https://www.paypal.com/checkoutnow?token=7VU60210NP657120H
Call Type: GET update: https://api.paypal.com/v2/checkout/orders/7VU60210NP657120H
Call Type: PATCH capture: https://api.paypal.com/v2/checkout/orders/7VU60210NP657120H/capture
Call Type: POST

*/