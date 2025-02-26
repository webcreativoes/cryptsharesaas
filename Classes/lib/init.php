<?php
declare(strict_types=1);

const KEY_MESSAGE = 'Message';
const KEY_ACTION = 'action';
const KEY_EVENT = 'event';

/**
 * Load configurations
 */
require_once __DIR__ . '/config.php';

/**
 * Load Mail Templates
 */
require_once __DIR__ . '/mailTemplates.php';

/**
 * Load all the fancy functions
 */
require_once __DIR__ . '/functions.php';

/**
 * Ensure session cookie exists for TYPO3 frontend user
 */
if (empty($_COOKIE['fe_typo_user'])) {
    die(json_encode([KEY_MESSAGE => 'There is no fe_typo_user in your Cookie'], JSON_THROW_ON_ERROR));
}

/**
 * Sanitize GET and POST input
 */
$input = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {
    foreach ($_GET as $key => $value) {
        $input[$key] = removeXSS(stripslashes(urldecode((string) $value)));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $input[$key] = removeXSS(stripslashes(urldecode((string) $value)));
    }
}

/**
 * Validate action or event parameters
 */
$action = $input[KEY_ACTION] ?? null;
$event = $input[KEY_EVENT] ?? null;

if (empty($action) && empty($event)) {
    die(json_encode([KEY_MESSAGE => 'No action or event transmitted'], JSON_THROW_ON_ERROR));
}

/**
 * Get uid of current fe_user
 */
$typo3_fe_user_id = getFeUserFromSessionId($config, $_COOKIE['fe_typo_user'] ?? '');

/**
 * Get all userdata of current user
 */
$fe_user_data = getFeUser($config, $typo3_fe_user_id);

/**
 * Die, if userdata array is empty
 */
if (empty($fe_user_data)) {
    die(json_encode([KEY_MESSAGE => 'TYPO3 fe-user data missing'], JSON_THROW_ON_ERROR));
}
