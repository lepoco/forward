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

	/** Install Forward */
	if (!is_file(ADMPATH.'red-config.php'))
		exit(require_once(ADMPATH.'red-install.php'));
	
	/** Config file */
	require_once(ADMPATH.'red-config.php');

	/** Database class */
	if (!is_file(ADMPATH.'db/red-db.php'))
		exit(RED_DEBUG ? 'The red-db.php file was not found!' : '');
	require_once(ADMPATH.'db/red-db.php');

	/** Main class */
	if (!is_file(ADMPATH.'red-model.php'))
		exit(RED_DEBUG ? 'The red-model.php file was not found!' : '');
	require_once(ADMPATH.'red-model.php');

	/** Start Forward */
	RED::init();
?>