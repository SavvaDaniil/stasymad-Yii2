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
use app\service\ForgetService;


class ForgetController extends Controller {


    public function actionIndex(){
        
        $request = Yii::$app->request;
        $action = Security::check_values_150($request->post('action'));
        $username = Security::check_values_150($request->post('username'));
        $code = Security::check_values_150($request->post('code'));
        $hash = Security::check_values_150($request->post('hash'));

        $json = array();
        if(!(Yii::$app->request->isPost))
        {
            return $this -> asJson($json);
        }
        if (!Yii::$app->user->isGuest) {
            $json["answer"] = "error";
            $json["error"] = "already_login";
            return $this -> asJson($json);
        }
        if($action == ""){
            $json["answer"] = "error";
            $json["error"] = "no_data";
            return $this -> asJson($json);
        }

        return ForgetService::init($username, $action, $code, $hash);
    }
}