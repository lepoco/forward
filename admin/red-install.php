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

	class RED_INSTALL
	{
		private $request_uri;
		private $script_uri;
		private $dbpath;
		private $salt;

		public static function init()
		{
			return new RED_INSTALL();
		}
		public function __construct()
		{
			$this->script_uri = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER["SCRIPT_NAME"]).'/';
			$this->request_uri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			if(!isset($_POST['action'])){
				if($this->script_uri != $this->request_uri)
					exit(header("Location: " . $this->script_uri));
			}

			if(isset($_POST['action'])){

				self::htaccess(
					filter_var($_POST['refFolder'], FILTER_SANITIZE_STRING)
				);

				self::config(
					filter_var($_POST['usersDB'], FILTER_SANITIZE_STRING),
					filter_var($_POST['recordsDB'], FILTER_SANITIZE_STRING),
					filter_var($_POST['optionsDB'], FILTER_SANITIZE_STRING)
				);

				$this->dbpath = ADMPATH.'db/';

				self::database(
					filter_var($_POST['usersDB'], FILTER_SANITIZE_STRING),
					filter_var($_POST['recordsDB'], FILTER_SANITIZE_STRING),
					filter_var($_POST['optionsDB'], FILTER_SANITIZE_STRING),
					filter_var($_POST['defUser'], FILTER_SANITIZE_STRING),
					filter_var($_POST['defPassw'], FILTER_SANITIZE_STRING),
					filter_var($_POST['defaultUrl'], FILTER_SANITIZE_URL),
				);

				exit('success');

			}else{
				if (is_file(ADMPATH.'theme/red-install.php')) {
					require_once(ADMPATH.'theme/red-install.php');
				}else{
					exit('Fatal error');
				}
			}
		}

		private function salter($length)
		{
			$characters = '$/.0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {$randomString .= $characters[rand(0, 64)];}
			return $randomString;
		}

		private function config($db_users, $db_records, $db_options)
		{
			if (is_file(ADMPATH.'red-config-sample.php'))
			{
				$config = file_get_contents( ADMPATH . 'red-config-sample.php' );

				$this->salt = self::salter(50);

				$config = str_replace(array(
					'example_salt',
					'example_session_salt',
					'example_nonce_salt'
				), array(
					$this->salt,
					self::salter(50),
					self::salter(50)),
				$config);

				$config = str_replace(array(
					'users_database',
					'options_database',
					'records_database'
				), array(
					$db_users,
					$db_options,
					$db_records),
				$config);
				
				file_put_contents(ADMPATH.'red-config.php', $config);
			}else{
				exit('error_1');
			}
		}

		private function htaccess($dir = 'forward/')
		{
			$htaccess  = "";
			$htaccess .= "Options All -Indexes\n\n<Files \"*.json\">\nOrder Deny,Allow\nDeny from all\n</Files>\n\n";
			$htaccess .= "<IfModule mod_rewrite.c>\n";
			$htaccess .= "RewriteEngine On\nRewriteBase /\nRewriteCond %{REQUEST_URI} ^(.*)$\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_URI} !\.(css|gif|ico|jpg|js|png|swf|txt|webp)$\n";
			$htaccess .= "RewriteRule .* $dir/index.php [L]\n</IfModule>";

			$path = ABSPATH.'.htaccess';
			file_put_contents($path, $htaccess);
		}

		private function database($users, $records, $options, $defUser, $defPass, $defUrl)
		{
			if (is_file(ADMPATH.'db/red-db.php'))
				require_once(ADMPATH.'db/red-db.php');
			else
				exit('error_2');

			$db = new \Filebase\Database([
				'dir'            => $this->dbpath.$options,
				'backupLocation' => $this->dbpath.$options.'/backup',
				'format'         => \Filebase\Format\Jdb::class,
				'cache'          => true,
				'cache_expires'  => 1800,
				'pretty'         => true,
				'safe_filename'  => true,
				'read_only'      => false,
				'validate' => [
					'value'   => [
						'valid.type' => 'string',
						'valid.required' => true
					]
				]
			]);

			$item = $db->get('siteurl');
			$item->value = $defUrl;
			$item->save();
			$item = $db->get('dashboard');
			$item->value = $defUrl.'dashboard/';
			$item->save();

			$db = new \Filebase\Database([
				'dir'            => $this->dbpath.$records,
				'backupLocation' => $this->dbpath.$records.'/backup',
				'format'         => \Filebase\Format\Jdb::class,
				'cache'          => true,
				'cache_expires'  => 1800,
				'pretty'         => true,
				'safe_filename'  => true,
				'read_only'      => false,
				'validate' => [
					'url'   => [
						'valid.type' => 'string',
						'valid.required' => true
					],
					'timestamp'   => [
						'valid.type' => 'string',
						'valid.required' => false
					],
					'clicks'   => [
						'valid.type' => 'int',
						'valid.required' => false
					],
					'referrers'   => [
						'valid.type' => 'string',
						'valid.required' => false
					],
					'locations'   => [
						'valid.type' => 'string',
						'valid.required' => false
					]
				]
			]);

			$item = $db->get('1ul24f');
			$item->url = 'https://github.com/rapiddev/forward';
			$item->clicks = 0;
			$item->save();
			$item = $db->get('m21n37');
			$item->url = 'https://rdev.cc/';
			$item->clicks = 0;
			$item->save();
			$item = $db->get('0m31n2');
			$item->url = 'https://4geek.co/';
			$item->clicks = 0;
			$item->save();


			$db = new \Filebase\Database([
				'dir'            => $this->dbpath.$users,
				'backupLocation' => $this->dbpath.$users.'/backup',
				'format'         => \Filebase\Format\Jdb::class,
				'cache'          => true,
				'cache_expires'  => 1800,
				'pretty'         => true,
				'safe_filename'  => true,
				'read_only'      => false,
				'validate' => [
					'password'   => [
						'valid.type' => 'string',
						'valid.required' => true
					],
					'token'   => [
						'valid.type' => 'string',
						'valid.required' => false
					],
					'lastlogin'   => [
						'valid.type' => 'string',
						'valid.required' => false
					],
					'email'   => [
						'valid.type' => 'string',
						'valid.required' => false
					]
				]
			]);

			$item = $db->get($defUser);
			$item->email = $defUser.'@'.$_SERVER['HTTP_HOST'];
			$item->password = password_hash(hash_hmac('sha256', $defPass, $this->salt), PASSWORD_ARGON2ID);
			$item->save();
		}
	}

	RED_INSTALL::init();
	exit;
?>