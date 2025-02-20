<?php

/**
 * Load config, functions and clean inputs
 */
require_once('lib/init.php');

if($action == 'get_product') {
    $result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data['bw_customer_id']);
} else {
    setDieError('Unknown action transmitted', __FILE__, __LINE__);
}
