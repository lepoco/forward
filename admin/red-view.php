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
	* RED_VIEW
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @version  $Id: red-view.php;RED_VIEW,v beta 1.0 2020/02/08
	* @access   public
	*/
	class RED_VIEW
	{
		private $title;
		private $uri;
		private $mediauri;

		private $RED;

		private $LANG;
		private $LANG_ARR;

		private $VIEW_DATA;

		/**
		* __construct
		* Displays the page
		*
		* @access   public
		* @param	array $data
		* @param	object RED
		* @return   void
		*/
		public function __construct(array $data, RED $RED)
		{	
			$this->RED = $RED;

			if(isset($data['page']))
				$page = $data['page'];
			else
				$page = '404';

			if($page == '404')
				self::error404();

			if($page == 'home')
				self::homepage();

			if(isset($data['title']))
				$this->title = $data['title'];
			else
				$this->title = NULL;

			if(isset($data['view_data']))
				$this->VIEW_DATA = $data['view_data'];

			self::print_page($page);
		}

		/**
		* print_page
		* Displays the selected page theme
		*
		* @access   private
		* @param    string $name
		* @return   void
		*/
		private function print_page(string $name) : void
		{
			if (is_file(ADMPATH.'theme/red-'.$name.'.php'))
				require_once(ADMPATH.'theme/red-'.$name.'.php');
			else
				exit(RED_DEBUG ? 'Page '.$name.' file not found!' : '');
		}

		/**
		* error404
		* Displays a 404 error or performs redirects
		*
		* @access   private
		* @return   void
		*/
		private function error404() : void
		{
			if($this->RED->DB['options']->get('redirect_404')->value)
			{
				$redirect_url = $this->RED->DB['options']->get('redirect_404_url')->value;
				if(!empty($redirect_url))
				{
					header('HTTP/1.1 301 Moved Permanently');
					header('Location: ' . $redirect_url);
					exit;
				}
			}
			self::print_page('404');
		}

		/**
		* home
		* Displays the home page or performs redirects
		*
		* @access   private
		* @return   void
		*/
		private function homepage() : void
		{
			if($this->RED->DB['options']->get('redirect_home')->value)
			{
				$redirect_url = $this->RED->DB['options']->get('redirect_home_url')->value;
				if(!empty($redirect_url))
				{
					header('HTTP/1.1 301 Moved Permanently');
					header('Location: ' . $redirect_url);
					exit;
				}
			}
			self::print_page('home');
		}

		/**
		* home_url
		* Returns the main website address
		*
		* @access   private
		* @return   string $this->uri
		*/
		private function home_url() : string
		{
			if($this->uri == null)
				$this->uri = $this->RED->DB['options']->get('siteurl')->value;

			return $this->uri;
		}

		/**
		* media_url
		* Returns the URL to the media folder
		*
		* @access   private
		* @return   string mediauri
		*/
		private function media_url() : string
		{
			if($this->mediauri == null)
				$this->mediauri = $this->RED->DB['options']->get('siteurl')->value.RED_MEDIA;

			return $this->mediauri;
		}

		/**
		* title
		* Returns the translated title of the site
		*
		* @access   private
		* @return   string title
		*/
		private function title() : string
		{
			return RED_NAME . ($this->title != null ? ' | '.$this->e($this->title) : '');
		}

		/**
		* e
		* Returns a translated piece of text based on a defined language
		*
		* @access   private
		* @param	string $raw_text
		* @return   string translated_text
		*/
		private function e(string $raw_text) : string
		{
			if($this->LANG == NULL)
			{
				if($this->RED->DB['options']->get('language_type')->value == 1)
					$lang = $this->RED->parse_language($_SERVER['HTTP_ACCEPT_LANGUAGE']);
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

			if(array_key_exists($raw_text, $this->LANG_ARR))
				return $this->LANG_ARR[$raw_text];
			else
				return $raw_text;
		}

		/**
		* menu
		* Prints the main menu of the administration panel
		*
		* @access   private
		* @return   void (echo)
		*/
		private function menu() : void
		{
			$menu = array('dashboard' => array($this->e('Dashboard'), RED_DASHBOARD));

			if($this->RED->is_admin())
			{
				$menu['users'] = array($this->e('Users'), RED_DASHBOARD.'/users');
				$menu['settings'] = array($this->e('Settings'), RED_DASHBOARD.'/settings');
			}

			if(defined('RED_PAGE_DASHBOARD'))
				$page = RED_PAGE_DASHBOARD;
			else
				$page = 'dashboard';

			$html = '<nav id="main-nav" class="navbar navbar-expand-lg navbar-dark bg-dark">';
			$html .= '<a class="navbar-brand" href="'.self::home_url().RED_DASHBOARD.'"><picture id="forward-navbar-logo"><source srcset="'.self::media_url().'/img/forward-logo-wt.webp" type="image/webp"><source srcset="'.self::media_url().'/img/forward-logo-wt.png" type="image/png"><img alt="Forward logo" src="'.self::media_url().'/img/forward-logo-wt.png"></picture></a>';
			$html .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#forward-navbar" aria-controls="forward-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
			$html .= '<div class="collapse navbar-collapse navbar-right" id="forward-navbar"><ul class="navbar-nav">';

			foreach ($menu as $key => $value) {
				$html .= '<li class="nav-item'.($page == $key ? ' active' : '').'"><a class="nav-link" href="'.self::home_url().$value[1].'">'.$value[0].'</a></li>';
			}
			$html .= '<li class="nav-item'.($page == 'about' ? ' active' : '').'"><a class="nav-link" href="'.self::home_url().RED_DASHBOARD.'/about"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path d="M11,18H13V16H11V18M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,6A4,4 0 0,0 8,10H10A2,2 0 0,1 12,8A2,2 0 0,1 14,10C14,12 11,11.75 11,15H13C13,12.75 16,12.5 16,10A4,4 0 0,0 12,6Z" /></svg></a></li>';
			$html .= '<li class="nav-item"><a class="nav-link" href="'.self::home_url().RED_DASHBOARD.'/signout"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path d="M13,3H11V13H13V3M17.83,5.17L16.41,6.59C18.05,7.91 19,9.9 19,12A7,7 0 0,1 12,19C8.14,19 5,15.88 5,12C5,9.91 5.95,7.91 7.58,6.58L6.17,5.17C2.38,8.39 1.92,14.07 5.14,17.86C8.36,21.64 14.04,22.1 17.83,18.88C19.85,17.17 21,14.65 21,12C21,9.37 19.84,6.87 17.83,5.17Z" /></svg></a></li>';
			$html .= '</ul></div></nav>';

			echo $html;
		}

		/**
		* queue_styles
		* Prints all scripts
		*
		* @access   private
		* @return   void
		*/
		private function queue_scripts() : void
		{
			$scripts = array(
				'/js/jquery-3.4.1.js',
				'/js/popper.min.js',
				'/js/bootstrap.min.js',
				'/js/chartist.min.js',
				'/js/clipboard.min.js'
			);

			foreach ($scripts as $script)
				echo '<script src="'.self::media_url().$script.'"></script>';
		}

		/**
		* queue_styles
		* Prints all styles
		*
		* @access   private
		* @return   void
		*/
		private function queue_styles() : void
		{
			$styles = array(
				'https://fonts.googleapis.com/css?family=Montserrat:300,400,700&display=swap',
				self::media_url().'/css/bootstrap.min.css',
				self::media_url().'/css/red.css',
				self::media_url().'/css/chartist.css'
			);

			foreach ($styles as $style)
				echo '<link href="'.$style.'" rel="stylesheet">';
		}

		/**
		* head
		* Prints the head part of the panel page
		*
		* @access   private
		* @return   void (echo)
		*/
		private function head() : void
		{
			if (is_file(ADMPATH.'theme/red-head.php'))
				require_once(ADMPATH.'theme/red-head.php');
			else
				echo 'Header file not found';
		}

		/**
		* footer
		* Prints the footer part of the panel page
		*
		* @access   private
		* @return   void (echo)
		*/
		public function footer() : void
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
