<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use yii\filters\auth\HttpBasicAuth;

use app\component\Security;
use app\service\RegistrationService;


class RegistrationController extends Controller {


    public function actionIndex(){
        
        $request = Yii::$app->request;
        $fio = Security::check_values_150($request->post('fio'));
        $username = Security::check_values_150($request->post('username'));
        $password = Security::check_values_150($request->post('password'));
        $confirmPassword = Security::check_values_150($request->post('confirmPassword'));

        $json = array();
        if(!(Yii::$app->request->isPost))
        {
            return $this -> asJson($json);
        }
        if (!Yii::$app->user->isGuest) {
            $json["answer"] = "already_login";
            return $this -> asJson($json);
        }

        return RegistrationService::init($username, $fio, $password, $confirmPassword);
    }
}