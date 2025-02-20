<?php

const KEY_BW_PLANVARIANT_ID = 'bw_PlanVariantId';
/**
 * Load config, functions and clean inputs
 */
require_once('lib/init.php');

if($action == 'get_planvariant') {
    if(empty($input[KEY_BW_PLANVARIANT_ID])) {
        setDieError('No billwerk PlanVariantId transmitted', __FILE__, __LINE__);
    } else {
        $data = [ KEY_BW_PLANVARIANT_ID => $input[KEY_BW_PLANVARIANT_ID] ];
    }
} else {
    setDieError('Unknown action transmitted', __FILE__, __LINE__);
}
$result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data['bw_customer_id']);
