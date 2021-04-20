<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

namespace Forward;

defined('ABSPATH') or die('No script kiddies please!');

/** Page models */
if (is_file(APPPATH . 'config.php'))
	require_once APPPATH . 'config.php';

/** Constants */
require_once APPPATH . 'code/core/' . 'rdev-constants.php';

/** Uri */
require_once APPPATH . 'code/core/' . 'rdev-uri.php';

/** Session manager */
require_once APPPATH . 'code/core/' . 'rdev-session.php';

/** Crypter */
require_once APPPATH . 'code/core/' . 'rdev-crypter.php';

/** String translator */
require_once APPPATH . 'code/core/' . 'rdev-translator.php';

/** Database */
require_once APPPATH . 'code/core/' . 'rdev-database.php';

/** User Agent */
require_once APPPATH . 'code/core/' . 'rdev-agent.php';

/** Ajax parser */
require_once APPPATH . 'code/core/' . 'rdev-ajax.php';

/** Options parser */
require_once APPPATH . 'code/core/' . 'rdev-options.php';

/** JSON API */
require_once APPPATH . 'code/core/' . 'rdev-api.php';

/** Page models */
require_once APPPATH . 'code/core/' . 'rdev-models.php';

/** User */
require_once APPPATH . 'code/core/' . 'rdev-user.php';

/** Redirect */
require_once APPPATH . 'code/core/' . 'rdev-redirect.php';

/** Dashboard */
require_once APPPATH . 'code/core/' . 'rdev-dashboard.php';

/** Forward */
require_once APPPATH . 'code/' . 'rdev-forward.php';

/* Start Forward CMS */
(new Forward());
