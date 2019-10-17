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
					if(defined('RED_DASHBOARD'))
					{
						if(RED_DASHBOARD == 'users'){
							echo 'users';
						}else if(RED_DASHBOARD == 'signout'){
							echo 'signout';
						}else{
							$this->page(['title' => 'Dashboard page not found']);
						}
					}else{
						self::admin();
					}
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
			if (is_file(ADMPATH.'theme/red-admin.php'))
				require_once(ADMPATH.'theme/red-admin.php');
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

		public static function error_404()
		{
			if(is_file(ADMPATH.'theme/red-404.php'))
				exit(require_once(ADMPATH.'theme/red-404.php'));
			else
				exit(RED_DEBUG ? 'The red-404.php file was not found!' : '');
		}

		public static function error($id, $title)
		{

		}
	}

	class RED_PAGES
	{
		private $title;
		private $uri;

		private $DB;

		public function __construct($data, $db)
		{	
			$this->DB = $db;

			if(isset($data['page']))
				$page = $data['page'];
			else
				$page = '404';

			if(isset($data['title']))
				$this->title = $data['title'];
			else
				$this->title = NULL;

			if (is_file(ADMPATH.'theme/red-'.$page.'.php'))
				require_once(ADMPATH.'theme/red-'.$page.'.php');
			else
				echo 'Page file not found';
		}

		private function home_url()
		{
			if($this->uri == null)
				$this->uri = $this->DB['options']->get('siteurl')->value;

			return $this->uri;
		}

		private function title()
		{
			return RED_NAME . ($this->title != null ? ' | '.$this->title : '');
		}

		private function head()
		{
			if (is_file(ADMPATH.'theme/red-head.php'))
				require_once(ADMPATH.'theme/red-head.php');
			else
				echo 'Header file not found';
		}

		public function footer()
		{
			if (is_file(ADMPATH.'theme/red-footer.php'))
				require_once(ADMPATH.'theme/red-footer.php');
			else
				echo 'Footer file not found';

			exit;
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
