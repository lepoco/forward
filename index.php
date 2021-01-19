<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2020, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;

	/** Verify PHP version */
	if ( version_compare( $ver = PHP_VERSION, $req = '7.0.11', '<' ) )
		exit( sprintf( 'You are running PHP %s, but Forward needs at least <strong>PHP %s</strong> to run.', $ver, $req ) );

	/** Define timezone */
	date_default_timezone_set( 'UTC' );

	/** Forward version */
	define( 'FORWARD_VERSION', '2.0.0' );

	/** The name of the directory with Forward files */
	define( 'APP_FOLDER', 'app' );

	/** Main constants for all files */
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
	define( 'APPPATH', ABSPATH . APP_FOLDER . '/' );

	/** Initialization file */
	if ( !is_file( APPPATH . 'system/rdev-init.php' ) )
		exit('Fatal error');

	require_once APPPATH . 'system/rdev-init.php' ;
