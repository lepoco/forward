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
	defined('ABSPATH') or die('No script kiddies please!');

	/** Page models */
	if ( is_file( APPPATH . 'config.php' ) )
		require_once APPPATH . 'config.php';

	/** Uri */
	require_once APPPATH . 'assets/' . 'rdev-uri.php';

	/** Session manager */
	require_once APPPATH . 'assets/' . 'rdev-session.php';

	/** Crypter */
	require_once APPPATH . 'assets/' . 'rdev-crypter.php';

	/** String translator */
	require_once APPPATH . 'assets/' . 'rdev-translator.php';

	/** Database */
	require_once APPPATH . 'assets/' . 'rdev-database.php';

	/** User Agent */
	require_once APPPATH . 'assets/' . 'rdev-agent.php';

	/** Ajax parser */
	require_once APPPATH . 'assets/' . 'rdev-ajax.php';

	/** Options parser */
	require_once APPPATH . 'assets/' . 'rdev-options.php';

	/** Page models */
	require_once APPPATH . 'assets/' . 'rdev-models.php';

	/** User */
	require_once APPPATH . 'assets/' . 'rdev-user.php';

	/** Redirect */
	require_once APPPATH . 'assets/' . 'rdev-redirect.php';

	/** Dashboard */
	require_once APPPATH . 'assets/' . 'rdev-dashboard.php';

	/** Forward */
	require_once APPPATH . 'system/' . 'rdev-forward.php';
