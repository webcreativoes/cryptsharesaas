<?php
declare(strict_types=1);

const KEY_CUSTOMER_ID = 'CustomerId';
const KEY_CONTRACT_ID = 'ContractId';
const TOKEN_SECRET = '5f58d21e3af14d0df470ba845f58cda63af14d0df470ae1a5f58cc5e3af14d0df470aad6';

// Prüfe, ob `token` gesetzt ist, um `Undefined index`-Fehler zu vermeiden
if (!isset($_GET['token']) || $_GET['token'] !== TOKEN_SECRET) {
    header('HTTP/1.0 401 Unauthorized');
    exit('Permission denied');
}

// Setze das richtige TYPO3-Umgebungs-Setting basierend auf dem Servernamen
if ($_SERVER['SERVER_NAME'] === 'api.cryptshare.express') {
    $_SERVER['TYPO3_CONTEXT'] = 'Production';
    $rootPath = '/is/htdocs/wp13251579_RIVEMTPQCA/';
} else {
    $_SERVER['TYPO3_CONTEXT'] = 'Development';
    $rootPath = '/is/htdocs/wp13303627_IADXHPXADX/';
}

// Logging starten
$logFile = $rootPath . 'www/logging/curl/webhook-ContractChanged.log';
file_put_contents($logFile, 'start' . PHP_EOL, FILE_APPEND);

// Konfigurationsdateien einbinden
require_once $rootPath . 'www/cryptshare.express_10-live/packages/cryptsharesaas/Classes/lib/config.php';
require_once $rootPath . 'www/cryptshare.express_10-live/packages/cryptsharesaas/Classes/lib/functions.php';

// HTTP-Antwort setzen
header("HTTP/1.0 200 OK");

// JSON-Input einlesen und Fehlerbehandlung durchführen
$rawInput = file_get_contents("php://input") ?: '';
$input = json_decode($rawInput, true);

if (json_last_error() === JSON_ERROR_NONE) {
    $input[KEY_CUSTOMER_ID] = 'webhook';
} else {
    file_put_contents($logFile, 'Fehler beim JSON-Decoding: ' . json_last_error_msg() . PHP_EOL, FILE_APPEND);
}
