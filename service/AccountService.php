<?php

namespace app\service;

use Yii;
use app\models\Back;
use app\models\Course;
use app\models\User;
use app\models\AccessOfUser;
use app\models\Cart;
use app\models\VideoPlay;



class AccountService {

    private static $actualAccesses = array();

    public static function listAllBuyedCoursesOfActualUserByIdOfType($id_of_type){

        $today = strtotime(date("Y-m-d"));

        self::$actualAccesses = AccessOfUser::find()
        -> select(["accessofuser.*","course.name","course.description"])
        -> innerJoin("course","course.id = accessofuser.id_of_course")
        -> innerJoin("connection_course_to_type","course.id = connection_course_to_type.id_of_course AND connection_course_to_type.id_of_type = ".$id_of_type)
        -> where(["accessofuser.status" => 1])
        -> andWhere(["accessofuser.is_back" => 0])
        -> andWhere(["accessofuser.id_of_user" => Yii::$app->user->id])
        -> andWhere(["or",
        ["=","accessofuser.date_must_be_used", $today],
        [">","accessofuser.date_must_be_used", $today],
        ["is","accessofuser.date_must_be_used", null]
        ])
        //-> groupBy(["accessofuser.id_of_course"])
        -> asArray()
        -> all();

        $coursesRepeat = array();

        foreach(self::$actualAccesses as $key => $access){
            if(in_array($access["id_of_course"], $coursesRepeat)){
                unset(self::$actualAccesses[$key]);
                continue;
            }
            array_push($coursesRepeat, $access["id_of_course"]);

            $videoplay = VideoPlay::find()
            -> where("id_of_course=:id_of_course",[":id_of_course" => $course["id_of_course"]])
            -> andWhere(["id_of_user" => Yii::$app->user->id])
            -> one();
            if(empty($videoplay)){
                self::$actualAccesses[$key]["last_played_number"] = 1;
            } else {
                self::$actualAccesses[$key]["last_played_number"] = $videoplay["number"];
            }



            if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/content/course/". $access["id_of_course"] . "/poster.jpg")){
                self::$actualAccesses[$key]["posterSrc"] = "/content/course/". $access["id_of_course"] . "/poster.jpg";
            } else {
                self::$actualAccesses[$key]["posterSrc"] = "/images/noPoster.jpg";
            }


        }



        return self::$actualAccesses;
    }


}