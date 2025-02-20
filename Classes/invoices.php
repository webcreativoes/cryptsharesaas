<?php
/*
 * Danger: Every customer can download invoices from all other customers
 */

/*
 * Load config, functions and clean inputs
 */
require_once('lib/init.php');

if($fe_user_data) {
    switch($action){
        case 'get_invoices':
            $data = [
                'CustomerId' => $fe_user_data['bw_customer_id']
            ];
            break;
        case 'download_invoice':
            if(empty($input['bw_InvoiceId'])) {
                setDieError('No billwerk InvoiceId transmitted', __FILE__, __LINE__);
            } else {
                $data = [
                    'CustomerId' => $fe_user_data['bw_customer_id'],
                    'InvoiceId' => $input['bw_InvoiceId']
                ];
            }
            break;
        default:
            setDieError('Unknown action transmitted', __FILE__, __LINE__);
    }
    $result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data['bw_customer_id'], $input);
}