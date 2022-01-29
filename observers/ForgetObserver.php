<?php

namespace app\observers;

use Yii;
use app\models\Course;

class ForgetObserver implements \app\interfaces\MailObserver {

    public static function sendMessageWithCodeToUser($user, $forgetCode){
        
        $listOfMail = [$user -> username];
        $subject = "Confirmation code to change password";
        $message = '<center><img src="https://stasymad.com/images/logo.png" style="height:50px;width:50px;" /></center>
        <p>Please, enter this code in window: <b>'.$forgetCode.'</b></p>';

        self::sendMessageToListOfMails($listOfMail, $subject, $message);
    }

    public static function sendMessageWithNewPasswordToUser($user, $newPassword){
        
        $listOfMail = [$user -> username];
        $subject = "New automatically generated password";
        $message = '<center><img src="https://stasymad.com/images/logo.png" style="height:50px;width:50px;" /></center>
        <p>Your new site access <a href="https://stasymad.com">stasymad.com</a><br /></p>
        <p>Username: <b>'.$user -> username.'</b></p>
        <p>New password: <b>'.$newPassword.'</b></p>';

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