<?php

namespace app\service;

use Yii;
use app\models\Back;
use app\models\Course;
use app\models\User;
use app\models\Cart;

class CartService {

    public static $cart_content = array();
    public static $currencyRubUsd = 73;

    public static function listAllAddedByActualUser(){

        $request = Yii::$app->request;
        $session = Yii::$app->session;
        if (!($session->isActive)){
            $session -> open();
        }

        if(empty($_SESSION["cart"])){
            return self::$cart_content;
        }

        $user = User::findActualUserOrReturnNull();
        
        if(!empty($_SESSION["cart"]["course"])){
            foreach($_SESSION["cart"]["course"] as $key => $content){
                $course = Course::findActiveByIdOrReturnNull($key);

                    if(!empty($course)){

                    $access_of_user_already = null;
                    
                    /*
                    $access_of_user_already = AccessOfUser::find()
                    -> where('id_of_course=:id_of_course', [':id_of_course' => $id])
                    -> andWhere(["id_of_user" => $user -> id])
                    -> andWhere(["is_back" => 0])
                    -> andWhere(["status" => 1])
                    -> one();
                    */

                    self::$cart_content[$key] = $content;
                    if(empty($access_of_user_already) || is_null($access_of_user_already)){
                        self::$cart_content[$key]["price"] = $course -> price;
                        self::$cart_content[$key]["priceUSD"] = round($course -> price / self::$currencyRubUsd);
                    } else {
                        self::$cart_content[$key]["price"] = round(($course -> price) / 2);
                        self::$cart_content[$key]["priceUSD"] = round(($course -> price / 2) / self::$currencyRubUsd);
                    }

                    self::$cart_content[$key]["name"] = $course -> name;
                }
            }
        }


        return self::$cart_content;
    }

    public static function clearCart(){
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        if (!($session->isActive)){
            $session -> open();
        }
        $_SESSION["cart"] = null;
    }
}