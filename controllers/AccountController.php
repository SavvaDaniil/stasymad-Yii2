<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\User;
use app\service\AccountService;


class AccountController extends Controller {

    public function actionIndex(){

        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $this->view->title = "Account | Nastya's Bagdasarova Online Platform";
        $accessStrip = AccountService::listAllBuyedCoursesOfActualUserByIdOfType(1);
        $accessExotic = AccountService::listAllBuyedCoursesOfActualUserByIdOfType(2);
        $accessAcrobatics = AccountService::listAllBuyedCoursesOfActualUserByIdOfType(3);

        
        $user = User::find()
        -> where(["id" => Yii::$app->user->id])
        -> one();

        return $this -> render("index", compact(["user","accessStrip","accessExotic","accessAcrobatics"]));
    }
}