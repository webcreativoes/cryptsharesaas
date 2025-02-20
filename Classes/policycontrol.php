<?php

/*const KEY_CS_HOST = 'cryptshare_host';
const KEY_CS_HOST_PURE = 'cryptshare_host_pure';
const KEY_CS_EMAIL_USER = 'CSEmailUser';
const KEY_CS_USER = 'cryptshare_user';
const KEY_CS_PASSWORD = 'cryptshare_password';
const KEY_TOKEN = 'token';
const KEY_CS_SERVER = 'csserver';
const KEY_ACTION = 'action';*/

$valid_passwords = array (
    'express.support' => '_49Jd?5wY?H7Js9h+4B.tfWb&A',
);
$valid_users = array_keys($valid_passwords);
$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];
$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
    header('WWW-Authenticate: Basic realm="PolicyControl"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Access denied");
}

function addEmailOnCryptshareServerLocal($config, $contract, $direction) {
    $config['cryptshare_host'] = $config['cryptshare_host_pure'].'service/ai?wsdl';
    if (is_string($config['cryptshare_host']) && strlen($config['cryptshare_host']) <= 28){
        die;
    }
    if($direction == 'sender') {
        $xml_post_string = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
                                <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                                <addPolicyRule xmlns="http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/">
                                <policyRule xmlns="">
                                        <storageDuration>10</storageDuration>
                                        <transferLimit>10240</transferLimit>
                                        <senderMatcher>'.$contract['CSEmailUser'].'</senderMatcher>
                                        <recipientMatcher>.*</recipientMatcher>
                                        <networkPattern>0.0.0.0/00</networkPattern>
                                        <senderFilter>email</senderFilter>
                                        <recipientFilter>email</recipientFilter>
                                        </policyRule>
                                        </addPolicyRule>
                                </s:Body>
                        </s:Envelope>';
    } else {
        $xml_post_string = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
                                        <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                                        <addPolicyRule xmlns="http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/">
                                        <policyRule xmlns="">
                                                <storageDuration>10</storageDuration>
                                                <transferLimit>10240</transferLimit>
                                                <senderMatcher>.*</senderMatcher>
                                                <recipientMatcher>'.$contract['CSEmailUser'].'</recipientMatcher>
                                                <networkPattern>0.0.0.0/00</networkPattern>
                                                <senderFilter>email</senderFilter>
                                                <recipientFilter>email</recipientFilter>
                                                </policyRule>
                                                </addPolicyRule>
                                        </s:Body>
                                </s:Envelope>';
    }
    $headers = [
        "Content-type: text/xml;charset=\"utf-8\"",
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "Expect: 100-continue",
        "user: " . $config['cryptshare_user'],
        "password: " . $config['cryptshare_password'],
        "SOAPAction: http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/CryptshareServer/addPolicyRuleRequest",
        "Content-length: ".strlen($xml_post_string)
    ];
    $ch = curl_init();
    $file = '/is/htdocs/wp13251579_RIVEMTPQCA/www/cryptshare.express_11-live/packages/cryptsharesaas/Classes/restlog.txt';
    $verbose = fopen($file, 'w');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $config['cryptshare_host']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $config['cryptshare_user'].":".$config['cryptshare_password']);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
    }
    curl_close($ch);
    $response1 = str_replace("<soap:Body>","",$response);
    $response2 = str_replace("</soap:Body>","",$response1);
    return simplexml_load_string($response2);
}

function removeEmailOnCryptshareServerLocal($config, $contract) {
    $config['cryptshare_host'] = $config['cryptshare_host_pure'].'service/ai?wsdl';
    if (is_string($config['cryptshare_host']) && strlen($config['cryptshare_host']) <= 28){
        die;
    }
    $xml_post_string = '<?xml version="1.0" encoding="UTF-8"?>
    <S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/">
        <S:Body>
            <ns2:removeEMailRuleSet xmlns:ns2="http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/">
                <email>'.$contract['CSEmailUser'].'</email>
            </ns2:removeEMailRuleSet>
        </S:Body>
    </S:Envelope>';
    $headers = [
        "Content-type: text/xml;charset=\"utf-8\"",
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "Expect: 100-continue",
        "user: " . $config['cryptshare_user'],
        "password: " . $config['cryptshare_password'],
        "SOAPAction: http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/CryptshareServer/removePolicyRuleRequest",
        "Content-length: ".strlen($xml_post_string)
    ];
    $ch = curl_init();
    $file = '/is/htdocs/wp13251579_RIVEMTPQCA/www/cryptshare.express_11-live/packages/cryptsharesaas/Classes/restlog.txt';
    $verbose = fopen($file, 'w');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $config['cryptshare_host']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $config['cryptshare_user'].":".$config['cryptshare_password']);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    $response = curl_exec($ch);
    curl_close($ch);
    $response1 = str_replace("<soap:Body>","",$response);
    $response2 = str_replace("</soap:Body>","",$response1);
    return simplexml_load_string($response2);
}

if($_GET['token'] != '5f58d21e3af14d0df470ba845f58cda63af14d0df470ae1a5f58cc5e3af14d0df470aad6'){
    header('HTTP/1.0 401');
    die('permission denied');
}

if($_SERVER['SERVER_NAME']=='api.cryptshare.express'){
    $_SERVER['TYPO3_CONTEXT'] = 'Production';
} else {
    $_SERVER['TYPO3_CONTEXT'] = 'Development';
}

require_once('lib/config.php');

if($_GET['csserver']=='https://cs-x-nl.equinoxe.de/'){
	#const CS_PASSWD_LIVE_VALUE = 'VKM02_NAp01-Urt5oublbF';
}

if($_GET['csserver']) {
    $config['cryptshare_host_pure'] = $_GET['csserver'];
} else {
    echo '<h1>Select Cryptshare.express Server</h1>';
    echo '<ul>';
    echo '<li><a href="?token='.$_GET['token'].'&csserver=https://webapp.cryptshare.express/">https://webapp.cryptshare.express/</a></li>';
    echo '<li><a href="?token='.$_GET['token'].'&csserver=https://nl.cryptshare.express/">https://nl.cryptshare.express/</a></li>';
    echo '<li><a href="?token='.$_GET['token'].'&csserver=https://beta.cryptshare.com/">https://beta.cryptshare.com/</a></li>';
    echo '<li><a href="?token='.$_GET['token'].'&csserver=https://cs-x-nl.equinoxe.de/">https://cs-x-nl.equinoxe.de/</a></li>';
    echo '</ul>';
}

if($_GET['csserver']){
    if(!$_GET['action']){
        echo '<h1>Select action</h1>';
        echo '<ul>';
        echo '<li><a href="?token='.$_GET['token'].'&csserver='.$_GET['csserver'].'&action=add">add email address</a></li>';
        echo '<li><a href="?token='.$_GET['token'].'&csserver='.$_GET['csserver'].'&action=remove">remove email address</a></li>';
        echo '</ul>';
    } else {
        if($_GET['email']){
            $contract['CSEmailUser'] = $_GET['email'];
            $config['cryptshare_host_pure'] = $_GET['csserver'];
            switch($_GET['action']){
                case 'add':
                    addEmailOnCryptshareServerLocal($config, $contract, 'sender');
                    addEmailOnCryptshareServerLocal($config, $contract, 'recipient');
                    echo '<p>Should have work! - '.$contract['CSEmailUser'].' should be on '.$config['cryptshare_host_pure'].' now.<br><a href="?token='.$_GET['token'].'">Back to the start</a></p>';
                break;
                case 'remove':
                    removeEmailOnCryptshareServerLocal($config, $contract);
                    echo '<p>Should have work! - '.$contract['CSEmailUser'].' should be removed from '.$config['cryptshare_host_pure'].' now.<br><a href="?token='.$_GET['token'].'">Back to the start</a></p>';
                break;
                default:
                exit;
            }
        } else {
            echo '<h1>Enter the email address, that you want to '.$_GET['action'].' on '.$_GET['csserver'].'</h1>';
            echo '<form><input type="hidden" name="token" value="'.$_GET['token'].'"><input type="hidden" name="csserver" value="'.$_GET['csserver'].'"><input type="hidden" name="action" value="'.$_GET['action'].'"><input type="email" name="email" placeholder="Enter e-mail address"><button type="submit">Submit</button></form>';
        }
    }
}
