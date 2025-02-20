<?php

$input['action'] = true;
require_once('lib/config.php');
require_once('lib/functions.php');
$config['current_hostname'] = getCurrentHostname();

header('Location: '.$config['current_hostname'].'de/users/order/?trigger=PaymentError');
exit;
