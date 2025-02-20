<?php

const KEY_CUSTOMER_ID = 'CustomerId';
const KEY_CONTRACT_ID = 'ContractId';

if($_GET['token'] != '5f58d21e3af14d0df470ba845f58cda63af14d0df470ae1a5f58cc5e3af14d0df470aad6') {
    header('HTTP/1.0 401');
    die('permission denied');
} else {
    if($_SERVER['SERVER_NAME']=='api.cryptshare.express') {
        $_SERVER['TYPO3_CONTEXT'] = 'Production';
        $rootPath = '/srv/www/virtual/cs-x-www.equinoxe.de/';
    } else {
        $_SERVER['TYPO3_CONTEXT'] = 'Development';
        $rootPath = '/srv/www/virtual/cs-x-dev.equinoxe.de/';
    }
    require_once('lib/config.php');
    require_once('lib/functions.php');
    $headerText = "HTTP/1.0 200 OK";
    if($input = json_decode(file_get_contents("php://input"), true)) {
        $input[KEY_CUSTOMER_ID] = 'webhook';
        if($input[KEY_CONTRACT_ID] && $input['Event']=='ContractChanged') {
            $data = [
                KEY_CONTRACT_ID => $input[KEY_CONTRACT_ID],
                KEY_CUSTOMER_ID => $input[KEY_CUSTOMER_ID]
            ];
            $token = getRestApiBearer($config);
            $contractDetails = callRestAPI($config, $data, 'get_contract', $token['access_token'], $bw_customer_id, $input = false);
            $contractComponents = callRestAPI($config, $data, 'get_components', $token['access_token'], $bw_customer_id, $input = false);
            $contract = arrayCastRecursive(json_decode($contractDetails));
            $components = arrayCastRecursive(json_decode($contractComponents));
            foreach ($components as $component) {
                if($component['EndDate']) {
                    $endDate = strtotime( $component['EndDate'] );
                    if($endDate <= time()) {
                        $componentMemo = explode(" ", $component['Memo']);
                        $componentEmail = $componentMemo[0];
                        $parser = removeEmailOnCryptshareServerForWebhook($config, $contract, $componentEmail);
                    }
                }
            }
            if($contract['LifecycleStatus']  != "InTrial") {
                setEndTrialOnFeUserByBwId($config, $bw_customer_id);
            }
            if($contract['LifecycleStatus'] == "Annulled" || $contract['LifecycleStatus'] == "Ended") {
                $parser = removeEmailOnCryptshareServerForWebhook($config, $contract, $contract['CustomFields']['CSEmailUser']);
                foreach ($components as $component) {
                    $componentMemo = explode(" ", $component['Memo']);
                    $componentEmail = $componentMemo[0];
                    $parser = removeEmailOnCryptshareServerForWebhook($config, $contract, $componentEmail);
                }
                $data = [
                    KEY_CONTRACT_ID => $contract['Id'],
                    'CSServerStatus' => 'Automatically deactivated'
                ];
                $response = callRestAPI($config, $data, 'set_contracts_csuserdata', $token['access_token'], $input[KEY_CUSTOMER_ID], $input = false);
            }
        } else {
            file_put_contents($rootPath.'www/logging/curl/webhook-ContractChanged.log', print_r($input).PHP_EOL, FILE_APPEND);
        }
        setKpi($config['db_kpi_host'], $config['db_kpi_user'], $config['db_kpi_pwd'], $config['db_kpi_name'], $contract['Id'], $contract['LifecycleStatus']);
    }
}
header($headerText);
