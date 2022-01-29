<?php

namespace app\service;

use Yii;
use app\models\Back;
use app\models\Course;
use app\models\AccessOfUser;

class CourseService {

    /*
    SELECT course.*, back.* FROM course INNER JOIN connection_course_to_type ON connection_course_to_type.id_of_course = course.id
    AND connection_course_to_type.id_of_type = '1'

    LEFT JOIN back ON back.id_of_course = course.id

    WHERE course.status = '1' GROUP BY course.id ORDER BY course.order_in_list
    */
    public static $currencyRubUsd = 73;


    public static function findAllByIdOfTypeOfContent($id_of_type_of_content = 0){

        $backs = Back::find()
        ->where(["status" => 1])
        -> all();

        $courses = Course::find()
        ->select(["course.*"])
        ->innerJoin(
            "connection_course_to_type",
            "connection_course_to_type.id_of_course = course.id AND connection_course_to_type.id_of_type = '".$id_of_type_of_content."'"
        )
        ->where(["course.status" => 1])
        ->orderBy(["course.order_in_list" => SORT_DESC])
        ->all();

        foreach($courses as $course){

            if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/content/course/".$course -> id . "/original.jpg")){
                $course -> posterOriginalSrc = "/content/course/".$course -> id . "/original.jpg";
            } else {
                $course -> posterOriginalSrc = "/images/noPoster.jpg";
            }
            if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/content/course/".$course -> id . "/demo.jpg")){
                $course -> posterDemoSrc = "/content/course/".$course -> id . "/demo.jpg";
            } else {
                $course -> posterDemoSrc = "/images/noPoster.jpg";
            }

            $course -> isOriginal = true;
            switch($course -> original_inst1_youtube2){
                case 2:
                    $course -> originalLink = $course -> youtube;
                    break;
                case 1:
                    $course -> originalLink = $course -> instagram;
                    break;
                default:
                    $course -> isOriginal = false;
                    break;
            }

            $course -> isDemo = false;
            if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/content/course/".$course -> id . "/demo/content/playlist.m3u8")){
                $course -> isDemo = true;
                $course -> demoSrc = "/content/course/".$course -> id . "/demo/content/playlist.m3u8";
            } else {
                $course -> posterDemoSrc = "/images/noDemoVideo.jpg";
            }


            //проверить на доступ
            $course -> alreadyBuyed = false;
            if (!Yii::$app->user->isGuest) {
                if(!empty(AccessOfUser::findActualByIdOfUserAndByIdOfCourseOrReturnNull(Yii::$app->user->id, $course -> id))){
                    $course -> alreadyBuyed = true;
                }
            }
            
            $course -> priceUSD = round($course -> price / self::$currencyRubUsd, 2);
            
            /*
            foreach($backs as $back){
                if($back -> id_of_course == $course -> id){
                    $course -> back = $back;
                }
            }
            */
        }


        return $courses;
    }
}