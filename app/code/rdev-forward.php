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
 * Forward
 *
 * @author   Leszek Pomianowski <https://rdev.cc>
 * @license	MIT License
 * @access   public
 */
class Forward
{
	/**
	 * Information about the address from the Uri class
	 *
	 * @var Uri
	 * @access public
	 */
	public $Path;

	/**
	 * Information about the session from the Session class
	 *
	 * @var Session
	 * @access public
	 */
	public $Session;

	/**
	 * Class for translating text strings
	 *
	 * @var Translator
	 * @access public
	 */
	public $Translator;

	/**
	 * A global class that stores options
	 *
	 * @var Options
	 * @access public
	 */
	public $Options;

	/**
	 * A set of user management tools
	 *
	 * @var User
	 * @access public
	 */
	public $User;

	/**
	 * Master database instance, requires config.php
	 *
	 * @var Database
	 * @access public
	 */
	public $Database;

	/**
	 * __construct
	 * Triggers and instances all necessary classes
	 *
	 * @access   public
	 * @return   Forward
	 */
	public function __construct()
	{
		$this->Init();

		//If the configuration file does not exist or is damaged, start the installation
		if (!DEFINED('FORWARD_DB_NAME')) {
			$this->LoadModel('install', 'Installer');
		} else {
			//Mechanism of action depending on the first part of the url
			switch ($this->Path->GetLevel(0)) {
				case '':
				case null:
					$this->AddStatistic('home');
					$this->LoadModel('home', 'Create your own link shortener');
					break;

				case $this->Options->Get('dashboard', 'dashboard'):
				case $this->Options->Get('login', 'login'):
					new Dashboard($this);
					break;

				default:
					new Redirect($this);
					break;
			}
		}

		exit; //Just in case
	}

	/**
	 * Init
	 * Instances all necessary classes
	 *
	 * @access   private
	 * @return   void
	 */
	private function Init(): void
	{
		$this->InitPath();
		$this->InitSession();
		$this->InitTranslator();
		$this->InitDatabase();
		$this->InitOptions();
		$this->InitUser();
	}

	/**
	 * IsConfig
	 * Checks if the configuration file exists
	 *
	 * @access   private
	 * @return   bool
	 */
	private function IsConfig(): bool
	{
		if (is_file(APPPATH . 'config.php'))
			return true;
		else
			return false;
	}

	/**
	 * InitPath
	 * Initializes the Uri class
	 *
	 * @access   private
	 * @return   void
	 */
	private function InitPath(): void
	{
		$this->Path = new Uri();
		$this->Path->Parse();
	}

	/**
	 * InitSession
	 * Initializes the Session class
	 *
	 * @access   private
	 * @return   void
	 */
	private function InitSession(): void
	{
		$this->Session = new Session();
		$this->Session->Open();
	}

	/**
	 * InitTranslator
	 * Initializes the Translator class
	 *
	 * @access   private
	 * @return   void
	 */
	private function InitTranslator(): void
	{
		$this->Translator = new Translator();
	}

	/**
	 * InitDatabase
	 * Initializes the Database class
	 *
	 * @access   private
	 * @return   void
	 */
	private function InitDatabase(): void
	{
		if ($this->IsConfig())
			$this->Database = new Database();
		else
			$this->Database = null;
	}

	/**
	 * InitOptions
	 * Initializes the Options class
	 *
	 * @access   private
	 * @return   void
	 */
	private function InitOptions(): void
	{
		$this->Options = new Options($this->Database);
	}

	/**
	 * InitUser
	 * Initializes the User class
	 *
	 * @access   private
	 * @return   void
	 */
	private function InitUser(): void
	{
		$this->User = new User($this);
	}

	/**
	 * LoadModel
	 * Loads the page model (logic)
	 * The page model is inherited from assets/rdev-models.php
	 *
	 * @access   private
	 * @return   void
	 */
	public function LoadModel(string $name, string $displayname = null)
	{
		if (is_file(APPPATH . "/models/rdev-$name.php")) {
			require_once APPPATH . "/models/rdev-$name.php";
			(new Model($this, $name, $displayname))->Print();
		} else {
			if (is_file(APPPATH . "/themes/pages/rdev-$name.php")) {
				//Display the page without additional logic
				(new Models($this, $name, $displayname))->Print();
			} else {
				exit("Unable to find model '$name'");
			}
		}
	}

	/**
	 * AddStatistic
	 * Checks if the selected page exists
	 *
	 * @access   private
	 */
	public function AddStatistic($page = null, $type = 'page'): void
	{
		if (empty($page)) {
			$page = null;
		} else {
			$query = $this->Database->query("SELECT page_id FROM forward_global_statistics_pages WHERE page_name = ?", $page)->fetchArray();

			if ($query == null) {
				$query = $this->Database->query("INSERT INTO forward_global_statistics_pages (page_name) VALUES (?)", $page);
				$page = $query->lastInsertID();
			} else {
				$page = filter_var($query['page_id'], FILTER_VALIDATE_INT);
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


		if (!$this->User->IsLoggedIn())
			$userid = null;
		else
			$userid = $this->User->Active()['user_id'];

		$query = $this->Database->query(
			"INSERT INTO forward_global_statistics (statistic_type, statistic_page, statistic_user_id, statistic_user_logged_in, statistic_ip) VALUES (?, ?, ?, ?, ?)",
			$typeId, //type id
			$page, //page id
			$userid, //user id
			$this->User->IsLoggedIn() ? 1 : 0, //logged in
			$this->ParseIP(true)
		);
	}

	/**
	 * ParseIP
	 * Gets the IP address of the user
	 *
	 * @access   public
	 * @return   string
	 */
	public function ParseIP($pton = false): string
	{
		if ($this->Options->Get('store_ip_addresses', true)) {
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
				return ($pton ? inet_pton($remote) : $remote);
			}
		} else {
			return '';
		}
	}

	/**
	 * Error
	 * Custom error handling
	 *
	 * @param	string $message
	 * @access   public
	 * @return   html (error message)
	 */
	public function Error(string $message, bool $suspend = false)
	{
		$r_message = '<br/><strong>Forward Error</strong><br/><br/><i>' . date('Y-m-d h:i:s a', time()) . '</i><br/>';

		if (is_file(APPPATH . 'config.php')) {
			if (DEFINED('FORWARD_DEBUG')) {
				if (FORWARD_DEBUG)
					echo $r_message . $message;
			} else {
				echo $r_message . $message . '<br/><i>Configuration file <strong>EXISTS</strong> but FORWARD_DEBUG constant could not be found ...</i>';
			}
		} else {
			echo $r_message . $message . '<br/><i>Configuration file does not exist...</i>';
		}

		if ($suspend)
			exit;
	}
}
