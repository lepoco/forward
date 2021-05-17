<?php

/**
 * @package   Forward
 *
 * @author    RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link      https://www.rdev.cc/forward
 * @license   https://opensource.org/licenses/MIT
 */

namespace Forward\Components;

use Forward\Forward;
use Forward\Core\{Agent, Client, Session};

defined('ABSPATH') or die('No script kiddies please!');

final class Redirect
{
    /**
     * Forward class instance
     *
     * @var Forward
     * @access private
     */
    private Forward $Forward;

    /**
     * Id of current redirected url
     *
     * @var string
     * @access private
     */
    private string $id = '';

    /**
     * Name of current redirected url
     *
     * @var string
     * @access private
     */
    private string $name = '';

    /**
     * Current record
     *
     * @var array
     * @access private
     */
    private $record = array();

    /**
     * __construct
     * Class constructor
     *
     * @access   public
     */
    public function __construct(Forward &$parent)
    {
        $this->Forward = $parent;
        $this->parseName();

        if (!$this->getRecord()) {
            $nonexistent = $this->Forward->Options->Get('non_existent_record', 'error404');

            if ($nonexistent == 'error404') {
                $this->Forward->loadModel('404', 'Page not found');
            } else if ($nonexistent == 'home') {
                $this->Forward->loadModel('home', 'Create your own link shortener');
            } else {
                $this->Forward->exit();
            }
        }

        $this->updateClicks();
        $this->addVisitor();
        $this->doFlatRedirect();
    }

    /**
     * parseName
     * Prepare a redirect ID
     *
     * @access   private
     */
    private function parseName(): void
    {
        $this->name = strtolower(filter_var($this->Forward->Path->getLevel(0), FILTER_SANITIZE_STRING));
    }

    /**
     * getRecord
     * Get the redirect record from the database
     *
     * @access   private
     */
    private function getRecord(): bool
    {
        $query = $this->Forward->Database->query("SELECT * FROM forward_records WHERE record_name = ?", $this->name)->fetchArray();

        if ($query == null) {
            return false;
        } else {
            $this->id = $query['record_id'];
            $this->record = $query;
            return true;
        }
    }

    /**
     * Gets the address from which the user came
     *
     * @access   public
     * @return   string
     */
    private function parseReferrer(): string
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            return substr((!empty($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : ''), 0, 512);
        } else {
            return '';
        }
    }

    /**
     * Checks the current language of the site
     *
     * @access   public
     * @return   string
     */
    public function parseLanguage(): string
    {
        $langs = array();
        preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']), $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            list($a, $b) = explode('-', $match[1]) + array('', '');
            $value = isset($match[2]) ? (float) $match[2] : 1.0;
            $langs[$match[1]] = $value;
        }
        arsort($langs);

        if (count($langs) == 0)
            return 'unknown';
        else
            return substr(key($langs), 0, 128);
    }

    /**
     * Increases the click count
     *
     * @access   private
     */
    private function updateClicks(): void
    {
        $query = $this->Forward->Database->query(
            "UPDATE forward_records SET record_clicks = ? WHERE record_id = ?",
            $this->record['record_clicks'] += 1,
            $this->id,
        );
    }

    /**
     * Origin id from database by name
     *
     * @access   private
     * @param 	string $name
     */
    private function getOriginId($name): int
    {
        if (trim($name) == '')
            return 1;

        $query = $this->Forward->Database->query("SELECT origin_id FROM forward_statistics_origins WHERE origin_name = ?", $name)->fetchArray();

        if ($query == null) {
            $query = $this->Forward->Database->query("INSERT INTO forward_statistics_origins (origin_name) VALUES (?)", $name);
            return $query->lastInsertID();
        } else {
            return filter_var($query['origin_id'], FILTER_VALIDATE_INT);
        }
    }

    /**
     * Language id from database by name
     *
     * @access   private
     * @param 	string $name
     */
    private function getLanguageId($name): int
    {
        if (trim($name) == '')
            return 1;

        $query = $this->Forward->Database->query("SELECT language_id FROM forward_statistics_languages WHERE language_name = ?", $name)->fetchArray();

        if ($query == null) {
            $query = $this->Forward->Database->query("INSERT INTO forward_statistics_languages (language_name) VALUES (?)", $name);
            return $query->lastInsertID();
        } else {
            return filter_var($query['language_id'], FILTER_VALIDATE_INT);
        }
    }

    /**
     * getAgentId
     * Paltform id from database by name
     *
     * @access   private
     * @param 	string $name
     */
    private function getAgentId($name): int
    {
        if (trim($name) == '')
            return 1;

        $query = $this->Forward->Database->query("SELECT agent_id FROM forward_statistics_agents WHERE agent_name = ?", $name)->fetchArray();

        if ($query == null) {
            $query = $this->Forward->Database->query("INSERT INTO forward_statistics_agents (agent_name) VALUES (?)", $name);
            return $query->lastInsertID();
        } else {
            return filter_var($query['agent_id'], FILTER_VALIDATE_INT);
        }
    }

    /**
     * Paltform id from database by name
     *
     * @access   private
     * @param 	string $name
     */
    private function getPlatformId($name): int
    {
        if (trim($name) == '')
            return 1;

        $query = $this->Forward->Database->query("SELECT platform_id FROM forward_statistics_platforms WHERE platform_name = ?", $name)->fetchArray();

        if ($query == null) {
            $query = $this->Forward->Database->query("INSERT INTO forward_statistics_platforms (platform_name) VALUES (?)", $name);
            return $query->lastInsertID();
        } else {
            return filter_var($query['platform_id'], FILTER_VALIDATE_INT);
        }
    }

    /**
     * addVisitor
     * Add current visitor to statistics database
     *
     * @access   private
     */
    private function addVisitor(): void
    {
        $agent = new Agent();

        $query = $this->Forward->Database->query(
            "INSERT INTO forward_statistics_visitors (record_id, visitor_ip, visitor_origin_id, visitor_language_id, visitor_agent_id, visitor_platform_id) VALUES (?,?,?,?,?,?)",
            $this->id,
            Client::parseIp(true),
            $this->getOriginId($this->parseReferrer()),
            $this->getLanguageId($this->parseLanguage()),
            $this->getAgentId($agent->getBrowser()),
            $this->getPlatformId($agent->getPlatform())
        );
    }

    /**
     * doFlatRedirect
     * Starts redirecting the user via php
     *
     * @access   private
     */
    private function doFlatRedirect(): void
    {
        //Redirect
        header('Expires: on, 01 Jan 1970 00:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $this->record['record_url']);

        $this->Forward->exit();
    }
}
