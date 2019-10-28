<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;
	defined('ABSPATH') or die('No script kiddies please!');

	/**
	*
	* RED
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @version  $Id: red-physic.php;RED,v beta 1.0 2019/10/27
	* @access   public
	*/
	class RED
	{
		public $DB;

		private $is_manager;
		private $is_admin;

		/**
		* init
		* Initializes the class without instantiating it
		*
		* @access   public
		* @return   object RED
		*/
		public static function init() : RED
		{
			return new RED();
		}

		/**
		* __construct
		* Registers the database, verifies the page id and redirect
		*
		* @access   public
		* @return   void
		*/
		public function __construct()
		{
			self::decode_url();

			self::database();

			self::https();

			switch (RED_PAGE)
			{
				case '_forward_dashboard':
					self::admin();
					break;
				case '_forward_home':
					if($this->DB['options']->get('redirect_home')->value)
					{
						$home_url = $this->DB['options']->get('redirect_home_url')->value;
						if(!empty($home_url))
						{
							header('HTTP/1.1 301 Moved Permanently');
							header('Location: ' . $home_url);
							exit;
						}
					}
					$this->page(['title' => 'Home page', 'page' => 'home']);
					break;
				case '404':
					$this->page(['title' => 'Page not found']);
					break;
				default:
					self::forward();
					break;
			}
		}

		/**
		* decode_url
		* Analyzes and determines the current url
		*
		* @access   private
		* @return   void
		*/
		private function decode_url(): void
		{
			$DIR_URL = urldecode('/'.trim(str_replace(rtrim(dirname($_SERVER['SCRIPT_NAME']),'/'),'',$_SERVER['REQUEST_URI']),'/'));
			$DIR_URL = parse_url($DIR_URL);
			$DIR_URL = explode( '/', $DIR_URL['path']);

			if(!isset($DIR_URL[0], $DIR_URL[1]))
				exit(RED_DEBUG ? $e : 'URL Parsing error');

			if($DIR_URL[1] == '')
				defined('RED_PAGE') or define('RED_PAGE', '_forward_home');
			else if($DIR_URL[1] == RED_DASHBOARD)
				defined('RED_PAGE') or define('RED_PAGE', '_forward_dashboard');
			else
				defined('RED_PAGE') or define('RED_PAGE', filter_var($DIR_URL[1], FILTER_SANITIZE_STRING));

			if(RED_PAGE == '_forward_dashboard')
				if(isset($DIR_URL[2]))
					defined('RED_PAGE_DASHBOARD') or define('RED_PAGE_DASHBOARD', filter_var($DIR_URL[2], FILTER_SANITIZE_STRING));
		}

		/**
		* database
		* Loads database objects into an array
		*
		* @access   private
		* @return   void
		*/
		private function database() : void
		{
			$this->DB = array(
				'options' => new \Filebase\Database([
					'dir' => DB_PATH.DB_OPTIONS,
					'backupLocation' => DB_PATH.DB_OPTIONS.'/backup',
					'format' => \Filebase\Format\Jdb::class,
					'cache' => true,
					'cache_expires' => 1800
				]),
				'records' => new \Filebase\Database([
					'dir' => DB_PATH.DB_RECORDS,
					'backupLocation' => DB_PATH.DB_RECORDS.'/backup',
					'format' => \Filebase\Format\Jdb::class,
					'cache' => true,
					'cache_expires' => 1800
				])
			);
		}

		/**
		* https
		* Checks whether the encryption enforcement option is enabled
		*
		* @access   private
		* @return   void
		*/
		private function https() : void
		{
			$force = false;

			if(RED_PAGE == '_forward_dashboard')
				if ($this->DB['options']->get('admin_ssl')->value)
					$force = true;
			else
				if ($this->DB['options']->get('redirect_ssl')->value)
					$force = true;

			if($force)
			{
				if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off")
				{
					header('HTTP/1.1 301 Moved Permanently');
					header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
					exit;
				}
			}
		}

		/**
		* page
		* Checks if the RED_PAGES class exists and returns a new page object
		*
		* @access   public
		* @param	array $data
		* @return   object RED_PAGES
		*/
		public function page(array $data) : RED_PAGES
		{
			self::include(ADMPATH.'red-page.php');
			return new RED_PAGES($data, $this);
		}

		/**
		* admin
		* Loads the administrator class
		*
		* @access   private
		* @return   object RED_ADMIN
		*/
		private function admin() : RED_ADMIN
		{
			self::include(ADMPATH.'red-admin.php');
			return RED_ADMIN::init($this);
		}

		/**
		* forward
		* Performs a redirection and saves information to the database
		*
		* @access   private
		* @return   void
		*/
		private function forward() : void
		{
			self::https();
			
			$record = $this->DB['records']->get(RED_PAGE);

			if($record->url == NULL)
				$this->page(['title' => 'Page not found']);

			/** Languages */
			$lang = self::parseLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
			if(is_array($record->locations))
				if(array_key_exists($lang, $record->locations))
					$record->locations[$lang] += 1;
				else
					$record->locations[$lang] = 1;
			else
				$record->locations = array($lang => 1);

			/** Daily stats */
			$time = time();
			$time = array(
				'key' => date('Y-m',$time),
				'day' => date('d',$time),
			);
			
			if(!is_array($record->stats))
				$record->stats = array();

			if(!array_key_exists($time['key'], $record->stats))
				$record->stats[$time['key']] = array();

			if(!array_key_exists($time['day'], $record->stats[$time['key']]))
				$record->stats[$time['key']][$time['day']] = 1;
			else
				$record->stats[$time['key']][$time['day']] += 1;

			/** Referrers */
			if(!is_array($record->referrers))
				$record->referrers = array();

			if(isset($_SERVER['HTTP_REFERER']))
			{
				$ref = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);

				if(array_key_exists($ref, $record->referrers))
					$record->referrers[$ref] += 1;
				else
					$record->referrers[$ref] += 1;
			}
			else
			{
				if(array_key_exists('direct', $record->referrers))
					$record->referrers['direct'] += 1;
				else
					$record->referrers['direct'] += 1;
			}

			/** Clicks */
			$record->clicks = $record->clicks + 1;
			$record->save();

			//Redirect
			header("Location: " . $record->url);
			exit;	
		}

		/**
		* parseLanguage
		* Checks the current language of the site
		*
		* @access   public
		* @return   string key($langs)
		*/
		public function parseLanguage() : string
		{
			$langs = array();
			preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']), $matches, PREG_SET_ORDER);

			foreach($matches as $match)
			{
				list($a, $b) = explode('-', $match[1]) + array('', '');
				$value = isset($match[2]) ? (float) $match[2] : 1.0;
				$langs[$match[1]] = $value;

			}
			arsort($langs);

			if(count($langs) == 0)
				return 'unknown';
			else
				return key($langs);
		}

		/**
		* rand
		* Generates a random string
		*
		* @access   public
		* @param	int $length
		* @return   string $randomString
		*/
		public static function rand(int $length) : string
		{
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {$randomString .= $characters[rand(0, 35)];}
			return $randomString;
		}

		/**
		* encrypt
		* Encrypts data depending on the selected method, default password
		*
		* @access   public
		* @param	string $string
		* @param	string $type
		* @return   string hash_hmac()
		*/
		public static function encrypt(string $string, string $type = 'password') : string
		{
			if($type == 'password')
			{
				return password_hash(hash_hmac('sha256', $string, RED_SALT), RED_ALGO);
			}
			else if($type == 'nonce')
			{
				return hash_hmac('sha1', $string, RED_NONCE);
			}
			else if($type == 'token')
			{
				return hash_hmac('sha256', $string, RED_SESSION);
			}
		}

		/**
		* compare_crypt
		* Compares encrypted data with those in the database
		*
		* @access   public
		* @param	string $input_string
		* @param	string $db_string
		* @param	string $type
		* @param	bool   $plain
		* @return	bool   true/false
		*/
		public static function compare_crypt(string $input_string, string $db_string, string $type = 'password', bool $plain = true) : bool
		{
			if($type == 'password')
			{
				if (password_verify(($plain ? hash_hmac('sha256', $input_string, RED_SALT) : $input_string), $db_string))
					return TRUE;
				else
					return FALSE;
			}
			else if($type == 'nonce')
			{
				if(($plain ? hash_hmac('sha1', $input_string, RED_NONCE) : $input_string) == $db_string)
					return TRUE;
				else
					return FALSE;
			}
			else if($type == 'token')
			{
				if(($plain ? hash_hmac('sha256', $input_string, RED_SESSION) : $input_string) == $db_string)
					return TRUE;
				else
					return FALSE;
			}
		}

		/**
		* is_admin
		* Verifies that the user has administrator rights based on the session and database
		*
		* @access   public
		* @return   bool   true/false
		*/
		public function is_admin() : bool
		{
			if($this->is_admin == NULL)
			{
				$this->is_admin = FALSE;

				if(isset($_SESSION['l'], $_SESSION['u'], $_SESSION['t'], $_SESSION['r']))
				{
					$user = $this->DB['users']->get(filter_var($_SESSION['u'], FILTER_SANITIZE_STRING));

					if($user->role != NULL)
						if($user->role == $_SESSION['r'])
							if($user->role == 'admin')
								$this->is_admin = TRUE;
				}
			}

			if($this->is_admin)
				return TRUE;
			else
				return FALSE;
		}

		/**
		* is_admin
		* Verifies that the user has administrator or manager rights based on the session and database
		*
		* @access   public
		* @return   bool   true/false
		*/
		public function is_manager() : bool
		{
			if($this->is_manager == NULL)
			{
				$this->is_manager = FALSE;

				if(isset($_SESSION['l'], $_SESSION['u'], $_SESSION['t'], $_SESSION['r']))
				{
					$user = $this->DB['users']->get(filter_var($_SESSION['u'], FILTER_SANITIZE_STRING));

					if($user->role != NULL)
						if($user->role == $_SESSION['r'])
							if($user->role == 'admin' || $user->role == 'manager')
								$this->is_manager = TRUE;
				}
			}

			if($this->is_manager)
				return TRUE;
			else
				return FALSE;
		}

		/**
		* include
		* Loads the desired file
		*
		* @access   public
		* @return   file content
		*/
		public function include($path) : int
		{
			if (!is_file($path))
				exit(RED_DEBUG ? 'The '.$path.' file was not found!' : '');
			
			return require_once($path);
		}
	}
?>
