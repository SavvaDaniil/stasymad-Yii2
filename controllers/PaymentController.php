<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\User;
use app\models\Payment;
use app\models\AccessOfUserPrepare;
use app\service\AccountService;
use app\service\AccessOfUserPrepareService;
use app\service\CartService;
use app\component\Security;
use app\observers\PaymentObserver;


use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;


class PaymentController extends Controller {

    

    public function actionIndex(){

        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }
        $this->view->title = "Processing request | Nastya's Bagdasarova Online Platform";

        $user = User::find()
        -> where(["id" => Yii::$app->user->id])
        -> one();

        $cart_content = 0;
        $payment;
        $id_of_payment;
        $already_save_payment = false;
        $access_of_user_prepare;
        $summa = 0;


        

        $cartList = CartService::listAllAddedByActualUser();
        foreach($cartList as $key => $cartItem){
            $summa += $cartItem["price"];
            $cart_content++;


        }

        if($cart_content == 0){
            return $this->redirect(['/cart']);
        }
        $summa = round($summa, 2);

        $payment = Payment::find()
        -> andWhere(["id_of_user" => Yii::$app->user->id])
        -> andWhere(["status" => 0])
        -> one();
        if(empty($payment)){
          $payment = new Payment();
          $payment -> id_of_user = Yii::$app->user->id;
          $payment -> status = 0;
          $payment -> date_of_add = date("Y-m-d H:i:s");
        }
        $payment -> summa = $summa;
        $payment -> save();

        AccessOfUserPrepareService::prepareAccessesOfUserBeforePayment($payment -> id, $cartList);

        $apiContext;
        if($user -> isTest == 1){
            $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    $this -> clientIdTest,     // ClientID
                    $this -> clientSecretTest      // ClientSecret
                )
            );
        } else {
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
        }







        // After Step 2
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        //$amount->setTotal('10.00');
        $amount->setTotal($summa);
        $amount->setCurrency('RUB');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls
            ->setReturnUrl("https://stasymad.com/payment/check")
            ->setCancelUrl("https://stasymad.com/payment/cansel");

        $paymentPayPal = new \PayPal\Api\Payment();
        $paymentPayPal->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);


        $url = "";
        $urlSuccess;
        $exception;
        try {
			
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return $this -> render("errorPrepare", compact("exception"));
        }






    }

    public function actionCheck(){
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }
        $this->view->title = "Payment check | Nastya's Bagdasarova Online Platform";

        $request = Yii::$app->request;
        $paymentId = Security::check_values_150($request->get("paymentId"));
        //echo "paymentId = " . $paymentId . "<br />";
        

        
        $payment = Payment::find()
        -> where('paypal_payment_id=:paymentId', [':paymentId' => $paymentId])
        -> andWhere(["status" => 0])
        -> one();
        $user = User::find()
        -> where(["id" => Yii::$app->user->id])
        -> one();

        if(!is_null($payment) && !empty($payment) && !is_null($user) && !empty($user)){
            $apiContext;
            if($user -> isTest == 1){
                $apiContext = new \PayPal\Rest\ApiContext(
                    new \PayPal\Auth\OAuthTokenCredential(
                        $this -> clientIdTest,     // ClientID
                        $this -> clientSecretTest      // ClientSecret
                    )
                );
            } else {
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
            }

            $paymentPayPal = new \PayPal\Api\Payment();
            $resultCheck = $paymentPayPal -> get($paymentId, $apiContext);

            if($resultCheck -> payer -> status == "VERIFIED"){
				
                return $this->redirect(['/payment/success']);
            } else {

                return $this->redirect(['/payment/error']);
            }

        } else {
            return $this->redirect(['/payment/error']);
        }

        return $this -> render("check");
    }


    public function actionSuccess(){
        $this->view->title = "Successful payment | Nastya's Bagdasarova Online Platform";
        return $this -> render("success");
    }
    public function actionError(){
        $this->view->title = "Error during the payment | Nastya's Bagdasarova Online Platform";
        return $this -> render("error");
    }

    public function actionCansel(){
        $this->view->title = "Payment was cansel | Nastya's Bagdasarova Online Platform";
        return $this -> render("cansel");
    }
}