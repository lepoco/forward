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


			if(defined('RED_DASHBOARD'))
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
					if(RED_DASHBOARD == 'users')
					{
						$this->RED->page(['page' => 'users', 'title' => 'Users']);
					}
					else if(RED_DASHBOARD == 'about')
					{
						$this->RED->page(['page' => 'about', 'title' => 'About']);
					}
					else if(RED_DASHBOARD == 'settings')
					{
						$this->RED->page(['page' => 'settings', 'title' => 'Settings']);
					}
					else if(RED_DASHBOARD == 'signout')
					{
						self::signout();
					}
					else if(RED_DASHBOARD == 'ajax')
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

						$_SESSION['loggedin'] = TRUE;
						$_SESSION['user'] = $userName;

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
					if($_POST['forward-url'] == '' || $_POST['forward-slug'] == '')
						exit('error_4');

					$record = $this->RED->DB['records']->get($_POST['forward-slug']);

					if($record->url == NULL)
					{
						$record->url = $_POST['forward-url'];
						$record->clicks = 0;
						$record->save();
					}
					else
					{
						exit('error_5');
					}
					var_dump($_POST);
					exit('success');
				}
				exit;
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
			$this->LOGGED_IN = false;

			if(isset($_SESSION['loggedin']))
			{
				if($_SESSION['loggedin'])
				{
					$this->LOGGED_IN = true;
				}
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
