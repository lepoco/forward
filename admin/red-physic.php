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

	class RED
	{
		private $page;
		private $uri;

		private $is_manager;
		private $is_admin;

		public $DB;

		public function __construct()
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

			self::https();

			switch (RED_PAGE)
			{
				case '_forward_dashboard':
					$this->DB['users'] = new \Filebase\Database([
						'dir' => DB_PATH.DB_USERS,
						'backupLocation' => DB_PATH.DB_USERS.'/backup',
						'format' => \Filebase\Format\Jdb::class
					]);
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

		public function page(array $data) : RED_PAGES
		{
			/** Display page class */
			if (is_file(ADMPATH.'red-page.php'))
				require_once(ADMPATH.'red-page.php');
			else
				exit(RED_DEBUG ? 'The red-page.php file was not found!' : '');
			
			return new RED_PAGES($data, $this);
		}

		private function admin() : void
		{
			if (is_file(ADMPATH.'red-admin.php'))
			{
				require_once(ADMPATH.'red-admin.php');
				RED_ADMIN::init($this);
			}
			else
			{
				$this->page(['title' => 'Page not found']);
			}
		}

		private function forward() : void
		{
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

		private function parse_url() : void
		{
			$URI = explode("/", $_SERVER['REQUEST_URI']);
			$this->page = $URI[2];
		}

		public static function rand(int $length) : string
		{
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {$randomString .= $characters[rand(0, 35)];}
			return $randomString;
		}

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

		public function include($path) : object
		{
			if (is_file($path))
				return require_once($path);
			else
				exit(RED_DEBUG ? 'The '.$path.' file was not found!' : '');
		}
	}
?>
