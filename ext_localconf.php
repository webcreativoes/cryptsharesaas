<?php
//const KEY_TYPO3_CONF_VARS = 'TYPO3_CONF_VARS';

defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:cryptsharesaas/Configuration/TSconfig/Page.typoscript">');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:cryptsharesaas/Configuration/TSconfig/User.typoscript">');

$applicationContext = \TYPO3\CMS\Core\Core\Environment::getContext();
if($applicationContext == 'Development' || $applicationContext == 'Development/Local') {
    $GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['deprecations']['writerConfiguration'][\TYPO3\CMS\Core\Log\LogLevel::NOTICE] = [];
}
