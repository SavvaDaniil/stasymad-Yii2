<?php

namespace app\models;


class SubtitleVideo {
    public $src;
    public static $kind = "captions";
    public $label;
    public $srclang;
    public $language;

    public function __construct($src, $label, $srclang, $language){
        $this -> src = $src;
        $this -> label = $label;
        $this -> srclang = $srclang;
        $this -> language = $language;
    }
}