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


	class RED_AJAX
	{
		private $RED;
		private $ACTION;
		private $NONCE;

		/** ERROR CODES */
		private const ERROR_MISSING_ACTION           = 'e01';
		private const ERROR_MISSING_NONCE            = 'e02';
		private const ERROR_INVALID_NONCE            = 'e03';
		private const ERROR_INVALID_ACTION           = 'e04';
		private const ERROR_INSUFFICIENT_PERMISSIONS = 'e05';
		private const ERROR_MISSING_ARGUMENTS        = 'e06';
		private const ERROR_EMPTY_ARGUMENTS          = 'e07';
		private const ERROR_ENTRY_EXISTS             = 'e08';
		private const ERROR_ENTRY_DONT_EXISTS        = 'e09';
		private const ERROR_INVALID_URL              = 'e10';
		private const ERROR_INVALID_PASSWORD         = 'e11';
		private const ERROR_PASSWORDS_DONT_MATCH     = 'e12';
		private const ERROR_PASSWORD_TOO_SHORT       = 'e13';
		private const ERROR_PASSWORD_TOO_SIMPLE      = 'e14';
		private const ERROR_INVALID_EMAIL            = 'e15';
		private const ERROR_SPECIAL_CHARACTERS       = 'e16';

		private const CODE_SUCCESS                   = 's01';

		public static function init($RED)
		{
			return new RED_AJAX($RED);
		}

		public function __construct($RED)
		{
			$this->RED = $RED;

			if (!isset($_POST['action']))
				exit(self::ERROR_MISSING_ACTION);
			else
				$this->ACTION = filter_var($_POST['action'], FILTER_SANITIZE_STRING);

			if (!isset($_POST['nonce']))
				exit(self::ERROR_MISSING_NONCE);
			else
				$this->NONCE = filter_var($_POST['nonce'], FILTER_SANITIZE_STRING);

			if(!self::verifyNonce())
				exit(self::ERROR_INVALID_NONCE);

			if(!self::checkAction())
				exit(self::ERROR_INVALID_ACTION);
			else
				$this->{$this->ACTION}();

			die; //Kill if something is wrong
		}

		private function verifyNonce()
		{
			if(isset($_POST['nonce']))
				if($this->RED->compare_crypt('ajax_'.$this->ACTION.'_nonce', $this->NONCE, 'nonce'))
					return TRUE;
				else
					return FALSE;
			else
				return FALSE;
		}

		private function checkAction()
		{
			if(method_exists($this,$this->ACTION))
				return TRUE;
			else
				return FALSE;
		}

		private function checkPermission($type)
		{
			if($type == 'manager')
				if(!$this->RED->is_manager())
					exit(self::ERROR_INSUFFICIENT_PERMISSIONS);
			else
				if(!$this->RED->is_admin())
					exit(self::ERROR_INSUFFICIENT_PERMISSIONS);
		}


		/**
			Ajax methods
		*/


		private function add_record()
		{
			self::checkPermission('manager');

			if(!isset(
				$_POST['forward-url'],
				$_POST['forward-slug'],
				$_POST['randValue']
			))
				exit(self::ERROR_MISSING_ARGUMENTS);

			if(empty($_POST['forward-url']) || empty($_POST['randValue']))
				exit(self::ERROR_EMPTY_ARGUMENTS);

			if(empty($_POST['forward-slug']))
				$slug = filter_var($_POST['randValue'], FILTER_SANITIZE_STRING);
			else
				$slug = filter_var($_POST['forward-slug'], FILTER_SANITIZE_STRING);

			$record = $this->RED->DB['records']->get($slug);

			//if(!filter_var($_POST['forward-url'], FILTER_VALIDATE_URL))
			//	exit(self::ERROR_INVALID_URL);
			
			$record->save(array('url' => $_POST['forward-url'], 'clicks' => 0));
			exit(self::CODE_SUCCESS);
		}

		private function remove_record()
		{
			self::checkPermission('manager');

			if(!isset($_POST['record_id']))
				exit(self::ERROR_MISSING_ARGUMENTS);

			$record = $this->RED->DB['records']->get(filter_var($_POST['record_id'], FILTER_SANITIZE_STRING));

			if(empty($record->url))
				exit(self::ERROR_ENTRY_DONT_EXISTS);

			$record = $this->RED->DB['records']->delete($record);
			exit(self::CODE_SUCCESS);
		}

		private function sign_in()
		{
			if(!isset(
				$_POST['login'],
				$_POST['password']
			))
				exit(self::ERROR_MISSING_ARGUMENTS);

			if(empty($_POST['login']) || empty($_POST['password']))
				exit(self::ERROR_ENTRY_DONT_EXISTS);

			$user = $this->RED->DB['users']->get(filter_var($_POST['login'], FILTER_SANITIZE_STRING));

			if(empty($user->password))
			{
				$user = $this->RED->DB['users']->select('__id,password')->where(['email' => filter_var($_POST['login'], FILTER_SANITIZE_STRING)])->results();
				
				if(!isset($user[0]['password']))
					exit('self::ERROR_ENTRY_DONT_EXISTS');

				if(empty($user[0]['password']))
					exit(self::ERROR_ENTRY_DONT_EXISTS);

				$userPassword = $user[0]['password'];
				$userName = $user[0]['__id'];
			}
			else
			{
				$userPassword = $user->password;
				$userName = $user->getId();
			}

			if(!$this->RED->compare_crypt(filter_var($_POST['password'], FILTER_SANITIZE_STRING), $userPassword))
				exit(self::ERROR_ENTRY_DONT_EXISTS);
			
			session_regenerate_id();

			$token = $this->RED->encrypt($this->RED->rand(20), 'token');

			$user = $this->RED->DB['users']->get($userName);
			$user->token = $token;
			$user->lastlogin = time();
			$user->save();

			$_SESSION = array(
				'l' => TRUE,
				'u' => $userName,
				't' => $token,
				'r' => $user->role
			);

			exit(self::CODE_SUCCESS);
		}

		private function add_user()
		{
			self::checkPermission('admin');

			if(!isset(
				$_POST['userName'],
				$_POST['userEmail'],
				$_POST['userRole'],
				$_POST['userPassword'],
				$_POST['userPasswordConfirm']
			))
				exit(self::ERROR_MISSING_ARGUMENTS);

			if(empty($_POST['userName']) || empty($_POST['userPassword']) || empty($_POST['userEmail']))
				exit(self::ERROR_EMPTY_ARGUMENTS);

			if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST['userName']))
				exit(self::ERROR_SPECIAL_CHARACTERS);

			if (!filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL))
				exit(self::ERROR_INVALID_EMAIL);

			if(strlen($_POST['userPassword']) < 8)
				exit(self::ERROR_PASSWORD_TOO_SHORT);

			if (!preg_match("#[0-9]+#", $_POST['userPassword']) || !preg_match("#[a-zA-Z]+#", $_POST['userPassword']) || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST['userPassword']))
				exit(self::ERROR_PASSWORD_TOO_SIMPLE);

			if($_POST['userPassword'] != $_POST['userPasswordConfirm'])
				exit(self::ERROR_PASSWORDS_DONT_MATCH);

			$user = $this->RED->DB['users']->get(filter_var($_POST['userName'], FILTER_SANITIZE_STRING));

			if(!empty($user->password))
				exit(self::ERROR_ENTRY_EXISTS);

			$user->save(array(
				'password' => $this->RED->encrypt($_POST['userPassword']),
				'role' => ($_POST['userRole'] == 'admin' ? 'admin' : ( $_POST['userRole'] == 'manager' ? 'manager' : 'analyst' )),
				'email' => filter_var($_POST['userEmail'], FILTER_SANITIZE_STRING)
			));

			exit(self::CODE_SUCCESS);
		}

		private function save_settings()
		{
			self::checkPermission('admin');

			if(!isset(
				$_POST['site_url'],
				$_POST['dashboard_url'],
				$_POST['redirect_404'],
				$_POST['redirect_404_url'],
				$_POST['redirect_home'],
				$_POST['redirect_home_url'],
				$_POST['cache_redirects'],
				$_POST['redirect_ssl'],
				$_POST['dashboard_ssl'],
				$_POST['js_redirect'],
				$_POST['gtag'],
				$_POST['js_redirect_after'],
				$_POST['captcha_site'],
				$_POST['captcha_secret'],
				$_POST['language_type'],
				$_POST['language_select']
			))
				exit(self::ERROR_MISSING_ARGUMENTS);

			if(!empty($_POST['redirect_404_url']))
				if(!filter_var($_POST['redirect_404_url'], FILTER_VALIDATE_URL))
					exit('e_invalid_404');

			if(!empty($_POST['redirect_home_url']))
				if(!filter_var($_POST['redirect_home_url'], FILTER_VALIDATE_URL))
					exit('e_invalid_home');

			$option = $this->RED->DB['options']->get('siteurl');
			$option->save(['value' => $_POST['site_url']]);

			$option = $this->RED->DB['options']->get('dashboard');
			$option->save(['value' => $_POST['dashboard_url']]);

			$option = $this->RED->DB['options']->get('redirect_404');
			$option->save(['value' => ($_POST['redirect_404'] == '1' ? true : false)]);
			$option = $this->RED->DB['options']->get('redirect_404_url');
			$option->save(['value' => $_POST['redirect_404_url']]);

			$option = $this->RED->DB['options']->get('redirect_home');
			$option->save(['value' => ($_POST['redirect_home'] == '1' ? true : false)]);
			$option = $this->RED->DB['options']->get('redirect_home_url');
			$option->save(['value' => $_POST['redirect_home_url']]);

			$option = $this->RED->DB['options']->get('cache_redirects');
			$option->save(['value' => ($_POST['cache_redirects'] == '1' ? true : false)]);

			$option = $this->RED->DB['options']->get('redirect_ssl');
			$option->save(['value' => ($_POST['redirect_ssl'] == '1' ? true : false)]);
			$option = $this->RED->DB['options']->get('dashboard_ssl');
			$option->save(['value' => ($_POST['dashboard_ssl'] == '1' ? true : false)]);

			$option = $this->RED->DB['options']->get('js_redirect');
			$option->save(['value' => ($_POST['js_redirect'] == '1' ? true : false)]);
			$option = $this->RED->DB['options']->get('gtag');
			$option->save(['value' => $_POST['gtag']]);
			$option = $this->RED->DB['options']->get('js_redirect_after');
			$option->save(['value' => (int)$_POST['js_redirect_after']]);

			$option = $this->RED->DB['options']->get('captcha_site');
			$option->save(['value' => $_POST['captcha_site']]);
			$option = $this->RED->DB['options']->get('captcha_secret');
			$option->save(['value' => $_POST['captcha_secret']]);

			$option = $this->RED->DB['options']->get('language_type');
			$option->save(['value' => (int)$_POST['language_type']]);
			$option = $this->RED->DB['options']->get('language_select');
			$option->save(['value' => $_POST['language_select']]);

			exit(self::CODE_SUCCESS);
		}
	}
?>
