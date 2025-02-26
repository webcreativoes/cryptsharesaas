<?php
declare(strict_types=1);

/**
 * Local environment configuration values.
 */

// KPI Database Configuration
$config = [
    'db_kpi_host' => 'localhost',
    'db_kpi_user' => 'db13251579-bwsta',
    'db_kpi_pwd'  => 'ug7A9QpRoopd_VX',
    'db_kpi_name' => 'db13251579-bwsta',

    // Logging & Environment
    LOGPATH    => LOGPATH_LOCAL_VALUE,
    ENVIRONMENT => SANDBOX,

    // Billwerk API Credentials
    CLIENT_ID     => BW_CLIENT_ID_LOCAL_VALUE,
    CLIENT_SECRET => BW_CLIENT_SECRET_LOCAL_VALUE,
    PLAN_ID       => BW_PLAN_ID_LOCAL_VALUE,

    // Cryptshare Configuration
    CRYPTSHARE_HOST      => CS_CRYPTSHARE_HOST_BETA_LOCAL_VALUE,
    CRYPTSHARE_HOST_PURE => CS_CRYPTSHARE_HOST_PURE_BETA_LOCAL_VALUE,
    CRYPTSHARE_USER      => CS_USER_LOCAL_VALUE,
    CRYPTSHARE_PASSWD    => CS_PASSWD_LOCAL_VALUE,

    // Email Configuration
    FORCE_CC_RECIPIENT_ADDRESS   => CS_CC_RECIPIENT_ADDRESS_LOCAL_VALUE,
    FORCE_CC_RECIPIENT_ADDRESS_2 => CS_CC_RECIPIENT_ADDRESS_2_LOCAL_VALUE,
    FORCE_CC_RECIPIENT_ADDRESS_3 => CS_CC_RECIPIENT_ADDRESS_3_LOCAL_VALUE,
    MAIL_TO                      => MAIL_TO_LOCAL_VALUE,
    DELETE_CVS                   => DELETE_CVS_LOCAL_VALUE,

    // SMTP Configuration
    SMTP_DEBUG    => SMTP_DEBUG_LOCAL_VALUE,
    DEV_IP        => DEV_IP_LOCAL_VALUE,
    SMTP_PORT     => SMTP_PORT_LOCAL_VALUE,
    SMTP_HOST     => SMTP_HOST_LOCAL_VALUE,
    SMTP_USERNAME => SMTP_USERNAME_LOCAL_VALUE,
    SMTP_PASSWD   => SMTP_PASSWD_LOCAL_VALUE,
    MAIL_FORM     => MAIL_TO_LOCAL_VALUE,
    SMTP_SECURE   => '',

    // Cryptshare Credentials Mapping
    NEW_CRYPTSHARE_PASSWD => [
        CS_SERVER_NL_LOCAL_VALUE   => CS_PASSWD_LOCAL_VALUE,
        CS_SERVER_BETA_LOCAL_VALUE => CS_PASSWD_LOCAL_VALUE
    ],
    NEW_CRYPTSHARE_USER => [
        CS_SERVER_NL_LOCAL_VALUE   => CS_USER_LOCAL_VALUE,
        CS_SERVER_BETA_LOCAL_VALUE => CS_USER_LOCAL_VALUE
    ],

    // TYPO3 Database Configuration
    TYPO3_DB_HOST     => TYPO3_DB_HOST_LOCAL_VALUE,
    TYPO3_DB_NAME     => TYPO3_DB_NAME_LOCAL_VALUE,
    TYPO3_DB_USER     => TYPO3_DB_USER_LOCAL_VALUE,
    TYPO3_DB_PASSWD   => TYPO3_DB_PASSWD_LOCAL_VALUE,
    TYPO3_ENCRYPTIONKEY => TYPO3_ENCRYPTIONKEY_LOCAL_VALUE,

    // IPDB Database Configuration
    IPDB_DB_HOST   => TYPO3_DB_HOST_LOCAL_VALUE,
    IPDB_DB_NAME   => IPDB_DB_NAME_LOCAL_VALUE,
    IPDB_DB_USER   => TYPO3_DB_USER_LOCAL_VALUE,
    IPDB_DB_PASSWD => TYPO3_DB_PASSWD_LOCAL_VALUE,
];
