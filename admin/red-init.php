<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;

	if (is_file(ADMPATH.'red-config.php'))
		require_once(ADMPATH.'red-config.php');
	else
		exit('Fatal error');

	if (is_file(ADMPATH.'db/red-db.php'))
		include(ADMPATH.'db/red-db.php');
	else
		exit(RED_DEBUG ? 'The red-db.php file was not found!' : '');

	if (is_file(ADMPATH.'red-class.php'))
		include(ADMPATH.'red-class.php');
	else
		exit(RED_DEBUG ? 'The red-class.php file was not found!' : '');

	$RED = RED();
?>