<?php
/*const KEY_DISPLAY_ERRORS = 'displayErrors';
const KEY_TYPO3_CONF_VARS = 'TYPO3_CONF_VARS';
const KEY_DEV_IP_MASK = 'devIPmask';
const KEY_CONNECTIONS = 'Connections';
const KEY_DEFAULT = 'Default';
const KEY_SYS = 'SYS';
const KEY_DB = 'DB';

putenv('TYPO3_CONTEXT=Development/Local');
$_SERVER['TYPO3_CONTEXT'] = 'Development/Local';
$_ENV['TYPO3_CONTEXT'] = 'Development/Local';

if (!defined('TYPO3_MODE')) {
   die('Access denied.');
}

// You may add PHP code here, wihch is executed on every request after the configuration is loaded.
// The code here should only manipulate TYPO3_CONF_VARS for example to set the database configuration
// dependent to the requested environment.

switch (\TYPO3\CMS\Core\Core\Environment::getContext()) {

   case 'Development':
   case 'Development/V10':

      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_SYS][KEY_DISPLAY_ERRORS] = 1;
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_SYS][KEY_DEV_IP_MASK] = '*';

      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['dbname'] = 'db13303627-xpr10';
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['host'] = 'localhost';
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['password'] = 'GJe_3_he6Z42jvC';
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['user'] = 'db13303627-xpr10';


      break;

   case 'Development/Local':

      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_SYS][KEY_DISPLAY_ERRORS] = 1;
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_SYS][KEY_DEV_IP_MASK] = '*';

      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['dbname'] = 'db';
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['host'] = 'db';
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['password'] = 'db';
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['user'] = 'db';
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['port'] = 3306;
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['driver'] = 'mysqli';
      $GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern'] = '.*';

      break;

   case 'Production/Staging':

      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_SYS][KEY_DISPLAY_ERRORS] = 0;
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_SYS][KEY_DEV_IP_MASK] = '192.168.1.*';

      break;

   default:

      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_SYS][KEY_DISPLAY_ERRORS] = 0;
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_SYS][KEY_DEV_IP_MASK] = '127.0.0.1';

      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['dbname'] = 'db13251579-t311l';
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['host'] = 'localhost';
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['password'] = 'P4j_3JNT2-HX49oi';
      $GLOBALS[KEY_TYPO3_CONF_VARS][KEY_DB][KEY_CONNECTIONS][KEY_DEFAULT]['user'] = 'db13251579-t311l';

      break;

}
*/