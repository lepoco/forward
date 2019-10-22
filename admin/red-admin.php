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

	class RED_ADMIN
	{
		private $RED;
		private $LOGGED_IN;

		public static function init($RED)
		{
			return new RED_ADMIN($RED);
		}

		public function __construct($RED)
		{
			$this->RED = $RED;

			session_start();
			session_regenerate_id();
			
			self::isLoggedIn();


			if(defined('RED_PAGE_DASHBOARD'))
			{
				if(!$this->LOGGED_IN)
				{
					if(isset($_POST['action']))
						if($_POST['action'] == 'signIn')
							self::ajax();

					header("Location: " . $RED->DB['options']->get('dashboard')->value);
					exit;
				}
				else
				{
					if(RED_PAGE_DASHBOARD == 'users')
					{
						$this->RED->page(['page' => 'users', 'title' => 'Users']);
					}
					else if(RED_PAGE_DASHBOARD == 'about')
					{
						$this->RED->page(['page' => 'about', 'title' => 'About']);
					}
					else if(RED_PAGE_DASHBOARD == 'settings')
					{
						$this->RED->page(['page' => 'settings', 'title' => 'Settings']);
					}
					else if(RED_PAGE_DASHBOARD == 'signout')
					{
						self::signout();
					}
					else if(RED_PAGE_DASHBOARD == 'ajax')
					{
						self::ajax();
					}
					else
					{
						$this->RED->page(['title' => 'Dashboard page not found']);
					}
				}
			}
			else
			{
				if(!$this->LOGGED_IN)
				{
					$this->RED->page(['page' => 'login', 'title' => 'Sign In']);
				}
				else
				{
					$this->RED->page(['page' => 'dashboard', 'title' => 'Dashboard']);
				}
			}
		}

		private function ajax()
		{
			if (isset($_POST['action']))
			{
				if($_POST['action'] == 'addUser')
				{
					if(!self::verifyNonce('ajax_add_user_nonce'))
						exit('error_2');

					if($_POST['userPassword'] != $_POST['userPasswordConfirm'])
						exit('error_3');

					if($_POST['userName'] == '' || $_POST['userPassword'] == '')
						exit('error_4');

					$user = $this->RED->DB['users']->get($_POST['userName']);

					if($user->password == NULL)
					{
						$user->email = $_POST['userEmail'];
						$user->password = $this->RED->encrypt($_POST['userPassword']);
						$user->save();
						exit('success');
					}
					else
					{
						exit('error_4');
					}
				}
				else if($_POST['action'] == 'signIn')
				{

					if(!self::verifyNonce('ajax_login_nonce'))
						exit('error_2');

					if(!isset($_POST['login'], $_POST['password']))
						exit('error_3');

					if(strlen($_POST['login']) < 5 || strlen($_POST['password']) < 5)
						exit('error_4');

					$login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
					$user  = $this->RED->DB['users']->get($login);

					if($user->password == NULL)
					{
						$user = $this->RED->DB['users']->select('__id,password')->where(['email' => $login])->results();

						if(isset($user[0]))
						{
							if(isset($user[0]['password']))
							{
								if ($user[0]['password'] == NULL || $user[0]['password'] == '')
								{
									exit('error_5');
								}
							}
							else
							{
								exit('error_5');
							}
						}
						else
						{
							exit('error_5');
						}

						$userPassword = $user[0]['password'];
						$userName = $user[0]['__id'];
					}
					else
					{
						$userPassword = $user->password;
						$userName = $login;
					}
					
					if($this->RED->compare_crypt(filter_var($_POST['password'], FILTER_SANITIZE_STRING), $userPassword))
					{
						session_regenerate_id();

						$token = $this->RED->encrypt($this->RED->rand(20), 'token');

						$user = $this->RED->DB['users']->get($userName);
						$user->token = $token;
						$user->lastlogin = time();
						$user->save();

						$_SESSION['l'] = TRUE;
						$_SESSION['u'] = $userName;
						$_SESSION['t'] = $token;

						exit('success');
					}
					else
					{
						exit('error_5');
					}

					exit('error_1');
				}
				else if($_POST['action'] == 'addRecord')
				{
					if(!self::verifyNonce('ajax_add_record_nonce'))
						exit('error_2');

					if(!isset($_POST['forward-url'], $_POST['forward-slug'], $_POST['randValue']))
						exit('error_3');

					if($_POST['forward-url'] == '' || $_POST['randValue'] == '')
						exit('error_4');

					if($_POST['forward-slug'] == '')
						$slug = filter_var($_POST['randValue'], FILTER_SANITIZE_STRING);
					else
						$slug = filter_var($_POST['forward-slug'], FILTER_SANITIZE_STRING);

					$record = $this->RED->DB['records']->get($slug);

					if($record->url == NULL)
					{
						$record->url = $_POST['forward-url'];
						$record->clicks = 0;
						$record->save();
						exit('success');
					}
					else
					{
						exit('error_6');
					}
				}
				else if($_POST['action'] == 'saveSettings')
				{
					if(!self::verifyNonce('ajax_save_settings_nonce'))
						exit('error_2');

					if(!isset(
						$_POST['site_url'],
						$_POST['dashboard_url'],
						$_POST['redirect_404'],
						$_POST['redirect_404_url'],
						$_POST['redirect_home'],
						$_POST['redirect_home_url'],
						$_POST['cache_redirects'],
						$_POST['redirect_ssl'],
						$_POST['admin_ssl'],
						$_POST['js_redirect'],
						$_POST['gtag'],
						$_POST['js_redirect_after'],
						$_POST['captcha_site'],
						$_POST['captcha_secret']
					))
						exit('error_3');

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
					$option = $this->RED->DB['options']->get('admin_ssl');
					$option->save(['value' => ($_POST['admin_ssl'] == '1' ? true : false)]);

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

					var_dump($_POST);
				}
				exit('error_1');
			}
			else
			{
				exit(header("Location: " . $this->RED->DB['options']->get('siteurl')->value));
			}
		}

		private function verifyNonce($nonce_name)
		{
			if(isset($_POST['nonce']))
			{
				if($this->RED->compare_crypt($nonce_name, filter_var($_POST['nonce'], FILTER_SANITIZE_STRING), 'nonce'))
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
		}

		public function isLoggedIn()
		{
			$this->LOGGED_IN = FALSE;

			if(isset($_SESSION['l'], $_SESSION['u'], $_SESSION['t']))
			{
				$user = $this->RED->DB['users']->get(filter_var($_SESSION['u'], FILTER_SANITIZE_STRING));

				if($user->token != NULL)
					if($user->token == $_SESSION['t'])
						if($_SESSION['l'])
							$this->LOGGED_IN = TRUE;
			}
		}

		public function signout()
		{
			session_destroy();
			header("Location: " . $this->RED->DB['options']->get('dashboard')->value);
			exit();
		}
	}
?>
