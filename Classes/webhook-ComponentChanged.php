<?php
if($_GET['token'] != '5f58d21e3af14d0df470ba845f58cda63af14d0df470ae1a5f58cc5e3af14d0df470aad6') {
    header('HTTP/1.0 401');
    die('permission denied');
} else {
    if($_SERVER['SERVER_NAME']=='api.cryptshare.express') {
        $_SERVER['TYPO3_CONTEXT'] = 'Production';
        $rootPath = '/is/htdocs/wp13251579_RIVEMTPQCA/';
    } else {
        $_SERVER['TYPO3_CONTEXT'] = 'Development';
        //$rootPath = '/is/htdocs/wp13303627_IADXHPXADX/';
        $rootPath = '/srv/www/virtual/cs-x-dev.equinoxe.de/';
    }
    $logPath = $rootPath.'www/logging/curl/webhook-ComponentChanged.log';
    $written = file_put_contents($logPath, 'start'.PHP_EOL, FILE_APPEND);
    require_once('lib/config.php');
    require_once('lib/functions.php');
    $headerText = "HTTP/1.0 200 OK";
    if($input = json_decode(file_get_contents("php://input"), true)) {
        $input['CustomerId'] = 'webhook';
        $logValue = '';
        foreach ($input as $key => $value) {
            $logValue .= $key.': '.$value.'|';
        }
        $written = file_put_contents($logPath, $logValue.PHP_EOL, FILE_APPEND);
    }
}
header($headerText);
