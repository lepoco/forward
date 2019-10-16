<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

	if (!defined('ABSPATH'))
		define('ABSPATH', dirname( __FILE__ ).'/');

	if (!defined('ADMPATH'))
		define('ADMPATH', ABSPATH.'admin/');

	if (is_file(ADMPATH.'red-init.php'))
		require_once(ADMPATH.'red-init.php');
	else
		exit('Fatal error');
?>