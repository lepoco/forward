<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	
	$logged_in = true;

	if(!$logged_in){
		$this->page(['page' => 'login', 'title' => 'Sign In']);
	}else{
		if(defined('RED_DASHBOARD'))
		{
			if(RED_DASHBOARD == 'users'){
				$this->page(['page' => 'users', 'title' => 'Users']);
			}else if(RED_DASHBOARD == 'about'){
				$this->page(['page' => 'about', 'title' => 'About']);
			}else if(RED_DASHBOARD == 'signout'){
				echo 'signout';
			}else{
				$this->page(['title' => 'Dashboard page not found']);
			}
		}else{
			$this->page(['page' => 'dashboard', 'title' => 'Dashboard']);
		}
	}


?>