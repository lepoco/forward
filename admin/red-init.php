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
		if (is_file(ADMPATH.'red-install.php'))
			require_once(ADMPATH.'red-install.php');
		else
			exit('Fatal error');
	else
		require_once(ADMPATH.'red-config.php');

	if (is_file(ADMPATH.'db/red-db.php'))
		require_once(ADMPATH.'db/red-db.php');
	else
		exit(RED_DEBUG ? 'The red-db.php file was not found!' : '');

	if (is_file(ADMPATH.'red-page.php'))
		require_once(ADMPATH.'red-page.php');
	else
		exit(RED_DEBUG ? 'The red-page.php file was not found!' : '');

	if (is_file(ADMPATH.'red-physic.php'))
		require_once(ADMPATH.'red-physic.php');
	else
		exit(RED_DEBUG ? 'The red-physic.php file was not found!' : '');

	$RED = new RED();
?>