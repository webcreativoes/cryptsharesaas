<?php

/*
 * Load config, functions and clean inputs
 */

// Added Logging
require_once('lib/init.php');

const ADD_EMAIL_ON_CSSERVER = 'add_email_on_csserver';
const BW_CONTRACT_ID = 'bw_ContractId';
const CONTRACT_ID = 'ContractId';
const LOG_NO_CONTACT_ID = 'Cryptshareserver Error :No billwerk ContractId transmitted';
const MSG_NO_CONTACT_ID = 'No billwerk ContractId transmitted';
const MESSAGE = 'Message';
const CUSTOMER_ID = 'CustomerId';
const BW_CUSTOMER_ID = 'bw_customer_id';
const BW_ACCESS_TOKEN = 'bw_access_token';
const LOG_NO_EMAIL = 'Cryptshareserver Error :Was not able to fetch email address of contract. Maybe the contract id was wrong.';
const MSG_NO_EMAIL = 'Was not able to fetch email address of contract. Maybe the contract id was wrong.';
const ORDERS = 'orders';
const CS_SERVER = 'CSServer';
const CUSTOM_FIELDS = 'CustomFields';
const EMAIL = 'email';
const SUCCESS = 'Success';
const SEND_WELCOME_MAIL = 'send_welcome_mail';

global $config, $input, $fe_user_data, $action;

switch($action){
    case ADD_EMAIL_ON_CSSERVER:
        $data = getData($input, $fe_user_data);
        $contract = getContract($config, $action, $fe_user_data, $data);
        $logParams['contract'] = $contract;
        if(empty($input[BW_CONTRACT_ID])) {
            logAndDieNoContractId();
        }else{
            if($contract['CSServerStatus']=='Active') {
                writeRestLog ('Cryptshareserver Error :Email for this contract is already active',ADD_EMAIL_ON_CSSERVER,NULL,NULL, NULL, NULL);
                setDieError('Email for this contract is already active', __FILE__, __LINE__);
            } else {
                if(empty($contract['CSEmailUser'])) {
                    logAndDieNoEmail();
                } else {
                    $contractDetails = callRestAPI($config, $data, 'get_contract_returnOnly', $fe_user_data[BW_ACCESS_TOKEN], $fe_user_data[BW_CUSTOMER_ID]);
                    /* if success contains valide data then go on ELSE NOT
                     * need positive example for this
                     * the following request results in an problem with contractId
                     **/
                    $planInfo = getCryptshareServerHost($config, $contractDetails['PlanId']);
                    $data = [
                        CUSTOMER_ID => $fe_user_data[BW_CUSTOMER_ID],
                        CONTRACT_ID => $input[BW_CONTRACT_ID],
                        'CSServerStatus' => 'Active',
                        CS_SERVER => $planInfo[CUSTOM_FIELDS][CS_SERVER],
                    ];
                    $result = callRestAPI($config, $data, $action, $fe_user_data[BW_ACCESS_TOKEN], $fe_user_data[BW_CUSTOMER_ID]);
                    $t3admin = [
                        'name' => $fe_user_data['first_name'].' '.$fe_user_data['last_name'],
                        EMAIL => $fe_user_data[EMAIL],
                        'language' => $fe_user_data['language'],
                        'usergroup' => $fe_user_data['usergroup']
                    ];
                    $bwcsuser = [
                        'name' => $contractDetails[CUSTOM_FIELDS]['CSFirstName'].' '.$contractDetails[CUSTOM_FIELDS]['CSLastName'],
                        'firstname' => $contractDetails[CUSTOM_FIELDS]['CSFirstName'],
                        EMAIL => $contractDetails[CUSTOM_FIELDS]['CSEmailUser'],
                    ];
                    $csserver = $planInfo[CUSTOM_FIELDS][CS_SERVER];
                    $orderObj = json_decode($input[ORDERS]);
                    foreach ($orderObj as $order) {
                        addToPolicy($config, $order->cs_email, $contractDetails);
                        sendOnBoardingMail($t3admin, $bwcsuser, $csserver, $order, $input['is_trial']);
                    }
                    die( json_encode( [MESSAGE => SUCCESS], true) );
                }
            }
        }
        break;
    case 'add_email_on_csserver_simple':
        $data = getData($input, $fe_user_data);
        if(empty($input[BW_CONTRACT_ID])) {
            logAndDieNoContractId();
        } else {
            if(empty($input['email'])) {
                logAndDieNoEmail();
            } else {
                $contractDetails = callRestAPI($config, $data, 'get_contract_returnOnly', $fe_user_data[BW_ACCESS_TOKEN], $fe_user_data[BW_CUSTOMER_ID]);
                addToPolicy($config, $input['email'], $contractDetails);
                die( json_encode( [MESSAGE => SUCCESS], true) );
            }
        }
        break;
    case 'remove_email_on_csserver':
        $data = getData($input, $fe_user_data);
        $contract = getContract($config, 'get_contract_returnOnly', $fe_user_data, $data);
        if(empty($input[BW_CONTRACT_ID])) {
            logAndDieNoContractId();
        } else {
            if(empty($input[EMAIL])) {
                writeRestLog (LOG_NO_EMAIL,ADD_EMAIL_ON_CSSERVER,NULL,NULL, NULL, NULL);
                setDieError(MSG_NO_EMAIL, __FILE__, __LINE__);
            } else {
                $success = removeEmailOnCryptshareServerLocal($config, $input);
                die( json_encode( [MESSAGE => SUCCESS], true) );
            }
        }
        break;
    case SEND_WELCOME_MAIL:
        $data = getData($input, $fe_user_data);
        $contract = getContract($config, $action, $fe_user_data, $data);
        if(empty($input[BW_CONTRACT_ID])) {
            writeRestLog (LOG_NO_CONTACT_ID,SEND_WELCOME_MAIL,NULL,NULL, NULL, NULL);
            setDieError(MSG_NO_CONTACT_ID, __FILE__, __LINE__);
        }else{
            if(empty($input['cs_email'])) {
                writeRestLog ('Cryptshareserver Error :No Cryptshare email address transmitted',SEND_WELCOME_MAIL,NULL,NULL, NULL, NULL);
                setDieError('No Cryptshare email address transmitted', __FILE__, __LINE__);
            }else{
                if(sendWelcomeMailToCSEmailUser($config, $input)) {
                    writeRestLog (NULL,SEND_WELCOME_MAIL,NULL,NULL, NULL, NULL);
                    die( json_encode( [MESSAGE => SUCCESS], true) );
                }else{
                    writeRestLog ('Cryptshareserver Error :Sending the welcome email failed',SEND_WELCOME_MAIL,NULL,NULL, NULL, NULL);
                    setDieError('Sending the welcome email failed', __FILE__, __LINE__);
                }
            }
        }
        break;
    default:
        writeRestLog ('Cryptshareserver Error :Unknown action transmitted','no action',NULL,NULL, NULL, NULL);
        setDieError('Unknown action transmitted', __FILE__, __LINE__);
}

function addToPolicy($config, $email, $contractDetails) {
    addSingleEmailOnCryptshareServer($config, $email, $contractDetails['PlanId'], 'sender');
    addSingleEmailOnCryptshareServer($config, $email, $contractDetails['PlanId'], 'recipient');
}

function logAndDieNoContractId() {
    writeRestLog (LOG_NO_CONTACT_ID,ADD_EMAIL_ON_CSSERVER,NULL,NULL, NULL, NULL);
    setDieError(MSG_NO_CONTACT_ID, __FILE__, __LINE__);
}

function logAndDieNoEmail() {
    writeRestLog (LOG_NO_EMAIL,ADD_EMAIL_ON_CSSERVER,NULL,NULL, NULL, NULL);
    setDieError(MSG_NO_EMAIL, __FILE__, __LINE__);
}
function getContract($config, $action, $fe_user_data, $data) {
    return callRestAPI($config, $data, $action, $fe_user_data[BW_ACCESS_TOKEN], $fe_user_data[BW_CUSTOMER_ID]);
}
function getData($input, $fe_user_data) {
    return [
        CONTRACT_ID => $input[BW_CONTRACT_ID],
        CUSTOMER_ID => $fe_user_data[BW_CUSTOMER_ID]
    ];
}
