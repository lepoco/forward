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

			if ( isset( $_SERVER['HTTP_USER_AGENT'] ) )
			{
				if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Lynx' ) !== false )
					$this->agent = 'lynx';
				elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Edge' ) !== false )
					$this->agent = 'edge';
				elseif ( stripos( $_SERVER['HTTP_USER_AGENT'], 'chrome' ) !== false )
					$this->agent = 'chrome';
				elseif ( stripos( $_SERVER['HTTP_USER_AGENT'], 'safari' ) !== false )
					$this->agent = 'safari';
				elseif ( ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], 'Trident' ) !== false ) && strpos( $_SERVER['HTTP_USER_AGENT'], 'Win' ) !== false )
					$this->agent = 'internetexplorer';
				elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false && strpos( $_SERVER['HTTP_USER_AGENT'], 'Mac' ) !== false )
					$this->agent = 'internetexplorer';
				elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Gecko' ) !== false )
					$this->agent = 'gecko';
				elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera' ) !== false )
					$this->agent = 'opera';
				elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Nav' ) !== false && strpos( $_SERVER['HTTP_USER_AGENT'], 'Mozilla/4.' ) !== false )
					$this->agent = 'ns4';

				if ( ($this->agent == 'safari') && stripos( $_SERVER['HTTP_USER_AGENT'], 'mobile' ) !== false )
					$this->agent = 'iphone';
			}
		}

		protected function DetectPlaform() : void
		{
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$os_platform  = 'unknown';

			$os_array     = array(
				'/windows nt 10/i'      =>  'windows_10',
				'/windows nt 6.3/i'     =>  'windows_8.1',
				'/windows nt 6.2/i'     =>  'windows_8',
				'/windows nt 6.1/i'     =>  'windows_7',
				'/windows nt 6.0/i'     =>  'windows_vista',
				'/windows nt 5.2/i'     =>  'windows_server2003/xp_x64',
				'/windows nt 5.1/i'     =>  'windows_xp',
				'/windows xp/i'         =>  'windows_xp',
				'/windows nt 5.0/i'     =>  'windows_2000',
				'/windows me/i'         =>  'windows_me',
				'/win98/i'              =>  'windows_98',
				'/win95/i'              =>  'windows_95',
				'/win16/i'              =>  'windows_3.11',
				'/macintosh|mac os x/i' =>  'mac_ox_x',
				'/mac_powerpc/i'        =>  'mac_os_9',
				'/linux/i'              =>  'linux',
				'/ubuntu/i'             =>  'linux_ubuntu',
				'/iphone/i'             =>  'apple_iphone',
				'/ipod/i'               =>  'apple_ipod',
				'/ipad/i'               =>  'apple_ipad',
				'/android/i'            =>  'android',
				'/blackberry/i'         =>  'blackberry',
				'/nintendo wiiu/i'      =>  'nintendo_wiiu',
				'/nintendo 3ds/i'       =>  'nintendo_3ds',
				'/xbox/i'               =>  'xbox_one',
				'/xbox_one_ed/i'        =>  'xbox_one_s',
				'/playstation vita/i'   =>  'playstation_vita',
				'/playstation 4/i'      =>  'playstation_4',
				'/playstation 5/i'      =>  'playstation_5',
				'/webos/i'              =>  'mobile'
			);


			//var_dump($_SERVER['HTTP_USER_AGENT']);

			//$user_agent = 'Mozilla/5.0 (PlayStation 4 3.11) AppleWebKit/537.73 (KHTML, like Gecko)';
			//var_dump($user_agent);

			foreach ( $os_array as $regex => $value )
				if ( preg_match( $regex, $user_agent ) )
					$os_platform = $value;


			//var_dump($os_platform);
			//exit;

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
				$this->server = 'iis';

			/* Whether the server software is IIS 7.X or greater */
			if( ($this->server == 'IIS') && intval( substr( $_SERVER['SERVER_SOFTWARE'], strpos( $_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS/' ) + 14 ) ) >= 7 )
				$this->server = 'iis7';
		}
	}