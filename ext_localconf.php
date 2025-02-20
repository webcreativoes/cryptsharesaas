<?php
defined('TYPO3') or die();

// Logging für Deprecations aktivieren
$GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['deprecations']['writerConfiguration'][\TYPO3\CMS\Core\Log\LogLevel::NOTICE] = [
    \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
        'logFile' => \TYPO3\CMS\Core\Core\Environment::getVarPath() . '/log/deprecations.log'
    ]
];

// PageTSConfig muss in `Configuration/page.tsconfig` verschoben werden
