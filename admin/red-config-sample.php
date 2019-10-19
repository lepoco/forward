<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;
	defined('ABSPATH') or die('No script kiddies please!');

	/** Debug */
	define('RED_DEBUG', false);
	
	/** Database path */
	define('DB_PATH', ADMPATH.'db/');

	/** The name of the database for users */
	define('DB_USERS', 'users_database');

	/** The name of the database for options */
	define('DB_OPTIONS', 'options_database');

	/** The name of the database for records */
	define('DB_RECORDS', 'records_database');

	/** Salt for passwords */
	define('RED_SALT', 'example_salt');

	/** Salt for passwords */
	define('RED_SESSION', 'example_session_salt');

	/** Salt for nonce */
	define('RED_NONCE', 'example_nonce_salt');

	/** WebName */
	define('RED_NAME', 'Forward');

	/** Forward version */
	define('RED_VERSION', 'beta 1.0.0');

	/** Password hash type */
	if(NULL != PASSWORD_ARGON2ID)
		define('RED_ALGO', PASSWORD_ARGON2ID);
	else if(NULL != PASSWORD_ARGON2I)
		define('RED_ALGO', PASSWORD_ARGON2I);
	else if(NULL != PASSWORD_BCRYPT)
		define('RED_ALGO', PASSWORD_BCRYPT);
	else if(NULL != PASSWORD_DEFAULT)
		define('RED_ALGO', PASSWORD_DEFAULT);
?>