<?php

/*
 * Load config, functions and clean inputs
 */
require_once('lib/init.php');

const BW_CONTRACT_ID = "bw_ContractId";
const CONTRACT_ID = "ContractId";

switch($action){
    case 'get_components':
        if(empty($input[BW_CONTRACT_ID])) {
            setDieError('No billwerk PlanVariantId transmitted', __FILE__, __LINE__);
        }else{
            $data = [
                CONTRACT_ID => $input[BW_CONTRACT_ID]
            ];
        }
        break;
    case 'edit_component':
    case 'cancel_component':
        if(empty($input['endDate'])) {
            $data = [
                CONTRACT_ID => $input[BW_CONTRACT_ID],
                'ComponentId' => $input['bw_ComponentId'],
                'Memo' => $input['memo']
            ];
        } else {
            $data = [
                CONTRACT_ID => $input[BW_CONTRACT_ID],
                'ComponentId' => $input['bw_ComponentId'],
                'Memo' => $input['memo'],
                'EndDate' => $input['endDate']
            ];
        }
        break;
    default:
        setDieError('Unknown action transmitted', __FILE__, __LINE__);
}
$result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data['bw_customer_id']);