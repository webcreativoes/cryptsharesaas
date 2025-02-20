<?php

/*
 * Load config, functions and clean inputs
 */
require_once('lib/init.php');

if($action == 'get_access_token') {
    $data = http_build_query(array(
        'grant_type' => 'client_credentials'
    ));
    $result = callRestAPI($config, $data, $action, false, $fe_user_data['bw_customer_id']);
    if( strlen( $result['access_token'] ) > 64 ) {
        setAccessTokenOnFeUser($config, $typo3_fe_user_id, $result['access_token']);
    } else {
        setDieError('Access token could not be determined', __FILE__, __LINE__);
    }
} else {
    setDieError('Unknown action transmitted', __FILE__, __LINE__);
}