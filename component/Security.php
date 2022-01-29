<?php

namespace app\component;

class Security {

    public static function check_values_long($text_to_check, $length = 1){
        return self::allCheck($text_to_check, $length);
    }
  
    public static function check_values_150($text_to_check){
        return self::allCheck($text_to_check, 150);
    }
  
    public static function check_values_32($text_to_check){
        return self::allCheck($text_to_check, 32);
    }
  
    public static function check_values_11($text_to_check){
        return self::allCheck($text_to_check, 11);
    }
  
    public static function check_values_1($text_to_check){
        return self::allCheck($text_to_check, 1);
    }

    private static function allCheck($text_to_check, $length = 1){
  
        $text_to_check = str_replace(";","",$text_to_check);
        $text_to_check = str_replace("'","",$text_to_check);
        $text_to_check = str_replace('"',"",$text_to_check);
        $text_to_check = str_replace("^","",$text_to_check);
        $text_to_check = str_replace("|","",$text_to_check);
        $text_to_check = str_replace("\n","",$text_to_check);
        $text_to_check = str_replace("\r","",$text_to_check);
        $text_to_check = str_replace("\p","",$text_to_check);
        $text_to_check = str_replace("<","",$text_to_check);
        $text_to_check = str_replace(">","",$text_to_check);
  
        $text_to_check = substr($text_to_check, 0, $length);
  
        $text_to_check = rtrim($text_to_check);
        $text_to_check = strip_tags($text_to_check);
        $text_to_check = htmlspecialchars($text_to_check);
        $text_to_check = stripslashes($text_to_check);
        $text_to_check = addslashes($text_to_check);
  
        return $text_to_check;
    }

    public static function generatedRandomString($length){
        $arr = array('1','2','3','4','5',
            '6','7','8','9','0',
            'a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            '1','2','3','4','5','6',
            '7','8','9','0');

        $new_hash = "";
        for($k=0;$k < $length; $k++){
            $index = rand(0, count($arr) - 1);
            $pass = $arr[$index];
            $new_hash = $new_hash . $pass;
        }
        return $new_hash;
    }
}