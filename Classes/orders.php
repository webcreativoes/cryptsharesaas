<?php

const KEY_TRIGGERINTERIM_BILLING = 'TriggerInterimBilling';
const KEY_CUSTOMER_ID = 'CustomerId';
const KEY_BW_CUSTOMER_ID = 'bw_customer_id';
const KEY_BW_PLANVARIANT_ID = 'bw_PlanVariantId';
const KEY_PLANVARIANT_ID = 'PlanVariantId';
const KEY_COUPON_CODE = 'CouponCode';
const KEY_BW_COUPON_CODE = 'bw_CouponCode';
const KEY_INHERIT_START_DATE = 'InheritStartDate';
const KEY_PREVIEW_AFTER_TRIAL = 'PreviewAfterTrial';
const KEY_ORDERS = 'orders';
const KEY_BW_CONTRACT_DETAILS = 'bw_ContractDetails';

/**
 * Load config, functions and clean inputs
 */
require_once('lib/init.php');

switch($action){
    case 'get_order_preview':
        $data = [
            KEY_TRIGGERINTERIM_BILLING => false,
            KEY_CUSTOMER_ID => $fe_user_data[KEY_BW_CUSTOMER_ID],
            'Cart' => [
                KEY_PLANVARIANT_ID => $input[KEY_BW_PLANVARIANT_ID],
                KEY_COUPON_CODE => $input[KEY_BW_COUPON_CODE],
                KEY_INHERIT_START_DATE => false,
            ],
            KEY_PREVIEW_AFTER_TRIAL => true,
        ];
        break;
    case 'create_order':
        $components = [];
        if($_SERVER['TYPO3_CONTEXT'] !== 'Development/Local') {
            $trialEndDate = round(strtotime($input['trial_enddate']) * 1000 * 1000);
            if($fe_user_data['is_trial'] !== '0') {
                $trial = true;
            }
            $data = [
                KEY_CUSTOMER_ID => $fe_user_data[KEY_BW_CUSTOMER_ID],
                'FirstName' => $fe_user_data['first_name'],
                'LastName' => $fe_user_data['last_name'],
                'EmailAddress' => $fe_user_data['email'],
                'cryptshare_express_trialenddate' => $trialEndDate,
                'cryptshare_express_trialhaseverbeenactive' => $trial
            ];
            //submitFormOnHubspot($config, $data, 'order', $_SERVER['HTTP_REFERER']);
        }

        if($input['bw_ContractId']) {
            $input[KEY_ORDERS] = str_replace("[", "", $input[KEY_ORDERS]);
            $input[KEY_ORDERS] = str_replace("]", "", $input[KEY_ORDERS]);
            $input[KEY_BW_CONTRACT_DETAILS] = str_replace("]", "", $input[KEY_BW_CONTRACT_DETAILS]);
            $input[KEY_BW_CONTRACT_DETAILS] = $input[KEY_BW_CONTRACT_DETAILS].','.$input[KEY_ORDERS].']';
            $orders = json_decode('['.$input[KEY_ORDERS].']');
            $i = 0;
            foreach ($orders as $order) {
                $components[$i]['ComponentId'] = $input['bw_ComponentId'];
                $components[$i]['Quantity'] = 1;
                $components[$i]['Memo'] = ''.$order->cs_email.' ('.$order->cs_first_name.' '.$order->cs_last_name.') (0)';
                $i++;
            }
            $data = [
                KEY_TRIGGERINTERIM_BILLING => false,
                KEY_CUSTOMER_ID => $fe_user_data[KEY_BW_CUSTOMER_ID],
                'ContractId' => $input['bw_ContractId'],
                'Cart' => [
                    KEY_PLANVARIANT_ID => $input[KEY_BW_PLANVARIANT_ID],
                    'AllowWithoutPaymentData' => true,
                    'ComponentSubscriptions' => $components,
                    KEY_COUPON_CODE => $input[KEY_BW_COUPON_CODE],
                    KEY_INHERIT_START_DATE => true,
                    'EnableTrial' => true
                ],
                'ContractCustomFields' => [
                    'CSContractDetails' => substr(substr(json_encode($input[KEY_BW_CONTRACT_DETAILS], JSON_UNESCAPED_UNICODE), 0, -1), 1)
                ],
                KEY_PREVIEW_AFTER_TRIAL => false
            ];
        } else {
            $input[KEY_ORDERS] = str_replace("[", "", $input[KEY_ORDERS]);
            $input[KEY_ORDERS] = str_replace("]", "", $input[KEY_ORDERS]);
            $orders = json_decode('['.$input[KEY_ORDERS].']');
            $i = 0;
            $j = 0;
            foreach ($orders as $order) {
                if($i > 0) {
                    $components[$j]['ComponentId'] = $input['bw_ComponentId'];
                    $components[$j]['Quantity'] = 1;
                    $components[$j]['Memo'] = ''.$order->cs_email.' ('.$order->cs_first_name.' '.$order->cs_last_name.') (0)';
                    $j++;
                }
                $i++;
            }
            $data = [
                KEY_TRIGGERINTERIM_BILLING => false,
                KEY_CUSTOMER_ID => $fe_user_data[KEY_BW_CUSTOMER_ID],
                'Cart' => [
                    KEY_PLANVARIANT_ID => $input[KEY_BW_PLANVARIANT_ID],
                    'ComponentSubscriptions' => $components,
                    KEY_COUPON_CODE => $input[KEY_BW_COUPON_CODE],
                    KEY_INHERIT_START_DATE => true,
                    'EnableTrial' => true
                ],
                'ContractCustomFields' => [
                    'CSEmailUser' => $input['cs_email'],
                    'CSFirstName' => ucfirst($input['cs_first_name']),
                    'CSLastName' => ucfirst($input['cs_last_name']),
                    'CSContractDetails' => '['.substr(substr(json_encode($input[KEY_ORDERS], JSON_UNESCAPED_UNICODE), 0, -1), 1).']',
                    'CSCompany' => $input['company'],
                    'CSAddress' => $input['address'],
                    'CSZip' => $input['zip'],
                    'CSCity' => $input['city'],
                    'CSCountry' => $input['country'],
                    'CSPhone' => $input['phone'],
                    'CSVat' => $input['vat'],
                    'CSHousenumber' => $input['house_no']
                ],
                KEY_PREVIEW_AFTER_TRIAL => false
            ];
        }
        if($input['trial'] != '1') {
            $data['Cart']['EnableTrial'] = false;
        }
        break;
    case 'commit_order_nopayment':
        if ($input['id'] == $fe_user_data[KEY_BW_CUSTOMER_ID]){
            $data = [
                'Order_id' => $input['bw_order_id'],
                KEY_TRIGGERINTERIM_BILLING => true,
                'Payment' => [
                    'None' => 'None',
                ],
                KEY_PREVIEW_AFTER_TRIAL => false,
            ];
        } else {
            setDieError('Wrong User ID', __FILE__, __LINE__);
        }
        break;
    case 'get_collectivemailbox_status':
        $result = checkIfEmailAddressIsCollectiveMailbox($input['cs_email']);
        die( json_encode( array('Result' => $result), true) );
        break;
    case 'end_trial':
        $dateTime = date("Y-m-d H:i:s");
        $newDateTime = new DateTime($dateTime);
        $newDateTime->setTimezone(new DateTimeZone("UTC"));
        $dateTimeUTC = $newDateTime->format("Y-m-d H:i:s");
        $data = [
            'EndDate' => $dateTimeUTC,
            KEY_CUSTOMER_ID => $input['bw_CustomerId'],
            'ContractId' => $input['bw_ContractId'],
            'Cart' => [
                KEY_PLANVARIANT_ID => $input['bw_PlanVariantId'],
                'EnableTrial' => false
            ],
        ];
        break;
    default:
        setDieError('Unknown action transmitted', __FILE__, __LINE__);
}
$result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data[KEY_BW_CUSTOMER_ID], $input);
