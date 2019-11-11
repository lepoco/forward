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
	* RED_INSTALL
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @version  $Id: red-install.php;RED_INSTALL,v beta 1.0 2019/10/27
	* @access   public
	*/
	class RED_INSTALL
	{
		private $request_uri;
		private $script_uri;
		private $dbpath;
		private $salt;

		/**
		* init
		* Returns the RED_INSTALL object without initializing the object
		*
		* @access   public
		* @return   object RED_INSTALL
		*/
		public static function init() : RED_INSTALL
		{
			return new RED_INSTALL();
		}

		/**
		* __construct
		* Installs the necessary components
		*
		* @access   public
		* @return   void
		*/
		public function __construct()
		{
			$HTTP = 'https://';
			if (empty($_SERVER['HTTPS']))
				$HTTP = 'http://';

			self::check_files();
			
			$this->request_uri = self::urlFix($HTTP.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			$this->script_uri = self::urlFix($HTTP.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));

			if(!isset($_POST['action']))
				if($this->script_uri != $this->request_uri)
					exit(header('Location: ' . $this->script_uri));

			if(isset($_POST['action']))
				self::do_install();
			else
				self::display_page();
		}

		/**
		* do_install
		* Performs the necessary installation steps
		*
		* @return void
		*/
		private function do_install() : void
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

		/**
		* display_page
		* Displays the installation page
		*
		* @return void
		*/
		private function display_page() : void
		{
			require_once(ADMPATH.'theme/red-install.php');
		}

		/**
		* check_files
		* Checks if the files already exist
		*
		* @return void
		*/
		private function check_files() : void
		{
			if (!is_file(ADMPATH.'theme/red-install.php'))
				exit('File red-install.php.php does not exist. This file is required for installation.');

			if (!is_file(ADMPATH.'red-config-sample.php'))
				exit('File red-config-sample.php does not exist. This file is required for installation.');

			if (!is_file(ADMPATH.'db/red-db.php'))
				exit('File db/red-db.php does not exist. This file is required for installation.');

			if (is_file(ABSPATH.'.htaccess'))
				exit('File .htaccess exists. Remove it to complete the installation.');

			if (is_file(ADMPATH.'red-config.php'))
				exit('File red-config.php exists. Remove it to complete the installation.');
		}

		/**
		* urlFix
		* Removes unnecessary parentheses and validates the url
		*
		* @access   private
		* @param	string $p
		* @return   string $p
		*/
		private function urlFix(string $p) : string
		{
			$p = str_replace('\\','/',trim($p));
			return (substr($p,-1)!='/') ? $p.='/' : $p;
		}

		/**
		* salter
		* Generates random salt
		*
		* @access   private
		* @param	string $length
		* @return   string $randomString
		*/
		private function salter(int $length) : string
		{
			$characters = '$/.0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {$randomString .= $characters[rand(0, 64)];}
			return $randomString;
		}

		/**
		* config
		* Creates a red-config.php file
		*
		* @access   private
		* @param	string $db_users
		* @param	string $db_records
		* @param	string $db_options
		* @return   void
		*/
		private function config(string $db_users, string $db_records, string $db_options) : void
		{
			$config = file_get_contents( ADMPATH . 'red-config-sample.php' );

			$this->salt = self::salter(60);

			//Salts
			$config = str_replace(array(
				'example_salt',
				'example_session_salt',
				'example_nonce_salt'
			), array(
				$this->salt,
				self::salter(60),
				self::salter(60)),
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
		}

		/**
		* htaccess
		* Creates a .htaccess file
		*
		* @access   private
		* @param	string $dir
		* @return   void
		*/
		private function htaccess(string $dir = 'forward/') : void
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

		/**
		* database
		* Adds all necessary information to the database
		*
		* @access   private
		* @param	string $users
		* @param	string $records
		* @param	string $options
		* @param	string $defUser
		* @param	string $defPass
		* @param	string $defUrl
		* @return   void
		*/
		private function database(string $users, string $records, string $options, string $defUser, string $defPass, string $defUrl) : void
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
			
			$db_record = $db->get('siteurl');
			$db_record->save(['value' => $defUrl]);

			$db_record = $db->get('dashboard');
			$db_record->save(['value' => $defUrl.'dashboard/']);

			$db_record = $db->get('redirect_404');
			$db_record->save(['value' => false]);
			$db_record = $db->get('redirect_404_url');
			$db_record->save(['value' => '']);

			$db_record = $db->get('redirect_home');
			$db_record->save(['value' => false]);
			$db_record = $db->get('redirect_home_url');
			$db_record->save(['value' => '']);

			$db_record = $db->get('cache_redirects');
			$db_record->save(['value' => true]);

			$db_record = $db->get('redirect_ssl');
			$db_record->save(['value' => false]);
			$db_record = $db->get('dashboard_ssl');
			$db_record->save(['value' => false]);

			$db_record = $db->get('js_redirect');
			$db_record->save(['value' => false]);
			$db_record = $db->get('gtag');
			$db_record->save(['value' => '']);
			$db_record = $db->get('js_redirect_after');
			$db_record->save(['value' => 0]);

			$db_record = $db->get('captcha_site');
			$db_record->save(['value' => '']);
			$db_record = $db->get('captcha_secret');
			$db_record->save(['value' => '']);

			$db_record = $db->get('language_type');
			$db_record->save(['value' => 1]);
			$db_record = $db->get('language_select');
			$db_record->save(['value' => 'en']);

			$db = new \Filebase\Database([
				'dir'            => $this->dbpath.$records,
				'backupLocation' => $this->dbpath.$records.'/backup',
				'format'         => \Filebase\Format\Jdb::class,
				'cache'          => true,
				'cache_expires'  => 1800
			]);

			$db_record = $db->get('ezk8h3');
			$db_record->save(['name' => 'EZK8H3', 'url' => 'https://github.com/rapiddev/forward', 'clicks' => 0]);
			$db_record = $db->get('qubse0');
			$db_record->save(['name' => 'QUBSE0', 'url' => 'https://rdev.cc/', 'clicks' => 0]);
			$db_record = $db->get('m6gmlo');
			$db_record->save(['name' => 'M6GMLO', 'url' => 'https://4geek.co/', 'clicks' => 0]);

			$db = new \Filebase\Database([
				'dir'            => $this->dbpath.$users,
				'backupLocation' => $this->dbpath.$users.'/backup',
				'format'         => \Filebase\Format\Jdb::class
			]);

			$db_record = $db->get($defUser);
			$db_record->email = $defUser.'@'.$_SERVER['HTTP_HOST'];
			$db_record->role = 'admin';
			$db_record->password = password_hash(hash_hmac('sha256', $defPass, $this->salt), RED_ALGO);
			$db_record->save();
		}
	}

	RED_INSTALL::init();
	exit;
?>