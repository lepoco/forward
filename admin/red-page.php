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
