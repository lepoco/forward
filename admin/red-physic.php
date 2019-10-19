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

		public $DB;

		public function __construct()
		{
			$this->DB = array(
				'options' => new \Filebase\Database(['dir' => DB_PATH.DB_OPTIONS,'format' => \Filebase\Format\Jdb::class]),
				'records' => new \Filebase\Database(['dir' => DB_PATH.DB_RECORDS,'format' => \Filebase\Format\Jdb::class])
			);

			switch (RED_PAGE) {
				case 'dashboard':
					$this->DB['users'] = new \Filebase\Database(['dir' => DB_PATH.DB_USERS,'format' => \Filebase\Format\Jdb::class]);
					self::admin();
					break;
				case 'home':
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

		public function page($data)
		{
			return new RED_PAGES($data, $this->DB);
		}

		private function admin()
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

		private function forward()
		{	

			$record = $this->DB['records']->get(RED_PAGE);

			if($record->url == NULL)
				$this->page(['title' => 'Page not found']);

			$lang = self::parseLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
			
			if(is_array($record->locations))
			{
				if(array_key_exists($lang, $record->locations))
				{
					$record->locations[$lang] += 1;
				}
				else
				{
					$record->locations[$lang] = 1;
				}
			}
			else
			{
				$record->locations = array($lang => 1);
			}


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

			$record->clicks = $record->clicks + 1;
			$record->save();

			//Redirect
			header("Location: " . $record->url);
			exit;	
		}

		private function parseLanguage()
		{
			$langs = array();
			preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]), $matches, PREG_SET_ORDER);

			foreach($matches as $match)
			{
				list($a, $b) = explode('-', $match[1]) + array('', '');
				$value = isset($match[2]) ? (float) $match[2] : 1.0;
				$langs[$match[1]] = $value;

			}
			arsort($langs);

			if(count($langs) == 0){
				return 'unknown';
			}else{
				return array_key_first($langs);
			}
		}

		private function parse_url()
		{
			$URI = explode("/", $_SERVER['REQUEST_URI']);
			$this->page = $URI[2];
		}

		public static function rand($length)
		{
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {$randomString .= $characters[rand(0, 35)];}
			return $randomString;
		}

		public static function encrypt($string, $type = 'password')
		{
			if($type == 'password')
			{
				return password_hash(hash_hmac('sha256', $string, RED_SALT), PASSWORD_ARGON2ID);
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

		public static function compare_crypt($input_string, $db_string, $type = 'password', $plain = true)
		{

			if($type == 'password')
			{
				if (password_verify(($plain ? hash_hmac('sha256', $input_string, RED_SALT) : $input_string), $db_string))
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else if($type == 'nonce')
			{
				if(($plain ? hash_hmac('sha1', $input_string, RED_NONCE) : $input_string) == $db_string)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else if($type == 'token')
			{
				if(($plain ? hash_hmac('sha256', $input_string, RED_SESSION) : $input_string) == $db_string)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}

		private function include($path)
		{
			if (is_file($path))
				return require_once(ADMPATH.'red-admin.php');
			else
				exit(RED_DEBUG ? 'The '.$path.' file was not found!' : '');
		}

		private function error($id, $title)
		{

		}
	}
?>
