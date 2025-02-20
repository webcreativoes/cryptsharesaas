<?php

/**
 * Load config, functions and clean inputs
 */
require_once('lib/init.php');

switch($action) {
    case 'get_plan':
        $data = [ 'planId' => $input['plan_id'] ];
        break;
    case 'get_plans':
        $data = [ 'planId' => $config['plan_id'] ];
        break;
    default:
        setDieError('Unknown action transmitted', __FILE__, __LINE__);
}
$result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data['bw_customer_id']);
