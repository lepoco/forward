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
	* API
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class API
	{
        /*
         * Actions:
         * create
         * read
         * update
         * delete
         * 
         * Authorization:
         * token
         * token should have expiration date, max 12 months
         * 
         * Parameters:
         * single= //whether we select single post
         * count= //how many recent posts
         * new_url= //if update action, new url
         * id= //post id
         * il= //include languages
         * ib= //include browsers
         * ip= //include platforms
         * ir= //include referers
         * 
         * ?action=read&token=jkiju12894j81924h&id=
         */

         public function print_response()
         {
             $data = array(
                'code' => 1, //1 success, 0 - unknown error, 2 - ...
                'kind' => 'forwardUpdateLinks',
                'etag' => 'QwjtrYbwdO6eAMnCCVyqDgHPkco',
                'info' => array(
                    'action' => 'create',
                    'requested_id' => 4,
                    'total_results' => 8,
                    'timestamp' => '54124511',
                    'execution_time' => '451'
                ),
                'request_parameters' => array(
                    'include_languages' => true,
                    'include_browsers' => true,
                    'include_platforms' => true,
                    'include_referers' => true
                ),
                'items' => array(),
                'error' => ''
             );
         }
    }