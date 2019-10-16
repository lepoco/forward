<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

	if (is_file(ADMPATH.'red-config.php'))
		require_once(ADMPATH.'red-config.php');
	else
		exit('Fatal error');
?>