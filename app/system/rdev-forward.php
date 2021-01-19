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
	* Forward
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class Forward
	{	
		/**
		 * Information about the address from the Uri class
		 *
		 * @var Uri
		 * @access public
		 */
		public $Path;

		/**
		 * Information about the session from the Session class
		 *
		 * @var Session
		 * @access public
		 */
		public $Session;

		/**
		 * Class for translating text strings
		 *
		 * @var Translator
		 * @access public
		 */
		public $Translator;

		/**
		 * A global class that stores options
		 *
		 * @var Options
		 * @access public
		 */
		public $Options;

		/**
		 * A set of user management tools
		 *
		 * @var User
		 * @access public
		 */
		public $User;

		/**
		 * Master database instance, requires config.php
		 *
		 * @var Database
		 * @access public
		 */
		public $Database;

		/**
		* __construct
		* Triggers and instances all necessary classes
		*
		* @access   public
		* @return   Forward
		*/
		public function __construct()
		{
			$this->Init();

			//If the configuration file does not exist or is damaged, start the installation
			if( !DEFINED( 'FORWARD_DB_NAME' ) )
			{
				$this->LoadModel( 'install', 'Installer' );
			}
			else
			{
				//Mechanism of action depending on the first part of the url
				switch ( $this->Path->GetLevel( 0 ) )
				{
					case '':
					case null:
						$this->LoadModel( 'home', 'Create your own link shortener' );
						break;

					case $this->Options->Get( 'dashboard', 'dashboard' ):
					case $this->Options->Get( 'login', 'login' ):
						new Dashboard( $this );
						break;

					default:
						new Redirect( $this );
						break;
				}
			}

			exit; //Just in case
		}

		/**
		* Init
		* Instances all necessary classes
		*
		* @access   private
		* @return   void
		*/
		private function Init() : void
		{
			$this->InitPath();
			$this->InitSession();
			$this->InitTranslator();
			$this->InitDatabase();
			$this->InitOptions();
			$this->InitUser();
		}

		/**
		* IsConfig
		* Checks if the configuration file exists
		*
		* @access   private
		* @return   bool
		*/
		private function IsConfig() : bool
		{
			if ( is_file( APPPATH . 'config.php' ) )
				return true;
			else
				return false;
		}

		/**
		* InitPath
		* Initializes the Uri class
		*
		* @access   private
		* @return   void
		*/
		private function InitPath() : void
		{
			$this->Path = new Uri();
			$this->Path->Parse();
		}

		/**
		* InitSession
		* Initializes the Session class
		*
		* @access   private
		* @return   void
		*/
		private function InitSession() : void
		{
			$this->Session = new Session();
			$this->Session->Open();
		}

		/**
		* InitTranslator
		* Initializes the Translator class
		*
		* @access   private
		* @return   void
		*/
		private function InitTranslator() : void
		{
			$this->Translator = new Translator();
		}

		/**
		* InitDatabase
		* Initializes the Database class
		*
		* @access   private
		* @return   void
		*/
		private function InitDatabase() : void
		{
			if( $this->IsConfig() )
				$this->Database = new Database();
			else
				$this->Database = null;
		}

		/**
		* InitOptions
		* Initializes the Options class
		*
		* @access   private
		* @return   void
		*/
		private function InitOptions() : void
		{
			$this->Options = new Options( $this->Database );
		}

		/**
		* InitUser
		* Initializes the User class
		*
		* @access   private
		* @return   void
		*/
		private function InitUser() : void
		{
			$this->User = new User( $this );
		}

		/**
		* LoadModel
		* Loads the page model (logic)
		* The page model is inherited from assets/rdev-models.php
		*
		* @access   private
		* @return   void
		*/
		public function LoadModel( string $name, string $displayname = null )
		{
			if ( is_file( APPPATH . "/models/rdev-$name.php" ) )
			{
				require_once APPPATH . "/models/rdev-$name.php";
				( new Model( $this, $name, $displayname ) )->Print();
			}
			else
			{
				if( is_file( APPPATH . "/themes/pages/rdev-$name.php" ) )
				{
					//Display the page without additional logic
					( new Models( $this, $name, $displayname ) )->Print();
				}
				else
				{
					exit( "Unable to find model '$name'" );
				}
			}
		}

		/**
		* Error
		* Custom error handling
		*
		* @param	string $message
		* @access   public
		* @return   html (error message)
		*/
		public function Error( string $message, bool $kill = false )
		{
			$r_message = '<br/><strong>Forward Error</strong><br/><br/><i>' . date('Y-m-d h:i:s a', time()) . '</i><br/>';

			if ( is_file( APPPATH . 'config.php' ) )
			{
				if( DEFINED( 'FORWARD_DEBUG' ) )
				{
					if( FORWARD_DEBUG )
						echo $r_message . $message;
				}
				else
				{
					echo $r_message . $message . '<br/><i>Configuration file <strong>EXISTS</strong> but FORWARD_DEBUG constant could not be found ...</i>';
				}
			}
			else
			{
				echo $r_message . $message . '<br/><i>Configuration file does not exist...</i>';
			}

			if( $kill )
				exit;
		}
	}
