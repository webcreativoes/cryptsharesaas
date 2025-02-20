<?php

const KEY_CUSTMER_ID = 'CustomerId';
const KEY_CONTRACT_ID = 'ContractId';
const KEY_PAYMENT_BEARER = 'PaymentBearer';
const KEY_CUSTOM_FIELD = 'CustomFields';

if($_GET['token'] != '5f58d21e3af14d0df470ba845f58cda63af14d0df470ae1a5f58cc5e3af14d0df470aad6'){
    header('HTTP/1.0 401');
    die('permission denied');
} else {
    if($_SERVER['SERVER_NAME']=='api.cryptshare.express'){
        $_SERVER['TYPO3_CONTEXT'] = 'Production';
    } else {
        $_SERVER['TYPO3_CONTEXT'] = 'Development';    
    }
    require_once('lib/config.php');
    require_once('lib/functions.php');
    $headerText = "HTTP/1.0 200 OK";
    if($input = json_decode(file_get_contents("php://input"), true)) {
        $input[KEY_CUSTMER_ID] = 'webhook';
        if ($input[KEY_CONTRACT_ID] && $input['Event'] == 'PaymentBearerExpiring') {
            $data = array(
                KEY_CONTRACT_ID => $input[KEY_CONTRACT_ID],
                KEY_CUSTMER_ID => $input[KEY_CUSTMER_ID]
            );
            $token = getRestApiBearer($config);
            $contract = callRestAPI($config, $data, 'get_contract_returnOnly', $token['access_token'], $bw_customer_id, $input = false);
            if (strlen($contract['EndDate']) < 1) {
                if ($contract[KEY_PAYMENT_BEARER]['Type'] == 'CreditCard') {
                    $mailSubject = 'Your credit card expires soon - Your action is required';
                    $mailText = '<p>Dear ' . $contract[KEY_CUSTOM_FIELD]['CSFirstName'] . ',</p>';
                    $mailText .= '<p>the credit card for your Cryptshare.express subscription "' . $contract[KEY_CUSTOM_FIELD]['CSEmailUser'] . '" <strong>expires on ' . $contract[KEY_PAYMENT_BEARER]['ExpiryMonth'] . '/' . $contract[KEY_PAYMENT_BEARER]['ExpiryYear'] . '</strong>.</p>';
                    $mailText .= '<p>Please follow the instructions "How can I change payment data?" on our FAQ:<br><a href="https://www.cryptshare.express/en/help/faq#c34879">https://www.cryptshare.express/en/help/faq#c34879</a></p>';
                    $mailText .= '<p>Or get in touch with the Credit card Holder ' . $contract[KEY_PAYMENT_BEARER]['Holder'] . ' (if this is not you),<br>so that your payment details are up-to-date for the <strong>next billing on ' . substr($contract['NextBillingDate'], 0, 10) . '</strong>.</p>';
                    $mailText .= '<p>Thank you for using Cryptshare.express.</p>';
                    sendMail($mailSubject, $mailText, $contract[KEY_CUSTOM_FIELD]['CSEmailUser']);
                }
            } else {
                die('Contract is cancelled - nothing to do');
            }
        }
    }
}
header($headerText);
