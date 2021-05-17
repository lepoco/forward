<?php

/**
 * @package   Forward
 *
 * @author    RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link      https://www.rdev.cc/forward
 * @license   https://opensource.org/licenses/MIT
 */

namespace Forward\Core;

use Forward\Forward;
use Forward\Assets\Constants;
//use const Forward\Components\Constants\STYLES;

defined('ABSPATH') or die('No script kiddies please!');

class Models
{
    /**
     * Forward class instance
     *
     * @var Forward
     * @access protected
     */
    protected Forward $Forward;

    /**
     * Basename of view
     *
     * @var string
     * @access protected
     */
    protected string $name;

    /**
     * Displayed name in title
     *
     * @var string
     * @access protected
     */
    protected string $displayname;

    /**
     * Views path
     *
     * @var string
     * @access protected
     */
    protected string $views;

    /**
     * Root url of website
     *
     * @var string
     * @access protected
     */
    protected string $baseurl;

    /**
     * Nonce for secured javascript 
     *
     * @var string
     * @access protected
     */
    protected string $js_nonce;

    /**
     * Nonce for DOM verification
     *
     * @var string
     * @access protected
     */
    protected string $body_nonce;

    /**
     * Record ID for quick add
     *
     * @var string
     * @access protected
     */
    protected string $new_record = '';

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
        $this->views = APPPATH . 'views/';

        $this->setLanguage();

        $this->buildNonces();

        $this->setBaseUrl();
        $this->setPrefetch();

        $this->getStyles();
        $this->getScripts();

        if (method_exists($this, 'init'))
            $this->{'init'}();

        if ($_GET != NULL)
            if (method_exists($this, 'get'))
                $this->{'get'}();
            else
                $this->getView();

        if ($_POST != NULL)
            if (method_exists($this, 'Post'))
                if (method_exists($this, 'Get'))
                    $this->{'get'}();
                else
                    $this->getView();
            else
                $this->getView();
    }

    protected function __($text = ''): ?string
    {
        return $this->Forward->Translator->__($text);
    }

    protected function _e($text = '')
    {
        return $this->Forward->Translator->_e($text);
    }

    protected function ajaxGateway()
    {
        return $this->baseurl . $this->Forward->Options->get('dashboard', 'dashboard') . '/ajax';
    }

    protected function ajaxNonce($name)
    {
        return Crypter::encrypt('ajax_' . $name . '_nonce', 'nonce');
    }

    protected function setLanguage()
    {
        // 1 - auto, browser
        // 2 - auto, geo
        // 3 - permanently
        if ($this->Forward->Options->get('dashboard_language_mode', 1) == 3) {
            $this->Forward->Translator->setLocale($this->Forward->Options->get('dashboard_language', 'en_US'));
        }

        $this->Forward->Translator->init();
    }

    protected function buildNonces()
    {
        $this->body_nonce = Crypter::salter(64, 'ULN');
        $this->js_nonce = Crypter::salter(64, 'ULN');
    }

    protected function setBaseUrl()
    {
        $this->baseurl = $this->Forward->Options->get('base_url', $this->Forward->Path->requestURI());
    }

    protected function getView()
    {
        require_once $this->views . "$this->name.php";
        exit;
    }

    protected function title()
    {
        echo $this->Forward->Options->get('site_name', 'Forward') . ($this->displayname != NULL ? ' | ' . $this->Forward->Translator->__($this->displayname) : '');
    }

    protected function description()
    {
        return $this->Forward->Translator->__($this->Forward->Options->get('site_description', 'Create your own link shortener'));
    }

    protected function getHeader()
    {
        require_once $this->views . 'components\header.php';
    }

    protected function getFooter()
    {
        require_once $this->views . 'components\footer.php';
    }

    protected function getNavigation()
    {
        require_once $this->views . 'components\navigation.php';
    }

    protected function getImage($name)
    {
        return $this->baseurl . (PUBLIC_PATH == 'root' ? 'public/' : '/') . 'img/' . $name;
    }

    protected function getBackgrounds()
    {
        return Constants::BACKGROUNDS[rand(0, count(Constants::BACKGROUNDS) - 1)];
    }

    protected function setPrefetch()
    {
        $this->prefetch = array(
            '//ogp.me',
            '//schema.org',
            '//cdn.jsdelivr.net'
        );
    }

    protected function getJSTranslator()
    {
        return array(
            //Strings
            'of clicks' => $this->__('of clicks'),
            'strength'  => $this->__('Strength'),
            'unknown'   => $this->__('Unknown'),
            'nodata'    => $this->__('No data'),
            'success'   => $this->__('Success!'),
            'error'     => $this->__('Error!'),
            'error_qa'  => $this->__('Quick add error!'),
            'e1'        => $this->__('Something went wrong!'),
            'e7'        => $this->__('You must provide a URL!'),
            'e8'        => $this->__('A record with this ID already exists!'),
            'e10'       => $this->__('The URL you entered is not valid!'),

            'worst'     => $this->__('Worst'),
            'bad'       => $this->__('Bad'),
            'weak'      => $this->__('Weak'),
            'good'      => $this->__('Good'),
            'strong'    => $this->__('Strong'),

            //Languages
            'en-gb'     => $this->__('English (UK)'),
            'en-us'     => $this->__('English (US)'),
            'pl-pl'     => $this->__('Polish'),

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
            'ajax' => ($this->name != 'home' ? $this->ajaxGateway() : ''),
            'getrecord' => $this->ajaxNonce('get_record_data'),
            'removerecord' => $this->ajaxNonce('remove_record')
        );

        $forwardJson['translator'] = $this->getJSTranslator();
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

        if ($this->Forward->User->isLoggedIn() && $this->name != 'home') {
            $visitors = array(
                'languages' => array(),
                'origins' => array(),
                'platforms' => array(),
                'agents' => array()
            );
            foreach ($this->getLanguages() as $key => $agent) {
                $visitors['languages'][$key] = $agent;
            }
            foreach ($this->getOrigins() as $key => $agent) {
                $visitors['origins'][$key] = $agent;
            }
            foreach ($this->getPlatforms() as $key => $agent) {
                $visitors['platforms'][$key] = $agent;
            }
            foreach ($this->getAgents() as $key => $agent) {
                $visitors['agents'][$key] = $agent;
            }
            $forwardJson['visitors'] = $visitors;

            $forwardJson['users'] = array();
            foreach ($this->getUsers() as $user) {
                $forwardJson['users'][] = array($user['user_id'], $user['user_display_name'], $user['user_email']);
            }
        }

        echo '<script type="text/javascript" nonce="' . $this->js_nonce . '">let forward = ' . json_encode($forwardJson, JSON_UNESCAPED_UNICODE) . ';</script>' . PHP_EOL;
    }

    protected function getStyles()
    {
        $this->styles = Constants::STYLES;
        $this->styles[] = array($this->baseurl . (PUBLIC_PATH == 'root' ? 'public/' : '/') . 'css/forward.min.css', '', FORWARD_VERSION);
    }

    protected function getScripts()
    {
        if ($this->name != 'home') {
            $this->scripts = Constants::SCRIPTS;
            $this->scripts[] = array($this->baseurl . (PUBLIC_PATH == 'root' ? 'public/' : '/') . 'js/forward.min.js', '', FORWARD_VERSION, 'module');
        } else {
            $this->scripts = array();
        }
    }

    public function print()
    {
        $this->getView();
        //Kill script :(
        exit;
    }

    public function getLanguages(): array
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

    public function getOrigins(): array
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

    public function getPlatforms(): array
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

    public function getAgents(): array
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

    public function getUsers(): array
    {
        $query = $this->Forward->Database->query("SELECT * FROM forward_users")->fetchAll();

        if (!empty($query)) {
            return $query;
        }

        return array();
    }

    public function newRecord(): string
    {
        if ($this->new_record == '')
            $this->new_record = strtoupper(Crypter::salter(5, 'UN'));

        return $this->new_record;
    }
}
