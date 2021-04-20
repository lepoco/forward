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
 * Redirect
 *
 * @author   Leszek Pomianowski <https://rdev.cc>
 * @license	MIT License
 * @access   public
 */
class Redirect
{
	/**
	 * Forward class instance
	 *
	 * @var Forward
	 * @access private
	 */
	private $Forward;

	/**
	 * Id of current redirected url
	 *
	 * @var string
	 * @access private
	 */
	private $id = '';

	/**
	 * Name of current redirected url
	 *
	 * @var string
	 * @access private
	 */
	private $name = '';

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
		$this->ParseName();

		if (!$this->GetRecord()) {
			$nonexistent = $this->Forward->Options->Get('non_existent_record', 'error404');

			if ($nonexistent == 'error404') {
				$this->Forward->LoadModel('404', 'Page not found');
			} else if ($nonexistent == 'home') {
				$this->Forward->LoadModel('home', 'Create your own link shortener');
			} else {
				exit;
			}
		}

		$this->UpdateClicks();
		$this->AddVisitor();

		//End ajax query
		$this->Forward->Session->Close();
		$this->DoFlatRedirect();
	}

	/**
	 * ParseName
	 * Prepare a redirect ID
	 *
	 * @access   private
	 */
	private function ParseName(): void
	{
		$this->name = strtolower(filter_var($this->Forward->Path->GetLevel(0), FILTER_SANITIZE_STRING));
	}

	/**
	 * GetRecord
	 * Get the redirect record from the database
	 *
	 * @access   private
	 */
	private function GetRecord(): bool
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
	 * ParseReferrer
	 * Gets the IP address of the user
	 *
	 * @access   public
	 * @return   string
	 */
	private function ParseIP(): string
	{
		if ($this->Forward->Options->Get('store_ip_addresses', true)) {
			if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
				$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
				$_SERVER['HTTP_CLIENT_IP'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
			}

			$client = @$_SERVER['HTTP_CLIENT_IP'];
			$remote = $_SERVER['REMOTE_ADDR'];

			$forward = '';
			if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
					$addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
					$forward = trim($addr[0]);
				} else {
					$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
				}
			}

			if (filter_var($client, FILTER_VALIDATE_IP)) {
				return $client;
			} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
				return $forward;
			} else {
				return $remote;
			}
		} else {
			return '';
		}
	}

	/**
	 * ParseReferrer
	 * Gets the address from which the user came
	 *
	 * @access   public
	 * @return   string
	 */
	private function ParseReferrer(): string
	{
		if (isset($_SERVER['HTTP_REFERER'])) {
			return substr((!empty($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : ''), 0, 512);
		} else {
			return '';
		}
	}

	/**
	 * ParseLanguage
	 * Checks the current language of the site
	 *
	 * @access   public
	 * @return   string
	 */
	public function ParseLanguage(): string
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
	 * UpdateClicks
	 * Increases the click count
	 *
	 * @access   private
	 */
	private function UpdateClicks(): void
	{
		$query = $this->Forward->Database->query(
			"UPDATE forward_records SET record_clicks = ? WHERE record_id = ?",
			$this->record['record_clicks'] += 1,
			$this->id,
		);
	}

	/**
	 * GetOriginId
	 * Language id from database by name
	 *
	 * @access   private
	 * @param 	string $name
	 */
	private function GetOriginId($name): int
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
	 * GetLanguageId
	 * Language id from database by name
	 *
	 * @access   private
	 * @param 	string $name
	 */
	private function GetLanguageId($name): int
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
	 * GetAgentId
	 * Paltform id from database by name
	 *
	 * @access   private
	 * @param 	string $name
	 */
	private function GetAgentId($name): int
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
	 * GetPlatformId
	 * Paltform id from database by name
	 *
	 * @access   private
	 * @param 	string $name
	 */
	private function GetPlatformId($name): int
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
	 * AddVisitor
	 * Add current visitor to statistics database
	 *
	 * @access   private
	 */
	private function AddVisitor(): void
	{
		$agent = new Agent();

		$query = $this->Forward->Database->query(
			"INSERT INTO forward_statistics_visitors (record_id, visitor_ip, visitor_origin_id, visitor_language_id, visitor_agent_id, visitor_platform_id) VALUES (?,?,?,?,?,?)",
			$this->id,
			$this->ParseIP(),
			$this->GetOriginId($this->ParseReferrer()),
			$this->GetLanguageId($this->ParseLanguage()),
			$this->GetAgentId($agent->GetBrowser()),
			$this->GetPlatformId($agent->GetPlatform())
		);
	}

	/**
	 * DoFlatRedirect
	 * Starts redirecting the user via php
	 *
	 * @access   private
	 */
	private function DoFlatRedirect(): void
	{
		//Redirect
		header('Expires: on, 01 Jan 1970 00:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $this->record['record_url']);

		exit;
	}
}
