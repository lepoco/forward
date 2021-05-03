<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

namespace Forward;

defined('ABSPATH') or die('No script kiddies please!');

use Mysqli;

/**
 *
 * Model [Install]
 *
 * @author   Leszek Pomianowski <https://rdev.cc>
 * @license	MIT License
 * @access   public
 */
class Model extends Models
{
	/**
	 * Get
	 * Get install form
	 *
	 * @access   private
	 */
	public function Get()
	{
		$this->InstallForm();
		exit;
	}

	/**
	 * Post
	 * Get install form
	 *
	 * @access   private
	 */
	public function Post()
	{
		$this->InstallForm();
		exit;
	}

	/**
	 * InstallForm
	 * Parse and verify install form
	 *
	 * @access   private
	 */
	private function InstallForm()
	{
		$result = array(
			'status' => 'error',
			'message' => 'Something went wrong!'
		);

		if (!isset(
			$_POST['action'],
			$_POST['input_scriptname'],
			$_POST['input_baseuri'],
			$_POST['input_db_name'],
			$_POST['input_db_user'],
			$_POST['input_db_host'],
			$_POST['input_db_password'],
			$_POST['input_user_name'],
			$_POST['input_user_password']
		)) {
			$result['message'] = 'Missing fields';
			exit(json_encode($result));
		}

		if ($_POST['action'] != 'setup') {
			$result['message'] = 'Inavlid action';
			exit(json_encode($result));
		}

		if (trim($_POST['input_user_name']) === '') {
			$result['message'] = 'User name empty';
			exit(json_encode($result));
		}

		if (trim($_POST['input_user_password']) === '') {
			$result['message'] = 'Password empty';
			exit(json_encode($result));
		}

		if (trim($_POST['input_db_name']) === '') {
			$result['message'] = 'DB name empty';
			exit(json_encode($result));
		}

		if (trim($_POST['input_db_user']) === '') {
			$result['message'] = 'DB user empty';
			exit(json_encode($result));
		}

		if (trim($_POST['input_db_host']) === '') {
			$result['message'] = 'DB host empty';
			exit(json_encode($result));
		}

		//error_reporting(0);
		$database = new Mysqli($_POST['input_db_host'], $_POST['input_db_user'], $_POST['input_db_password'], $_POST['input_db_name']);
		if ($database->connect_error) {
			$result['message'] = 'Unable to connect to database';
			exit(json_encode($result));
		}

		$this->BuildResources($database, array(
			'path' => filter_var($_POST['input_scriptname'], FILTER_SANITIZE_STRING),
			'db_name' => filter_var($_POST['input_db_name'], FILTER_SANITIZE_STRING),
			'db_host' => filter_var($_POST['input_db_host'], FILTER_SANITIZE_STRING),
			'db_user' => filter_var($_POST['input_db_user'], FILTER_SANITIZE_STRING),
			'db_pass' => $_POST['input_db_password'],
			'baseuri' => filter_var($_POST['input_baseuri'], FILTER_SANITIZE_STRING),
			'user_name' => filter_var($_POST['input_user_name'], FILTER_SANITIZE_STRING),
			'user_pass' => $_POST['input_user_password'],
		));

		$result['status'] = 'success';
		exit(json_encode($result, JSON_UNESCAPED_UNICODE));
	}

	/**
	 * BuildResources
	 * Creates config file and database tables
	 *
	 * @param	Mysqli $database
	 * @param	array $args
	 * @access   private
	 */
	private function BuildResources($database, $args): void
	{
		$this->BuildHtaccess($args['path']);
		$this->BuildConfig($args);
		$this->BuildTables($database, $args);
	}

	/**
	 * SetAlgo
	 * Defines Password hash type
	 *
	 * @access   private
	 * @return   void
	 */
	private function SetAlgo(): string
	{
		/** Password hash type */
		if (defined('PASSWORD_ARGON2ID'))
			return 'PASSWORD_ARGON2ID';
		else if (defined('PASSWORD_ARGON2I'))
			return 'PASSWORD_ARGON2I';
		else if (defined('PASSWORD_BCRYPT'))
			return 'PASSWORD_BCRYPT';
		else if (defined('PASSWORD_DEFAULT'))
			return 'PASSWORD_DEFAULT';
	}

	/**
	 * BuildHtaccess
	 * Creates a .htaccess file
	 *
	 * @access   private
	 * @param	string $dir
	 * @return   void
	 */
	private function BuildHtaccess(string $dir = '/'): void
	{
		if ($dir == '/')
			$dir = '';

		$htaccess  = "";
		$htaccess .= "Options All -Indexes\n\n";
		$htaccess .= "<IfModule mod_rewrite.c>\n";
		$htaccess .= "RewriteEngine On\nRewriteBase /\nRewriteCond %{REQUEST_URI} ^(.*)$\nRewriteCond %{REQUEST_FILENAME} !-f\n";
		$htaccess .= "RewriteRule .* $dir/index.php [L]\n</IfModule>";

		if (PUBLIC_PATH == 'root')
			$path = ABSPATH . '.htaccess';
		else
			$path = ABSPATH . 'public/.htaccess';

		file_put_contents($path, $htaccess);
	}

	/**
	 * BuildConfig
	 * Creates config file
	 *
	 * @access   private
	 * @param	array $args
	 * @return   void
	 */
	private function BuildConfig($args): void
	{

		$config  = "";
		$config .= "<?php\n\n/**\n * @package Forward\n *\n * @author RapidDev\n * @copyright Copyright (c) 2019-" . date('Y') . ", RapidDev\n * @link https://www.rdev.cc/forward\n * @license https://opensource.org/licenses/MIT\n */\nnamespace Forward;\ndefined('ABSPATH') or die('No script kiddies please!');";

		$config .= "\n\n/** Passwords hash type */\ndefine( 'FORWARD_ALGO', " . $this->SetAlgo() . " );";

		$config .= "\n\n/** Database table */\ndefine( 'FORWARD_DB_NAME', '" . $args['db_name'] . "' );";
		$config .= "\n/** Database table */\ndefine( 'FORWARD_DB_HOST', '" . $args['db_host'] . "' );";
		$config .= "\n/** Database table */\ndefine( 'FORWARD_DB_USER', '" . $args['db_user'] . "' );";
		$config .= "\n/** Database table */\ndefine( 'FORWARD_DB_PASS', '" . $args['db_pass'] . "' );";

		$config .= "\n\n/** Session salt */\ndefine( 'SESSION_SALT', '" . Crypter::DeepSalter(64) . "' );";
		$config .= "\n/** Passowrd salt */\ndefine( 'PASSWORD_SALT', '" . Crypter::DeepSalter(64) . "' );";
		$config .= "\n/** Nonce salt */\ndefine( 'NONCE_SALT', '" . Crypter::DeepSalter(64) . "' );";

		$config .= "\n\n/** Debugging */\ndefine( 'FORWARD_DEBUG', false );";
		$config .= "\n";

		$path = APPPATH . 'config.php';
		file_put_contents($path, $config);
	}

	/**
	 * BuildTables
	 * Creates database tables
	 *
	 * @access   private
	 * @param	Mysqli $database
	 * @param	array $args
	 * @return   void
	 */
	private function BuildTables($database, $args): void
	{
		$database->set_charset('utf8');

		$dbFile = file(APPPATH . 'code/rdev-database.sql');
		$queryLine = '';

		// Loop through each line
		foreach ($dbFile as $line) {
			//Skip comments and blanks
			if (substr($line, 0, 2) == '--' || $line == '' || substr($line, 0, 1) == '#')
				continue;

			$queryLine .= $line;

			if (substr(trim($line), -1, 1) == ';') {
				$database->query($queryLine);
				$queryLine = '';
			}
		}

		$this->FillData($database, $args);
	}

	/**
	 * BuildTables
	 * Creates database tables
	 *
	 * @access   private
	 * @param	Mysqli $db
	 * @param	array $args
	 * @return   void
	 */
	private function FillData($database, $args)
	{
		//$stmt = $db->prepare("SELECT * FROM myTable WHERE name = ? AND age = ?");

		require_once APPPATH . 'config.php';

		//Static
		$database->query(
			"INSERT IGNORE INTO forward_options (option_name, option_value) VALUES " .
				"('version', '" . FORWARD_VERSION . "'), " .
				"('site_name', 'Forward'),  " .
				"('site_description', 'Create your own link shortener'),  " .
				"('dashboard', 'dashboard'),  " .
				"('login', 'login'),  " .
				"('timezone', 'UTC'), " .
				"('date_format', 'j F Y'), " .
				"('time_format', 'H:i'), " .
				"('record_date_format', 'j F Y'), " .
				"('charset', 'UTF8'), " .
				"('latest_visitors_limit', '200'), " .
				"('dashboard_links', '30'), " .
				"('dashboard_sort', 'date'), " .
				"('cache', 'false'), " .
				"('dashboard_gzip', 'false'),  " .
				"('dashboard_language', 'en_US'),  " .
				"('dashboard_language_mode', '1'),  " .
				"('dashboard_captcha', 'false'), " .
				"('dashboard_captcha_public', ''), " .
				"('dashboard_captcha_secret', ''), " .
				"('force_dashboard_ssl', 'false'), " .
				"('force_redirect_ssl', 'false'), " .
				"('store_ip_addresses', 'true'), " .
				"('non_existent_record', 'error404'), " .
				"('redirect_404', 'false'), " .
				"('redirect_404_direction', ''), " .
				"('redirect_home', 'false'), " .
				"('redirect_home_direction', ''), " .
				"('google_analytics', '2000'), " .
				"('js_redirect_after', '2000'), " .
				"('js_redirect', 'false')"
		);

		$q1 = Crypter::BaseSalter(5);
		$q2 = Crypter::BaseSalter(5);
		$q3 = Crypter::BaseSalter(5);
		$q4 = Crypter::BaseSalter(5);

		$database->query(
			"INSERT IGNORE INTO forward_records (record_name, record_display_name, record_url) VALUES " .
				"('" . strtolower($q1) . "', '" . strtoupper($q1) . "', 'https://github.com/rapiddev/Forward'), " .
				"('" . strtolower($q2) . "', '" . strtoupper($q2) . "', 'https://rdev.cc/'),  " .
				"('" . strtolower($q3) . "', '" . strtoupper($q3) . "', 'https://4geek.co/'),  " .
				"('" . strtolower($q4) . "', '" . strtoupper($q4) . "', 'https://lepo.co/')"
		);

		//Binded
		if ($query = $database->prepare("INSERT IGNORE INTO forward_options (option_name, option_value) VALUES ('base_url', ?)")) {
			$query->bind_param('s', $args['baseuri']);
			$query->execute();
		}

		if ($query = $database->prepare("INSERT IGNORE INTO forward_options (option_name, option_value) VALUES ('ssl', ?)")) {
			$ssl = $this->Forward->Path->ssl ? 'true' : 'false';
			$query->bind_param('s', $ssl);
			$query->execute();
		}

		if ($query = $database->prepare("INSERT IGNORE INTO forward_users (user_name, user_display_name, user_password, user_token, user_role, user_status) VALUES (?, ?, ?, ?, ?, ?)")) {

			$password = Crypter::Encrypt($args['user_pass'], 'password');
			$token = '';
			$role = 'admin';
			$status = 1;

			$query->bind_param(
				'ssssss',
				$args['user_name'],
				$args['user_name'],
				$password,
				$token,
				$role,
				$status
			);
			$query->execute();
		}

		$this->Forward->User->LogIn(array('user_id' => 1, 'user_role' => 'admin'));

		$database->close();
	}

	/**
	 * Footer
	 * Prints data in footer
	 *
	 * @access   private
	 */
	public function Footer()
	{
		//echo 'script';
	}
}
