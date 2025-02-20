<?php

require_once('lib/config.php');
require_once('lib/functions.php');

foreach ($_GET as $key => $value){
    $input[$key] = removeXSS(
        stripslashes(urldecode($value))
    );
}

/**
 * @function maintainFeUserBwToken
 * @description Maintenance function to remove billwerk tokens from fe_users
 * @param $config is an associative array with configurations
 * @return integer with number of affected rows of fe_user table
 */
function maintainFeUserBwToken($config){
    $con = mysqli_connect($config['typo3_dbhost'],$config['typo3_dbuser'],$config['typo3_dbpassword'],$config['typo3_dbname']);
    if (mysqli_connect_errno())  {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $query = "UPDATE fe_users SET bw_access_token = \"\" WHERE lastlogin < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 120 MINUTE)) AND is_online < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 120 MINUTE))";
    mysqli_query($con,$query);
    $row = mysqli_affected_rows($con);
    mysqli_close($con);
    return $row;
}

if ($input['action'] == 'maintainFeUserBwToken') {
    $result = maintainFeUserBwToken($config);
    echo json_encode( array('Result' => $result), true);
} else {
    echo 'No action selected';
}
