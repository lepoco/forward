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
	* Models
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class Models
	{
		/**
		 * Forward class instance
		 *
		 * @var Forward
		 * @access protected
		 */
		protected $Forward;

		/**
		 * Basename of view
		 *
		 * @var string
		 * @access protected
		 */
		protected $name;

		/**
		 * Displayed name in title
		 *
		 * @var string
		 * @access protected
		 */
		protected $displayname;

		/**
		 * Themes path
		 *
		 * @var string
		 * @access protected
		 */
		protected $themes;

		/**
		 * List of frontend styles
		 *
		 * @var array
		 * @access protected
		 */
		protected $styles;

		/**
		 * List of frontend scripts
		 *
		 * @var array
		 * @access protected
		 */
		protected $scripts;

		/**
		 * List of sites to dns prefetch
		 *
		 * @var array
		 * @access protected
		 */
		protected $prefetch;

		/**
		 * Root url of website
		 *
		 * @var string
		 * @access protected
		 */
		protected $baseurl;

		/**
		 * Nonce for secured javascript 
		 *
		 * @var string
		 * @access protected
		 */
		protected $js_nonce;

		/**
		 * Nonce for DOM verification
		 *
		 * @var string
		 * @access protected
		 */
		protected $body_nonce;

		/**
		* __construct
		* Class constructor
		*
		* @access   public
		* @param	Forward $parent
		* @param	string $name
		* @param	string $displayname
		*/
		public function __construct( Forward &$parent, string $name, string $displayname )
		{
			$this->Forward = $parent;

			$this->name = $name;
			$this->displayname = $displayname;
			$this->themes = APPPATH . 'themes/';

			$this->BuildNonces();

			$this->SetBaseUrl();
			$this->SetPrefetch();

			$this->GetStyles();
			$this->GetScripts();

			if( method_exists( $this, 'Init' ) )
				$this->Init();

			if($_GET != NULL)
				if( method_exists( $this, 'Get' ) )
					$this->Get();
				else
					$this->GetView();

			if($_POST != NULL)
				if( method_exists( $this, 'Post' ) )
					if( method_exists( $this, 'Get' ) )
						$this->Get();
					else
						$this->GetView();
				else
					$this->GetView();
		}

		protected function __( $text = '' )
		{
			return $this->Forward->Translator->__( $text );
		}

		protected function _e( $text = '' )
		{
			return $this->Forward->Translator->_e( $text );
		}

		protected function AjaxGateway()
		{
			return $this->baseurl . $this->Forward->Options->Get( 'dashboard', 'dashboard' ) . '/ajax';
		}

		protected function AjaxNonce( $name )
		{
			return Crypter::Encrypt( 'ajax_' . $name . '_nonce', 'nonce' );
		}

		protected function BuildNonces()
		{
			$this->body_nonce = Crypter::BaseSalter(40);
			$this->js_nonce = Crypter::BaseSalter(40);
		}

		protected function SetBaseUrl()
		{
			$this->baseurl = $this->Forward->Options->Get('base_url', $this->Forward->Path->RequestURI());
		}
		
		protected function GetView()
		{
			require_once $this->themes . "pages/rdev-$this->name.php";
			exit;
		}

		protected function Title()
		{
			echo $this->Forward->Options->Get('site_name', 'Forward') . ($this->displayname != NULL ? ' | ' . $this->Forward->Translator->__($this->displayname) : '');
		}

		protected function Description()
		{
			return $this->Forward->Translator->__($this->Forward->Options->Get('site_description', 'Create your own link shortener'));
		}

		protected function GetHeader()
		{
			require_once $this->themes . 'rdev-header.php';
		}

		protected function GetFooter()
		{
			require_once $this->themes . 'rdev-footer.php';
		}

		protected function GetNavigation()
		{
			require_once $this->themes . 'rdev-navigation.php';
		}

		protected function GetImage($name)
		{
			return $this->baseurl . 'media/img/' . $name;
		}

		protected function SetPrefetch()
		{
			$this->prefetch = array(
				'//ogp.me',
				'//schema.org',
				'//cdnjs.cloudflare.com'
			);
		}

		protected function GetStyles()
		{
			$this->styles = array(
				array( 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css', 'sha512-weZatQD41YXNCVn3Bvl2y1iAZqtH/Y+MlAQUwovog1iwj8cbSEpQMeErMnDp9CBlqIo0oxOcOF8GUEoOZYD4Zg==', '5.0.0-alpha1' ),
				array( 'https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.4/chartist.min.css', 'sha512-V0+DPzYyLzIiMiWCg3nNdY+NyIiK9bED/T1xNBj08CaIUyK3sXRpB26OUCIzujMevxY9TRJFHQIxTwgzb0jVLg==', '0.11.4'),
				array( $this->baseurl . 'media/css/forward.css', '', FORWARD_VERSION )
			);
		}

		protected function GetScripts()
		{
			$this->scripts = array(
				array( 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js', 'sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==', '3.5.1' ),
				array( 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js', 'sha512-hCP3piYGSBPqnXypdKxKPSOzBHF75oU8wQ81a6OiGXHFMeKs9/8ChbgYl7pUvwImXJb03N4bs1o1DzmbokeeFw==', '2.4.4' ),
				array( 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/js/bootstrap.min.js', 'sha512-lmArColmgJ0LRo8c6rZwAhB3mVVSFSsrpqOrmtXMgOFYu8VOwdxTliXrHYdsdmututXwD0Xc1GiGvZlHgNAh4g==', '5.0.0-alpha1' ),
				array( 'https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js', 'sha512-TZlMGFY9xKj38t/5m2FzJ+RM/aD5alMHDe26p0mYUMoCF5G7ibfHUQILq0qQPV3wlsnCwL+TPRNK4vIWGLOkUQ==', '4.4.2' ),
				array( 'https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js', 'sha512-hDWGyh+Iy4Mr9AHOzUP2+Y0iVPn/BwxxaoSleEjH/i1o4EVTF/sh0/A1Syii8PWOae+uPr+T/KHwynoebSuAhw==', '2.0.6' ),
				array( 'https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.4/chartist.min.js' , 'sha512-9rxMbTkN9JcgG5euudGbdIbhFZ7KGyAuVomdQDI9qXfPply9BJh0iqA7E/moLCatH2JD4xBGHwV6ezBkCpnjRQ==', '0.11.4' ),
				array( $this->baseurl . 'media/js/forward.js', '', FORWARD_VERSION )
			);
		}

		public function Print()
		{
			$this->GetView();
			$this->Forward->Session->Close();
			//Kill script :(
			exit;
		}

		public function GetLanguages() : array
		{
			$query = $this->Forward->Database->query( "SELECT * FROM forward_statistics_languages" )->fetchAll();

			if( !empty( $query ) )
			{
				$languages = array();
				foreach ( $query as $lang )
				{
					$languages[ $lang[ 'language_id' ] ] = $lang[ 'language_name' ];
				}

				return $languages;
			}

			return array();
		}

		public function GetOrigins() : array
		{
			$query = $this->Forward->Database->query( "SELECT * FROM forward_statistics_origins" )->fetchAll();

			if( !empty( $query ) )
			{
				$origins = array();
				foreach ( $query as $origin )
				{
					$origins[ $origin[ 'origin_id' ] ] = $origin[ 'origin_name' ];
				}

				return $origins;
			}

			return array();
		}

		public function GetPlatforms() : array
		{
			$query = $this->Forward->Database->query( "SELECT * FROM forward_statistics_platforms" )->fetchAll();

			if( !empty( $query ) )
			{
				$platforms = array();
				foreach ( $query as $platform )
				{
					$platforms[ $platform[ 'platform_id' ] ] = $platform[ 'platform_name' ];
				}

				return $platforms;
			}

			return array();
		}

		public function GetAgents() : array
		{
			$query = $this->Forward->Database->query( "SELECT * FROM forward_statistics_agents" )->fetchAll();

			if( !empty( $query ) )
			{
				$agents = array();
				foreach ( $query as $agent )
				{
					$agents[ $agent[ 'agent_id' ] ] = $agent[ 'agent_name' ];
				}

				return $agents;
			}

			return array();
		}

		public function GetUsers() : array
		{
			$query = $this->Forward->Database->query( "SELECT * FROM forward_users" )->fetchAll();

			if( !empty( $query ) )
			{
				return $query;
			}

			return array();
		}
	}

?>