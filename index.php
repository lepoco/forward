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

	/** The name of the directory with Forward files */
	define('ADMIN_PATH', 'admin');

	/** Main constants for all files */
	define('ABSPATH', dirname( __FILE__ ).'/');
	define('ADMPATH', ABSPATH.ADMIN_PATH.'/');

	/** Initialization file */
	if (!is_file(ADMPATH.'red-init.php'))
		exit('Fatal error');
	require_once(ADMPATH.'red-init.php');
?>