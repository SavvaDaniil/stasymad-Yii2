<?php

namespace app\service;

use Yii;
use app\models\User;
use app\component\Security;
use app\observers\ForgetObserver;

class ForgetService {
    private static $json = array();

    public static function init($username, $action, $code, $hash){

        if($action == 0 && !is_null($username)){
            return self::forgetStart($username);
        }
        
        if($action == 1 && !is_null($username) && !is_null($code) && !is_null($hash)){
            return self::finishForget($username, $code, $hash);
        }


        self::$json["answer"] = "error";
        self::$json["error"] = "no_data";
        return self::$json;
    }

    private static function forgetStart($username){

        $user = User::find() -> where('username=:username', [':username' => $username]) -> one();
        if(empty($user)){
            self::$json["answer"] = "error";
            self::$json["error"] = "no_user";
            return self::$json;
        }

        $forgetCount = $user -> forgetCount;

        //проверяем, на сколько часто восстановление пароля происходило
        if($user -> forgetLast > (strtotime(date("Y-m-d H:i:s")) - 60 * 20)){
            if($forgetCount > 2){
                self::$json["answer"] = "error";
                self::$json["error"] = "please_wait_20";
                return self::$json;
            }
        } else {
            $forgetCount = 0;
        }

        $forgetCode = Security::generatedRandomString(6);
        $forgetHash = Security::generatedRandomString(32);


        $user -> forgetCode = $forgetCode;
        $user -> forgetTry = 0;
        $user -> forgetHash = $forgetHash;
        $user -> forgetCount = $forgetCount + 1;
        $user -> forgetLast = strtotime(date("Y-m-d H:i:s"));
        $user -> save();

        
        ForgetObserver::sendMessageWithCodeToUser($user, $forgetCode);
        

        self::$json["answer"] = "success";
        //self::$json["code"] = $forgetCode;
        self::$json["hash"] = $forgetHash;
        return self::$json;
    }



    private static function finishForget($username, $code, $hash){
        
        //проверяем код
        $user = User::find() -> where('username=:username', [':username' => $username]) -> one();
        if(empty($user)){
            self::$json["answer"] = "error";
            self::$json["error"] = "no_user";
            return self::$json;
        }

        
        //проверяем hash
        if($user -> forgetHash == $hash){
            //проверяем код, если не подходит, увеличиваем попытки
            if($user -> forgetCode == $code){

                $user -> forgetCode = null;
                $user -> forgetTry = 0;
                $user -> forgetHash = null;
                $user -> forgetCount = 0;
                $user -> forgetLast = strtotime(date("Y-m-d H:i:s"));

                $user -> authKey = Security::generatedRandomString(32);

                $new_password = Security::generatedRandomString(6);
                $hash_of_password = Yii::$app->getSecurity()->generatePasswordHash($new_password);
                $user -> password = $hash_of_password;
                $user -> save();


                ForgetObserver::sendMessageWithNewPasswordToUser($user, $new_password);


                //дальше авторизация
                if(Yii::$app->user->login($user, 3600*24*30)){
                    self::$json["answer"] = "success";
                } else {
                    self::$json["answer"] = "error";
                }
                return self::$json;

            } else {
                $forgetTry = $user -> forgetTry;
                $user -> forgetTry = $forgetTry + 1;
                $user -> save();

                if($forgetTry == 0){
                    self::$json["answer"] = "error";
                    self::$json["error"] = "wrong_code_2";
                    return self::$json;
                } else if($forgetTry == 1){
                    self::$json["answer"] = "error";
                    self::$json["error"] = "wrong_code_1";
                    return self::$json;
                } else {
                    self::$json["answer"] = "error";
                    self::$json["error"] = "limit_try";
                    return self::$json;
                }
            }
        } else {
            self::$json["answer"] = "error";
            self::$json["error"] = "error_hash";
            return self::$json;
        }
  
        self::$json["answer"] = "error";
        self::$json["error"] = "error_after_hash";


        return self::$json;
    }

}
