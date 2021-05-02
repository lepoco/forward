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

/**
 *
 * Model [Dashboard]
 *
 * @author   Leszek Pomianowski <https://rdev.cc>
 * @license	MIT License
 * @access   public
 */
class Model extends Models
{
    protected function Init(): void
    {
    }

    protected function VisitsToday()
    {
        $query = $this->Forward->Database->query("SELECT statistic_id FROM forward_statistics_pages WHERE date(statistic_date) = CURDATE() AND statistic_page <> 'ajax_query'")->fetchAll();
        if (empty($query))
            return 0;

        return count($query);
    }

    protected function QueriesToday()
    {
        $query = $this->Forward->Database->query("SELECT statistic_id FROM forward_statistics_pages WHERE statistic_page = 'ajax_query'")->fetchAll();
        if (empty($query))
            return 0;

        return count($query);
    }
}
