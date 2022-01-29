<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use yii\filters\auth\HttpBasicAuth;

use app\component\Security;
use app\models\Course;


class CartController extends \yii\rest\Controller {

    private static $json = array();

    public function actionAdd(){

        if(!(Yii::$app->request->isPost)){
            return self::$json;
        }

        if (Yii::$app->user->isGuest) {
            self::$json["answer"] = "error";
            self::$json["error"] = "quest";
            return self::$json;
        }

        $request = Yii::$app->request;
        $session = Yii::$app->session;
        if (!($session->isActive)){
            $session -> open();
        }
        
        $id = $request->post('id');
        /*
        back
        0 - без обратной связи
        1 - с обратной связью

        operation
        0 - покупка
        1 - продление
        */
        $back = $request->post('back');
        $operation = $request->post('operation');

        if(isset($_SESSION["cart"]["course"][$id])
            && $_SESSION["cart"]["course"][$id]["back"] == $back
            && $_SESSION["cart"]["course"][$id]["operation"] == $operation){
            self::$json["answer"] = "error";
            self::$json["error"] = "already_done";
            return self::$json;
        }
        if($back != 0 && $back != 1 || $back == "" || $operation == ""){
            self::$json["answer"] = "error";
            self::$json["error"] = "no_data";
            return self::$json;
        }


        $course = Course::findActiveByIdOrReturnNull($id);

        if(!empty($course)){

            $price_to_session = $course -> price;

            if($back == 1){
                $back_model = Back::find()
                -> where(["id_of_course" => $id])
                -> andWhere(["status" => 1])
                -> one();

                if(!empty($back_model)){
                    $_SESSION["cart"]["course"][$id] = [
                        "id" => $id,
                        "back" => $back,
                        "operation" => $operation,
                        "price" => $back_model -> price
                    ];
                }
            }
            $_SESSION["cart"]["course"][$id] = [
                "id" => $id,
                "back" => $back,
                "operation" => $operation,
                "price" => $price_to_session
            ];


            self::$json["answer"] = "success";
            self::$json["count"] = count($session["cart"]);
            return self::$json;
        } else {
            self::$json["answer"] = "error";
            self::$json["error"] = "no_product";
            return self::$json;
        }

        return self::$json;
    }

    public function actionRemove(){

        if(!(Yii::$app->request->isPost)){
            return self::$json;
        }

        if (Yii::$app->user->isGuest) {
            self::$json["answer"] = "error";
            self::$json["error"] = "quest";
            return self::$json;
        }

        $request = Yii::$app->request;
        $session = Yii::$app->session;
        if (!($session->isActive)){
            $session -> open();
        }
        
        $id = $request->post('id');
        $product = $request->post('product');

        unset($_SESSION["cart"][$product][$id]);
        self::$json["answer"] = "success";

        return self::$json;
    }

}