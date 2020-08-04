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
	* Agent
	*
	* @license	MIT License
	* @access   public
	*/
	class Agent
	{
		protected $server = '';
		protected $platform = '';
		protected $agent = '';

		public function __construct()
		{
			$this->DetectServer();
			$this->DetectPlaform();
			$this->IsMobile();
		}

		public function GetAgent() : string
		{
			return $this->agent;
		}

		public function GetPlatform() : string
		{
			return $this->platform;
		}

		public function GetServer() : string
		{
			return $this->server;
		}

		protected function IsMobile() : void
		{
			// Simple browser detection
			$is_lynx   = false;
			$is_gecko  = false;
			$is_winIE  = false;
			$is_macIE  = false;
			$is_opera  = false;
			$is_NS4    = false;
			$is_safari = false;
			$is_chrome = false;
			$is_iphone = false;
			$is_edge   = false;

			if ( isset( $_SERVER['HTTP_USER_AGENT'] ) )
			{
				if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Lynx' ) !== false )
					$this->agent = 'Lynx';
				elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Edge' ) !== false )
					$this->agent = 'Edge';
				elseif ( stripos( $_SERVER['HTTP_USER_AGENT'], 'chrome' ) !== false )
					$this->agent = 'Chrome';
				elseif ( stripos( $_SERVER['HTTP_USER_AGENT'], 'safari' ) !== false )
					$this->agent = 'Safari';
				elseif ( ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], 'Trident' ) !== false ) && strpos( $_SERVER['HTTP_USER_AGENT'], 'Win' ) !== false )
					$this->agent = 'IE';
				elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false && strpos( $_SERVER['HTTP_USER_AGENT'], 'Mac' ) !== false )
					$this->agent = 'IE';
				elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Gecko' ) !== false )
					$this->agent = 'Gecko';
				elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera' ) !== false )
					$this->agent = 'Opera';
				elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Nav' ) !== false && strpos( $_SERVER['HTTP_USER_AGENT'], 'Mozilla/4.' ) !== false )
					$this->agent = 'NS4';

				if ( ($this->agent == 'Safari') && stripos( $_SERVER['HTTP_USER_AGENT'], 'mobile' ) !== false )
					$this->agent = 'iPhone';
			}
		}

		protected function DetectPlaform() : void
		{
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$os_platform  = 'unknown';

			$os_array     = array(
				'/windows nt 10/i'      =>  'Windows 10',
				'/windows nt 6.3/i'     =>  'Windows 8.1',
				'/windows nt 6.2/i'     =>  'Windows 8',
				'/windows nt 6.1/i'     =>  'Windows 7',
				'/windows nt 6.0/i'     =>  'Windows Vista',
				'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
				'/windows nt 5.1/i'     =>  'Windows XP',
				'/windows xp/i'         =>  'Windows XP',
				'/windows nt 5.0/i'     =>  'Windows 2000',
				'/windows me/i'         =>  'Windows ME',
				'/win98/i'              =>  'Windows 98',
				'/win95/i'              =>  'Windows 95',
				'/win16/i'              =>  'Windows 3.11',
				'/macintosh|mac os x/i' =>  'Mac OS X',
				'/mac_powerpc/i'        =>  'Mac OS 9',
				'/linux/i'              =>  'Linux',
				'/ubuntu/i'             =>  'Ubuntu',
				'/iphone/i'             =>  'iPhone',
				'/ipod/i'               =>  'iPod',
				'/ipad/i'               =>  'iPad',
				'/android/i'            =>  'Android',
				'/blackberry/i'         =>  'BlackBerry',
				'/webos/i'              =>  'Mobile'
			);

			foreach ($os_array as $regex => $value)
				if (preg_match($regex, $user_agent))
					$os_platform = $value;

			$this->platform = $os_platform;
		}

		protected function DetectServer() : void
		{
			/* Whether the server software is Apache or something else */
			if( strpos( $_SERVER['SERVER_SOFTWARE'], 'Apache' ) !== false || strpos( $_SERVER['SERVER_SOFTWARE'], 'LiteSpeed' ) !== false )
				$this->server = 'apache';

			/* Whether the server software is Nginx or something else */
			if( strpos( $_SERVER['SERVER_SOFTWARE'], 'nginx' ) !== false )
				$this->server = 'nginx';

			/* Whether the server software is IIS or something else */
			if( ! ($this->server == 'apache') && ( strpos( $_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS' ) !== false || strpos( $_SERVER['SERVER_SOFTWARE'], 'ExpressionDevServer' ) !== false ) )
				$this->server = 'IIS';

			/* Whether the server software is IIS 7.X or greater */
			if( ($this->server == 'IIS') && intval( substr( $_SERVER['SERVER_SOFTWARE'], strpos( $_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS/' ) + 14 ) ) >= 7 )
				$this->server = 'IIS7';
		}
	}