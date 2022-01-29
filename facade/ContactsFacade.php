<?php

namespace app\facade;

use Yii;


class ContactsFacade {

    public static function sendMessageToAdminAndReturnBoolean($email, $name, $message){

        $ip = "Ошибка определения ip";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $message = "
        <p>Email: ".$email."</p>
        <p>Имя: ".$name."</p>
        <p>Дата: ".(date("d.m.Y"))."</p>
        <p>IP: ".$ip."</p>
        <hr />
        <p>Сообщение: ".$message."</p>
        ";

        $listOfMail = ["savva.d@mail.ru"];

        if(Yii::$app->mailer->compose()
        ->setFrom('info@stasymad.com')
        ->setTo($listOfMail)
        ->setSubject("Сообщение из контактов STASYMAD")
        ->setHtmlBody($message)
        ->send()){
            return true;
        } else {
            return false;
        }
    }
}
