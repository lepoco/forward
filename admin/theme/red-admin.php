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

	if($logged_in){
		$this->page(['page' => 'dashboard', 'title' => 'Dashboard']);
	}else{
		$this->page(['page' => 'login', 'title' => 'Sign In']);
	}

?>