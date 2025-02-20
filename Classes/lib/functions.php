<?php
if(!isset($is_webhook) || !$is_webhook) {
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
}

const STYLE = 'style';
const HTTPS = 'https://';
const CURL_ENVIRONMENT_KEY = 'environment';
const CURL_PRAGMA_NO_CACHE_VALUE = "Pragma: no-cache";
const CURL_ENCODING_ACCEPT_TEXT = "Accept: text/json";
const CURL_CHARSET= 'UTF-8';
const CURL_AUTH = "Authorization: ";
const CURL_CACHE_CONTROL = "Cache-Control: no-cache";
const CURL_GRANT_TYPE = "grant_type: client_credentials";
const CURL_CUSTOMREQUEST_PATCH = 'PATCH';
const ACTION_UPDATE_CUSTOMER = 'update_customer';
const ACTION_GET_CONTRACTS = 'get_contracts';
const ACTION_GET_CONTRACT = 'get_contract';
const ACTION_GET_COMPONENTS = 'get_components';
const ACTION_GET_ORDER_PREVIEW = 'get_order_preview';
const ACTION_GET_SELFSERVICE_TOKEN = 'get_selfservice_token';
const ACTION_CREATE_ORDER = 'create_order';
const ACTION_COMMIT_ORDER_NOPAYMENT = 'commit_order_nopayment';
const ACTION_SET_CONTRACTS_CSUSERDATA = 'set_contracts_csuserdata';
const ACTION_GET_PLANVARIANT = 'get_planvariant';
const ACTION_GET_INVOICES = 'get_invoices';
const ACTION_DOWNLOAD_INVOICE = 'download_invoice';
const KEY_CUSTOMER_ID_1 = 'CustomerId';
const KEY_CONTRACT_ID = 'ContractId';
const KEY_MESSAGE_1 = 'Message';
const KEY_CURLOPT_URL = 'curloptUrl';
const KEY_CURLOPT_HTTPAUTH = 'curlorpHttpauth';
const KEY_CURLOPT_POST = 'curloptPost';
const KEY_CURLOPT_POSTFIELDS = 'curloptPostfields';
const KEY_CURLOPT_RETURNTRANSFER = 'curloptReturntransfer';
const KEY_CURLOPT_USERPWD = 'curloptUserpwd';
const KEY_CURLOPT_HTTPHEADER = 'curloptHttpheader';
const KEY_CURLOPT_CONNECTTIMEOUT = 'curloptConnecttimeout';
const KEY_CURLOPT_VERBOSE = 'curloptVerbose';
const KEY_CURLOPT_STDERR = 'curloptStderr';
const KEY_CURLOPT_ENCODING = 'curloptEncoding';
const KEY_CURLOPT_CUSTOMERREQUEST = 'curloptCustomrequest';
const KEY_HTTPREFERER = 'HTTP_REFERER';
const KEY_FE_TYPO3_USER = 'fe_typo_user';
const KEY_ERROR = 'error';
const KEY_LANGUAGE = 'language';
const KEY_EMAIL = 'EMAIL';
const KEY_ONBOARDING_1 = 'onboarding';
const KEY_TYPO3_DBUSER = 'typo3_dbuser';
const KEY_TYPO3_DBHOST = 'typo3_dbhost';
const KEY_TYPO3_DBPASSWORD = 'typo3_dbpassword';
const KEY_TYPO3_DBNAME = 'typo3_dbname';
const KEY_RESULT = 'Result';
const KEY_CSHOSTPURE = 'cryptshare_host_pure';
const KEY_FUNCTION = 'function';
const KEY_PLANID = 'planId';
const KEY_CSUSER = 'cryptshare_user';
const KEY_CSPASSWORD = 'cryptshare_password';
const KEY_CSHOST = 'cryptshare_host';
const KEY_CS_SERVER = 'CSServer';
const KEY_CUSTOM_FIELDS = 'CustomFields';
const KEY_ADDRESS = 'Address';
const KEY_CONSENT = 'consent';
const KEY_COMMUNICATIONS = 'communications';
const KEY_VALUE = 'value';
const STRING_LINEBREAKS = "\r\n\r\n";
const STRING_FROM = "[FROM : ";
const STRING_DBLIMIT = '" LIMIT 1';
const STRING_DBWHERE = '" WHERE uid = "';
const STRING_POLICYURL = 'service/ai?wsdl';
const STRING_RESTLOG = 'restlog.txt';
const STRING_SOAP_BODY_START = "<soap:Body>";
const STRING_SOAP_BODY_END = "</soap:Body>";
const BW_URL_CUSTOMERS = '.billwerk.com/api/v1/customers/';
const BW_URL_CONTRACTS = '.billwerk.com/api/v1/Contracts/';
const BW_URL_CUSTOM_FIELDS = '/customFields';
const CURL_ENCODING_ACCEPT_APPLICATION = "Accept: application/json";
const ENCODING_ACCEPT = "Accept: application/json";
const CURL_CONTENT_TYPE_TEXT = "Content-type: text/json";
const CURL_CONTENT_TYPE_APPLICATION = "Content-type: application/json";
const MSG_CONTACT_ID_NOT_EXISTS = 'It seems that the contract id you entered does not exists or belongs to an other business account';
const MSG_NO_COMPONENTS_FOR_CONTACT_ID = 'It seems that there are none Components booked for the given ContractId';
const MSG_MYSQL_CONNECTION_FAILED = "Failed to connect to MySQL: ";
const DATE_FORMAT = 'Y.m.d-h:i:s';
const VALUE_HEADER_CONTENTTYPE_TEXT = 'Content-type: text/xml;charset="utf-8"';
const VALUE_HEADER_ACCEPT_TEXT = 'Accept: text/xml';
const VALUE_HEADER_EXPECT = 'Expect: 100-continue';
const VALUE_HEADER_USER = 'user: ';
const VALUE_HEADER_PASSWORD = 'password: ';
const VALUE_HEADER_SOAPACTION = 'SOAPAction: http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/CryptshareServer/addPolicyRuleRequest';
const VALUE_HEADER_CONTENTLENGTH = 'Content-length: ';
const STRING_CURL_CONTENT_TYPE = "Content-type: application/json;charset=\"utf-8\"";
const STRING_DEV_LOCAL_CONTEXT = 'Development/Local';
const PRAGMA_NO_CACHE_VALUE = '';

function checkRa1word($ra, $val2, $ra1word, $ra_protocol, $ra_tag, $ra_attribute) {
    if (stripos($val2, $ra1word ) !== FALSE ) {
        if (in_array($ra1word, $ra_protocol, TRUE)) {
            $ra[] = array($ra1word, 'ra_protocol');
        }
        if (in_array($ra1word, $ra_tag, TRUE)) {
            $ra[] = array($ra1word, 'ra_tag');
        }
        if (in_array($ra1word, $ra_attribute, TRUE)) {
            $ra[] = array($ra1word, 'ra_attribute');
        }
    }
    return $ra;
}
/**
 * Removes potential XSS code from an input string.
 *
 * Using an external class by Travis Puderbaugh <kallahar@quickwired.com>
 *
 * @param string $val Input string
 * @param string $replaceString replaceString for inserting in keywords (which destroys the tags)
 * @return string Input string with potential XSS code removed
 */
function removeXSS($val, $replaceString = '<x>') {
    $replaceString = ($replaceString == '') ? '<x>' : $replaceString;
    $val = preg_replace('/([\x00-\x08]|[\x0b-\x0c]|[\x0e-\x19])/', '', $val);
    $searchHexEncodings = '/&#[xX]0{0,8}(21|22|23|24|25|26|27|28|29|2a|2b|2d|2f|30|31|32|33|34|35|36|37|38|39|3a|3b|3d|3f|40|41|42|43|44|45|46|47|48|49|4a|4b|4c|4d|4e|4f|50|51|52|53|54|55|56|57|58|59|5a|5b|5c|5d|5e|5f|60|61|62|63|64|65|66|67|68|69|6a|6b|6c|6d|6e|6f|70|71|72|73|74|75|76|77|78|79|7a|7b|7c|7d|7e);?/i';
    $searchUnicodeEncodings = '/&#0{0,8}(33|34|35|36|37|38|39|40|41|42|43|45|47|48|49|50|51|52|53|54|55|56|57|58|59|61|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90|91|92|93|94|95|96|97|98|99|100|101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125|126);?/i';
    while (preg_match($searchHexEncodings, $val) || preg_match($searchUnicodeEncodings, $val)) {
        $val = preg_replace_callback(
            $searchHexEncodings,
            function ($matches) {
                return chr(hexdec($matches[1]));
            },
            $val
        );
        $val = preg_replace_callback(
            $searchUnicodeEncodings,
            function ($matches) {
                return chr($matches[1]);
            },
            $val
        );
    }
    $ra1 = ['javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', STYLE, 'script', 'embed',
        'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base', 'video', 'audio', 'track',
        'canvas', 'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut',
        'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate',
        'onblur', 'onbounce', 'oncanplay', 'oncanplaythrough', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu',
        'oncontrolselect', 'oncopy', 'oncuechange', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete',
        'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart',
        'ondrop', 'ondurationchange', 'onemptied', 'onended', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish',
        'onfocus', 'onfocusin', 'onfocusout', 'onhashchange', 'onhelp', 'oninput', 'oninvalid', 'onkeydown', 'onkeypress',
        'onkeyup', 'onlayoutcomplete', 'onload', 'onloadeddata', 'onloadedmetadata', 'onloadstart', 'onlosecapture',
        'onmessage', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup',
        'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onoffline', 'ononline', 'onpagehide', 'onpageshow', 'onpaste',
        'onpause', 'onplay', 'onplaying', 'onpopstate', 'onprogress', 'onpropertychange', 'onratechange', 'onreadystatechange',
        'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted',
        'onscroll', 'onseeked', 'onseeking','onselect', 'onselectionchange', 'onselectstart', 'onshow', 'onstalled', 'onstart',
        'onstop', 'onstorage', 'onsubmit', 'onsuspend', 'ontimeupdate', 'onunload', 'onvolumechange', 'onwaiting'];
    $ra_tag = ['applet', 'meta', 'xml', 'blink', 'link', STYLE, 'script', 'embed', 'object', 'iframe', 'frame',
        'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base', 'video', 'audio', 'track', 'canvas'];
    $ra_attribute = [STYLE, 'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate',
        'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint',
        'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncanplay', 'oncanplaythrough', 'oncellchange', 'onchange',
        'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncuechange', 'oncut', 'ondataavailable', 'ondatasetchanged',
        'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover',
        'ondragstart', 'ondrop', 'ondurationchange', 'onemptied', 'onended', 'onerror', 'onerrorupdate', 'onfilterchange',
        'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhashchange', 'onhelp', 'oninput', 'oninvalid,', 'onkeydown',
        'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onloadeddata', 'onloadedmetadata', 'onloadstart',
        'onlosecapture', 'onmessage', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout',
        'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onoffline', 'ononline',
        'onpagehide', 'onpageshow', 'onpaste', 'onpause', 'onplay', 'onplaying', 'onpopstate', 'onprogress',
        'onpropertychange', 'onratechange', 'onreadystatechange', 'onredo', 'onreset', 'onresize', 'onresizeend',
        'onresizestart','onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onseeked', 'onseeking',
        'onselect', 'onselectionchange', 'onselectstart', 'onshow', 'onstalled', 'onstart', 'onstop', 'onstorage', 'onsubmit',
        'onsuspend', 'ontimeupdate', 'onundo', 'onunload', 'onvolumechange', 'onwaiting'];
    $ra_protocol = ['javascript', 'vbscript', 'expression'];
    $val2 = preg_replace('/(&#[xX]?0{0,8}(9|10|13|a|b);?)*\s*/i', '', $val);
    $ra = [];
    foreach ($ra1 as $ra1word) {
        $ra[] = checkRa1word($ra, $val2, $ra1word, $ra_protocol, $ra_tag, $ra_attribute);
    }
    if (count($ra) > 0) {
        $val = findPattern($val, $ra, $replaceString);
    }
    return $val;
}

function findPattern($val, $ra, $replaceString) {
    $found = TRUE;
    while ($found) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '';
            if(isset($ra[$i][0]) && !empty($ra[$i][0])) {
                for ($j = 0; $j < strlen($ra[$i][0]); $j++) {
                    $pattern .= ($j > 0) ? '((&#[xX]0{0,8}([9ab]);?)|(&#0{0,8}(9|10|13);?)|\s)*' : '';
                    $pattern .= $ra[$i][0][$j];
                }
            }
            if(isset($ra[$i][1]) && !empty($ra[$i][1])) {
                $pattern .= findSwitchPattern($ra[$i][1], $pattern);
            }
            $pattern = '/' . $pattern . '/i';
            $replacement = null;
            if(isset($ra[$i][0]) && !empty($ra[$i][0])) {
                $replacement = substr_replace($ra[$i][0], $replaceString, 2, 0);
            }
            $val = preg_replace($pattern, $replacement, $val);
            $found = ($val_before == $val) ? FALSE : TRUE;
        }
    }
    return $val;
}

function findSwitchPattern($switchValue, $pattern) {
    switch ($switchValue) {
        case 'ra_protocol':
            $pattern .= '((&#[xX]0{0,8}([9ab]);?)|(&#0{0,8}(9|10|13);?)|\s)*(?=:)';
            break;
        case 'ra_tag':
            /** These take the form of e.g. '<SCRIPT[^\da-z] ....'; */
            $pattern = '(?<=<)' . $pattern . '((&#[xX]0{0,8}([9ab]);?)|(&#0{0,8}(9|10|13);?)|\s)*(?=[^\da-z])';
            break;
        case 'ra_attribute':
            $pattern .= '[\s\!\#\$\%\&\(\)\*\~\+\-\_\.\,\:\;\?\@\[\/\|\\\\\]\^\`]*(?==)';
            break;
        default:
            $pattern .= '';
    }
    return $pattern;
}

function calcHash($input) {
    return md5($input['email_address'] . $input['first_name'] . $input['last_name']);
}

/**
 * This function was introduced with TYPO3 9.5.23 because of this breaking change:
 * https://github.com/TYPO3/TYPO3.CMS/commit/dc26a4ac1a
 */
function calcSessionHash($config,$sessionId) {
    $key = sha1($config['typo3_encryptionkey'] . 'core-session-backend');
    return hash_hmac('sha256', $sessionId, $key);
}

function arrayCastRecursive($array) {
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = arrayCastRecursive($value);
            }
            if ($value instanceof stdClass) {
                $array[$key] = arrayCastRecursive((array)$value);
            }
        }
    }
    if ($array instanceof stdClass) {
        return arrayCastRecursive((array)$array);
    }
    return $array;
}

/**
 * Get Hostname with protocol
 */
function getCurrentHostname() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? HTTPS : 'http://';
    $domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol.$domainName;
}

function checkIfEmailAddressIsCollectiveMailbox($email){
    $email_normalized = strtolower(trim($email));
    $user = strstr( $email_normalized, '@', true);
    $filename = '../Resources/Private/Extensions/cryptsharesaas/collectivemailbox.csv';
    if(file_exists($filename)){
        $lines = file($filename);
        foreach ($lines as $line) {
            if(trim($line) == $user){
                return 1;
            }
        }
    }else{
        return 0;
    }
    return 0;
}

/**
 * Build rest request
 */
function callRestAPI($config, $data, $action, $bw_access_token, $bw_customer_id, $input = false, $echo = true, $json = false) {
    $curl = curl_init();
    ob_start();
    $verbose = fopen('php://output', 'w');
    $client_id = $config['client_id'];
    $client_secret = $config['client_secret'];
    /**
     * Nächster Schritt
     * Hierbei handelt es sich immer noch um Admin-Rolle, daher wahrscheinlich auch die fremden Bestellungen im contracts-Array -> User Rolle möglich?
     */
    $Bearer = 'Bearer ' . $bw_access_token;
    $result = false;
    $response = false;
    switch($action){
        case 'get_access_token':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/oauth/token', KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => 1, KEY_CURLOPT_POSTFIELDS => $data, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => ["Content-type: application/x-www-form-urlencoded"], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $result = arrayCastRecursive(json_decode($response));
            break;
        case 'create_customer':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/Customers', KEY_CURLOPT_HTTPAUTH => false, KEY_CURLOPT_POST => 1, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => false, KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, "Content-type: text/json;charset=\"utf-8\"", CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => CURL_CHARSET, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $result = json_decode($response);
            break;
        case 'set_customer':
        case ACTION_UPDATE_CUSTOMER:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CUSTOMERS.$data[KEY_CUSTOMER_ID_1], KEY_CURLOPT_HTTPAUTH => false, KEY_CURLOPT_POST => 1, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => false, KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, STRING_CURL_CONTENT_TYPE, CURL_ENCODING_ACCEPT_APPLICATION, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => CURL_CHARSET, KEY_CURLOPT_CUSTOMERREQUEST => 'PUT'];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            break;
        case 'save_business_partner_change_decision':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CUSTOMERS.$data[KEY_CUSTOMER_ID_1], KEY_CURLOPT_HTTPAUTH => false, KEY_CURLOPT_POST => 1, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => false, KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, STRING_CURL_CONTENT_TYPE, CURL_ENCODING_ACCEPT_APPLICATION, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => CURL_CHARSET, KEY_CURLOPT_CUSTOMERREQUEST => 'PUT'];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            break;
        case 'get_customer':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/customers/'.$data[KEY_CUSTOMER_ID_1], KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            if($json){
                $customer = arrayCastRecursive(json_decode($response));
                $result = json_encode($customer);
            }
            break;
        case 'cancel_preview':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/contracts/'.$data['ContractId'].'/cancellationPreview', KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            break;
        case 'cancel_contract':
            $post = ['EndDate' => $data['EndDate']];
            $params = [
                KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/contracts/'.$data['ContractId'].'/end',
                KEY_CURLOPT_HTTPAUTH => false,
                KEY_CURLOPT_POST => 1,
                KEY_CURLOPT_POSTFIELDS => json_encode($post, true),
                KEY_CURLOPT_RETURNTRANSFER => true,
                KEY_CURLOPT_USERPWD => false,
                KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, STRING_CURL_CONTENT_TYPE, CURL_ENCODING_ACCEPT_APPLICATION, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE],
                KEY_CURLOPT_CONNECTTIMEOUT => 5,
                KEY_CURLOPT_VERBOSE => true,
                KEY_CURLOPT_STDERR => $verbose,
                KEY_CURLOPT_ENCODING => CURL_CHARSET,
                KEY_CURLOPT_CUSTOMERREQUEST => 'POST'
            ];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            break;
        case ACTION_GET_CONTRACTS:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CUSTOMERS.$data[KEY_CUSTOMER_ID_1].'/contracts/', KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $all_contracts = arrayCastRecursive(json_decode($response));
            foreach($all_contracts as $value){
                if($value[KEY_CUSTOMER_ID_1]==$bw_customer_id && $value['LifecycleStatus'] != 'Annulled' && $value['LifecycleStatus'] != 'Ended'){
                    $customer_contracts[] = $value;
                }
            }
            if($json){
                $customer_contracts = arrayCastRecursive(json_decode($response));
                $result = json_encode($customer_contracts);
            } else {
                $result = json_encode($customer_contracts);
            }
            break;
        case ACTION_GET_CONTRACT:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CONTRACTS.$data[KEY_CONTRACT_ID], KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $contract = arrayCastRecursive(json_decode($response));
            if($data[KEY_CUSTOMER_ID_1]=='webhook' || $contract[KEY_CUSTOMER_ID_1]==$bw_customer_id){
                $result = json_encode($contract);
            } else {
                $result = json_encode( array(KEY_MESSAGE_1 => MSG_CONTACT_ID_NOT_EXISTS), true);
                setDieError(MSG_CONTACT_ID_NOT_EXISTS, __FILE__, __LINE__);
            }
            break;
        case ACTION_GET_COMPONENTS:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CONTRACTS.$data[KEY_CONTRACT_ID].'/componentSubscriptions', KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $components = arrayCastRecursive(json_decode($response));
            if($data[KEY_CUSTOMER_ID_1]=='webhook') {
                $result = json_encode($components);
            } else if($components[0][KEY_CUSTOMER_ID_1]==$bw_customer_id){
                echo $response;
            }
            break;
        case 'get_component':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CONTRACTS.$data[KEY_CONTRACT_ID].'/componentSubscriptions/'.$data['ComponentId'], KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $components = arrayCastRecursive(json_decode($response));
            if($components[0][KEY_CUSTOMER_ID_1]==$bw_customer_id){
                echo $response;
            } else {
                $result = json_encode( array(KEY_MESSAGE_1 =>  MSG_NO_COMPONENTS_FOR_CONTACT_ID), true);
                setDieError(MSG_NO_COMPONENTS_FOR_CONTACT_ID, __FILE__, __LINE__);
            }
            break;
        case 'edit_component':
        case 'cancel_component':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/componentSubscriptions/'.$data['ComponentId'], KEY_CURLOPT_HTTPAUTH => false, KEY_CURLOPT_POST => 1, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => false, KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, STRING_CURL_CONTENT_TYPE, CURL_ENCODING_ACCEPT_APPLICATION, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => CURL_CHARSET, KEY_CURLOPT_CUSTOMERREQUEST => 'PUT'];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $components = arrayCastRecursive(json_decode($response));
            if($components[KEY_CUSTOMER_ID_1] == $bw_customer_id){
                echo $response;
            } else {
                $result = json_encode( array(KEY_MESSAGE_1 =>  MSG_NO_COMPONENTS_FOR_CONTACT_ID), true);
                setDieError(MSG_NO_COMPONENTS_FOR_CONTACT_ID, __FILE__, __LINE__);
            }
            break;
        case 'get_contract_returnOnly':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CONTRACTS.$data[KEY_CONTRACT_ID], KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $contract = arrayCastRecursive(json_decode($response));
            if($data[KEY_CUSTOMER_ID_1]=='webhook' || $contract[KEY_CUSTOMER_ID_1]==$bw_customer_id){
                $result = $contract;
            } else {
                json_encode( array(KEY_MESSAGE_1 => '-=contract_returnOnly=-It seems that the contract id you entered does not exists or belongs to an other business account'), true);
                setDieError('-=contract_returnOnly=-It seems that the contract id you entered does not exists or belongs to an other business account', __FILE__, __LINE__);
            }
            break;
        case ACTION_GET_SELFSERVICE_TOKEN:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CONTRACTS.$data[KEY_CONTRACT_ID].'/selfServiceToken', KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            break;
        case 'set_contract_customer':
        case 'set_contracts_customerId':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CONTRACTS.$data[KEY_CONTRACT_ID].BW_URL_CUSTOM_FIELDS, KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_APPLICATION, CURL_ENCODING_ACCEPT_APPLICATION, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => CURL_CUSTOMREQUEST_PATCH];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            break;
        case ACTION_SET_CONTRACTS_CSUSERDATA:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CONTRACTS.$data[KEY_CONTRACT_ID].BW_URL_CUSTOM_FIELDS, KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_APPLICATION, CURL_ENCODING_ACCEPT_APPLICATION, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => CURL_CHARSET, KEY_CURLOPT_CUSTOMERREQUEST => CURL_CUSTOMREQUEST_PATCH];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            break;
        case 'get_product':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/ProductInfo/'.$data, KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $result =$response;
            break;
        case 'get_plan':
            if(!is_array($data)) {
                $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/Plans/'.$data, KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            } else {
                $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/Plans/'.$data['planId'], KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, CURL_ENCODING_ACCEPT_TEXT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            }
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $result = $response;
            break;
        case 'get_plans':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/PlanVariants?planId='.$data['bw_planId'], KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => false, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_TEXT, ENCODING_ACCEPT, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            break;
        case ACTION_GET_PLANVARIANT:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/PlanVariants/'.$data['bw_PlanVariantId'], KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_ENCODING_ACCEPT_APPLICATION, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => CURL_CHARSET, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            break;
        case 'add_email_on_csserver':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].BW_URL_CONTRACTS.$data[KEY_CONTRACT_ID].BW_URL_CUSTOM_FIELDS, KEY_CURLOPT_HTTPAUTH =>CURLAUTH_BASIC , KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_APPLICATION, CURL_ENCODING_ACCEPT_APPLICATION, CURL_CACHE_CONTROL, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => CURL_CUSTOMREQUEST_PATCH];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $result = arrayCastRecursive(json_decode($response));
            if($result[KEY_CUSTOMER_ID_1]!=$bw_customer_id){
                json_encode( array(KEY_MESSAGE_1 => MSG_CONTACT_ID_NOT_EXISTS), true);
                setDieError(MSG_CONTACT_ID_NOT_EXISTS, __FILE__, __LINE__);
            }
            break;
        case ACTION_GET_ORDER_PREVIEW:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/Orders/preview', KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => 1, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_APPLICATION, CURL_ENCODING_ACCEPT_APPLICATION, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $result = curl_exec($curl);
            break;
        case ACTION_CREATE_ORDER:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/Orders', KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => 1, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_APPLICATION, CURL_ENCODING_ACCEPT_APPLICATION, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            $order = arrayCastRecursive(json_decode($response));
            $fileNameContractData = $config['log_path']."contractData/".$order['Contract']['Id'].'.txt';
            $orders = json_decode('['.$input['orders'].']');
            foreach($orders as $orderItem) {
                file_put_contents($fileNameContractData, $order['Contract']['Id'] . '|' . $orderItem->cs_first_name . '|' . $orderItem->cs_last_name . '|' . $orderItem->cs_email.PHP_EOL, FILE_APPEND);
            }
            break;
        case 'end_trial':
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/Orders', KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => 1, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_APPLICATION, CURL_ENCODING_ACCEPT_APPLICATION, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $response = curl_exec($curl);
            arrayCastRecursive(json_decode($response));
            break;
        case ACTION_COMMIT_ORDER_NOPAYMENT:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/Orders/'.$data['Order_id'].'/commit', KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => 1, KEY_CURLOPT_POSTFIELDS => json_encode($data, true), KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_APPLICATION, CURL_ENCODING_ACCEPT_APPLICATION, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $result = curl_exec($curl);
            echo $result;
            break;
        case ACTION_GET_INVOICES:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/Invoices?customerId='.$data[KEY_CUSTOMER_ID_1], KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => false, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_APPLICATION, CURL_ENCODING_ACCEPT_APPLICATION, CURL_PRAGMA_NO_CACHE_VALUE], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $result = curl_exec($curl);
            break;
        case ACTION_DOWNLOAD_INVOICE:
            $params = [KEY_CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/api/v1/Invoices/'.$data['InvoiceId'].'/downloadlink', KEY_CURLOPT_HTTPAUTH => CURLAUTH_BASIC, KEY_CURLOPT_POST => 1, KEY_CURLOPT_POSTFIELDS => false, KEY_CURLOPT_RETURNTRANSFER => true, KEY_CURLOPT_USERPWD => "$client_id:$client_secret", KEY_CURLOPT_HTTPHEADER => [CURL_GRANT_TYPE, CURL_AUTH.$Bearer, CURL_CONTENT_TYPE_APPLICATION, CURL_ENCODING_ACCEPT_APPLICATION, CURL_PRAGMA_NO_CACHE_VALUE, "Content-Length: 0"], KEY_CURLOPT_CONNECTTIMEOUT => 5, KEY_CURLOPT_VERBOSE => true, KEY_CURLOPT_STDERR => $verbose, KEY_CURLOPT_ENCODING => false, KEY_CURLOPT_CUSTOMERREQUEST => false];
            $curl = getCurlCall($curl, $params);
            $result = curl_exec($curl);
            break;
        default:
            setDieError('It seems that there was no action set', __FILE__, __LINE__);
    }
    arrayCastRecursive(json_decode($response));
    fclose($verbose);
    ob_get_clean();
    if($result) {
        writeTypeLog($action, gettype($result));
    }
    if($response) {
        writeTypeLog($action, gettype($result));
    }
    if ($action == 'end_trial' || $action == ACTION_GET_ORDER_PREVIEW || $action == ACTION_CREATE_ORDER || $action == ACTION_COMMIT_ORDER_NOPAYMENT || $action ==ACTION_SET_CONTRACTS_CSUSERDATA || $action ==ACTION_GET_PLANVARIANT || $action ==ACTION_GET_SELFSERVICE_TOKEN || $action ==ACTION_GET_CONTRACTS || $action ==ACTION_GET_CONTRACT || $action ==ACTION_GET_COMPONENTS || $action ==ACTION_UPDATE_CUSTOMER || $action == ACTION_GET_INVOICES || $action == ACTION_DOWNLOAD_INVOICE || $action == 'cancel_component' || $action == 'get_component' || $action == 'edit_component' || $action == 'get_customer_contracts' || $action == 'get_customer' || $action == 'set_customer' || $action == 'get_plan' || $action == 'set_contract_customer' || $action == 'cancel_preview' || $action == 'cancel_contract')
    {
        if($echo) {
            if (is_string($result)){
                echo $result;
            } else {
                if (is_string($response)){
                    echo $response;
                }
            }
        }
    } else {
        if (!$result){
            $result = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        }
    }
    curl_close($curl);
    return $result;
}

function getCurlCall($curl, $params) {
    $curlParams = [];
    if($params[KEY_CURLOPT_URL]) {
        $curlParams[CURLOPT_URL] = $params[KEY_CURLOPT_URL];
    }
    if($params[KEY_CURLOPT_HTTPAUTH]) {
        $curlParams[CURLOPT_HTTPAUTH] = $params[KEY_CURLOPT_HTTPAUTH];
    }
    if($params[KEY_CURLOPT_POST]) {
        $curlParams[CURLOPT_POST] = $params[KEY_CURLOPT_POST];
    }
    if($params[KEY_CURLOPT_POSTFIELDS]) {
        $curlParams[CURLOPT_POSTFIELDS] = $params[KEY_CURLOPT_POSTFIELDS];
    }
    if($params[KEY_CURLOPT_RETURNTRANSFER]) {
        $curlParams[CURLOPT_RETURNTRANSFER] = $params[KEY_CURLOPT_RETURNTRANSFER];
    }
    if($params[KEY_CURLOPT_USERPWD]) {
        $curlParams[CURLOPT_USERPWD] = $params[KEY_CURLOPT_USERPWD];
    }
    if($params[KEY_CURLOPT_HTTPHEADER]) {
        $curlParams[CURLOPT_HTTPHEADER] = $params[KEY_CURLOPT_HTTPHEADER];
    }
    if($params[KEY_CURLOPT_CONNECTTIMEOUT]) {
        $curlParams[CURLOPT_CONNECTTIMEOUT] = $params[KEY_CURLOPT_CONNECTTIMEOUT];
    }
    if($params[KEY_CURLOPT_VERBOSE]) {
        $curlParams[CURLOPT_VERBOSE] = $params[KEY_CURLOPT_VERBOSE];
    }
    if($params[KEY_CURLOPT_STDERR]) {
        $curlParams[CURLOPT_STDERR] = $params[KEY_CURLOPT_STDERR];
    }
    if($params[KEY_CURLOPT_ENCODING]) {
        $curlParams[CURLOPT_ENCODING] = $params[KEY_CURLOPT_ENCODING];
    }
    if($params[KEY_CURLOPT_CUSTOMERREQUEST]) {
        $curlParams[CURLOPT_CUSTOMREQUEST] = $params[KEY_CURLOPT_CUSTOMERREQUEST];
    }
    curl_setopt_array($curl, $curlParams);
    return $curl;
}

function writeDevLog($config, $log) {
    ob_start();
    $fileNameLog = $config['log_path'].'dev.log';
    $dt = new DateTime('now');
    $dateTime = "[".$dt->format(DATE_FORMAT)."]";
    $dateTime .= STRING_FROM.$_SERVER[KEY_HTTPREFERER]."]";
    $typo3_fe_user_id = getFeUserFromSessionId($config, $_COOKIE[KEY_FE_TYPO3_USER]);
    var_dump('---------------------------------------------------------------------------------------');
    var_dump($dateTime.'['.$typo3_fe_user_id.']');
    var_dump($log);
    $logContent = ob_get_contents();
    ob_end_clean();
    file_put_contents($fileNameLog, $logContent, FILE_APPEND | LOCK_EX);
    ob_start();
}

function writeTypeLog($action, $type)
{
    if($_SERVER['TYPO3_CONTEXT'] != STRING_DEV_LOCAL_CONTEXT) {
        global $config;
        $dt = new DateTime('now');
        $date = $dt->format('Y-m-d');
        $dateTime = "[" . $dt->format(DATE_FORMAT) . "]";
        $dateTime .= STRING_FROM . $_SERVER[KEY_HTTPREFERER] . "]";
        $fileNameLog = $config['log_path']."restLog-Error/typeLog-" . $date . '.txt';
        $typo3_fe_user_id = getFeUserFromSessionId($config, $_COOKIE[KEY_FE_TYPO3_USER]);
        if(($typeLog = @fopen($fileNameLog, 'a+')) !== FALSE) {
            if (is_resource($typeLog)) {
                $logString = fwrite($typeLog, "---------------------------------------------------------------------------------------\r\n");
                $logString .= $dateTime . "[" . $typo3_fe_user_id . "] function: " . $action . '; type :' . $type . "\r\n";
                fwrite($typeLog, $logString . "\r\n");
                fclose($typeLog);
            }
        }
    }
}

function contractAnnulledOrEnded($config, $contract, $token, $input, $components) {
    $parser = removeEmailOnCryptshareServerForWebhook($config, $contract, $contract['CustomFields']['CSEmailUser']);
    foreach ($components as $component) {
        $componentMemo = explode(" ", $component['Memo']);
        $componentEmail = $componentMemo[0];
        $parser = removeEmailOnCryptshareServerForWebhook($config, $contract, $componentEmail);
    }
    $data = [
        'ContractId' => $contract['Id'],
        'CSServerStatus' => 'Automatically deactivated'
    ];
    $response = callRestAPI($config, $data, 'set_contracts_csuserdata', $token['access_token'], $input['CustomerId'], $input = false);
}

/**
 * @param $error
 * @param $action
 * @param $declaration
 * @param $restArray
 * @param $curlerrorNo
 * @param $header
 */
function writeRestLog ($error, $action, $declaration, $restArray, $curlerrorNo, $header) {
    global $config;
    $ajaxErrorArray = [];
    $errorString = NULL;
    $logError = '';
    $dt = new DateTime('now');
    $date = $dt->format('Y-m-d');
    $dateTime = "[" . $dt->format('Y.m.d-h:i:s') . "]";
    $dateTime .= STRING_FROM . $_SERVER['HTTP_REFERER'] . "]";
    $fileNameLogError = $config['log_path']."restLog-Error/restLog_Error-" . $date . '.txt';
    if(!file_exists($fileNameLogError)) {
        file_put_contents($fileNameLogError, '');
    }
    if (is_writable($fileNameLogError)) {
        $fileNameLog = $config['log_path']."restLog/restLog-" . $date . '.txt';
        $typo3_fe_user_id = getFeUserFromSessionId($config, $_COOKIE['fe_typo_user']);
        $logString = $dateTime . "[" . $typo3_fe_user_id . "][" . $action . "][OK]" . "\r\n";
        if ($error || $restArray['error'] || $restArray['Message'] || $curlerrorNo || $ajaxErrorArray) {
            if ($verboseLog = fopen($fileNameLogError, "a+")) {
                $errorString = fwrite($verboseLog, "---------------------------------------------------------------------------------------\r\n");
            }
        }
        if (is_writable($fileNameLog)) {
            if ($log = fopen($fileNameLog, 'a+')) {
                if ($error) {
                    $logError = $dateTime . "[" . $typo3_fe_user_id . "][" . $error . "] function: " . $action . '; declaration :' . $declaration . "\r\n";
                    $errorString .= $logError;
                } else if ($restArray['error'] || $restArray['Message']) {
                    $logError = $dateTime . "[" . $typo3_fe_user_id . "][" . $action . "] Billwerk API Fehler :" . $restArray['error'] . " : " . $restArray['error_description'] . "\r\n\r\n";
                    $errorString .= $logError;
                    $errorString .= $dateTime . "[" . $typo3_fe_user_id . "][" . $action . "] Billwerk API Fehler Message :" . $restArray['Message'] . "\r\n\r\n";
                    $errorString .= 'JSON Komplett:' . json_encode($restArray) . "\r\n\r\n";
                } else if ($curlerrorNo) {
                    $logError = $dateTime . "[" . $typo3_fe_user_id . "][" . $action . "].";
                    $errorString .= $logError;
                }
                if ($errorString) {
                    $errorString .= $header . "\r\n";
                    $errorString .= $config['environment'] . ":";
                    sendMail('CSX Rest Log - Error ', $errorString, 'lutz.eckelmann@cryptshare.com');

                    fwrite($verboseLog, $errorString . "\r\n");
                    fwrite($log, $logError);
                } else {
                    fwrite($log, $logString . "\r\n");
                }
            }
            fclose($verboseLog);
            fclose($log);
        }
    }
}

function sendMail($mailSubject,$MailContent,$recipient) {
    global $config;
    $subject = $mailSubject;
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAutoTLS = false;
    $mail->Password = $config['SMTPPassword'];
    $mail->Username = $config['SMTPUsername'];
    $mail->SMTPDebug  = 0;
    $mail->Port = $config['SMTPPort'];
    $mail->Host = $config['SMTPHost'];
    $mail->CharSet = CURL_CHARSET;
    $mail->IsHTML(true);
    $mail->SetFrom($config['MAILFrom']);
    $mail->Subject  = $subject;
    $mail->Body     = $MailContent;
    if(isset($config['forceRecipientAddress'])){
        $mail->AddAddress($config['forceRecipientAddress']);
    }else{
        $mail->AddAddress($recipient);
    }
    if(isset($config['forceCCRecipientAddress'])){
        $mail->AddBCC($config['forceCCRecipientAddress']);
    }
    if(isset($config['forceCCRecipientAddress2'])){
        $mail->AddBCC($config['forceCCRecipientAddress2']);
    }
    if(isset($config['forceCCRecipientAddress3'])){
        $mail->AddBCC($config['forceCCRecipientAddress3']);
    }
    if(!$mail->send()) {
        return 'Mailer error: ' . $mail->ErrorInfo.'HOST :' .$config['SMTPHost'].":".$mail->Port = $config['SMTPPort'];
    } else {
        return 'Message has been sent.';
    }
}

function createSubjectContent($mailTemplates, $admin, $is_trial) {
    if (!$mailTemplates[$admin[KEY_LANGUAGE]] && $is_trial) {
        $subject = $mailTemplates['EN'][KEY_ONBOARDING_1]['is_trial']['subject'];
        $content = $mailTemplates['EN'][KEY_ONBOARDING_1]['is_trial']['content'];
    } elseif(!$mailTemplates[$admin[KEY_LANGUAGE]] && !$is_trial) {
        $subject = $mailTemplates['EN'][KEY_ONBOARDING_1]['subject'];
        $content = $mailTemplates['EN'][KEY_ONBOARDING_1]['content'];
    } elseif($mailTemplates[$admin[KEY_LANGUAGE]] && $is_trial) {
        $subject = $mailTemplates[$admin[KEY_LANGUAGE]][KEY_ONBOARDING_1]['is_trial']['subject'];
        $content = $mailTemplates[$admin[KEY_LANGUAGE]][KEY_ONBOARDING_1]['is_trial']['content'];
    } elseif($mailTemplates[$admin[KEY_LANGUAGE]] && !$is_trial) {
        $subject = $mailTemplates[$admin[KEY_LANGUAGE]][KEY_ONBOARDING_1]['subject'];
        $content = $mailTemplates[$admin[KEY_LANGUAGE]][KEY_ONBOARDING_1]['content'];
    }
    if($admin['usergroup']==='18'){
        $subject = $mailTemplates['ORANGEDENTAL'][KEY_ONBOARDING_1]['subject'];
        $content = $mailTemplates['ORANGEDENTAL'][KEY_ONBOARDING_1]['content'];
    }
    return [$subject, $content];
}

function sendOnBoardingMail($admin, $user, $server, $order, $is_trial) {
    global $mailTemplates;
    $tagreplaces = array(
        'from' => array('###username###', '###userfirstname###', '###userlastname###', '###adminname###', '###server###'),
        'to' => array($order->cs_last_name, $order->cs_first_name, $order->cs_last_name, $admin['name'], $server),
    );

    list($subject, $content) = createSubjectContent($mailTemplates, $admin, $is_trial);

    $subject = str_replace($tagreplaces['from'], $tagreplaces['to'], $subject);
    $content = str_replace($tagreplaces['from'], $tagreplaces['to'], $content);
    $mailResult = sendMail($subject, $content, $order->cs_email);
    if ($mailResult == 'Message has been sent.') {
        $error = NULL;
    } else {
        if(is_array($mailResult)) {
            $error = json_encode($mailResult).' '.$user;
        } elseif(is_array($user)) {
            $error = $mailResult.' '.json_encode($user);
        }  elseif(is_array($mailResult) && is_array($user)) {
            $error = json_encode($mailResult).' '.json_encode($user);
        } else {
            $error = $mailResult.' '.$user;
        }
    }
    $action = "PHP-sendOnBoardingMail";
    $declaration = "PHP-function Call";
    writeRestLog($error, $action, $declaration, NULL, NULL, NULL);
}

function getFeUserFromSessionId($config, $ses_id){
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $hashed_ses_id = calcSessionHash($config, $ses_id);
    $query = 'SELECT * FROM fe_sessions WHERE ses_id LIKE "'.$hashed_ses_id.STRING_DBLIMIT;
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    return $row['ses_userid'];
}

function getIso2FromIso3($config, $iso3){
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'SELECT * FROM static_countries WHERE cn_iso_3 LIKE "'.$iso3.STRING_DBLIMIT;
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    return $row['cn_iso_2'];
}

function getCountryNameFromIso2($config, $iso2){
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'SELECT * FROM static_countries WHERE cn_iso_2 LIKE "'.$iso2.STRING_DBLIMIT;
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    return $row['cn_short_en'];
}

function ConvertIP($ip){
    $segments = explode('.', $ip);
    return $segments[0] * (256*256*256) + $segments[1] * (256*256) + $segments[2] * 256 + $segments[3];
}

function getCompanyData($config, $convertedIP){
    $con = mysqli_connect($config['ipdb_dbhost'],$config['ipdb_dbuser'],$config['ipdb_dbpassword'],$config['ipdb_dbname']);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'SELECT * FROM ext_ip2location WHERE ' . $convertedIP . ' <= ip_to LIMIT 1';
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    return $row;
}

function getFeUser($config, $user_id){
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    $con->set_charset('utf8');
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'SELECT * FROM fe_users WHERE uid = "'.$user_id.STRING_DBLIMIT;
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    return $row;
}

function setCustomerIdOnFeUser($config, $fe_user_id, $customerId) {
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'UPDATE fe_users SET tx_extbase_type = "Tx_BefineFeusers_FrontendUser", bw_customer_id = "'.$customerId.STRING_DBWHERE.$fe_user_id.STRING_DBLIMIT;
    mysqli_query($con,$query);
    $row = mysqli_affected_rows($con);
    mysqli_close($con);
    return json_encode( array(KEY_RESULT => $row), true);
}

function setEndTrialOnFeUser($config, $fe_user_id) {
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'UPDATE fe_users SET is_trial = 2 WHERE uid = '.$fe_user_id.' LIMIT 1';
    mysqli_query($con,$query);
    $row = mysqli_affected_rows($con);
    mysqli_close($con);
    return json_encode( array(KEY_RESULT => $row), true);
}

function setBusinessPartnerChangeDecisionOnFeUser($config, $fe_user_id, $decision) {
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'UPDATE fe_users SET business_partner_change_accepted = "'.$decision.'" WHERE uid = '.$fe_user_id.' LIMIT 1';
    mysqli_query($con,$query);
    $row = mysqli_affected_rows($con);
    mysqli_close($con);
    return json_encode( array(KEY_RESULT => $row), true);
}


function setEndTrialOnFeUserByBwId($config, $bw_customer_id) {
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'UPDATE fe_users SET is_trial = 2 WHERE bw_customer_id = '.$bw_customer_id.' LIMIT 1';
    mysqli_query($con,$query);
    $row = mysqli_affected_rows($con);
    mysqli_close($con);
    return json_encode( array(KEY_RESULT => $row), true);
}

function setCustomerDisableOnFeUser($config, $bw_customer_id) {
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'UPDATE fe_users SET disable = 1 WHERE bw_customer_id = "'.$bw_customer_id.STRING_DBLIMIT;
    mysqli_query($con,$query);
    $row = mysqli_affected_rows($con);
    mysqli_close($con);
    return $row;
}

function setCustomerEnableOnFeUser($config, $bw_customer_id) {
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'UPDATE fe_users SET disable = 0 WHERE bw_customer_id = "'.$bw_customer_id.STRING_DBLIMIT;
    mysqli_query($con,$query);
    $row = mysqli_affected_rows($con);
    mysqli_close($con);
    return $row;
}

function replaceUserGroupOnFeUser($config, $fe_user_id, $before, $after){
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'UPDATE fe_users SET usergroup = REPLACE(usergroup, '.$before.', '.$after.') WHERE uid = "'.$fe_user_id.STRING_DBLIMIT;
    mysqli_query($con,$query);
    $row = mysqli_affected_rows($con);
    mysqli_close($con);
    return $row;
}

function setServerOnFeUser($config){
    $typo3_fe_user_id = getFeUserFromSessionId($config, $_COOKIE[KEY_FE_TYPO3_USER]);
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'UPDATE fe_users SET cs_server_host = "'.$config[KEY_CSHOSTPURE].STRING_DBWHERE.$typo3_fe_user_id.STRING_DBLIMIT;
    mysqli_query($con,$query);
    mysqli_affected_rows($con);
    mysqli_close($con);
}

function setAccessTokenOnFeUser($config, $fe_user_id, $token){
    $con = mysqli_connect($config[KEY_TYPO3_DBHOST],$config[KEY_TYPO3_DBUSER],$config[KEY_TYPO3_DBPASSWORD],$config[KEY_TYPO3_DBNAME]);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'UPDATE fe_users SET bw_access_token = "'.$token.STRING_DBWHERE.$fe_user_id.STRING_DBLIMIT;
    mysqli_query($con,$query);
    $num_rows = mysqli_affected_rows($con);
    mysqli_close($con);
    die( json_encode( array(KEY_RESULT => $num_rows), true) );
}

function getCryptshareServerHost($config, $planId){
    $typo3_fe_user_id = getFeUserFromSessionId($config, $_COOKIE[KEY_FE_TYPO3_USER]);
    $fe_user_data = getFeUser($config, $typo3_fe_user_id);
    $response = callRestAPI($config, $planId, 'get_plan', $fe_user_data['bw_access_token'], $fe_user_data['bw_customer_id'], false, false);
    return arrayCastRecursive(json_decode($response));
}

function addSingleEmailOnCryptshareServer($config, $email, $planId, $direction) {
    $serverInfo = getCryptshareServerHost($config, $planId);
    $config[KEY_CSHOSTPURE] = $serverInfo[KEY_CUSTOM_FIELDS][KEY_CS_SERVER];
    $config[KEY_CSUSER] = $config['new_cryptshare_user'][$serverInfo[KEY_CUSTOM_FIELDS][KEY_CS_SERVER]];
    $config[KEY_CSPASSWORD] = $config['new_cryptshare_password'][$serverInfo[KEY_CUSTOM_FIELDS][KEY_CS_SERVER]];
    $config[KEY_CSHOST] = $serverInfo[KEY_CUSTOM_FIELDS][KEY_CS_SERVER].STRING_POLICYURL;
    $logEntry = 'addEmailOnCryptshareServer : '.$config[KEY_CSHOST].' - ServerUser : '.$config[KEY_CSUSER].' E-Mail:'.$email;
    if (is_string($config[KEY_CSHOST]) && strlen($config[KEY_CSHOST]) <= 28){
        writeRestLog('No Server Data',$logEntry,NULL,NULL,NULL,NULL);
        die;
    } else {
        writeRestLog(NULL,$logEntry,NULL,NULL,NULL,NULL);
    }
    if($direction == 'sender') {
        $xml_post_string = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
                                    <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                                    <addPolicyRule xmlns="http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/">
                                            <policyRule xmlns="">
                                            <storageDuration>10</storageDuration>
                                            <transferLimit>10240</transferLimit>
                                            <senderMatcher>'.$email.'</senderMatcher>
                                            <recipientMatcher>.*</recipientMatcher>
                                            <networkPattern>0.0.0.0/00</networkPattern>
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
                                                    <recipientMatcher>'.$email.'</recipientMatcher>
                                                    <networkPattern>0.0.0.0/00</networkPattern>
                                                    </policyRule>
                                                    </addPolicyRule>                                                
                                            </s:Body>
                                    </s:Envelope>';
    }
    $headers = array(
        VALUE_HEADER_CONTENTTYPE_TEXT,
        VALUE_HEADER_ACCEPT_TEXT,
        CURL_CACHE_CONTROL,
        CURL_PRAGMA_NO_CACHE_VALUE,
        VALUE_HEADER_EXPECT,
        VALUE_HEADER_USER . $config[KEY_CSUSER],
        VALUE_HEADER_PASSWORD . $config[KEY_CSPASSWORD],
        VALUE_HEADER_SOAPACTION,
        VALUE_HEADER_CONTENTLENGTH.strlen($xml_post_string),
    );
    $ch = curl_init();
    $verbose = fopen(STRING_RESTLOG, 'w');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $config[KEY_CSHOST]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $config[KEY_CSUSER].":".$config[KEY_CSPASSWORD]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    $response = curl_exec($ch);
    curl_close($ch);
    $response1 = str_replace(STRING_SOAP_BODY_START,"",$response);
    $response2 = str_replace(STRING_SOAP_BODY_END,"",$response1);
    $parser = simplexml_load_string($response2);
    setServerOnFeUser($config);
    writeRestLog(NULL,'Response from CSS : '.$response,NULL,NULL,NULL,NULL);
    sleep(1);
    return $parser;
}

function addEmailOnCryptshareServer($config, $orders, $planId, $direction) {
    $orderObj = json_decode($orders);
    $parser = '';
    foreach ($orderObj as $order) {
        $logParams = [];
        $logParams[KEY_FUNCTION] = 'Classes/lib/functions->addEmailOnCryptshareServer:1282';
        $logParams[KEY_PLANID] = $planId;
        writeDevLog($config, print_r($logParams, TRUE));
        $serverInfo = getCryptshareServerHost($config, $planId);
        $config[KEY_CSHOSTPURE] = $serverInfo[KEY_CUSTOM_FIELDS][KEY_CS_SERVER];
        $config[KEY_CSUSER] = $config['new_cryptshare_user'][$config[KEY_CSHOSTPURE]];
        $config[KEY_CSPASSWORD] = $config['new_cryptshare_password'][$config[KEY_CSHOSTPURE]];
        $config[KEY_CSHOST] = $config[KEY_CSHOSTPURE].STRING_POLICYURL;
        $logEntry = 'addEmailOnCryptshareServer : '.$config[KEY_CSHOST].' - ServerUser : '.$config[KEY_CSUSER].' E-Mail:'.$order->cs_email;
        if (is_string($config[KEY_CSHOST]) && strlen($config[KEY_CSHOST]) <= 28){
            writeRestLog('No Server Data',$logEntry,NULL,NULL,NULL,NULL);
            die;
        }else{
            writeRestLog(NULL,$logEntry,NULL,NULL,NULL,NULL);
        }
        if($direction == 'sender') {
            $xml_post_string = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
                                    <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                                    <addPolicyRule xmlns="http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/">
                                            <policyRule xmlns="">
                                            <storageDuration>10</storageDuration>
                                            <transferLimit>10240</transferLimit>
                                            <senderMatcher>'.$order->cs_email.'</senderMatcher>
                                            <recipientMatcher>.*</recipientMatcher>
                                            <networkPattern>0.0.0.0/00</networkPattern>
                                            </policyRule>
                                            </addPolicyRule>                                                
                                    </s:Body>
                            </s:Envelope>';
        }else{
            $xml_post_string = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
                                            <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                                            <addPolicyRule xmlns="http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/">
                                                    <policyRule xmlns="">
                                                    <storageDuration>10</storageDuration>
                                                    <transferLimit>10240</transferLimit>
                                                    <senderMatcher>.*</senderMatcher>
                                                    <recipientMatcher>'.$order->cs_email.'</recipientMatcher>
                                                    <networkPattern>0.0.0.0/00</networkPattern>
                                                    </policyRule>
                                                    </addPolicyRule>                                                
                                            </s:Body>
                                    </s:Envelope>';
        }
        $headers = array(
            VALUE_HEADER_CONTENTTYPE_TEXT,
            VALUE_HEADER_ACCEPT_TEXT,
            CURL_CACHE_CONTROL,
            CURL_PRAGMA_NO_CACHE_VALUE,
            VALUE_HEADER_EXPECT,
            VALUE_HEADER_USER . $config[KEY_CSUSER],
            VALUE_HEADER_PASSWORD . $config[KEY_CSPASSWORD],
            VALUE_HEADER_SOAPACTION,
            VALUE_HEADER_CONTENTLENGTH.strlen($xml_post_string),
        );
        $ch = curl_init();
        $verbose = fopen(STRING_RESTLOG, 'w');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $config[KEY_CSHOST]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $config[KEY_CSUSER].":".$config[KEY_CSPASSWORD]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_STDERR, $verbose);
        $response = curl_exec($ch);
        curl_close($ch);
        $response1 = str_replace(STRING_SOAP_BODY_START,"",$response);
        $response2 = str_replace(STRING_SOAP_BODY_END,"",$response1);
        $parser = simplexml_load_string($response2);
        setServerOnFeUser($config);
        writeRestLog(NULL,'Response from CSS : '.$response,NULL,NULL,NULL,NULL);
        sleep(1);
    }
    return $parser;
}

function removeEmailOnCryptshareServer($config, $contract) {
    $config[KEY_CSHOST] = $contract[KEY_CUSTOM_FIELDS][KEY_CS_SERVER].STRING_POLICYURL;
    $xml_post_string = '<?xml version="1.0" encoding="UTF-8"?>
    <S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/">
        <S:Body>
            <ns2:removeEMailRuleSet xmlns:ns2="http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/">
                <email>'.$contract[KEY_CUSTOM_FIELDS]['CSEmailUser'].'</email>
            </ns2:removeEMailRuleSet>
        </S:Body>
    </S:Envelope>';
    $headers = array(
        VALUE_HEADER_CONTENTTYPE_TEXT,
        VALUE_HEADER_ACCEPT_TEXT,
        CURL_CACHE_CONTROL,
        CURL_PRAGMA_NO_CACHE_VALUE,
        VALUE_HEADER_EXPECT,
        VALUE_HEADER_USER . $config[KEY_CSUSER],
        VALUE_HEADER_PASSWORD . $config[KEY_CSPASSWORD],
        "SOAPAction: http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/CryptshareServer/removePolicyRuleRequest",
        VALUE_HEADER_CONTENTLENGTH.strlen($xml_post_string),
    );
    $ch = curl_init();
    $verbose = fopen(STRING_RESTLOG, 'w');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $config[KEY_CSHOST]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $config[KEY_CSUSER].":".$config[KEY_CSPASSWORD]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    $response = curl_exec($ch);
    curl_close($ch);
    $response1 = str_replace(STRING_SOAP_BODY_START,"",$response);
    $response2 = str_replace(STRING_SOAP_BODY_END,"",$response1);
    $parser = simplexml_load_string($response2);
    sendMail('CSX Webhook - Removed ' . $contract[KEY_CUSTOM_FIELDS]['CSEmailUser'] . ' from ' . $contract[KEY_CUSTOM_FIELDS][KEY_CS_SERVER],'','marcel.filipp@cryptshare.com');
    return $parser;
}

function removeEmailOnCryptshareServerForWebhook($config, $contract, $email) {
    $config[KEY_CSHOST] = $contract[KEY_CUSTOM_FIELDS][KEY_CS_SERVER].STRING_POLICYURL;
    $xml_post_string = '<?xml version="1.0" encoding="UTF-8"?>
    <S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/">
        <S:Body>
            <ns2:removeEMailRuleSet xmlns:ns2="http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/">
                <email>'.$email.'</email>
            </ns2:removeEMailRuleSet>
        </S:Body>
    </S:Envelope>';
    $headers = array(
        VALUE_HEADER_CONTENTTYPE_TEXT,
        VALUE_HEADER_ACCEPT_TEXT,
        CURL_CACHE_CONTROL,
        CURL_PRAGMA_NO_CACHE_VALUE,
        VALUE_HEADER_EXPECT,
        VALUE_HEADER_USER . $config[KEY_CSUSER],
        VALUE_HEADER_PASSWORD . $config[KEY_CSPASSWORD],
        "SOAPAction: http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/CryptshareServer/removePolicyRuleRequest",
        VALUE_HEADER_CONTENTLENGTH.strlen($xml_post_string),
    );
    $ch = curl_init();
    $verbose = fopen(STRING_RESTLOG, 'w');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $config[KEY_CSHOST]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $config[KEY_CSUSER].":".$config[KEY_CSPASSWORD]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    $response = curl_exec($ch);
    curl_close($ch);
    $response1 = str_replace(STRING_SOAP_BODY_START,"",$response);
    $response2 = str_replace(STRING_SOAP_BODY_END,"",$response1);
    $parser = simplexml_load_string($response2);
    sendMail('CSX Webhook - Removed ' . $contract[KEY_CUSTOM_FIELDS]['CSEmailUser'] . ' from ' . $contract[KEY_CUSTOM_FIELDS][KEY_CS_SERVER],'','marcel.filipp@cryptshare.com');
    return $parser;
}

function removeEmailOnCryptshareServerLocal($config, $input) {
    $config[KEY_CSHOST] = $config['cryptshare_host_pure'].STRING_POLICYURL;
    if (is_string($config[KEY_CSHOST]) && strlen($config[KEY_CSHOST]) <= 28){
        die;
    }
    $xml_post_string = '<?xml version="1.0" encoding="UTF-8"?>
    <S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/">
        <S:Body>
            <ns2:removeEMailRuleSet xmlns:ns2="http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/">
                <email>'.$input['email'].'</email>
            </ns2:removeEMailRuleSet>
        </S:Body>
    </S:Envelope>';
    $headers = array(
        VALUE_HEADER_CONTENTTYPE_TEXT,
        VALUE_HEADER_ACCEPT_TEXT,
        CURL_CACHE_CONTROL,
        CURL_PRAGMA_NO_CACHE_VALUE,
        VALUE_HEADER_EXPECT,
        VALUE_HEADER_USER . $config[KEY_CSUSER],
        VALUE_HEADER_PASSWORD . $config[KEY_CSPASSWORD],
        "SOAPAction: http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/CryptshareServer/removePolicyRuleRequest",
        VALUE_HEADER_CONTENTLENGTH.strlen($xml_post_string),
    );
    $ch = curl_init();
    $verbose = fopen(STRING_RESTLOG, 'w');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $config[KEY_CSHOST]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $config[KEY_CSUSER].":".$config[KEY_CSPASSWORD]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    $response = curl_exec($ch);
    curl_close($ch);
    $response1 = str_replace(STRING_SOAP_BODY_START,"",$response);
    $response2 = str_replace(STRING_SOAP_BODY_END,"",$response1);
    return simplexml_load_string($response2);
}

function sendWelcomeMailToCSEmailUser($config, $input) {
    die(true);
    $xml_post_string = '
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
    <s:Body xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
        <addPolicyRule xmlns="http://v1.cs3service.webservice.server.cryptshare.befinesolutions.com/">
            <policyRule xmlns="">
                <storageDuration>30</storageDuration>
                <transferLimit>2048</transferLimit>
                <senderMatcher>'.$input['cs_email'].'</senderMatcher>
                <recipientMatcher>.*</recipientMatcher>
                <networkPattern>0.0.0.0/00</networkPattern>
            </policyRule>
        </addPolicyRule>                                                
    </s:Body>
</s:Envelope>';
    $headers = array(
        VALUE_HEADER_CONTENTTYPE_TEXT,
        VALUE_HEADER_ACCEPT_TEXT,
        CURL_CACHE_CONTROL,
        PRAGMA_NO_CACHE_VALUE,
        VALUE_HEADER_EXPECT,
        VALUE_HEADER_USER . $config[KEY_CSUSER],
        VALUE_HEADER_PASSWORD . $config[KEY_CSPASSWORD],
        VALUE_HEADER_SOAPACTION,
        VALUE_HEADER_CONTENTLENGTH.strlen($xml_post_string),
    );
    $ch = curl_init();
    $verbose = fopen('restlog_cryptshareapi.txt', 'w');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $config[KEY_CSHOST]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $config[KEY_CSUSER].":".$config[KEY_CSPASSWORD]);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    $response = curl_exec($ch);
    curl_close($ch);
    $response1 = str_replace(STRING_SOAP_BODY_START,"",$response);
    $response2 = str_replace(STRING_SOAP_BODY_END,"",$response1);
    return simplexml_load_string($response2);
}

/*function submitFormOnHubspot($config,$input,$requestType,$referrer) {
    $hscountry = getCountryNameFromIso2($config, strtoupper($input[KEY_ADDRESS]['country']));
    $hubspotutk      = $_COOKIE['hubspotutk'];
    $ip_addr         = $_SERVER['REMOTE_ADDR'];
    $hs_context      = array(
        'hutk' => $hubspotutk,
        'ipAddress' => $ip_addr,
        'pageUri' => $referrer
    );
    json_encode($hs_context);
    $submitted_form_fields[] = array( 'name' => 'company', KEY_VALUE => $input['CompanyName']);
    $submitted_form_fields[] = array( 'name' => 'firstname', KEY_VALUE => ucfirst($input['FirstName']));
    $submitted_form_fields[] = array( 'name' => 'lastname', KEY_VALUE => ucfirst($input['LastName']));
    $submitted_form_fields[] = array( 'name' => 'email', KEY_VALUE => strtolower($input['EmailAddress']));
    $submitted_form_fields[] = array( 'name' => KEY_ADDRESS, KEY_VALUE => $input[KEY_ADDRESS]['Street'] . ' ' . $input[KEY_ADDRESS]['HouseNumber']);
    $submitted_form_fields[] = array( 'name' => 'zip', KEY_VALUE => $input[KEY_ADDRESS]['PostalCode']);
    $submitted_form_fields[] = array( 'name' => 'city', KEY_VALUE => $input[KEY_ADDRESS]['City']);
    $submitted_form_fields[] = array( 'name' => 'country', KEY_VALUE => $hscountry);
    $submitted_form_fields[] = array( 'name' => 'phone', KEY_VALUE => $input['PhoneNumber']);

    $data = array(
        'submittedAt' => round(microtime(true) * 1000),
        'fields' => $submitted_form_fields,
        'context' => $hs_context,
        'legalConsentOptions' => $legal_consent_options
    );
    $endpoint = 'https://api.hsforms.com/submissions/v3/integration/submit/'.$config['HSAccount'].'/'.$hs_forms[$requestType][$input['Locale']];
    $ch = @curl_init();
    @curl_setopt($ch, CURLOPT_POST, true);
    @curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    @curl_setopt($ch, CURLOPT_URL, $endpoint);
    @curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    @curl_exec($ch);
    $http_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
    @curl_close($ch);
    switch($http_code){
        case '200':
        case '204':
        case '302':
            $output = array(KEY_RESULT => 'Success');
            break;
        case '404':
        default:
            $output = array(KEY_RESULT => 'Error: ' . $http_code);
            break;
    }
    return $output;
}*/

/**
 * @function getRestApiBearer
 * @description gets Bearertoken via Billwerk REST API
 * @return array Bearertoken for Authentication
 */
function getRestApiBearer($config){
    global $config;
    $data = http_build_query(array(
        'grant_type' => 'client_credentials'
    ));
    $curl = curl_init();
    $client_id = $config['client_id'] ;
    $client_secret = $config['client_secret'] ;
    curl_setopt_array($curl, array(
            CURLOPT_URL => HTTPS.$config[CURL_ENVIRONMENT_KEY].'.billwerk.com/oauth/token',
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => "$client_id:$client_secret",
            CURLOPT_HTTPHEADER => array("Content-type: application/x-www-form-urlencoded"),
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_VERBOSE => false
        )
    );
    $response = curl_exec($curl);
    return arrayCastRecursive(json_decode($response));
}

function webhookNoToken($token) {
    if($token != '5f58d21e3af14d0df470ba845f58cda63af14d0df470ae1a5f58cc5e3af14d0df470aad6') {
        header('HTTP/1.0 401');
        die('permission denied');
    }
}

function setKpi($dbHost, $dbUser, $dbPwd, $dbName, $contractId, $lifecycleStatus) {
    $con = mysqli_connect($dbHost,$dbUser,$dbPwd,$dbName);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    }
    $query = 'INSERT INTO csx_kpis (crdate, contract_id, lifecycle_status) VALUES ('.time().', $contractId, $lifecycleStatus);';
    mysqli_query($con,$query);
    mysqli_affected_rows($con);
    mysqli_close($con);
}

function setWebhookLog($dbHost, $dbUser, $dbPwd, $dbName, $contractId, $customerId, $entityId, $orderId, $lifecycleStatus, $event, $webhookParameter, $sandbox, $startDate, $lastDate, $nextDate, $currentPhaseType = '') {
    $con = mysqli_connect($dbHost,$dbUser,$dbPwd,$dbName);
    if (mysqli_connect_errno())  {
        echo MSG_MYSQL_CONNECTION_FAILED . mysqli_connect_error();
    } else {
        $query = 'INSERT INTO csx_webhook_log (crdate, contract_id, customer_id, order_id, entity_id, lifecycle_status, contract_phase, start_date, last_date, next_date, environment, event, webhook_input, sandbox) VALUES ('.time().', "'.$contractId.'", "'.$customerId.'", "'.$entityId.'", "'.$orderId.'", "'.$lifecycleStatus.'", "'.$currentPhaseType.'", '.$startDate.', '.$lastDate.', '.$nextDate.', "'.$_SERVER['TYPO3_CONTEXT'].'", "'.$event.'", "'.$webhookParameter.'", "'.$sandbox.'");';
        if(mysqli_query($con, $query)) {
            $num_rows = mysqli_affected_rows($con);
        }
    }
    mysqli_close($con);
}

function setDieError($msg, $file = '', $line = 0) {
    if(!$typo3_fe_user_id) {
        $uid = $fe_user_data['uid'];
    } else {
        $uid = $typo3_fe_user_id;
    }
    $errorString = '['.$uid.']['.$file.']['.$line.']: '.$msg;
    //sendMail('CSX DIE - Error ', $errorString,'lutz.eckelmann@cryptshare.com');
    sendMail('CSX DIE - Error ', $errorString,'cs-express@equinoxe.com');
    die( json_encode( ['Message' => $msg], true) );
}
