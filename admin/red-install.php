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
			if (empty($_SERVER['HTTPS']))
				$HTTP = 'http://';
			else
				$HTTP = 'https://';
			
			$this->request_uri = self::urlFix($HTTP.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			if (self::urlSlash($this->request_uri,'/') == false) 
				$this->request_uri = $this->request_uri."/";


			$this->script_uri = self::urlFix($HTTP.$_SERVER['HTTP_HOST'].dirname($_SERVER["SCRIPT_NAME"]));
			if (self::urlSlash($this->script_uri,'/') == false) 
				$this->script_uri = $this->script_uri."/";

			if(!isset($_POST['action']))
				if($this->script_uri != $this->request_uri)
					exit(header("Location: " . $this->script_uri));

			if(isset($_POST['action']))
			{

				self::htaccess(
					filter_var($_POST['refFolder'], FILTER_SANITIZE_STRING)
				);

				/** Password hash type */
				if(defined('PASSWORD_ARGON2ID'))
					define('RED_ALGO', PASSWORD_ARGON2ID);
				else if(defined('PASSWORD_ARGON2I'))
					define('RED_ALGO', PASSWORD_ARGON2I);
				else if(defined('PASSWORD_BCRYPT'))
					define('RED_ALGO', PASSWORD_BCRYPT);
				else if(defined('PASSWORD_DEFAULT'))
					define('RED_ALGO', PASSWORD_DEFAULT);

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
					filter_var($_POST['defaultUrl'], FILTER_SANITIZE_URL)
				);

				exit('success');

			}
			else
			{
				if (is_file(ADMPATH.'theme/red-install.php')) {
					require_once(ADMPATH.'theme/red-install.php');
				}
				else
				{
					exit('Fatal error');
				}
			}
		}

		function urlSlash($FullStr, $needle)
		{
			$StrLen = strlen($needle);
			$FullStrEnd = substr($FullStr, strlen($FullStr) - $StrLen);
			return $FullStrEnd == $needle;
		}

		function urlFix($p)
		{
			$p = str_replace('\\','/',trim($p));
			return (substr($p,-1)!='/') ? $p.='/' : $p;
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

				//Salts
				$config = str_replace(array(
					'example_salt',
					'example_session_salt',
					'example_nonce_salt'
				), array(
					$this->salt,
					self::salter(50),
					self::salter(50)),
				$config);



				//Cryptographic
				switch (RED_ALGO) {
					case 1: //PASSWORD_BCRYPT
						$crypto = 'PASSWORD_BCRYPT';
						break;
					case 2: //PASSWORD_ARGON2I
						$crypto = 'PASSWORD_ARGON2I';
						break;
					case 3: //PASSWORD_ARGON2ID
						$crypto = 'PASSWORD_ARGON2ID';
						break;
					default: //PASSWORD_DEFAULT
						$crypto = 'PASSWORD_DEFAULT';
						break;
				}
				$config = str_replace(
					'PASSWORD_DEFAULT',
					$crypto,
				$config);

				//Databases
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

			if($dir == '/')
				$dir = '';

			$htaccess  = "";
			$htaccess .= "Options All -Indexes\n\n";
			$htaccess .= "<IfModule mod_rewrite.c>\n";
			$htaccess .= "RewriteEngine On\nRewriteBase /\nRewriteCond %{REQUEST_URI} ^(.*)$\nRewriteCond %{REQUEST_FILENAME} !-f\n";
			$htaccess .= "RewriteRule .* $dir/index.php [L]\n</IfModule>";

			$path = ABSPATH.'.htaccess';
			file_put_contents($path, $htaccess);
		}

		private function database($users, $records, $options, $defUser, $defPass, $defUrl)
		{
			/** Get database file */
			if (is_file(ADMPATH.'db/red-db.php'))
				require_once(ADMPATH.'db/red-db.php');
			else
				exit('error_2');

			$db = new \Filebase\Database([
				'dir'            => $this->dbpath.$options,
				'backupLocation' => $this->dbpath.$options.'/backup',
				'format'         => \Filebase\Format\Jdb::class,
				'cache'          => true,
				'cache_expires'  => 1800
			]);
			
			$option = $db->get('siteurl');
			$option->save(['value' => $defUrl]);

			$option = $db->get('dashboard');
			$option->save(['value' => $defUrl.'dashboard/']);

			$option = $db->get('redirect_404');
			$option->save(['value' => false]);
			$option = $db->get('redirect_404_url');
			$option->save(['value' => '']);

			$option = $db->get('redirect_home');
			$option->save(['value' => false]);
			$option = $db->get('redirect_home_url');
			$option->save(['value' => '']);

			$option = $db->get('cache_redirects');
			$option->save(['value' => true]);

			$option = $db->get('redirect_ssl');
			$option->save(['value' => false]);
			$option = $db->get('dashboard_ssl');
			$option->save(['value' => false]);

			$option = $db->get('js_redirect');
			$option->save(['value' => false]);
			$option = $db->get('gtag');
			$option->save(['value' => '']);
			$option = $db->get('js_redirect_after');
			$option->save(['value' => 0]);

			$option = $db->get('captcha_site');
			$option->save(['value' => '']);
			$option = $db->get('captcha_secret');
			$option->save(['value' => '']);

			$option = $db->get('language_type');
			$option->save(['value' => 1]);
			$option = $db->get('language_select');
			$option->save(['value' => 'en']);

			$db = new \Filebase\Database([
				'dir'            => $this->dbpath.$records,
				'backupLocation' => $this->dbpath.$records.'/backup',
				'format'         => \Filebase\Format\Jdb::class,
				'cache'          => true,
				'cache_expires'  => 1800
			]);

			$record = $db->get('EZK8H3');
			$record->url = 'https://github.com/rapiddev/forward';
			$record->clicks = 0;
			$record->save();
			$record = $db->get('QUBSE0');
			$record->url = 'https://rdev.cc/';
			$record->clicks = 0;
			$record->save();
			$record = $db->get('M6GMLO');
			$record->url = 'https://4geek.co/';
			$record->clicks = 0;
			$record->save();


			$db = new \Filebase\Database([
				'dir'            => $this->dbpath.$users,
				'backupLocation' => $this->dbpath.$users.'/backup',
				'format'         => \Filebase\Format\Jdb::class
			]);

			$user = $db->get($defUser);
			$user->email = $defUser.'@'.$_SERVER['HTTP_HOST'];
			$user->role = 'admin';
			$user->password = password_hash(hash_hmac('sha256', $defPass, $this->salt), RED_ALGO);
			$user->save();
		}
	}

	RED_INSTALL::init();
	exit;
?>