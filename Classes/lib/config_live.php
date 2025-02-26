<?php
declare(strict_types=1);

/**
 * Live environment configuration values.
 */

$config = [
    // KPI Database Configuration
    'db_kpi_host' => 'localhost',
    'db_kpi_user' => 'db13251579-bwsta',
    'db_kpi_pwd'  => 'om5PGOdK',
    'db_kpi_name' => 'db13251579-bwsta',

    // Logging & Environment
    LOGPATH    => LOGPATH_LIVE_VALUE,
    ENVIRONMENT => APP,

    // Billwerk API Credentials
    CLIENT_ID     => BW_CLIENT_ID_LIVE_VALUE,
    CLIENT_SECRET => BW_CLIENT_SECRET_LIVE_VALUE,
    PLAN_ID       => BW_PLAN_ID_LIVE_VALUE,

    // Email Configuration
    FORCE_CC_RECIPIENT_ADDRESS   => FORCE_CC_RECIPIENT_ADDRESS_LIVE_VALUE,
    FORCE_CC_RECIPIENT_ADDRESS_2 => CS_CC_RECIPIENT_ADDRESS_2_LIVE_VALUE,
    FORCE_CC_RECIPIENT_ADDRESS_3 => CS_CC_RECIPIENT_ADDRESS_3_LIVE_VALUE,
    MAIL_TO                      => MAIL_FORM_LIVE_VALUE,
    DELETE_CVS                   => DELETE_CVS_LIVE_VALUE,

    // SMTP Configuration
    SMTP_DEBUG    => SMTP_DEBUG_LIVE_VALUE,
    DEV_IP        => DEV_IP_LIVE_VALUE,
    SMTP_PORT     => SMTP_PORT_LIVE_VALUE,
    SMTP_HOST     => SMTP_HOST_LIVE_VALUE,
    SMTP_USERNAME => SMTP_USERNAME_LIVE_VALUE,
    SMTP_PASSWD   => SMTP_PASSWD_LIVE_VALUE,
    MAIL_FORM     => MAIL_FORM_LIVE_VALUE,
    SMTP_SECURE   => SMTP_SECURE_LIVE_VALUE,

    // Cryptshare Configuration
    CRYPTSHARE_HOST      => CS_CRYPTSHARE_HOST_WEBAPP_LIVE_VALUE,
    CRYPTSHARE_HOST_PURE => CS_CRYPTSHARE_HOST_PURE_WEBAPP_LIVE_VALUE,
    CRYPTSHARE_USER      => CS_USER_LIVE_VALUE,
    CRYPTSHARE_PASSWD    => CS_PASSWD_LIVE_VALUE,

    // Cryptshare Credentials Mapping
    NEW_CRYPTSHARE_PASSWD => [
        CS_SERVER_NL_LIVE_VALUE   => CS_PASSWD_LIVE_VALUE,
        CS_SERVER_WEBAPP_LIVE_VALUE => CS_PASSWD_LIVE_VALUE
    ],
    NEW_CRYPTSHARE_USER => [
        CS_SERVER_NL_LIVE_VALUE   => CS_USER_LIVE_VALUE,
        CS_SERVER_WEBAPP_LIVE_VALUE => CS_USER_LIVE_VALUE
    ],

    // TYPO3 Database Configuration
    TYPO3_DB_HOST     => DB_HOST_LIVE_VALUE,
    TYPO3_DB_NAME     => TYPO3_DB_NAME_LIVE_VALUE,
    TYPO3_DB_USER     => TYPO3_DB_USER_LIVE_VALUE,
    TYPO3_DB_PASSWD   => TYPO3_DB_PASSWD_LIVE_VALUE,
    TYPO3_ENCRYPTIONKEY => TYPO3_ENCRYPTIONKEY_LIVE_VALUE,

    // IPDB Database Configuration
    IPDB_DB_HOST   => DB_HOST_LIVE_VALUE,
    IPDB_DB_NAME   => IPDB_DB_NAME_LIVE_VALUE,
    IPDB_DB_USER   => IPDB_DB_USER_LIVE_VALUE,
    IPDB_DB_PASSWD => IPDB_DB_PASSWD_LIVE_VALUE,
];
