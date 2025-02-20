<?php
/*
 * Load config, functions and clean inputs
 */
require_once('lib/init.php');

const BW_CUSTOMER_ID = 'bw_customer_id';
const CUSTOMER_ID = 'CustomerId';
const BW_CONTRACT_ID = 'bw_ContractId';
const CONTRACT_ID = 'ContractId';
const MSG_NO_CONTACT_ID = 'No billwerk ContractId transmitted';
const MESSAGE = 'Message';

switch($action){
    case 'get_contracts':
        $data = [ CUSTOMER_ID => $fe_user_data[BW_CUSTOMER_ID] ];
    break;
    case 'get_contract':
        if(empty($input[BW_CONTRACT_ID])) {
            setDieError('No billwerk ContractId transmitted', __FILE__, __LINE__);
        } else {
            $data = array( 
                CONTRACT_ID => $input[BW_CONTRACT_ID],
                CUSTOMER_ID => $fe_user_data[BW_CUSTOMER_ID]
            );
        }
    break;
    case 'get_selfservice_token':
        if(empty($input[BW_CONTRACT_ID])) {
            setDieError('No billwerk ContractId transmitted', __FILE__, __LINE__);
        } else {
            $data = array( CONTRACT_ID => $input[BW_CONTRACT_ID] );
        }
    break;
    case 'set_contracts_customerId':
        if(empty($input[BW_CONTRACT_ID])) {
            setDieError('No billwerk ContractId transmitted', __FILE__, __LINE__);
        } else {
            $data = array( 
                CUSTOMER_ID => $fe_user_data[BW_CUSTOMER_ID]
            );
        }
    break;
    case 'set_contract_customer':
        $data = [
            'ContractId' => $input['Id'],
            'CSEmailUser' => $input['Email'],
            'CSFirstName' => $input['Firstname'],
            'CSLastName' => $input['Lastname'],
            'CSCompany' => $input['Company'],
            'CSAddress' => $input['Street'],
            'CSZip' => $input['Zip'],
            'CSCity' => $input['City'],
            'CSCountry' => $input['Country'],
            'CSPhone' => $input['Phone'],
            'CSVat' => $input['Vat'],
            'CSHousenumber' => $input['Housenumber'],
            'CSChangedName' => $input['ChangedName'],
            'CSChangedEmail' => $input['ChangedEmail']
        ];
        break;
    case 'set_contracts_csuserdata':
        if(empty($input[BW_CONTRACT_ID])) {
            setDieError('No billwerk ContractId transmitted', __FILE__, __LINE__);
        } else {
            $data = array(
                CUSTOMER_ID => $fe_user_data[BW_CUSTOMER_ID],
                CONTRACT_ID => $input[BW_CONTRACT_ID],
                'CSServerStatus' => 'InitialInactive'
            );
        }
    break;
    case 'get_contracts_csuserdata':
        if(empty($input[BW_CONTRACT_ID])) {
            setDieError('No billwerk ContractId transmitted', __FILE__, __LINE__);
        } else {
            $fileNameContractData = $config['log_path']."contractData/".$input[BW_CONTRACT_ID].'.txt';
            if(file_exists($fileNameContractData)){
                $lines = file($fileNameContractData, FILE_IGNORE_NEW_LINES);
                $i = 0;
                $cs_user_data = [];
                foreach($lines as $order) {
                    $fileContentsArr = explode('|', $order);
                    $cs_user_data[$i] = [
                        BW_CONTRACT_ID => $fileContentsArr[0],
                        'cs_first_name' => $fileContentsArr[1],
                        'cs_last_name' => $fileContentsArr[2],
                        'cs_email' => $fileContentsArr[3]
                    ];
                    $i++;
                }
                die( json_encode($cs_user_data) );
            } else {
                setDieError('userdata file of your contract not found', __FILE__, __LINE__);
            }
        }
    break;
    case 'cancel_preview':
        $data = [
            CONTRACT_ID => $input[BW_CONTRACT_ID]
        ];
        break;
    case 'cancel_contract':
        $data = [
            CONTRACT_ID => $input['bw_ContractId'],
            'EndDate' => $input['endDate']
        ];
        break;
    default:
        setDieError('Unknown action transmitted', __FILE__, __LINE__);
}
$result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data[BW_CUSTOMER_ID]);
