<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use yii\filters\auth\HttpBasicAuth;

use app\models\User;
use app\models\Payment;
use app\models\AccessOfUserPrepare;
use app\service\AccountService;
use app\service\AccessOfUserPrepareService;
use app\service\CartService;
use app\component\Security;
use app\observers\PaymentObserver;


use app\facade\PayPalClientFacade;
use app\factory\PayPalClientFactory;

class PaypalController extends \yii\rest\Controller {

    public $json = array();

    public function actionCreateorder(){

        if(Yii::$app->user->isGuest){
            return null;
        }

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
            return null;
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

        $payPalClient = PayPalClientFactory::createNewClient($user);
        $payPalOrder = PayPalClientFacade::createOrder(false, $payPalClient, $summa);

        if($payPalOrder->result->status != "CREATED"){
            return null;
        }

        $payment -> paypal_payment_id = $payPalOrder -> result -> id;
        $payment -> save();

        $payPalOrder -> id = $payPalOrder -> result -> id;

        //return $this -> asJson($this -> json);
        return $payPalOrder;
    }


    public function actionGetorder(){

        if(Yii::$app->user->isGuest){
            return null;
        }

        //$request = Yii::$app->request;
        $request = Yii::$app->getRequest()->getBodyParams();
        $orderID = Security::check_values_150($request["orderID"]);

        
        $payment = Payment::find()
        -> where('paypal_payment_id=:paymentId', [':paymentId' => $orderID])
        -> andWhere(["status" => 0])
        -> one();
        $user = User::find()
        -> where(["id" => Yii::$app->user->id])
        -> one();


        $this -> json["answer"] = "error";
        if(!is_null($payment) && !empty($payment) && !is_null($user) && !empty($user)){

            $payPalClient = PayPalClientFactory::createNewClient($user);
            //$checkOrder = PayPalClientFacade::getOrder(false, $payment -> paypal_payment_id, $payPalClient);
            $checkOrder = PayPalClientFacade::captureOrder($payment -> paypal_payment_id, $payPalClient, false);

            //if($checkOrder -> result -> status == "APPROVED" || $checkOrder -> result -> status == "COMPLETED"){
            if($checkOrder -> result -> status == "COMPLETED"){
                $payment -> status = 1;
                $payment -> date_of_done = date("Y-m-d H:i:s");
                $payment -> save();
                
                CartService::clearCart();
                $accessOfUserList = AccessOfUserPrepareService::generateAndReturnAccessesOfUserAfterPaymentOrReturnNull($payment -> id);
                PaymentObserver::reportAboutNewPaymentAndNewAccessesOfUser($accessOfUserList, $user, $payment);
    
                $this -> json["answer"] = "success";
                //return $this->redirect(['/payment/success']);
            } else {

                //return $this->redirect(['/payment/error']);
            }
            //return $checkOrder;


        } else {
            //return $this->redirect(['/payment/error']);
        }

        //return $this -> render("check");
        return $this -> asJson($this-> json);
    }
}