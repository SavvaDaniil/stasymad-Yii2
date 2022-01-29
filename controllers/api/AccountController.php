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
use app\models\AccessOfUser;
use app\models\User;
use app\models\Video;
use app\models\VideoPlay;
use app\models\SubtitleVideo;
use app\service\RegistrationService;


class AccountController extends \yii\rest\Controller {

    public static $json = array();

    public $areTracksExists;
    public static $arrayTracksLanguages = [
		["english","English","en"],
		["china","中文","china"],
		["spain","Español","spain"],
		["deutch","Deutsche","deutch"],
        ["hungarian","Magyar","hungarian"]
    ];
    public static $trackFormat = "vtt";

    public static function actionSave(){
        
        if (Yii::$app->user->isGuest) {
            return self::$json;
        }
        if(!(Yii::$app->request->isPost)){
            return self::$json;
        }

        $request = Yii::$app->request;
        $username = Security::check_values_150($request->post('username'));
        $fio = Security::check_values_150($request->post('fio'));
        $new_password = Security::check_values_150($request->post('new_password'));
        $new_password_confirm = Security::check_values_150($request->post('new_password_confirm'));
        $password = Security::check_values_150($request->post('password'));


        $user = User::findActualUserOrReturnNull();

        if($user -> username != $username){
            $user_repeat = User::findRepeatOfUsernameExeptWithIdOfUser($user -> id, $username);

            if(!empty($user_repeat)){
                self::$json["answer"] = "error";
                self::$json["error"] = "username_already_exist";
                return self::$json;
            }
            $user -> username = $username;
        }

        $user -> fio = $fio;



        if($new_password != "" && $new_password_confirm != $new_password){
            self::$json["answer"] = "error";
            self::$json["error"] = "wrong_new_password";
            return self::$json;
        } elseif($password != "" && !Yii::$app->getSecurity()->validatePassword($password, $user -> password)){
            self::$json["answer"] = "error";
            self::$json["error"] = "wrong_password";
            return self::$json;
        } else if($new_password != "") {
            $user -> password = Yii::$app->getSecurity()->generatePasswordHash($new_password);

            //очищаем от всех авторизаций и авторизируем заново
            $user -> authKey = RegistrationService::generatedRandomString(32);
            $user -> accessToken = RegistrationService::generatedRandomString(32);
        }
      
        $user -> save();
      
        self::$json["answer"] = "success";

        return self::$json;
    }


    

  public function actionGetvideo(){
        if (Yii::$app->user->isGuest) {
            return self::$json;
        }
        if(!(Yii::$app->request->isPost)){
            return self::$json;
        }

        $request = Yii::$app->request;
        $id_of_content = Security::check_values_150($request->post('id_of_content'));
        $content = Security::check_values_150($request->post('content'));
        $number = Security::check_values_150($request->post('number'));

        if(empty($id_of_content) || empty($content) || empty($number)){
            self::$json["answer"] = "error";
            self::$json["error"] = "no_data";
            return self::$json;
        }
        $today = strtotime(date("Y-m-d"));

        $user = User::find()
        -> where(["id" => Yii::$app->user->id])
        -> one();


        $listOfVideos = Video::find()
        -> select("video.id, video.hash")
        -> innerJoin("accessofuser","accessofuser.id_of_course = video.id_of_course AND accessofuser.status = '1' AND (date_must_be_used IS NULL OR date_must_be_used > ".$today." OR date_must_be_used = ".$today.")  AND accessofuser.id_of_user = ".Yii::$app->user->id)
        -> where("video.id_of_course=:id_of_course",[":id_of_course" => $id_of_content])
        -> groupBy("video.id")
        -> asArray()
        -> all();

        //проверяем доступ
        $this -> checkaccessToProduct($user -> id, $id_of_content, $content);


        //var_dump($answer->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        //считываем последнее воспроизведение
        $videoplay = VideoPlay::find()
        -> where("id_of_course=:id_of_course",[":id_of_course" => $id_of_content])
        -> andWhere(["id_of_user" => Yii::$app->user->id])
        -> one();
        if(empty($videoplay)){
            $videoplay = new VideoPlay();
            $videoplay -> id_of_user = Yii::$app->user->id;
            $videoplay -> id_of_course = $id_of_content;
            $videoplay -> number = 1;
            $videoplay -> date_of_add = date("Y-m-d H:i:s");
            $videoplay -> date_of_refresh= date("Y-m-d H:i:s");

            $videoplay -> save();
        } else {
            $videoplay -> number = $number;
            $videoplay -> date_of_refresh= date("Y-m-d H:i:s");
            $videoplay -> save();
        }

        foreach($listOfVideos as $key => $video){
            if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/video/".$video["id"] . "_" . $video["hash"] . "/playlist.m3u8")){
                $listOfVideos[$key]["src"] = "/video/".$video["id"] . "_" . $video["hash"] . "/playlist.m3u8";
            } else {
                $listOfVideos[$key]["src"] = "";
            }

            //проверяем субтитры listOfSubtitle
            $listOfSubtitle = array();
            $subtitle;
            $src;
            foreach(self::$arrayTracksLanguages as $trackLanguage){
                $src = "/video/".$video["id"] . "_" . $video["hash"] . "/track/" . $trackLanguage[0] . "." . self::$trackFormat;
                if(file_exists($_SERVER["DOCUMENT_ROOT"] . $src)){
                    $subtitle = new SubtitleVideo($src, $trackLanguage[1], $trackLanguage[2], $trackLanguage[1]);
                    array_push($listOfSubtitle, $subtitle);
                }
            }
            $listOfVideos[$key]["listOfSubtitle"] = $listOfSubtitle;

        }


        if(!empty($listOfVideos)){
            self::$json["answer"] = "success";
            self::$json["content"] = $listOfVideos;
            return self::$json;

        } else {
            self::$json["answer"] = "error";
            self::$json["error"] = "no_access";
            return self::$json;
        }
        


    }

    public function actionUpdatevideoplay(){
        if (Yii::$app->user->isGuest) {
            exit();
        }
        if(!(Yii::$app->request->isPost)){exit();}

        $request = Yii::$app->request;
        $id_of_content = Security::check_values_150($request->post('id_of_content'));
        $content = Security::check_values_150($request->post('content'));
        $number = Security::check_values_150($request->post('number'));

        if(empty($id_of_content) || empty($number)){
            self::$json["answer"] = "error";
            self::$json["error"] = "no_data";
            return self::$json;
        }


        $videoplay = VideoPlay::find()
        -> where("id_of_course=:id_of_course",[":id_of_course" => $id_of_content])
        -> andWhere(["id_of_user" => Yii::$app->user->id])
        -> one();

        $videoplay -> number = $number;
        $videoplay -> date_of_refresh = date("Y-m-d H:i:s");
        $videoplay -> save();

        self::$json["answer"] = "success";
        return self::$json;
    }



    

    private function checkaccessToProduct($id_of_user, $id_of_content, $product){

        $today = strtotime(date("Y-m-d"));
        $null = new \yii\db\Expression('null');
        //ищем сначала продукт с ненулевым и не вышедшим из даты доступом

        $access = AccessOfUser::find()
        -> where(["id_of_".$product => $id_of_content])
        -> andWhere(["status" => 1])
        -> andWhere(["is_back" => 0])
        -> andWhere(["id_of_user" => $id_of_user])
        -> andWhere(["or",
        ["date_must_be_used" => $today],
        [">","date_must_be_used", $today]
        ])
        -> one();



        if(!empty($access)){
            return;
        }

        $access = AccessOfUser::find()
        -> where(["id_of_".$product => $id_of_content])
        -> andWhere(["status" => 1])
        -> andWhere(["is_back" => 0])
        -> andWhere(["id_of_user" => $id_of_user])
        -> andWhere(["date_must_be_used" => null])
        -> one();


        //var_dump($access->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);

        if(!empty($access)){
            //активируем доступ
            $access -> date_of_activation = strtotime(date("Y-m-d"));
            $access -> date_must_be_used =  strtotime(date("Y-m-d")) + 86400 * $access -> days;
            $access -> save();

            return;
        }
        //если нет еще не начатого доступа, снова ищем уже нулевой


    }

}