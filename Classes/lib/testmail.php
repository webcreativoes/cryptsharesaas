<?php
require_once 'config.php';
require 'PHPMailer/PHPMailerAutoload.php';

$mail = sendMail('test','testen');

echo mail;

function sendMail($input,$MailContent) {
    global $config;

    $config['DebugMailSubject'] = "Test";

    /**
    * Create e-mail and fill it with the content and attach file
    */
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = tls;
    $mail->SMTPAutoTLS = false;
    $mail->Password = $config['SMTPPassword'];
    $mail->Username = $config['SMTPUsername'];
    $mail->SMTPDebug  = 1;
    $mail->Port = $config['SMTPPort'];
    $mail->Host = $config['SMTPHost'];
    $mail->CharSet = 'utf-8';
    $mail->IsHTML(true);
    $mail->SetFrom($config['MAILFrom']);
    $mail->Subject  = $config['DebugMailSubject'].$input;
    $mail->Body     = $MailContent;

    if(isset($config['forceRecipientAddress'])){
        $mail->AddAddress($config['forceRecipientAddress']);
    }else{
        $mail->AddAddress($config['MAILTo']);
    }
    $mail->AddBCC('support@cryptshare.express');
    if(isset($config['forceCCRecipientAddress'])){
        $mail->AddCC($config['forceCCRecipientAddress']);
    }
    if(!$mail->send()) {
        return 'Mailer error: ' . $mail->ErrorInfo.'HOST :' .$config['SMTPHost'].":".$mail->Port = $config['SMTPPort'];
    } else {
        return 'Message has been sent.';
    }
}
