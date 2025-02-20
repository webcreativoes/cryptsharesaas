<?php

const KEY_MESSAGE = 'Message';
const KEY_ACTION = 'action';
const KEY_EVENT = 'event';

/**
 * Load configurations
 */
require_once('config.php');

/**
 * Load Mail Templates
 */
require_once('mailTemplates.php');

/**
 * Load all the fancy functions
 */
require_once('functions.php');

/**
* Die, if no session cookie of TYPO3 user is set
*/
if(empty($_COOKIE['fe_typo_user'])){ die( json_encode( [KEY_MESSAGE => 'There is no fe_typo_user in your Cookie'], true) ); }

/**
 * Extended to secure POST too
 */
if ($_GET){
    /**
     * Runs through all GET-Values and removes XSS potential and special chars
     */
    foreach ($_GET as $key => $value){
        $input[$key] = removeXSS(
            stripslashes(urldecode($value))
        );
    }
} else if ($_POST) {
    /**
     * Runs through all POST-Values and removes XSS potential and special chars
     */
    foreach ($_POST as $key => $value){
        $input[$key] = removeXSS(
            stripslashes(urldecode($value))
        );
    }
}

/**
 * Die, if no action get parameter is set
 * Extended for event post parameter
 * do we need another answer for webhooks?
 */
if(empty($input[KEY_ACTION])&&empty($input[KEY_EVENT])) { die ( json_encode( [KEY_MESSAGE => 'No action or event transmitted'], true) ); }else if ($input[KEY_ACTION]){ $action = $input[KEY_ACTION]; }else if ($input[KEY_EVENT]){ $event = $input[KEY_EVENT]; }

/**
 * Get uid of current fe_user
 */
$typo3_fe_user_id = getFeUserFromSessionId($config, $_COOKIE['fe_typo_user']);

/**
 * Get all userdata of current user
 */
$fe_user_data = getFeUser($config, $typo3_fe_user_id);

/**
 * Die, if userdata array is empty
 */
if(empty($fe_user_data)) { die ( json_encode( [KEY_MESSAGE => 'TYPO3 fe-user data missing'], true) ); }
