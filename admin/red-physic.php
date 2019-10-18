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

		private $DB;

		public function __construct()
		{
			$this->DB = array(
				'options' => new \Filebase\Database(['dir' => DB_PATH.DB_OPTIONS]),
				'records' => new \Filebase\Database(['dir' => DB_PATH.DB_RECORDS])
			);

			switch (RED_PAGE) {
				case 'dashboard':
					$this->DB['users'] = new \Filebase\Database(['dir' => DB_PATH.DB_USERS]);
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
				require_once(ADMPATH.'red-admin.php');
			else
				$this->page(['title' => 'Page not found']);
		}

		private function ajax()
		{
			if (isset($_POST['action']))
			{
				exit;
			}else{
				exit(header("Location: " . $this->DB['options']->get('siteurl')->value));
			}
		}

		private function signout()
		{
			exit('signed out');
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
