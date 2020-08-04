<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2020, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;
	defined('ABSPATH') or die('No script kiddies please!');

	use DateTime;

	/**
	*
	* User
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class User
	{
		/**
		 * Forward class instance
		 *
		 * @var Forward
		 * @access private
		 */
		private $Forward;

		/**
		 * Active user id
		 *
		 * @var int
		 * @access private
		 */
		private $id;

		/**
		 * Current user
		 *
		 * @var array
		 * @access private
		 */
		private $User;

		/**
		* __construct
		* Class constructor
		*
		* @access   public
		*/
		public function __construct($parent)
		{
			$this->Forward = $parent;
		}

		/**
		* LogIn
		* Sign in selected user
		*
		* @param	array $user
		* @access   public
		*/
		public function LogIn( $user ) : void
		{
			$token = Crypter::Encrypt(Crypter::DeepSalter(30), 'token');

			if( $this->Forward->Database == null )
				$this->Forward->Database = new Database();

			$query = $this->Forward->Database->query(
				"UPDATE forward_users SET user_token = ?, user_last_login = ? WHERE user_id = ?",
				$token,
				(new DateTime())->format('Y-m-d H:i:s'),
				$user['user_id']
			);

			$this->id = $user['user_id'];

			session_regenerate_id();
			$_SESSION = array(
				'l' => true,
				'u' => $user['user_id'],
				't' => $token,
				'r' => $user['user_role']
			);
		}

		/**
		* LogOut
		* Sign out selected user and destroy session
		*
		* @access   public
		*/
		public function LogOut() : void
		{
			if( isset( $_SESSION['u'], $_SESSION['t'], $_SESSION['r'] ) )
			{
				if( $this->User == null )
					$this->GetUser( $_SESSION['u'] );

				$query = $this->Forward->Database->query(
					"UPDATE forward_users SET user_token = ? WHERE user_id = ?",
					'',
					$this->User['user_id'],
				);
			}

			$this->Forward->Session->Destroy();
		}

		/**
		* IsLoggedIn
		* Checks if the user is correctly logged in
		*
		* @access   public
		*/
		public function IsLoggedIn() : bool
		{
			if( isset( $_SESSION['u'], $_SESSION['t'], $_SESSION['r'] ) )
			{
				if( $this->User == null )
					$this->GetUser( $_SESSION['u'] );

				if($this->User != null)
				{
					if( isset( $this->User['user_token'], $this->User['user_role'] ) )
					{
						if( Crypter::Compare($_SESSION['t'], $this->User['user_token'], 'token', false)  && $_SESSION['r'] == $this->User['user_role'] )
						{
							return true;
						}
					}
				}
			}
			
			return false;
		}

		public function Active() : array
		{
			if( $this->User == null )
				$this->GetUser( $this->id );

			return $this->User;
		}

		/**
		* GetUser
		* Get's user by id
		*
		* @param	int $id
		* @access   public
		*/
		private function GetUser( $id )
		{
			$query = $this->Forward->Database->query( "SELECT * FROM forward_users WHERE user_id = ?", $id )->fetchArray();

			if($query != null)
			{
				$this->id = $query['user_id'];
				$this->User = $query;
			}
		}

		/**
		* GetByName
		* Get's user by username
		*
		* @param	string $username
		* @access   public
		*/
		public function GetByName( $username )
		{
			$query = $this->Forward->Database->query( "SELECT user_id, user_email, user_password, user_role, user_token FROM forward_users WHERE user_name = ?", $username )->fetchArray();
			return $query;
		}

		/**
		* GetByEmail
		* Get's user by e-mail
		*
		* @param	string $username
		* @access   public
		*/
		public function GetByEmail( $email )
		{
			$query = $this->Forward->Database->query( "SELECT user_id, user_name, user_password, user_role, user_token FROM forward_users WHERE user_email = ?", $email )->fetchArray();
			return $query;
		}
	}

?>
