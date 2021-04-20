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
	 * Site address for ip location
	 *
	 * @var string
	 * @access protected
	 */
	protected $geoip = '';

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

	protected function GetStyles()
	{
		$this->styles = array(
			array('https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css', 'sha256-DU9iQBJ89dHP2iyusCg++0ych55DAx8QL6P8CYU64bI=', '5.0.0-beta3'),
			array('https://cdn.jsdelivr.net/npm/chartist@0.11.4/dist/chartist.min.css', 'sha256-seGyqLj5T52Hx8W7/YTajtNXGXQf+IksfkcaKGoTkbY=', '0.11.4'),
			array($this->baseurl . 'media/css/forward.min.css', '', FORWARD_VERSION)
		);
	}

	protected function GetScripts()
	{
		$this->scripts = array(
			array('https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js', 'sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=', '3.6.0'),
			array('https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js', 'sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf', '5.0.0-beta3'),
			array('https://cdn.jsdelivr.net/npm/zxcvbn@4.4.2/dist/zxcvbn.js', 'sha256-9CxlH0BQastrZiSQ8zjdR6WVHTMSA5xKuP5QkEhPNRo=', '4.4.2'),
			array('https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js', 'sha256-DhdpoP64xch/Frz8CiBQE12en55NX+RhlPGRg6KWm5s=', '1.4.4'),
			array('https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js', 'sha256-Eb6SfNpZyLYBnrvqg4KFxb6vIRg+pLg9vU5Pv5QTzko=', '2.0.8'),
			array('https://cdn.jsdelivr.net/npm/chartist@0.11.4/dist/chartist.min.js', 'sha256-xNhpuwaNiVdna6L8Wy3GNuQz1z+SCmo4NY1c7cJ9Vdc=', '0.11.4'),
			array('https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js', 'sha256-KSlsysqp7TXtFo/FHjb1T9b425x3hrvzjMWaJyKbpcI=', '3.6.0'),
			array($this->baseurl . 'media/js/forward.min.js', '', FORWARD_VERSION)
		);
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
}
