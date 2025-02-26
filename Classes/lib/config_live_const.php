<?php
declare(strict_types=1);

/**
 * Live environment configuration values.
 */

// Billwerk API Credentials
const BW_CLIENT_ID_LIVE_VALUE = '5dfccbf14802012700bf47de';
const BW_CLIENT_SECRET_LIVE_VALUE = 'bc8fb9f670b4ba968e01a271631d9c4a';
const BW_PLAN_ID_LIVE_VALUE = '5bbf3551e369ee0ddcb47dc8';

// Cryptshare Server
const CS_CRYPTSHARE_HOST_BETA_LIVE_VALUE = CS_BETA_SERVER . 'service/ai?wsdl';
const CS_CRYPTSHARE_HOST_WEBAPP_LIVE_VALUE = 'https://webapp.cryptshare.express/service/ai?wsdl';
const CS_CRYPTSHARE_HOST_PURE_WEBAPP_LIVE_VALUE = 'https://webapp.cryptshare.express/';
const CS_SERVER_NL_LIVE_VALUE = 'https://nl.cryptshare.express/';
const CS_SERVER_BETA_LIVE_VALUE = CS_BETA_SERVER;
const CS_SERVER_WEBAPP_LIVE_VALUE = 'https://webapp.cryptshare.express/';

// Cryptshare Credentials
const CS_USER_LIVE_VALUE = 'wsdl.api';
const CS_PASSWD_LIVE_VALUE = 'VKM02_NAp01-Urt5oublbF';
const CS_CC_RECIPIENT_ADDRESS_LIVE_VALUE = 'cs-express@equinoxe.com';
const CS_CC_RECIPIENT_ADDRESS_2_LIVE_VALUE = '';
const CS_CC_RECIPIENT_ADDRESS_3_LIVE_VALUE = '';

// Mail Configuration
const MAIL_TO_LIVE_VALUE = 'info@dev.cryptshare.express';
const MAIL_FORM_LIVE_VALUE = 'support@cryptshare.express';
const SMTP_PORT_LIVE_VALUE = '25';
const SMTP_HOST_LIVE_VALUE = 'darkgate.equinoxe.de';
const SMTP_USERNAME_LIVE_VALUE = 'support@cryptshare.express';
const SMTP_PASSWD_LIVE_VALUE = 'UPknP-W9q4_RiwKFE47AT';
const SMTP_SECURE_LIVE_VALUE = 'tls';
const SMTP_DEBUG_LIVE_VALUE = 0;

// Database Configuration
const TYPO3_DB_NAME_LIVE_VALUE = 'db13251579-t311l';
const TYPO3_DB_USER_LIVE_VALUE = 'db13251579-t311l';
const TYPO3_DB_PASSWD_LIVE_VALUE = 'P4j_3JNT2-HX49oi';
const IPDB_DB_NAME_LIVE_VALUE = 'db13251579-ipdb';
const IPDB_DB_USER_LIVE_VALUE = 'db13251579-ipdb';
const IPDB_DB_PASSWD_LIVE_VALUE = '_N3w+1pdb7';
const TYPO3_ENCRYPTIONKEY_LIVE_VALUE = '72430f0c162ec54c59386e886d69789883f05e161f6cde727b69d373c040f624c1a0ba3779c3429e3fbfc602d42510b9';
const DB_HOST_LIVE_VALUE = 'localhost';

// Logging & Maintenance
const LOGPATH_LIVE_VALUE = '/srv/www/virtual/cs-x-www.equinoxe.de/www/logging/dev/';
const DELETE_CVS_LIVE_VALUE = false;

// Live Settings
const DEV_IP_LIVE_VALUE = '87.190.45.234';
const FORCE_CC_RECIPIENT_ADDRESS_LIVE_VALUE = '';
