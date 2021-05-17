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

defined('ABSPATH') or die('No script kiddies please!');

if (is_file(APPPATH . 'config.php')) {
    require_once APPPATH . 'config.php';

    if (FORWARD_DEBUG) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

require_once APPPATH . 'code/core/' . 'agent.php';
require_once APPPATH . 'code/core/' . 'api.php';
require_once APPPATH . 'code/core/' . 'client.php';
require_once APPPATH . 'code/core/' . 'crypter.php';
require_once APPPATH . 'code/core/' . 'database.php';
require_once APPPATH . 'code/core/' . 'models.php';
require_once APPPATH . 'code/core/' . 'options.php';
require_once APPPATH . 'code/core/' . 'session.php';
require_once APPPATH . 'code/core/' . 'statistics.php';
require_once APPPATH . 'code/core/' . 'translator.php';
require_once APPPATH . 'code/core/' . 'uri.php';
require_once APPPATH . 'code/core/' . 'user.php';

require_once APPPATH . 'code/components/' . 'ajax.php';
require_once APPPATH . 'code/components/' . 'redirect.php';
require_once APPPATH . 'code/components/' . 'dashboard.php';
require_once APPPATH . 'code/assets/'     . 'constants.php';

require_once APPPATH . 'code/' . 'forward.php';
