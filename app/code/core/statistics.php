<?php

/**
 * @package   Forward
 *
 * @author    RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link      https://www.rdev.cc/forward
 * @license   https://opensource.org/licenses/MIT
 */

namespace Forward\Core;

use Forward\Forward;

defined('ABSPATH') or die('No script kiddies please!');

final class Statistics
{
    /**
     * Forward instance
     *
     * @var Forward
     * @access private
     */
    private Forward $Forward;

    /**
     * __construct
     * Class constructor
     *
     * @access   public
     */
    public function __construct(Forward $parent)
    {
        $this->Forward = $parent;
    }

    /**
     * Get options from database
     *
     * @access   public
     */
    public function add(?string $tag = null, ?string $type = 'page'): void
    {
        if ($this->Forward->Database == null) {
            return;
        }

        if (empty($tag)) {
            $tag = null;
        } else {
            $query = $this->Forward->Database->query("SELECT tag_id FROM forward_global_statistics_tags WHERE tag_name = ?", $tag)->fetchArray();

            if ($query == null) {
                $query = $this->Forward->Database->query("INSERT INTO forward_global_statistics_tags (tag_name) VALUES (?)", $tag);
                $tag = $query->lastInsertID();
            } else {
                $tag = filter_var($query['tag_id'], FILTER_VALIDATE_INT);
            }
        }

        switch ($type) {
            case 'query':
                $typeId = 2;
                break;
            case 'action':
                $typeId = 4;
                break;
            default:
                $typeId = 3;
                break;
        }


        if (!$this->Forward->User->isLoggedIn())
            $userid = null;
        else
            $userid = $this->Forward->User->current()['user_id'];

        $query = $this->Forward->Database->query(
            "INSERT INTO forward_global_statistics (statistic_type, statistic_tag, statistic_user_id, statistic_user_logged_in, statistic_ip) VALUES (?, ?, ?, ?, ?)",
            $typeId, //type id
            $tag, //tag id
            $userid, //user id
            $this->Forward->User->isLoggedIn() ? 1 : 0, //logged in
            ($this->Forward->Options->get('store_ip_addresses', true) ? Client::parseIp(true) : '')
        );
    }
}
