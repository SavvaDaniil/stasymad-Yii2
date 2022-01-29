<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

use app\service\CartService;

use app\models\Back;
use app\models\Course;
use app\models\User;
use app\models\Cart;
use app\models\PayPalClient;

class CartController extends Controller {

    public function actionIndex(){

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/login']);
        }
        $this->view->title = "Cart | Nastya's Bagdasarova Online Platform";

        $cartList = CartService::listAllAddedByActualUser();

        $user = User::find()
        -> where(["id" => Yii::$app->user->id])
        -> one();

        $payPalClientId = PayPalClient::$clientId;
        if($user -> isTest == 1){
            $payPalClientId = PayPalClient::$clientIdTest;
        }


        return $this->render("index", compact(["cartList","payPalClientId"]));
    }
}