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
	* Uri
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class Uri
	{
		/**
		 * Current first level page
		 *
		 * @access   public
		 * @var object
		 */
		public $pagenow = NULL;

		/**
		 * Whole URL path
		 *
		 * @access   public
		 * @var object
		 */
		public $trace = array();

		/**
		 * Whole URL path
		 *
		 * @access   public
		 * @var object
		 */
		public $ssl = FALSE;

		public function __construct()
		{
			if (!empty($_SERVER['HTTPS']))
				$this->ssl = TRUE;
		}

		/**
		* ScriptURI
		* Returns the curent request url
		*
		* @access   public
		* @return   string
		*/
		public function RequestURI() : string
		{
			return self::UrlFix( ($this->ssl ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		}

		/**
		* ScriptURI
		* Returns the curent script url
		*
		* @access   public
		* @return   string
		*/
		public function ScriptURI() : string
		{
			return self::UrlFix( ($this->ssl ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['SCRIPT_NAME'] ) );
		}

		/**
		* ScriptURI
		* Returns the curent script url
		*
		* @access   public
		* @return   string
		*/
		public function Redirect( string $url ) : void
		{
			header( 'Expires: on, 01 Jan 1970 00:00:00 GMT' );
			header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
			header( 'Cache-Control: no-store, no-cache, must-revalidate' );
			header( 'Cache-Control: post-check=0, pre-check=0', false );
			header( 'Pragma: no-cache' );
			header( 'Location: ' . $url );

			exit;
		}

		/**
		* GetLevel
		* Returns the selected level
		*
		* @access   public
		* @return   string
		*/
		public function GetLevel( int $lvl ) : string
		{
			if( isset( $this->trace[ $lvl + 1 ] ) )
				return $this->trace[ $lvl + 1 ];
			else
				return '';
		}

		/**
		* Parse
		* Analyzes and determines the current url
		*
		* @access   public
		* @return   void
		*/
		public function Parse() : void
		{
			$this->trace = explode( '/', parse_url(urldecode('/'.trim(str_replace(rtrim(dirname($_SERVER['SCRIPT_NAME']),'/'),'',$_SERVER['REQUEST_URI']),'/')))[ 'path' ] );

			if( !isset( $this->trace[ 0 ], $this->trace[ 1 ] ) )
				$this->pagenow = 'unknown';
			else
				$this->pagenow = filter_var( $this->trace[ 1 ], FILTER_SANITIZE_STRING );
		}

		/**
		* UrlFix
		* Removes unnecessary parentheses and validates the url
		*
		* @access   private
		* @param	string $p
		* @return   string $p
		*/
		private static function UrlFix( string $p ) : string
		{
			$p = str_replace( '\\', '/', trim( $p ) );
			return ( substr( $p, -1 ) != '/' ) ? $p .= '/' : $p;
		}
	}
