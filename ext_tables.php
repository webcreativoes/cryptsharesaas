<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Core\Utility\GLOBALS['TYPO3_CONF_VARS']['SYS']['TypoScript']['cryptsharesaas'] = 'cryptsharesaas', 'Configuration/TypoScript', 'Cryptshare SaaS Template');

    }
);
