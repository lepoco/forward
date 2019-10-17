<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

	$db = new \Filebase\Database([
		'dir'            => DB_PATH.DB_OPTIONS,
		'backupLocation' => DB_PATH.DB_OPTIONS.'/backup',
		'format'         => \Filebase\Format\Json::class,
		'cache'          => true,
		'cache_expires'  => 1800,
		'pretty'         => true,
		'safe_filename'  => true,
		'read_only'      => false,
		'validate' => [
			'name'   => [
				'valid.type' => 'string',
				'valid.required' => true
			],
			'value'   => [
				'valid.type' => 'string',
				'valid.required' => true
			]
		]
	]);

	$db = new \Filebase\Database([
		'dir'            => DB_PATH.DB_RECORDS,
		'backupLocation' => DB_PATH.DB_RECORDS.'/backup',
		'format'         => \Filebase\Format\Json::class,
		'cache'          => true,
		'cache_expires'  => 1800,
		'pretty'         => true,
		'safe_filename'  => true,
		'read_only'      => false,
		'validate' => [
			'name'   => [
				'valid.type' => 'string',
				'valid.required' => true
			],
			'url'   => [
				'valid.type' => 'string',
				'valid.required' => true
			],
			'timestamp'   => [
				'valid.type' => 'string',
				'valid.required' => true
			],
			'clicks'   => [
				'valid.type' => 'int',
				'valid.required' => true
			],
			'referrers'   => [
				'valid.type' => 'string',
				'valid.required' => true
			],
			'locations'   => [
				'valid.type' => 'string',
				'valid.required' => true
			]
		]
	]);

	$db = new \Filebase\Database([
		'dir'            => DB_PATH.DB_USERS,
		'backupLocation' => DB_PATH.DB_USERS.'/backup',
		'format'         => \Filebase\Format\Json::class,
		'cache'          => true,
		'cache_expires'  => 1800,
		'pretty'         => true,
		'safe_filename'  => true,
		'read_only'      => false,
		'validate' => [
			'name'   => [
				'valid.type' => 'string',
				'valid.required' => true
			],
			'password'   => [
				'valid.type' => 'string',
				'valid.required' => true
			],
			'email'   => [
				'valid.type' => 'string',
				'valid.required' => true
			]
		]
	]);

	$this->DB['options'] = new \Filebase\Database(['dir' => DB_PATH.DB_OPTIONS]);
	
	$item = $this->DB['options']->get('siteurl');
	$item->value = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$item->save();
	$item = $this->DB['options']->get('dashboard');
	$item->value = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]dashboard";
	$item->save();

	$this->DB['users'] = new \Filebase\Database(['dir' => DB_PATH.DB_USERS]);
	$item = $this->DB['users']->get('admin');
	$item->password = 'admin';
	$item->email = 'admin@example.com';
	$item->save();

	$this->DB['records'] = new \Filebase\Database(['dir' => DB_PATH.DB_RECORDS]);
	$item = $this->DB['records']->get('sample');
	$item->url = 'https://rdev.cc/';
	$item->clicks = 1;
	$item->save();





	/*
	#Htaccess
	$htaccess = ABSPATH.'.htaccess';
	if (is_file($htaccess)) {
		$current = file_get_contents($htaccess);
		file_put_contents($htaccess, str_replace('RewriteEngine on', 'RewriteEngine on'.PHP_EOL.'RewriteBase /'.$this->page, $current), FILE_APPEND);
	}else{
		exit('There is no htacess file!');
	}
	*/

?>