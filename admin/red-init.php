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

	if (!is_file(ADMPATH.'red-config.php'))
		if (is_file(ADMPATH.'red-config-sample.php'))
			file_put_contents(ADMPATH.'red-config.php', file_get_contents(ADMPATH.'red-config-sample.php'), FILE_APPEND);
		else
			exit('Fatal error');
	require_once(ADMPATH.'red-config.php');

	if (is_file(ADMPATH.'db/red-db.php'))
		include(ADMPATH.'db/red-db.php');
	else
		exit(RED_DEBUG ? 'The red-db.php file was not found!' : '');

	if (is_file(ADMPATH.'red-physic.php'))
		include(ADMPATH.'red-physic.php');
	else
		exit(RED_DEBUG ? 'The red-physic.php file was not found!' : '');

	$RED = new RED();
?>