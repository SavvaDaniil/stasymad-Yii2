<?php

namespace app\service;

use Yii;
use app\models\Back;
use app\models\Course;
use app\models\User;
use app\models\AccessOfUser;
use app\models\AccessOfUserPrepare;
use app\models\Cart;


class AccessOfUserPrepareService {

    public static function generateAndReturnAccessesOfUserAfterPaymentOrReturnNull($id_of_payment){
        $accessOfUserPrepareList = AccessOfUserPrepare::find()
        -> where(["id_of_user" => Yii::$app->user->id])
        -> andWhere("id_of_payment = :id_of_payment", ["id_of_payment" => $id_of_payment])
        -> andWhere(["status" => 0])
        -> all();
        $accessOfUser;
        $accessOfUserList = array();
        foreach($accessOfUserPrepareList as $accessOfUserPrepare){
            $course = Course::findActiveByIdOrReturnNull($accessOfUserPrepare -> id_of_course);
            if(is_null($course))continue;
            
            $accessOfUser = new AccessOfUser();
            $accessOfUser -> id_of_user = $accessOfUserPrepare -> id_of_user;
            $accessOfUser -> id_of_payment = $accessOfUserPrepare -> id_of_payment;
            $accessOfUser -> date_of_add = date("Y-m-d H:i:s");
            $accessOfUser -> id_of_course = $accessOfUserPrepare -> id_of_course;
            $accessOfUser -> days = $course -> days;
            $accessOfUser -> kind = 0;
            $accessOfUser -> status = 1;
            $accessOfUser -> save();

            $accessOfUserPrepare -> status = 1;
            $accessOfUserPrepare -> save();
            array_push($accessOfUserList, $accessOfUser);
        }

        return $accessOfUserList;
    }

    public static function prepareAccessesOfUserBeforePayment($id_of_payment, $cartList){
        $accessOfUserPrepare;
        foreach($cartList as $key => $cartItem){

            $accessOfUserPrepare = AccessOfUserPrepare::find()
            -> where(["id_of_user" => Yii::$app->user->id])
            -> andWhere("id_of_course = :id_of_course", ["id_of_course" => $key])
            -> andWhere(["status" => 0])
            -> one();

            if(is_null($accessOfUserPrepare) || empty($accessOfUserPrepare)){
                $accessOfUserPrepare = new AccessOfUserPrepare();
                $accessOfUserPrepare -> id_of_payment = $id_of_payment;
                $accessOfUserPrepare -> id_of_course = $key;
                $accessOfUserPrepare -> status = 0;
                $accessOfUserPrepare -> id_of_user = Yii::$app->user->id;

            } else {
                $accessOfUserPrepare -> id_of_payment = $id_of_payment;
            }

            $accessOfUserPrepare -> save();
        }
    }

}