<?php
declare(strict_types=1);

require_once 'config.php';
require_once 'PHPMailer/PHPMailerAutoload.php';

$mailResult = sendMail('test', 'testen');

echo $mailResult;

function sendMail(string $input, string $MailContent): string {
    global $config;

    $config['DebugMailSubject'] = "Test";

    try {
        /**
         * Create e-mail and fill it with the content
         */
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls'; // Fix: Muss ein String sein, keine undefinierte Konstante
        $mail->SMTPAutoTLS = false;

        // Sicherstellen, dass alle Konfigurationswerte existieren, um Fehler zu vermeiden
        $mail->Password = $config['SMTPPassword'] ?? '';
        $mail->Username = $config['SMTPUsername'] ?? '';
        $mail->SMTPDebug  = 1;
        $mail->Port = $config['SMTPPort'] ?? 587; // Standardport als Fallback
        $mail->Host = $config['SMTPHost'] ?? '';
        $mail->CharSet = 'utf-8';
        $mail->isHTML(true);

        $mail->setFrom($config['MAILFrom'] ?? 'noreply@example.com');
        $mail->Subject  = ($config['DebugMailSubject'] ?? 'Debug') . ' ' . $input;
        $mail->Body     = $MailContent;

        // Empfänger setzen (Hauptempfänger oder Fallback-Adresse)
        if (!empty($config['forceRecipientAddress'])) {
            $mail->addAddress($config['forceRecipientAddress']);
        } elseif (!empty($config['MAILTo'])) {
            $mail->addAddress($config['MAILTo']);
        } else {
            return 'Fehler: Keine Empfängeradresse konfiguriert.';
        }

        // BCC & CC-Empfänger setzen
        $mail->addBCC('support@cryptshare.express');
        if (!empty($config['forceCCRecipientAddress'])) {
            $mail->addCC($config['forceCCRecipientAddress']);
        }

        // E-Mail versenden
        if (!$mail->send()) {
            return 'Mailer error: ' . $mail->ErrorInfo . ' | HOST: ' . $mail->Host . ':' . $mail->Port;
        } else {
            return 'Message has been sent.';
        }
    } catch (Exception $e) {
        return 'Fehler beim Senden der E-Mail: ' . $e->getMessage();
    }
}
