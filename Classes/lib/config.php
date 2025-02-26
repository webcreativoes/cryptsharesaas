<?php
declare(strict_types=1);

/**
 * Main configuration loader.
 * This file dynamically loads all required configuration files.
 */

$config = [];

// Lade Konfigurationsdateien basierend auf dem aktuellen TYPO3_CONTEXT
$context = $_SERVER['TYPO3_CONTEXT'] ?? 'Live';

// Basis-Konfigurationsdateien laden
require_once __DIR__ . '/config_constants.php';
require_once __DIR__ . '/config_helpers.php';

// Kontextbezogene Konfigurationen laden
switch ($context) {
    case 'Development/Local':
        require_once __DIR__ . '/config_local.php';
        break;
    case 'Development':
    case 'Development/V10':
        require_once __DIR__ . '/config_dev.php';
        break;
    default:
        require_once __DIR__ . '/config_live.php';
        break;
}

// Die Konfigurationswerte aus den geladenen Dateien zusammenführen
if (isset($config)) {
    $config = array_merge($config);
}
