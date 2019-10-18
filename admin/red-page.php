<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

	namespace Forward;

	class RED_PAGES
	{
		private $title;
		private $uri;

		private $DB;

		public function __construct($data, $db)
		{	
			$this->DB = $db;

			if(isset($data['page']))
				$page = $data['page'];
			else
				$page = '404';

			if(isset($data['title']))
				$this->title = $data['title'];
			else
				$this->title = NULL;

			if (is_file(ADMPATH.'theme/red-'.$page.'.php'))
				require_once(ADMPATH.'theme/red-'.$page.'.php');
			else
				echo 'Page file not found';
		}

		private function home_url()
		{
			if($this->uri == null)
				$this->uri = $this->DB['options']->get('siteurl')->value;

			return $this->uri;
		}

		private function title()
		{
			return RED_NAME . ($this->title != null ? ' | '.$this->title : '');
		}

		private function menu()
		{

			$menu = array(
				'dashboard' => array('Dashboard', 'dashboard'),
				'users' => array('Users', 'dashboard/users'),
				'about' => array('About', 'dashboard/about'),
				'signout' => array('Sign Out', 'dashboard/signout'),
			);

			if(defined('RED_DASHBOARD'))
				$page = RED_DASHBOARD;
			else
				$page = 'dashboard';

			$html = '<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">';
			$html .= '<a class="navbar-brand" href="'.self::home_url().'dashboard"><picture id="forward-navbar-logo"><source srcset="'.self::home_url().'admin/img/forward-logo-wt.webp" type="image/webp"><source srcset="'.self::home_url().'admin/img/forward-logo-wt.png" type="image/png"><img alt="This is my face" src="'.self::home_url().'admin/img/forward-logo-wt.png"></picture></a>';
			$html .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#forward-navbar" aria-controls="forward-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>';
			$html .= '<div class="collapse navbar-collapse navbar-right" id="forward-navbar"><ul class="navbar-nav">';

			foreach ($menu as $key => $value) {
				$html .= '<li class="nav-item'.($page == $key ? ' active' : '').'"><a class="nav-link" href="'.self::home_url().$value[1].'">'.$value[0].'</a></li>';
			}
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
