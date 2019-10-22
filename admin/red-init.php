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

	/** Config file / Install Forward */
	if (!is_file(ADMPATH.'red-config.php'))
		if (is_file(ADMPATH.'red-install.php'))
			require_once(ADMPATH.'red-install.php');
		else
			exit('Fatal error');
	else
		require_once(ADMPATH.'red-config.php');

	/** Database class */
	if (is_file(ADMPATH.'db/red-db.php'))
		require_once(ADMPATH.'db/red-db.php');
	else
		exit(RED_DEBUG ? 'The red-db.php file was not found!' : '');

	try
	{
		$DIR_URL = urldecode('/'.trim(str_replace(rtrim(dirname($_SERVER['SCRIPT_NAME']),'/'),'',$_SERVER['REQUEST_URI']),'/'));
		$DIR_URL = parse_url($DIR_URL);
		$DIR_URL = explode( '/', $DIR_URL['path']);
	}
	catch (Exception $e)
	{
		exit(RED_DEBUG ? $e : '');
	}

	if(!isset($DIR_URL[0], $DIR_URL[1]))
		exit(RED_DEBUG ? $e : 'URL Parsing error');

	if($DIR_URL[1] == '')
		defined('RED_PAGE') or define('RED_PAGE', '_forward_home');
	else if($DIR_URL[1] == RED_DASHBOARD)
		defined('RED_PAGE') or define('RED_PAGE', '_forward_dashboard');
	else
		defined('RED_PAGE') or define('RED_PAGE', filter_var($DIR_URL[1], FILTER_SANITIZE_STRING));

	if(RED_PAGE == '_forward_dashboard')
		if(isset($DIR_URL[2]))
			defined('RED_PAGE_DASHBOARD') or define('RED_PAGE_DASHBOARD', filter_var($DIR_URL[2], FILTER_SANITIZE_STRING));

	/** Main class */
	if (is_file(ADMPATH.'red-physic.php'))
		require_once(ADMPATH.'red-physic.php');
	else
		exit(RED_DEBUG ? 'The red-physic.php file was not found!' : '');

	/** Start Forward */
	$RED = new RED();
?>