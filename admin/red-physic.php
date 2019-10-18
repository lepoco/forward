<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

	namespace Forward;

	class RED
	{
		private $page;
		private $uri;

		private $HOOK;
		private $DB;

		public function __construct()
		{
			$HOOK = new RED_HOOK();

			$this->DB = array(
				'options' => new \Filebase\Database(['dir' => DB_PATH.DB_OPTIONS]),
				'records' => new \Filebase\Database(['dir' => DB_PATH.DB_RECORDS])
			);

			self::init();

			switch (RED_PAGE) {
				case 'home':
					$this->page(['title' => 'Home page', 'page' => 'home']);
					break;
				case 'dashboard':
					$this->DB['users'] = new \Filebase\Database(['dir' => DB_PATH.DB_USERS]);
					self::admin();
					break;
				case 'ajax':
					self::ajax();
					break;
				case '404':
					$this->page(['title' => 'Page not found']);
					break;
				default:
					self::forward();
					break;
			}
		}

		private function init()
		{
			$item = $this->DB['options']->get('siteurl');

			if($item->value == '')
			{
				if (is_file(ADMPATH.'red-install.php'))
					require_once(ADMPATH.'red-install.php');
			else
				$this->page(['title' => 'Page not found']);
			}
		}

		public function hook()
		{
			return new $HOOK;
		}

		public function page($data)
		{
			return new RED_PAGES($data, $this->DB);
		}

		private function admin()
		{
			if (is_file(ADMPATH.'red-admin.php'))
				require_once(ADMPATH.'red-admin.php');
			else
				$this->page(['title' => 'Page not found']);
		}

		private function ajax()
		{
			if (isset($_GET['query']))
			{
				exit;
			}else{
				header("Location: " . $this->uri);
				exit;
			}
		}

		private function forward()
		{
			$record = $this->DB['records']->get(RED_PAGE);

			if($record->url == NULL)
				$this->page(['title' => 'Page not found']);

			$record->clicks = $record->clicks + 1;
			$record->save();

			//Redirect
			header("Location: " . $record->url);
			exit;	
		}

		private function parse_url()
		{
			$URI = explode("/", $_SERVER['REQUEST_URI']);
			$this->page = $URI[2];
		}

		private function encrypt($string, $type = 'password')
		{
			if($type == 'password')
			{
				return password_hash(hash_hmac('sha256', $string, RED_SALT), PASSWORD_ARGON2ID);
			}
		}

		private function compare_crypt($input_string, $db_string, $type = 'password', $plain = true)
		{

			if($type == 'password')
			{
				if (password_verify(($plain ? hash_hmac('sha256', $input_string, RED_SALT) : $input_string), $db_string))
				{
					return TRUE;
				}else{
					return FALSE;
				}
			}
		}

		public static function error($id, $title)
		{

		}
	}

	class RED_HOOK
	{
		public function __construct()
		{

		}

		public function add($name)
		{
			echo $name;
		}

		public function do()
		{

		}
	}
?>