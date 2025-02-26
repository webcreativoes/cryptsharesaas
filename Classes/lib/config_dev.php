<?php
declare(strict_types=1);

/**
 * Development environment configuration values.
 */

// KPI Database Configuration
$config = [
    'db_kpi_host' => 'localhost',
    'db_kpi_user' => 'db13303627-bwsta',
    'db_kpi_pwd'  => 'ug7A9QpRoopd_VX',
    'db_kpi_name' => 'db13303627-bwsta',

    // Logging & Environment
    LOGPATH    => LOGPATH_DEV_VALUE,
    ENVIRONMENT => SANDBOX,

    // Billwerk API Credentials
    CLIENT_ID     => BW_CLIENT_ID_DEV_VALUE,
    CLIENT_SECRET => BW_CLIENT_SECRET_DEV_VALUE,
    PLAN_ID       => BW_PLAN_ID_DEV_VALUE,

    // Cryptshare Configuration
    CRYPTSHARE_HOST      => CS_CRYPTSHARE_HOST_BETA_DEV_VALUE,
    CRYPTSHARE_HOST_PURE => CS_CRYPTSHARE_HOST_PURE_BETA_LOCAL_VALUE,
    CRYPTSHARE_USER      => CS_USER_DEV_VALUE,
    CRYPTSHARE_PASSWD    => CS_PASSWD_DEV_VALUE,

    // Email Configuration
    FORCE_CC_RECIPIENT_ADDRESS   => CS_CC_RECIPIENT_ADDRESS_DEV_VALUE,
    FORCE_CC_RECIPIENT_ADDRESS_2 => CS_CC_RECIPIENT_ADDRESS_2_DEV_VALUE,
    FORCE_CC_RECIPIENT_ADDRESS_3 => CS_CC_RECIPIENT_ADDRESS_3_DEV_VALUE,
    MAIL_TO                      => MAIL_TO_DEV_VALUE,
    DELETE_CVS                   => DELETE_CVS_DEV_VALUE,

    // SMTP Configuration
    SMTP_DEBUG    => SMTP_DEBUG_DEV_VALUE,
    DEV_IP        => DEV_IP_DEV_VALUE,
    SMTP_PORT     => SMTP_PORT_DEV_VALUE,
    SMTP_HOST     => SMTP_HOST_DEV_VALUE,
    SMTP_USERNAME => SMTP_USERNAME_DEV_VALUE,
    SMTP_PASSWD   => SMTP_PASSWD_DEV_VALUE,
    MAIL_FORM     => MAIL_FORM_DEV_VALUE,
    SMTP_SECURE   => SMTP_SECURE_DEV_VALUE,

    // Cryptshare Credentials Mapping
    NEW_CRYPTSHARE_PASSWD => [
        CS_SERVER_NL_DEV_VALUE   => CS_PASSWD_DEV_VALUE,
        CS_SERVER_BETA_DEV_VALUE => CS_PASSWD_DEV_VALUE
    ],
    NEW_CRYPTSHARE_USER => [
        CS_SERVER_NL_DEV_VALUE   => CS_USER_DEV_VALUE,
        CS_SERVER_BETA_DEV_VALUE => CS_USER_DEV_VALUE
    ],

    // TYPO3 Database Configuration
    TYPO3_DB_HOST     => DB_HOST_DEV_VALUE,
    TYPO3_DB_NAME     => TYPO3_DB_NAME_DEV_VALUE,
    TYPO3_DB_USER     => TYPO3_DB_USER_DEV_VALUE,
    TYPO3_DB_PASSWD   => TYPO3_DB_PASSWD_DEV_VALUE,
    TYPO3_ENCRYPTIONKEY => TYPO3_ENCRYPTIONKEY_DEV_VALUE,

    // IPDB Database Configuration
    IPDB_DB_HOST   => DB_HOST_DEV_VALUE,
    IPDB_DB_NAME   => IPDB_DB_NAME_DEV_VALUE,
    IPDB_DB_USER   => IPDB_DB_USER_DEV_VALUE,
    IPDB_DB_PASSWD => IPDB_DB_PASSWD_DEV_VALUE,
];
