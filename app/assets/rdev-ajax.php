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

	/**
	*
	* Ajax
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class Ajax
	{
		/** ERROR CODES */
		private const ERROR_UNKNOWN                  = 'e00';
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
		
		/**
		 * Forward class instance
		 *
		 * @var Forward
		 * @access private
		 */
		private $Forward;

		/**
		 * Current ajax action
		 *
		 * @var string
		 * @access private
		 */
		private $action = '';

		/**
		 * Current ajax nonce
		 *
		 * @var string
		 * @access private
		 */
		private $nonce = '';

		/**
		* __construct
		* Class constructor
		*
		* @access   public
		*/
		public function __construct( $parent )
		{
			$this->Forward = $parent;

			if( $this->IsNull() )
				exit('Bad gateway');

			if ( !isset( $_POST['action'] ) )
				exit( self::ERROR_MISSING_ACTION );
			else
				$this->action = filter_var( $_POST['action'], FILTER_SANITIZE_STRING );

			if ( !isset( $_POST['nonce'] ) )
				exit( self::ERROR_MISSING_NONCE );
			else
				$this->nonce = filter_var( $_POST['nonce'], FILTER_SANITIZE_STRING );

			if( !$this->ValidNonce() )
				exit( self::ERROR_INVALID_NONCE );

			if( !$this->ValidAction() )
				exit(self::ERROR_INVALID_ACTION);
			else
				$this->{$this->action}();

			$this->Finish();
		}

		/**
		* ValidNonce
		* Nonce validation
		*
		* @access   private
		* @return	bool
		*/
		private function ValidNonce() : bool
		{
			if( isset( $_POST['nonce'] ) )
				if( Crypter::Compare( 'ajax_' . $this->action . '_nonce', $this->nonce, 'nonce' ) )
					return true;
				else
					return false;
			else
				return false;
		}

		/**
		* ValidAction
		* Action validation
		*
		* @access   private
		* @return	bool
		*/
		private function ValidAction() : bool
		{
			if( method_exists( $this, $this->action ) )
				return true;
			else
				return false;
		}

		/**
		* IsNull
		* If $_POST is not empty
		*
		* @access   private
		* @return	bool
		*/
		private function IsNull() : bool
		{
			if( !empty( $_POST ) )
				return false;
			else
				return true;
		}

		/**
		* Finish
		* End ajax script
		*
		* @access   private
		* @return	bool
		*/
		private function Finish( $code = null )
		{
			$this->Forward->Session->Close();

			if( $code == null )
				echo ERROR_UNKNOWN;
			else
				echo $code;

			exit;
		}


		/**
			Ajax methods
		*/

		/**
		* sign_in
		* The action is triggered on login
		*
		* @access   private
		* @return	void
		*/
		private function sign_in() : void
		{
			if( !isset( $_POST['login'], $_POST['password'] ) )
				$this->Finish( self::ERROR_MISSING_ARGUMENTS );

			if( empty( $_POST['login'] ) || empty( $_POST['password'] ) )
				$this->Finish( self::ERROR_ENTRY_DONT_EXISTS );

			$login = filter_var( $_POST['login'], FILTER_SANITIZE_STRING );
			$password = filter_var( $_POST['password'], FILTER_SANITIZE_STRING );

			$user = $this->Forward->User->GetByName( $login );

			if( empty( $user ))
				$user = $this->Forward->User->GetByEmail( $login );
			
			if( empty( $user ))
				$this->Finish( self::ERROR_ENTRY_DONT_EXISTS );

			if( !Crypter::Compare( $password, $user['user_password'], 'password' ) )
				$this->Finish( self::ERROR_ENTRY_DONT_EXISTS );

			$this->Forward->User->LogIn( $user );

			$this->Finish( self::CODE_SUCCESS );
		}

		/**
		* sign_in
		* The action is triggered on adding record
		*
		* @access   private
		* @return	void
		*/
		private function add_record() : void
		{
			if( !$this->Forward->User->IsManager() )
				$this->Finish( self::ERROR_INSUFFICIENT_PERMISSIONS );

			if(!isset(
				$_POST[ 'input-record-url' ],
				$_POST[ 'input-record-slug' ],
				$_POST[ 'input-rand-value' ]
			))
				$this->Finish( self::ERROR_MISSING_ARGUMENTS );

			if( trim( $_POST[ 'input-record-url' ] ) == '' || trim( $_POST[ 'input-rand-value' ] ) == '' )
				$this->Finish( self::ERROR_EMPTY_ARGUMENTS );
			
			if( trim( $_POST[ 'input-record-slug' ] ) != '' && $_POST[ 'input-record-slug' ] != $_POST[ 'input-rand-value' ])
				$slug = filter_var( $_POST[ 'input-record-slug' ], FILTER_SANITIZE_STRING );
			else
				$slug = filter_var( $_POST[ 'input-rand-value' ], FILTER_SANITIZE_STRING );

			$query = $this->Forward->Database->query( "SELECT record_id FROM forward_records WHERE record_name = ?", strtolower( $slug ) )->fetchAll();
			if( !empty( $query ) )
				$this->Finish( self::ERROR_ENTRY_EXISTS );

			$query = $this->Forward->Database->query(
				"INSERT INTO forward_records (record_name, record_display_name, record_url) VALUES (?,?,?)",
				strtolower( $slug ),
				$slug,
				filter_var( $_POST[ 'input-record-url' ], FILTER_SANITIZE_STRING )
			);

			$this->Finish( self::CODE_SUCCESS );
		}
	}
?>
