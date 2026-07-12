<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../vendor/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/PHPMailer/src/SMTP.php';

function getMailer()
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    // YOUR GMAIL
    $mail->Username = 'brewhaven12@gmail.com';

    // YOUR 16-CHARACTER APP PASSWORD
    $mail->Password = 'rcvl gijq ytxx jrzd';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom(
        'khaykai47@gmail.com',
        'Brew Haven'
    );

    $mail->isHTML(true);

    return $mail;
}

?>