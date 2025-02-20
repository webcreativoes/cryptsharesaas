<?php

const KEY_BW_ACCESS_TOKEN = 'bw_access_token';
const KEY_TOKEN = 'token';

if($_SERVER['REMOTE_ADDR'] == '178.77.85.170'){
    $valid_passwords = array (
        'support.tool' => '_1rgendwass9BwicheresB'
    );

    $valid_users = array_keys($valid_passwords);

    $user = $_SERVER['PHP_AUTH_USER'];
    $pass = $_SERVER['PHP_AUTH_PW'];

    $validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

    if (!$validated) {
        header('WWW-Authenticate: Basic realm="API"');
        header('HTTP/1.0 401 Unauthorized');
        die ("Access denied");
    }

    require_once ('lib/config.php');
    require_once('lib/functions.php');

    $path = "/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/restLog/";
    $files = getAllFilesFromFolder($path);
    $logs = [];
    $logsTogo = [];
    $logsResult = [];
    $logsResult['logs'] = [];
    $logsResult['allT3Users'] = getFeUserAll($config);

    foreach ($files as $value) {
        $singleFileArray = file($path.$value, FILE_SKIP_EMPTY_LINES);
        $logs = array_merge($logs, $singleFileArray);
    }

    foreach ($logs as $key => $value) {
        $logsTo = [];
        $value = str_replace("][",",",$value);
        $value = str_replace("[","",$value);
        $value = str_replace("] :",",",$value);
        $value = str_replace("]","",$value);
        $value = explode(",", $value);
        if(strpos($value['4'],"allet")!==false){$value['4'] = "OK";}
        if(strlen ( $value['0']) >= 5) {
            $logsTogo[$key]['time'] = $value['0'];
            $logsTo['time'] = $value['0'];
            $logsTogo[$key]['url'] = $value['1'];
            $logsTo['url'] = $value['1'];
            if($value['2'] == $lastT3Session){
                $logsTogo[$key]['user'] = $fe_user_data;
                $logsTo['user'] = $fe_user_data;
            } else {
                if (strlen ( $value['2']) >= 6) {
                    $typo3_fe_user_id = getFeUserFromSessionId($config, $value['2']);
                } else {
                    $typo3_fe_user_id = $value['2'];
                }
                $fe_user_data = getFeUser($config, $typo3_fe_user_id);
                if (strlen ( $fe_user_date[KEY_BW_ACCESS_TOKEN]) >= 16){
                    $fe_user_date[KEY_BW_ACCESS_TOKEN] = 'SET';
                } else {
                    $fe_user_date[KEY_BW_ACCESS_TOKEN] = 'NOT SET';
                }
                if (strlen ( $fe_user_date[KEY_TOKEN]) >= 16){
                    $fe_user_date[KEY_TOKEN] = 'SET';
                } else {
                    $fe_user_date[KEY_TOKEN] = 'NOT SET';
                }
                array_walk_recursive($fe_user_data, 'encode_items');
                $logsTogo[$key]['user'] = $fe_user_data;
                $logsTo['user'] = $fe_user_data;
            }
            $logsTogo[$key]['t3session'] = $value['2'];
            $logsTogo[$key]['action'] = $value['3'];
            $logsTogo[$key]['success'] = $value['4'];
            $logsTo['t3session'] = $value['2'];
            $logsTo['action'] = $value['3'];
            $logsTo['success'] = $value['4'];
            array_push($logsResult['logs'], $logsTo);
        }
        $lastT3Session = $value['2'];
    }

    function encode_items(&$item)
    {
        $item = utf8_encode($item);
    }

    echo json_encode($logsResult);

    function getFeUserAll($config){
        $con = mysqli_connect($config['typo3_dbhost'],$config['typo3_dbuser'],$config['typo3_dbpassword'],$config['typo3_dbname']);
        if (mysqli_connect_errno())  {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $query = "SELECT * FROM fe_users";
        $result = mysqli_query($con,$query);
        $myRows = mysqli_fetch_all($result,MYSQLI_ASSOC);
        array_walk_recursive($myRows, 'encode_items');
        mysqli_close($con);
        return $myRows;
    }

    function getAllFilesFromFolder($folder){
        $files = null;
        if ( is_dir ( $folder ) && $handle = opendir($folder) ){
            while (($file = readdir($handle)) !== false) {
                if($file != '.' && $file != '..'){
                    $files[] = $file;
                }
            }
            closedir($handle);
            natsort($files);
        }
        return $files;
    }
} else {
	die('you are not allowed to access this endpoint');
}
