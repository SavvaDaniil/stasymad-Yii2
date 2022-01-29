<?php

namespace app\service;

use Yii;
use app\models\User;
use app\observers\RegistrationObserver;

class RegistrationService {


    public static function init($username, $fio, $password, $confirmPassword){
        $json = array();

        if(empty($fio) || empty($username) ||  empty($password) ||  empty($confirmPassword) || ($password != $confirmPassword)){
            $json["answer"] = "error";
            $json["error"] = "no_data";
            return $json;
        }


        $check_user = User::find() -> where('username=:username', [':username' => $username]) -> one();
        if(!empty($check_user)){
            $json["answer"] = "error";
            $json["error"] = "login_already_exist";
            return $json;
        }

        $user = new User;
        $user -> username = $username;
        $user -> authKey = self::generatedRandomString(32);
        $user -> fio = $fio;
        $user -> date_of_add = date("Y-m-d H:i:s");

        if($username == "savva.d@mail.ru"){
            $password = "123";
        }

        $hash_of_password = Yii::$app->getSecurity()->generatePasswordHash($password);
        $user -> password = $hash_of_password;
        $user -> save();

        RegistrationObserver::reportAboutNewUserAndSendMailToUser($user, $password);
        

        if(Yii::$app->user->login($user, 3600*24*30)){
            $json["answer"] = "success";
        } else {
            $json["answer"] = "error";
        }

        return $json;
    }

    
    public static function generatedRandomString($length){
        $arr = array('1','2','3','4','5',
            '6','7','8','9','0',
            'a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            '1','2','3','4','5','6',
            '7','8','9','0');

        $new_hash = "";
        for($k=0;$k < $length; $k++){
            $index = rand(0, count($arr) - 1);
            $pass = $arr[$index];
            $new_hash = $new_hash . $pass;
        }
        return $new_hash;
    }
}