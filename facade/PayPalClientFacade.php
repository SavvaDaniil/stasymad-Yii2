<?php

namespace app\facade;

use app\models\PayPalClient;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;


class PayPalClientFacade {

    
    public static function getOrder($debug=false, $orderId, $client)
    {

        // 3. Call PayPal to get the transaction details
        //$client = PayPalClient::client();

        $response = $client->execute(new OrdersGetRequest($orderId));
        
        /**
         *Enable the following line to print complete response as JSON.
        */
        //print json_encode($response->result);
        if($debug){
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
        }

        // To print the whole response body, uncomment the following line
        // echo json_encode($response->result, JSON_PRETTY_PRINT);
        return $response;
    }



    public static function createOrder($debug=false, $client, $summa)
    {
        if(is_null($summa) || $summa <= 0 || is_null($client))return null;

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = self::buildRequestBody($summa);
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
    private static function buildRequestBody($summa)
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
                            'reference_id' => 'PUHF',
                            'description' => 'Sporting Goods',
                            'custom_id' => 'CUST-HighFashions',
                            'soft_descriptor' => 'HighFashions',

                            'amount' =>
                                array(
                                    'currency_code' => 'RUB',
                                    'value' => $summa
                                )
                        )
                )
        );
    }


    public static function captureOrder($orderId, $client, $debug=false)
    {
        //$request = new OrdersCaptureRequest($orderId);

        // 3. Call PayPal to capture an authorization
        //$client = PayPalClient::client();
        //$response = $client->execute($request);

        $response = $client->execute(new OrdersCaptureRequest($orderId));


        // 4. Save the capture ID to your database. Implement logic to save capture to your database for future reference.
        if ($debug)
        {
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Links:\n";
            foreach($response->result->links as $link)
            {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }
            print "Capture Ids:\n";
            foreach($response->result->purchase_units as $purchase_unit)
            {
                foreach($purchase_unit->payments->captures as $capture)
                {   
                    print "\t{$capture->id}";
                }
            }
            // To print the whole response body, uncomment the following line
            // echo json_encode($response->result, JSON_PRETTY_PRINT);
        }

        return $response;
    }
}