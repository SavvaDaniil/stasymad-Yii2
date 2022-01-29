<?php

namespace app\models;

use yii\db\ActiveRecord;

class VideoPlay extends ActiveRecord {

    public static function tableName(){
      return "video_play";
    }
}
