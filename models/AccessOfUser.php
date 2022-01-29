<?php

namespace app\models;

use yii\db\ActiveRecord;

class AccessOfUser extends ActiveRecord {

    public function __construct(){

    }
    public static function tableName(){
      return "accessofuser";
    }

    

    public static function findActualByIdOfUserAndByIdOfCourseOrReturnNull($id_of_user, $id_of_course){

      $today = strtotime(date("Y-m-d"));

      return self::find()
      -> where(["status" => 1])
      -> andWhere(["is_back" => 0])
      -> andWhere("id_of_course = :id_of_course", ["id_of_course" => $id_of_course])
      -> andWhere("id_of_user = :id_of_user", ["id_of_user" => $id_of_user])
      -> andWhere(["or",
      ["=","date_must_be_used", $today],
      [">","date_must_be_used", $today],
      ["is","date_must_be_used", null]
      ])
      -> one();
    }

}