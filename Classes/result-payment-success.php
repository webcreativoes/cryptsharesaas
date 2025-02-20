<?php

const KEY_CURRENT_HOSTNAME = 'current_hostname';
const KEY_CONTRACT_ID = 'contractId';
const STRING_LOCATION = 'Location: ';
const STRING_TRIGGER = '&trigger=Payment';

$input['action'] = true;
require_once('lib/init.php');
global $input;
$config[KEY_CURRENT_HOSTNAME] = getCurrentHostname();
if(empty($input[KEY_CONTRACT_ID])) {
    die ( 'No contractId given' );
} else {
    if($input['trigger']=='Payment'){
        switch($fe_user_data['language']) {
            case 'DE':
                header(STRING_LOCATION.$config[KEY_CURRENT_HOSTNAME].'de/users/order/?contractId='.$input[KEY_CONTRACT_ID].STRING_TRIGGER);
                exit;
            case 'NL':
                header(STRING_LOCATION.$config[KEY_CURRENT_HOSTNAME].'nl/users/order/?contractId='.$input[KEY_CONTRACT_ID].STRING_TRIGGER);
                exit;
            case 'EN_GB':
                header(STRING_LOCATION.$config[KEY_CURRENT_HOSTNAME].'en-gb/users/order/?contractId='.$input[KEY_CONTRACT_ID].STRING_TRIGGER);
                exit;
            case 'EN_US':
                header(STRING_LOCATION.$config[KEY_CURRENT_HOSTNAME].'en-us/users/order/?contractId='.$input[KEY_CONTRACT_ID].STRING_TRIGGER);
                exit;
            case 'IT':
                header(STRING_LOCATION.$config[KEY_CURRENT_HOSTNAME].'it/users/order/?contractId='.$input[KEY_CONTRACT_ID].STRING_TRIGGER);
                exit;
            case 'ES':
                header(STRING_LOCATION.$config[KEY_CURRENT_HOSTNAME].'es/users/order/?contractId='.$input[KEY_CONTRACT_ID].STRING_TRIGGER);
                exit;
            case 'FR':
                header(STRING_LOCATION.$config[KEY_CURRENT_HOSTNAME].'fr/users/order/?contractId='.$input[KEY_CONTRACT_ID].STRING_TRIGGER);
                exit;
            case 'PT':
                header(STRING_LOCATION.$config[KEY_CURRENT_HOSTNAME].'pt/users/order/?contractId='.$input[KEY_CONTRACT_ID].STRING_TRIGGER);
                exit;
            case 'FI':
                header(STRING_LOCATION.$config[KEY_CURRENT_HOSTNAME].'fi/users/order/?contractId='.$input[KEY_CONTRACT_ID].STRING_TRIGGER);
                exit;
            case 'EN':
            default:
                header(STRING_LOCATION.$config[KEY_CURRENT_HOSTNAME].'en/users/order/?contractId='.$input[KEY_CONTRACT_ID].STRING_TRIGGER);
                exit;
        }
    } else {
        die ( 'Trigger unknown or missing, sorry' );
    }
}
