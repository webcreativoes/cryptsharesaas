<?php
declare(strict_types=1);

/**
 * Defines Configuration-Array depending on application-context.
 * Further configs can be found in:
 * - ../Configuration/LocalConfiguration.php
 * - ../Configuration/AdditionalConfiguration.php
 *
 * NEXT STEPS: Consolidate configuration in other files.
 *
 */

/**
 * You can control policies via Cryptshare Administrator Interface on:
 * https://cryptshare-test4.equinoxe.de:8080/ai/Login?1
 * Just log in, click on "System Settings" -> "Policy Settings" and search for the email address.
 */

// Configuration Keys
const TYPO3_CONTEXT = 'TYPO3_CONTEXT';
const ENVIRONMENT = 'environment';
const CLIENT_ID = 'client_id';
const CLIENT_SECRET = 'client_secret';
const PLAN_ID = 'plan_id';
const CRYPTSHARE_HOST = 'cryptshare_host';
const CRYPTSHARE_HOST_PURE = 'cryptshare_host_pure';
const CRYPTSHARE_USER = 'cryptshare_user';
const CRYPTSHARE_PASSWD = 'cryptshare_password';
const FORCE_CC_RECIPIENT_ADDRESS = 'forceCCRecipientAddress';
const FORCE_CC_RECIPIENT_ADDRESS_2 = 'forceCCRecipientAddress2';
const FORCE_CC_RECIPIENT_ADDRESS_3 = 'forceCCRecipientAddress3';
const MAIL_TO = 'MAILTo';
const DELETE_CVS = 'deleteCSVs';
const SMTP_DEBUG = 'SMTPDebug';
const DEV_IP = 'DevIP';
const SMTP_PORT = 'SMTPPort';
const SMTP_HOST = 'SMTPHost';
const SMTP_USERNAME = 'SMTPUsername';
const SMTP_PASSWD = 'SMTPPassword';
const MAIL_FORM = 'MAILFrom';
const SMTP_SECURE = 'SMTPSecure';
const NEW_CRYPTSHARE_PASSWD = 'new_cryptshare_password';
const NEW_CRYPTSHARE_USER = 'new_cryptshare_user';
const TYPO3_DB_HOST = 'typo3_dbhost';
const TYPO3_DB_NAME = 'typo3_dbname';
const TYPO3_DB_USER = 'typo3_dbuser';
const TYPO3_DB_PASSWD = 'typo3_dbpassword';
const TYPO3_ENCRYPTIONKEY = 'typo3_encryptionkey';
const IPDB_DB_HOST = 'ipdb_dbhost';
const IPDB_DB_NAME = 'ipdb_dbname';
const IPDB_DB_USER = 'ipdb_dbuser';
const IPDB_DB_PASSWD = 'ipdb_dbpassword';
const LOGPATH = 'log_path';

// Global Values
const SANDBOX = 'sandbox';
const APP = 'app';
