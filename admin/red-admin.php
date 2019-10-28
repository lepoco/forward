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
	* RED_ADMIN
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @version  $Id: red-admin.php;RED_ADMIN,v beta 1.0 2019/10/27
	* @access   public
	*/
	class RED_ADMIN
	{
		private $RED;
		private $LOGGED_IN;

		/**
		* init
		* Returns the RED_ADMIN object without initializing the object
		*
		* @access   public
		* @return   object RED_ADMIN
		*/
		public static function init(RED $RED) : RED_ADMIN
		{
			return new RED_ADMIN($RED);
		}

		/**
		* __construct
		* Checks permissions and redirects to the website, or return ajax
		*
		* @access   public
		* @return   void
		*/
		public function __construct(RED $RED)
		{
			$this->RED = $RED;

			$this->RED->DB['users'] = new \Filebase\Database([
				'dir' => DB_PATH.DB_USERS,
				'backupLocation' => DB_PATH.DB_USERS.'/backup',
				'format' => \Filebase\Format\Jdb::class
			]);

			session_start();
			session_regenerate_id();
			
			self::isLoggedIn();

			if(defined('RED_PAGE_DASHBOARD'))
			{
				if(!$this->LOGGED_IN)
				{
					if(RED_PAGE_DASHBOARD == 'ajax')
					{
						if(!isset($_POST['action']))
							exit('e99');
						if(!$_POST['action'] == 'sign_in')
							exit('e99');

						self::ajax();
					}

					header("Location: " . $this->RED->DB['options']->get('dashboard')->value);
					exit;
				}
				else
				{
					if(RED_PAGE_DASHBOARD == 'users' && $this->RED->is_admin())
						$this->RED->page(['page' => 'users', 'title' => 'Users']);
					else if(RED_PAGE_DASHBOARD == 'settings' && $this->RED->is_admin())
						$this->RED->page(['page' => 'settings', 'title' => 'Settings']);
					else if(RED_PAGE_DASHBOARD == 'about')
						$this->RED->page(['page' => 'about', 'title' => 'About']);
					else if(RED_PAGE_DASHBOARD == 'signout')
						self::signout();
					else if(RED_PAGE_DASHBOARD == 'ajax')
						self::ajax();
					else
						$this->RED->page(['title' => 'Page not found']);
				}
			}
			else
			{
				if(!$this->LOGGED_IN)
					$this->RED->page(['page' => 'login', 'title' => 'Sign In']);
				else
					$this->RED->page(['page' => 'dashboard', 'title' => 'Dashboard']);
			}
		}

		/**
		* ajax
		* Returns a new instance of the RED_AJAX class
		*
		* @access   private
		* @return   object RED_AJAX
		*/
		private function ajax() : RED_AJAX
		{
			$this->RED->include(ADMPATH.'red-ajax.php');
			return RED_AJAX::init($this->RED);
		}

		/**
		* isLoggedIn
		* Checks whether the user is logged in correctly
		*
		* @access   public
		* @return   void
		*/
		public function isLoggedIn() : void
		{
			$this->LOGGED_IN = FALSE;

			if(isset($_SESSION['l'], $_SESSION['u'], $_SESSION['t'], $_SESSION['r']))
			{
				$user = $this->RED->DB['users']->get(filter_var($_SESSION['u'], FILTER_SANITIZE_STRING));

				if($user->token != NULL)
					if($user->token == $_SESSION['t'])
						if($_SESSION['l'])
							$this->LOGGED_IN = TRUE;
			}
		}

		/**
		* signout
		* Destroys session, logs off user
		*
		* @access   public
		* @return   void
		*/
		public function signout() : void
		{
			session_destroy();
			header("Location: " . $this->RED->DB['options']->get('dashboard')->value);
			exit();
		}
	}
?>
