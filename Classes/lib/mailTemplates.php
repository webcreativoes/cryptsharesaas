<?php
declare(strict_types=1);

const KEY_ONBOARDING = 'onboarding';
const KEY_SUBJECT = 'subject';
const KEY_CONTENT = 'content';
const EN_SUBJECT = "Welcome to Cryptshare.express, ###userfirstname### ###userlastname###! - Your start";

// Sicherstellen, dass `$config` existiert, um Fehler zu vermeiden
$environment = $config['environment'] ?? '';
if ($environment === 'sandbox') {
    $environment .= ': ';
}

// Sicherstellen, dass `file_get_contents()` absolute Pfade verwendet
function getEmailTemplate(string $filename): string {
    $filePath = __DIR__ . '/../Resources/Private/Extensions/cryptsharesaas/Email/' . $filename;
    return file_exists($filePath) ? file_get_contents($filePath) : '';
}

// Setzt die Mail-Templates für verschiedene Sprachen
$mailTemplates = [
    'EN' => setMailTemplate(
        $environment . EN_SUBJECT,
        getEmailTemplate('onboarding-en.html'),
        1,
        $environment . EN_SUBJECT,
        getEmailTemplate('onboarding-trial-en.html')
    ),
    'UK' => setMailTemplate(
        $environment . EN_SUBJECT,
        getEmailTemplate('onboarding-en.html'),
        1,
        $environment . EN_SUBJECT,
        getEmailTemplate('onboarding-trial-en.html')
    ),
    'DE' => setMailTemplate(
        $environment . "Willkommen bei Cryptshare.express, ###userfirstname### ###userlastname###! - Dein Einstieg",
        getEmailTemplate('onboarding-de.html'),
        1,
        $environment . "Willkommen bei Cryptshare.express, ###userfirstname### ###userlastname###! - Dein Einstieg",
        getEmailTemplate('onboarding-trial-de.html')
    ),
    'FR' => setMailTemplate(
        $environment . "Bienvenue sur Cryptshare.express, ###userfirstname### ###userlastname###! - Votre entrée",
        getEmailTemplate('onboarding-fr.html'),
        1,
        $environment . "Bienvenue sur Cryptshare.express, ###userfirstname### ###userlastname###! - Votre entrée",
        getEmailTemplate('onboarding-trial-fr.html')
    ),
    'ES' => setMailTemplate(
        $environment . "¡Bienvenido a Cryptshare.express, ###userfirstname### ###userlastname###! - Su entrada",
        getEmailTemplate('onboarding-es.html'),
        1,
        $environment . "¡Bienvenido a Cryptshare.express, ###userfirstname### ###userlastname###! - Su entrada",
        getEmailTemplate('onboarding-trial-es.html')
    ),
    'NL' => setMailTemplate(
        $environment . "Welkom bij Cryptshare.express, ###userfirstname### ###userlastname###! - Uw start",
        getEmailTemplate('onboarding-nl.html'),
        1,
        $environment . "Welkom bij Cryptshare.express, ###userfirstname### ###userlastname###! - Uw start",
        getEmailTemplate('onboarding-trial-nl.html')
    ),
    'LT' => setMailTemplate(
        $environment . EN_SUBJECT,
        getEmailTemplate('onboarding-lt.html'),
        1,
        $environment . EN_SUBJECT,
        getEmailTemplate('onboarding-trial-lt.html')
    ),
    'OD' => setMailTemplate(
        $environment . "Willkommen bei Cryptshare.express, powered by orangedental",
        getEmailTemplate('onboarding-orangedental.html')
    )
];

// Funktion zur Erstellung der Mail-Templates
function setMailTemplate(
    string $subject,
    string $content,
    int $isTrial = 0,
    string $trialSubject = '',
    string $trialContent = ''
): array {
    $template = [
        KEY_ONBOARDING => [
            KEY_SUBJECT => $subject,
            KEY_CONTENT => $content
        ]
    ];

    if ($isTrial) {
        $template[KEY_ONBOARDING]['is_trial'] = [
            KEY_SUBJECT => $trialSubject,
            KEY_CONTENT => $trialContent
        ];
    }

    return $template;
}
