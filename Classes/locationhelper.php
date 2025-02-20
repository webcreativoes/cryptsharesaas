<?php
require_once('lib/config.php');
require_once('lib/functions.php');

foreach ($_GET as $key => $value){
    $input[$key] = removeXSS(
        stripslashes(urldecode($value))
    );
}

if ($input['action'] == 'get_location') {
    $ip = $_SERVER['REMOTE_ADDR'];
    $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $convertedIP = ConvertIP($ip);
    $companyData = getCompanyData($config, $convertedIP);
    $results['website_language'] = strtolower($input['website_lang']);
    if($companyData['COUNTRY_CODE'] === '-') {
        $results['user_country'] = strtolower($browserLang);
    } else {
        $results['user_country'] = strtolower($companyData['COUNTRY_CODE']);
    }
    $results['browser_language'] = $browserLang;
    die( json_encode( $results, true) );
}
echo 'No action selected';
