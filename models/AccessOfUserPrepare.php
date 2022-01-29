<?php

namespace app\models;

use yii\db\ActiveRecord;

class AccessOfUserPrepare extends ActiveRecord {

    public function __construct(){

    }
    public static function tableName(){
        return "accessOfUserPrepare";
    }


    public static function findActualByStatusAndByIdOfPaymentOrReturnNull($id_of_payment, $status){
        return self::find()
        -> where("status = :status", ["status" => $status])
        -> andWhere("id_of_payment = :id_of_payment", ["id_of_payment" => $id_of_payment])
        -> all();
    }

}