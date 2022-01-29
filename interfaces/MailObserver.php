<?php

namespace app\interfaces;

interface MailObserver {
    public static function sendMessageToListOfMails($listOfMail, $subject, $message);
}