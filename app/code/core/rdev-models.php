<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
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
 * @license  MIT License
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
	 * Site address for ip location
	 *
	 * @var string
	 * @access protected
	 */
	protected $geoip = '';

	/**
	 * Record ID for quick add
	 *
	 * @var string
	 * @access protected
	 */
	protected string $new_record = '';

	/**
	 * __construct
	 * Class constructor
	 *
	 * @access   public
	 * @param	Forward $parent
	 * @param	string $name
	 * @param	string $displayname
	 */
	public function __construct(Forward &$parent, string $name, string $displayname)
	{
		$this->Forward = $parent;

		$this->name = $name;
		$this->displayname = $displayname;
		$this->themes = APPPATH . 'themes/';

		$this->SetGeoIP();

		$this->SetLanguage();

		$this->BuildNonces();

		$this->SetBaseUrl();
		$this->SetPrefetch();

		$this->GetStyles();
		$this->GetScripts();

		if (method_exists($this, 'Init'))
			$this->Init();

		if ($_GET != NULL)
			if (method_exists($this, 'Get'))
				$this->Get();
			else
				$this->GetView();

		if ($_POST != NULL)
			if (method_exists($this, 'Post'))
				if (method_exists($this, 'Get'))
					$this->Get();
				else
					$this->GetView();
			else
				$this->GetView();
	}

	protected function __($text = '')
	{
		return $this->Forward->Translator->__($text);
	}

	protected function _e($text = '')
	{
		return $this->Forward->Translator->_e($text);
	}

	protected function AjaxGateway()
	{
		return $this->baseurl . $this->Forward->Options->Get('dashboard', 'dashboard') . '/ajax';
	}

	protected function AjaxNonce($name)
	{
		return Crypter::Encrypt('ajax_' . $name . '_nonce', 'nonce');
	}

	protected function SetGeoIP()
	{
		$this->geoip = ' https://freegeoip.app/';
	}

	protected function SetLanguage()
	{
		// 1 - auto, browser
		// 2 - auto, geo
		// 3 - permanently
		if ($this->Forward->Options->Get('dashboard_language_mode', 1) == 3) {
			$this->Forward->Translator->SetLocale($this->Forward->Options->Get('dashboard_language', 'en_US'));
		}

		$this->Forward->Translator->Init();
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
			'//cdn.jsdelivr.net'
		);
	}

	protected function GetJSTranslator()
	{
		return array(
			//Strings
			'of clicks' => $this->__('of clicks'),
			'unknown'   => $this->__('Unknown'),
			'nodata'    => $this->__('No data'),
			'success'   => $this->__('Success!'),
			'error'     => $this->__('Error!'),
			'error_qa'  => $this->__('Quick add error!'),
			'e1'        => $this->__('Something went wrong!'),
			'e7'        => $this->__('You must provide a URL!'),
			'e8'        => $this->__('A record with this ID already exists!'),
			'e10'       => $this->__('The URL you entered is not valid!'),

			//Languages
			'en-gb'     => $this->__('English (United Kingdom)'),
			'en-us'     => $this->__('English (United States)'),

			//Origins
			'direct'     => $this->__('Email, SMS, Direct'),

			//Platforms
			'windows_10' => 'Windows 10',
			'windows_81' => 'Windows 8.1',
			'windows_8' => 'Windows 8',
			'windows_7' => 'Windows 7',
			'windows_vista' => 'Windows Vista',
			'windows_xp' => 'Windows XP',
			'windows' => 'Windows (Other)',
			'windows_ce' => 'Windows CE',
			'apple' => 'Apple',
			'linux' => 'Linux',
			'os_2' => 'OS/2',
			'beos' => 'BeOS',
			'iphone' => 'iPhone',
			'ipod' => 'iPod',
			'ipad' => 'iPad',
			'blackberry' => 'Blackberry',
			'nokia' => 'Nokia',
			'freebsd' => 'Free BSD',
			'openbsd' => 'Open BSD',
			'netbsd' => 'Net BSD',
			'sunos' => 'Sun OS',
			'opensolaris' => 'Open Solaris',
			'android' => 'Android',
			'sony_playstation' => 'Playstation',
			'roku' => 'Roku',
			'apple_tv' => 'Apple TV',
			'terminal' => 'Terminal',
			'fire_os' => 'Fire OS',
			'smart_tv' => 'Smart TV',
			'chrome_os' => 'Chrome OS',
			'java_android' => 'Java/Android',
			'postman' => 'Postman',
			'iframely' => 'iFramely',

			//Agents
			'opera' => 'Opera',
			'opera_mini' => 'Opera Mini',
			'webtv' => 'WebTV',
			'edge' => 'MS Edge',
			'internet_explorer' => 'MS IE',
			'pocket_internet_explorer' => 'MS IE Pocket',
			'konqueror' => 'Konqueror',
			'icab' => 'iCab',
			'omniweb' => 'OmniWeb',
			'firebird' => 'AAA',
			'firefox' => 'Firefox',
			'brave' => 'Brave',
			'palemoon' => 'Palemoon',
			'iceweasel' => 'AAA',
			'shiretoko' => 'AAA',
			'mozilla' => 'Mozilla (Other)',
			'amaya' => 'Amaya',
			'lynx' => 'Lynx',
			'safari' => 'Safari',
			'chrome' => 'Chrome',
			'google_bot' => 'Google Bot',
			'curl' => '#CURL',
			'wget' => '#WGET',
			'uc_browser' => 'UC Browser',
			'yandex_bot' => 'Yandex Bot',
			'yandex_image_resizer' => 'Yahoo Image Resizer',
			'yandex_images' => 'Yahoo Images',
			'yandex_video' => 'Yahoo Video',
			'yandex_media' => 'Yahoo Media',
			'yandex_blogs' => 'Yahoo Blogs',
			'yandex_favicons' => 'Yahoo Favicons',
			'yandex_webmaster' => 'Yahoo WebMaster',
			'yandex_direct' => 'Yahoo Direct',
			'yandex_metrika' => 'Yahoo Metrika',
			'yandex_news' => 'Yahoo News',
			'yandex_catalog' => 'Yahoo Catalog',
			'yahoo_slurp' => 'Yahoo Slurp',
			'w3c_validator' => 'W3C Validator',
			'icecat' => 'Icecat',
			'nokia_s60_oss_browser' => 'Nokia S60',
			'nokia_browser' => 'Nokia Browser',
			'msn_browser' => 'MSN Browser',
			'msn_bot' => 'MSN Bot',
			'bing_bot' => 'Bing Bot',
			'vivaldi' => 'Vivaldi',
			'yandex' => 'Yandex',
			'netscape_navigator' => 'Netscape Navigator',
			'galeon' => 'Galeon',
			'netpositive' => 'NetPositive',
			'phoenix' => 'Phoenix',
			'playstation' => 'Playstation Browser',
			'samsungbrowser' => 'Samsung Browser',
			'silk' => 'Silk',
			'iframely' => 'Iframely',
			'cocoarestclient' => 'Cocoa Rest Client',
		);
	}

	protected function GetHeaderJson()
	{
		$forwardJson = array(
			'pagenow' => $this->name,
			'usernonce' => $this->body_nonce,
			'baseurl' => $this->baseurl,
			'version' => FORWARD_VERSION,
			'ajax' => ($this->name != 'home' ? $this->AjaxGateway() : ''),
			'getrecord' => $this->AjaxNonce('get_record_data'),
			'removerecord' => $this->AjaxNonce('remove_record')
		);

		$forwardJson['translator'] = $this->GetJSTranslator();
		$forwardJson['months'] = array(
			$this->__('January'),
			$this->__('February'),
			$this->__('March'),
			$this->__('April'),
			$this->__('May'),
			$this->__('June'),
			$this->__('July'),
			$this->__('August'),
			$this->__('September'),
			$this->__('October'),
			$this->__('November'),
			$this->__('December')
		);
		$forwardJson['months_short'] = array(
			$this->__('Jan'),
			$this->__('Feb'),
			$this->__('Mar'),
			$this->__('Apr'),
			$this->__('May'),
			$this->__('Jun'),
			$this->__('Jul'),
			$this->__('Aug'),
			$this->__('Sep'),
			$this->__('Oct'),
			$this->__('Nov'),
			$this->__('Dec')
		);

		if ($this->Forward->User->IsLoggedIn() && $this->name != 'home') {
			$visitors = array(
				'languages' => array(),
				'origins' => array(),
				'platforms' => array(),
				'agents' => array()
			);
			foreach ($this->GetLanguages() as $key => $agent) {
				$visitors['languages'][$key] = $agent;
			}
			foreach ($this->GetOrigins() as $key => $agent) {
				$visitors['origins'][$key] = $agent;
			}
			foreach ($this->GetPlatforms() as $key => $agent) {
				$visitors['platforms'][$key] = $agent;
			}
			foreach ($this->GetAgents() as $key => $agent) {
				$visitors['agents'][$key] = $agent;
			}
			$forwardJson['visitors'] = $visitors;

			$forwardJson['users'] = array();
			foreach ($this->GetUsers() as $user) {
				$forwardJson['users'][] = array($user['user_id'], $user['user_display_name'], $user['user_email']);
			}
		}

		echo '<script type="text/javascript" nonce="' . $this->js_nonce . '">let forward = ' . json_encode($forwardJson, JSON_UNESCAPED_UNICODE) . ';</script>' . PHP_EOL;
	}

	protected function GetStyles()
	{
		$this->styles = Constants::$forwardStyles;
		$this->styles[] = array($this->baseurl . 'media/css/forward.min.css', '', FORWARD_VERSION);
	}

	protected function GetScripts()
	{
		if ($this->name != 'home') {
			$this->scripts = Constants::$forwardScripts;
			$this->scripts[] = array($this->baseurl . 'media/js/forward-pages.min.js', '', FORWARD_VERSION);
			$this->scripts[] = array($this->baseurl . 'media/js/forward.min.js', '', FORWARD_VERSION);
		} else {
			$this->scripts = array();
		}
	}

	public function Print()
	{
		$this->GetView();
		$this->Forward->Session->Close();
		//Kill script :(
		exit;
	}

	public function GetLanguages(): array
	{
		$query = $this->Forward->Database->query("SELECT * FROM forward_statistics_languages")->fetchAll();

		if (!empty($query)) {
			$languages = array();
			foreach ($query as $lang) {
				$languages[$lang['language_id']] = $lang['language_name'];
			}

			return $languages;
		}

		return array();
	}

	public function GetOrigins(): array
	{
		$query = $this->Forward->Database->query("SELECT * FROM forward_statistics_origins")->fetchAll();

		if (!empty($query)) {
			$origins = array();
			foreach ($query as $origin) {
				$origins[$origin['origin_id']] = $origin['origin_name'];
			}

			return $origins;
		}

		return array();
	}

	public function GetPlatforms(): array
	{
		$query = $this->Forward->Database->query("SELECT * FROM forward_statistics_platforms")->fetchAll();

		if (!empty($query)) {
			$platforms = array();
			foreach ($query as $platform) {
				$platforms[$platform['platform_id']] = $platform['platform_name'];
			}

			return $platforms;
		}

		return array();
	}

	public function GetAgents(): array
	{
		$query = $this->Forward->Database->query("SELECT * FROM forward_statistics_agents")->fetchAll();

		if (!empty($query)) {
			$agents = array();
			foreach ($query as $agent) {
				$agents[$agent['agent_id']] = $agent['agent_name'];
			}

			return $agents;
		}

		return array();
	}

	public function GetUsers(): array
	{
		$query = $this->Forward->Database->query("SELECT * FROM forward_users")->fetchAll();

		if (!empty($query)) {
			return $query;
		}

		return array();
	}

	public function NewRecord(): string
	{
		if ($this->new_record == '')
			$this->new_record = strtoupper(Crypter::BaseSalter(5));

		return $this->new_record;
	}
}
