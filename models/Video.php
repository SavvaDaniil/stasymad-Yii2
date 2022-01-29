<?php

namespace app\models;

use yii\db\ActiveRecord;

class Video extends ActiveRecord {
    public $src;
    
    public $areTracksExists;
    public static $arrayTracksLanguages = array("english","china","spain","deutch","hungarian");
    public static $trackFormat = "vtt";

    public function fields()
    {
        $fields = parent::fields();
        $fields['src'] = 'src';
        return $fields;
    }
}
