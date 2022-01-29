<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\User;
use app\component\Security;
use app\facade\ContactsFacade;


class ApiController extends Controller {

    public function actionLogin(){
        if(!(Yii::$app->request->isPost))exit();

        $json = array();

        if (!Yii::$app->user->isGuest) {
            $json["answer"] = "already_login";
            return $this -> asJson($json);
        }
        $request = Yii::$app->request;
        $password = Security::check_values_150($request->post('password'));
        $username = Security::check_values_150($request->post('username'));

        if(empty($password) || empty($username)){
            $json["answer"] = "error";
            $json["error"] = "no_data";
            return $this -> asJson($json);
        }

        $user = User::findByUsername($username);
        if(empty($user)){
          $json["answer"] = "error";
          $json["error"] = "wrong";
          return $this -> asJson($json);
        }
        
        if (Yii::$app->getSecurity()->validatePassword($password, $user -> password)) {
            if(Yii::$app->user->login($user, 3600*24*30)){
                $json["answer"] = "success";
            } else {
                $json["answer"] = "error";
            }
            return $this -> asJson($json);
        }  else {
            $json["answer"] = "error";
            $json["error"] = "wrong";
            return $this -> asJson($json);
        }

    }

    public function actionRegistration(){
        if(!(Yii::$app->request->isPost))exit();

        $json = array();

        if (!Yii::$app->user->isGuest) {
            $json["answer"] = "already_login";
            return $this -> asJson($json);
        }
        $request = Yii::$app->request;
        $fio = Security::check_values_150($request->post('fio'));
        $username = Security::check_values_150($request->post('username'));

        if(empty($fio) || empty($username)){
            $json["answer"] = "error";
            $json["error"] = "no_data";
            return $this -> asJson($json);
        }

        $user = User::findByUsername($username);
        if(!empty($user)){
          $json["answer"] = "error";
          $json["error"] = "login_already_exist";
          return $this -> asJson($json);
        }

        $newPassword = generatedRandom(6);

        

    }

    public function actionContacts(){
        if(!(Yii::$app->request->isPost))exit();

        $json = array();

        $request = Yii::$app->request;
        $email = Security::check_values_150($request->post('email'));
        $name = Security::check_values_150($request->post('name'));
        $message = Security::check_values_long($request->post('message'), 50000);

        if(empty($email) || empty($name) || empty($message)){
            $json["answer"] = "error";
            $json["error"] = "no_data";
            return $this -> asJson($json);
        }

        if(ContactsFacade::sendMessageToAdminAndReturnBoolean($email, $name, $message)){
            $json["answer"] = "success";
        } else {
            $json["answer"] = "error";
        }
        
        return $this -> asJson($json);
    }
    
    private function generatedRandom($length){
        if(is_null($length))return 0;

			$arr = array('1','2','3','4','5',
						 '6','7','8','9','0',
						 'a','b','c','d','e','f',
						 'g','h','i','j','k','l',
						 'm','n','o','p','r','s',
						 't','u','v','x','y','z',
						 '1','2','3','4','5','6',
						 '7','8','9','0');

			$new_password = "";
			for($k=0;$k < $length; $k++){
  			$index = rand(0, count($arr) - 1);
  			$pass = $arr[$index];
  			$new_password = $new_password . $pass;
			}
      return $new_password;
  }
}