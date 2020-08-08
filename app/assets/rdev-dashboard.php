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
	* Dashboard
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class Dashboard
	{
		/**
		 * Forward class instance
		 *
		 * @var Forward
		 * @access private
		 */
		private $Forward;

		/**
		 * Current dashboard page
		 *
		 * @var string
		 * @access private
		 */
		private $subpage;

		/**
		 * List of available pages
		 *
		 * @var array
		 * @access private
		 */
		private static $pages = array(
			'__dashboard__',
			'ajax',
			'signout',
			'users',
			'settings',
			'about',
			'login'
		);

		/**
		* __construct
		* Class constructor
		*
		* @access   public
		*/
		public function __construct(  Forward &$parent )
		{
			$this->Forward = $parent;

			$this->SetPage();
			$this->IfExists();

			if( !$this->Forward->User->IsLoggedIn() )
			{
				if( $this->subpage != 'login' && $this->subpage != 'ajax' )
					$this->RedirectTo( $this->Forward->Options->Get( 'login', 'login' ) );
			}
			else
			{
				if( $this->subpage == 'login' )
					$this->RedirectTo();
			}

			switch ($this->subpage)
			{
				case 'ajax':
					new Ajax( $this->Forward );
					break;

				case '__dashboard__':
					$this->Forward->LoadModel( 'dashboard', 'Dashboard' );
					break;

				case 'settings':
					$this->Forward->LoadModel( 'settings', 'Settings' );
					break;

				case 'about':
					$this->Forward->LoadModel( 'about', 'About' );
					break;

				case 'login':
					$this->Forward->LoadModel( 'login', 'Sign in' );
					break;

				case 'signout':
					$this->Forward->User->LogOut();
					$this->Forward->Path->Redirect( $this->Forward->Options->Get( 'base_url', $this->Forward->Path->ScriptURI() ) );
					break;
				
				default:
					$this->Forward->LoadModel( '404', 'Page not found' );
					break;
			}
			
			//End ajax query
			$this->Forward->Session->Close();
			exit;
		}

		/**
		* RedirectLogin
		* Redirect to login if illegal dashboard page
		*
		* @access   private
		*/
		private function RedirectTo( $slug = null ) : void
		{
			$this->Forward->Path->Redirect(
				$this->Forward->Options->Get(
					'base_url',
					$this->Forward->Path->ScriptURI()
				) . $this->Forward->Options->Get( 'dashboard', 'dashboard' ) . '/' . $slug
			);
		}

		/**
		* SetPage
		* Defines current dashboard page
		*
		* @access   private
		*/
		private function SetPage() : void
		{
			if( $this->Forward->Path->GetLevel( 1 ) == null )
				$this->subpage = '__dashboard__';
			else
				$this->subpage = $this->Forward->Path->GetLevel( 1 );
		}

		/**
		* IfExists
		* Checks if the selected page exists
		*
		* @access   private
		*/
		private function IfExists() : void
		{	
			if( !in_array( $this->subpage, self::$pages ) )
				$this->Forward->LoadModel( '404', 'Page not found' );
		}
	}
?>
