<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;
	defined('ABSPATH') or die('No script kiddies please!');

	class RED_PAGES
	{
		private $title;
		private $uri;

		private $RED;

		private $LANG;
		private $LANG_ARR;

		public function __construct($data, $RED)
		{	
			$this->RED = $RED;

			if(isset($data['page']))
				$page = $data['page'];
			else
				$page = '404';

			if($page == '404')
			{
				if($this->DB['options']->get('redirect_404')->value)
				{
					$home_url = $this->DB['options']->get('redirect_404_url')->value;
					if(!empty($home_url))
					{
						header('HTTP/1.1 301 Moved Permanently');
						header('Location: ' . $home_url);
						exit;
					}
				}
			}

			if(isset($data['title']))
				$this->title = $data['title'];
			else
				$this->title = NULL;

			if (is_file(ADMPATH.'theme/red-'.$page.'.php'))
				require_once(ADMPATH.'theme/red-'.$page.'.php');
			else
				exit(RED_DEBUG ? 'Page '.$page.' file not found!' : '');
		}

		private function home_url()
		{
			if($this->uri == null)
				$this->uri = $this->RED->DB['options']->get('siteurl')->value;

			return $this->uri;
		}

		private function title()
		{
			return RED_NAME . ($this->title != null ? ' | '.$this->e($this->title) : '');
		}

		private function e($string)
		{
			if($this->LANG == NULL)
			{
				if($this->RED->DB['options']->get('language_type')->value == 1)
					$lang = $this->RED->parseLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE']);
				else
					$lang = $this->RED->DB['options']->get('language_select')->value;
				
				switch ($lang)
				{
					case 'pl': case 'pl_PL':
						$this->LANG = 'pl_PL';
						break;
					case 'de': case 'de_DE':
						$this->LANG = 'de_DE';
						break;
					default:
						$this->LANG = 'en_EN';
						break;
				}
			}

			if(file_exists(ADMPATH.'/languages/'.$this->LANG.'.json'))
				$this->LANG_ARR = json_decode(file_get_contents(ADMPATH.'/languages/'.$this->LANG.'.json'), true);

			if(array_key_exists($string, $this->LANG_ARR))
				return $this->LANG_ARR[$string];
			else
				return $string;
		}

		private function menu()
		{
			$menu = array('dashboard' => array($this->e('Dashboard'), 'dashboard'));

			if($this->RED->is_admin())
			{
				$menu['users'] = array($this->e('Users'), 'dashboard/users');
				$menu['settings'] = array($this->e('Settings'), 'dashboard/settings');
			}

			if(defined('RED_PAGE_DASHBOARD'))
				$page = RED_PAGE_DASHBOARD;
			else
				$page = 'dashboard';

			$html = '<nav id="main-nav" class="navbar navbar-expand-lg navbar-dark bg-dark">';
			$html .= '<a class="navbar-brand" href="'.self::home_url().'dashboard"><picture id="forward-navbar-logo"><source srcset="'.self::home_url().'admin/img/forward-logo-wt.webp" type="image/webp"><source srcset="'.self::home_url().'admin/img/forward-logo-wt.png" type="image/png"><img alt="This is my face" src="'.self::home_url().'admin/img/forward-logo-wt.png"></picture></a>';
			$html .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#forward-navbar" aria-controls="forward-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
			$html .= '<div class="collapse navbar-collapse navbar-right" id="forward-navbar"><ul class="navbar-nav">';

			foreach ($menu as $key => $value) {
				$html .= '<li class="nav-item'.($page == $key ? ' active' : '').'"><a class="nav-link" href="'.self::home_url().$value[1].'">'.$value[0].'</a></li>';
			}
			$html .= '<li class="nav-item'.($page == 'about' ? ' active' : '').'"><a class="nav-link" href="'.self::home_url().'dashboard/about"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path d="M11,18H13V16H11V18M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,6A4,4 0 0,0 8,10H10A2,2 0 0,1 12,8A2,2 0 0,1 14,10C14,12 11,11.75 11,15H13C13,12.75 16,12.5 16,10A4,4 0 0,0 12,6Z" /></svg></a></li>';
			$html .= '<li class="nav-item"><a class="nav-link" href="'.self::home_url().'dashboard/signout"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path d="M13,3H11V13H13V3M17.83,5.17L16.41,6.59C18.05,7.91 19,9.9 19,12A7,7 0 0,1 12,19C8.14,19 5,15.88 5,12C5,9.91 5.95,7.91 7.58,6.58L6.17,5.17C2.38,8.39 1.92,14.07 5.14,17.86C8.36,21.64 14.04,22.1 17.83,18.88C19.85,17.17 21,14.65 21,12C21,9.37 19.84,6.87 17.83,5.17Z" /></svg></a></li>';
			$html .= '</ul></div></nav>';

			echo $html;
		}

		private function head()
		{
			if (is_file(ADMPATH.'theme/red-head.php'))
				require_once(ADMPATH.'theme/red-head.php');
			else
				echo 'Header file not found';
		}

		public function footer()
		{
			if (is_file(ADMPATH.'theme/red-footer.php'))
				require_once(ADMPATH.'theme/red-footer.php');
			else
				echo 'Footer file not found';

			//Stop everything after printing theme
			exit;
		}
	}
?>
