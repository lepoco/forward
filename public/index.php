<?php

/**
 * @package   Forward
 *
 * @author    RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link      https://www.rdev.cc/forward
 * @license   https://opensource.org/licenses/MIT
 */

namespace Forward;

define('FORWARD_VERSION', '2.0.3');
define('APPDIR', 'app');
define('ABSPATH', dirname(__FILE__) . '\\..\\');
define('APPPATH', ABSPATH . APPDIR . '\\');

if (version_compare($ver = PHP_VERSION, $req = '7.4.0', '<')) {
    exit(sprintf('You are running PHP %s, but Forward needs at least <strong>PHP %s</strong> to run.', $ver, $req));
}

date_default_timezone_set('UTC');

if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', 'public');
}

if (!is_file(APPPATH . 'loader.php')) {
    exit('Fatal error');
}
require_once APPPATH . 'loader.php';

/** Start Forward */
(new Forward());
