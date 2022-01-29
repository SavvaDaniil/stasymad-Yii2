<?php

namespace app\models;

use yii\db\ActiveRecord;

class Course extends ActiveRecord {
    public $back;
    public $posterSrc;
    public $contentSrc;
    public $alreadyBuyed;
    public $priceUSD;

    public $posterOriginalSrc;
    public $posterDemoSrc;
    public $originalLink;
    public $demoSrc;

    public $isOriginal;
    public $isDemo;

    public $areTracksExists;
    const arrayTracksLanguages = array("english","china","spain","deutch","hungarian");
    const trackFormat = "vtt";


    public static function listAllActiveOrReturnNull(){
        return self::find() -> where(['status' => 1]) -> orderBy(["order_in_list" => SORT_DESC]) -> all();
    }
    public static function findByIdOrReturnNull($id_of_course){
        return self::find() -> where('id=:id', [':id' => $id_of_course]) -> one();
    }
    public static function findActiveByIdOrReturnNull($id_of_course){
        return self::find() -> where('id=:id', [':id' => $id_of_course]) -> andWhere(["status" => 1]) -> one();
    }


}