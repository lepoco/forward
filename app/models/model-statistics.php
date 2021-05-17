<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

namespace Forward\Models;

use Forward\Core\Models;

defined('ABSPATH') or die('No script kiddies please!');

final class Model extends Models
{
    protected function init(): void
    {
    }

    protected function visitsToday()
    {
        $query = $this->Forward->Database->query("SELECT statistic_id FROM forward_global_statistics WHERE date(statistic_date) = CURDATE() AND statistic_type = 3")->fetchAll();
        if (empty($query))
            return 0;

        return count($query);
    }

    protected function queriesToday()
    {
        $query = $this->Forward->Database->query("SELECT statistic_id FROM forward_global_statistics WHERE date(statistic_date) = CURDATE() AND statistic_type = 2")->fetchAll();
        if (empty($query))
            return 0;

        return count($query);
    }
}
