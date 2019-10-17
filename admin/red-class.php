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

	function RED()
	{
		return new RED();
	}

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

			self::parse_url();

			$this->uri = $this->DB['options']->get('siteurl')->value;

			if($this->page == 'admin'){
				$this->DB['users'] = new \Filebase\Database(['dir' => DB_PATH.DB_USERS]);
				self::admin();
			}else if($this->page == 'ajax'){
				self::ajax();
			}else{
				self::forward();
			}
		}

		private function init()
		{
			$item = $this->DB['options']->get('siteurl');

			if($item->value == ''){
				$db = new \Filebase\Database([
					'dir'            => DB_PATH.DB_OPTIONS,
					'backupLocation' => DB_PATH.DB_OPTIONS.'/backup',
					'format'         => \Filebase\Format\Json::class,
					'cache'          => true,
					'cache_expires'  => 1800,
					'pretty'         => true,
					'safe_filename'  => true,
					'read_only'      => false,
					'validate' => [
						'name'   => [
							'valid.type' => 'string',
							'valid.required' => true
						],
						'value'   => [
							'valid.type' => 'string',
							'valid.required' => true
						]
					]
				]);
				$db = new \Filebase\Database([
					'dir'            => DB_PATH.DB_RECORDS,
					'backupLocation' => DB_PATH.DB_RECORDS.'/backup',
					'format'         => \Filebase\Format\Json::class,
					'cache'          => true,
					'cache_expires'  => 1800,
					'pretty'         => true,
					'safe_filename'  => true,
					'read_only'      => false,
					'validate' => [
						'name'   => [
							'valid.type' => 'string',
							'valid.required' => true
						],
						'url'   => [
							'valid.type' => 'string',
							'valid.required' => true
						],
						'timestamp'   => [
							'valid.type' => 'string',
							'valid.required' => true
						],
						'clicks'   => [
							'valid.type' => 'int',
							'valid.required' => true
						],
						'referrers'   => [
							'valid.type' => 'string',
							'valid.required' => true
						],
						'locations'   => [
							'valid.type' => 'string',
							'valid.required' => true
						]
					]
				]);
				$db = new \Filebase\Database([
					'dir'            => DB_PATH.DB_USERS,
					'backupLocation' => DB_PATH.DB_USERS.'/backup',
					'format'         => \Filebase\Format\Json::class,
					'cache'          => true,
					'cache_expires'  => 1800,
					'pretty'         => true,
					'safe_filename'  => true,
					'read_only'      => false,
					'validate' => [
						'name'   => [
							'valid.type' => 'string',
							'valid.required' => true
						],
						'password'   => [
							'valid.type' => 'string',
							'valid.required' => true
						],
						'email'   => [
							'valid.type' => 'string',
							'valid.required' => true
						]
					]
				]);
				$this->DB['options'] = new \Filebase\Database(['dir' => DB_PATH.DB_OPTIONS]);
				$item = $this->DB['options']->get('siteurl');
				$item->value = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$item->save();

				$this->DB['users'] = new \Filebase\Database(['dir' => DB_PATH.DB_USERS]);
				$item = $this->DB['users']->get('admin');
				$item->password = 'admin';
				$item->email = 'admin@example.com';
				$item->save();

				$this->DB['records'] = new \Filebase\Database(['dir' => DB_PATH.DB_RECORDS]);
				$item = $this->DB['records']->get('sample');
				$item->url = 'https://rdev.cc/';
				$item->clicks = 1;
				$item->save();
			}
		}

		public function hook()
		{
			return new $HOOK;
		}

		public function page($data)
		{
			return new RED_PAGES($data, $this->uri);
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
			
		}

		private function forward()
		{
			$record = $this->DB['records']->get($this->page);

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
				exit('Fatal error');
		}

		public static function error($id, $title)
		{

		}
	}

	class RED_PAGES
	{
		private $title;
		private $uri;

		public function __construct($data, $uri)
		{	
			$this->uri = $uri;

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
