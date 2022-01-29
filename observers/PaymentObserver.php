<?php

namespace app\observers;

use Yii;
use app\models\Course;

class PaymentObserver implements \app\interfaces\MailObserver {

    public static function reportAboutNewPaymentAndNewAccessesOfUser($accessOfUserList, $user, $payment){
        $listOfGrantedCourses;
        $course;
        $schetchik = 0;
        if(empty($accessOfUserList))return;

        foreach($accessOfUserList as $accessOfUser){
            $course = Course::findActiveByIdOrReturnNull($accessOfUser -> id_of_course);
            if(is_null($course))continue;

            $schetchik++;
            $listOfGrantedCourses .= $schetchik . ") id" . $course -> id . " - " . $course -> name . "<br />";
        }

        $listOfMail = ["savva.d@mail.ru"];
        $subject = "Оплата курсов";
        $message = "
        <h6>Произошла оплата курсов</h6>
        <p>IP: ".Yii::$app->request->userIP."</p>
        <p>Дата: ".date("d.m.Y H:i:s")."</p>
        <p>Пользователь: ".$user -> fio." (id".$user -> id." ".$user -> username.")</p>
        <hr />
        ".$listOfGrantedCourses."
        <br />
        <b>ОЖИДАЕМАЯ СУММА: ".$payment -> summa." рублей</b>";
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