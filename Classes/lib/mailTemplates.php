<?php
const KEY_ONBOARDING = 'onboarding';
const KEY_SUBJECT = 'subject';
const KEY_CONTENT = 'content';
const EN_SUBJECT = "Welcome to Cryptshare.express, ###userfirstname### ###userlastname###! - Your start";

$environment = '';
if($config['environment'] == 'sandbox') {
    $environment = $config['environment'].': ';
}

$mailTemplates['EN'] = setMailtemplate($environment.EN_SUBJECT, file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-en.html'), 1, $environment.EN_SUBJECT, file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-trial-en.html'));
$mailTemplates['UK'] = setMailtemplate($environment.EN_SUBJECT, file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-en.html'), 1, $environment.EN_SUBJECT, file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-trial-en.html'));
$mailTemplates['DE'] = setMailtemplate($environment."Willkommen bei Cryptshare.express, ###userfirstname### ###userlastname###! - Dein Einstieg", file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-de.html'), 1, $environment."Willkommen bei Cryptshare.express, ###userfirstname### ###userlastname###! - Dein Einstieg", file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-trial-de.html'));
$mailTemplates['FR'] = setMailtemplate($environment."Bienvenue sur Cryptshare.express, ###userfirstname### ###userlastname###! - Votre entrée", file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-fr.html'), 1, $environment."Bienvenue sur Cryptshare.express, ###userfirstname### ###userlastname###! - Votre entrée", file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-trial-fr.html'));
$mailTemplates['ES'] = setMailtemplate($environment."¡Bienvenido a Cryptshare.express, ###userfirstname### ###userlastname###! - Su entrada", file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-es.html'), 1, $environment."¡Bienvenido a Cryptshare.express, ###userfirstname### ###userlastname###! - Su entrada", file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-trial-es.html'));
$mailTemplates['NL'] = setMailtemplate($environment."Welkom bij Cryptshare.express, ###userfirstname### ###userlastname###! - Uw start", file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-nl.html'), 1, $environment."Welkom bij Cryptshare.express, ###userfirstname### ###userlastname###! - Uw start", file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-trial-nl.html'));
$mailTemplates['LT'] = setMailtemplate($environment.EN_SUBJECT, file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-lt.html'), 1, $environment.EN_SUBJECT, file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-trial-lt.html'));
$mailTemplates['OD'] = setMailtemplate($environment."Willkommen bei Cryptshare.express, powered by orangedental", file_get_contents('../Resources/Private/Extensions/cryptsharesaas/Email/onboarding-orangedental.html'));

function setMailtemplate($subject, $content, $is_trial = 0, $trialSubject = '', $trialContent = '') {
    $template = [];
    $template[KEY_ONBOARDING][KEY_SUBJECT] = $subject;
    $template[KEY_ONBOARDING][KEY_CONTENT] = $content;
    if($is_trial) {
        $template[KEY_ONBOARDING]['is_trial'][KEY_SUBJECT] = $trialSubject;
        $template[KEY_ONBOARDING]['is_trial'][KEY_CONTENT] = $trialContent;
    }
    return $template;
}