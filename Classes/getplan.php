<?php

/*
 * Load config, functions and clean inputs
 */

global $config;
const LNB = " <br><br>";

$action= 'get_plan';

/*
 * Load configurations
 */
require_once('lib/config.php');

/*
 * Load all the fancy functions
 */
require_once('lib/functions.php');

/*
 * Get uid of current fe_user
 */
$typo3_fe_user_id = getFeUserFromSessionId($config, $_COOKIE['fe_typo_user']);
$fe_user_data = getFeUser($config, $typo3_fe_user_id);

if ($action == 'get_plan') {
    $data = $config['plan_id'];
} else {
    setDieError('Unknown action transmitted', __FILE__, __LINE__);
}
$contract = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data['bw_customer_id']);
$contract = arrayCastRecursive(json_decode($contract));
$logParams = [];
$logParams['function'] = 'Classes/getplan.php:36';
$logParams['planId'] = $contract['Id'];
writeDevLog($config, print_r($logParams, TRUE));
$result = getCryptshareServerHost($config, $contract['Id']);
$needle = 'NL';
echo "name :".$result[Name][_c].LNB;
echo "server:".$result[CustomFields][CSServer].LNB;
echo "user :".$config['new_cryptshare_user'][$result[CustomFields][CSServer]].LNB;
echo "ID: ".$contract['Id'].LNB;
