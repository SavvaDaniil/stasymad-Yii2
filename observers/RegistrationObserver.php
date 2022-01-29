<?php

namespace app\observers;

use Yii;
use app\models\Course;

class RegistrationObserver implements \app\interfaces\MailObserver {

    public static function reportAboutNewUserAndSendMailToUser($user, $password){
        
        $listOfMail = [$user -> username];
        $subject = "Thank you for registering";
        $message = '<center><img src="https://stasymad.com/images/logo.png" style="height:50px;width:50px;" /></center>
        <p>Thanks for registration on my platform <a href="https://stasymad.com">stasymad.com</a><br /></p>
        <p>Your login/username: <b>'.$user -> username.'</b></p>
        <p>Your password: <b>'.$password.'</b></p>';
        self::sendMessageToListOfMails($listOfMail, $subject, $message);

        $listOfMail = ["savva.d@mail.ru"];
        $subject = "Новый пользователь";
        $message = "
        <p>IP: ".Yii::$app->request->userIP."</p>
        <p>Пользователь: ".$user -> fio." (id".$user -> id." ".$user -> username.")</p>";

        self::sendMessageToListOfMails($listOfMail, $subject, $message);
    }

    public static function sendMessageToListOfMails($listOfMail, $subject, $message){
        
        Yii::$app->mailer->compose()
        ->setFrom('info@stasymad.com')
        ->setTo($listOfMail)
        ->setSubject($subject)
        ->setHtmlBody($message)
        ->send();
    }
}