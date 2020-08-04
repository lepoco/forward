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
	* Session
	*
	* @author   Leszek Pomianowski <https://rdev.cc>
	* @license	MIT License
	* @access   public
	*/
	class Session
	{
		/**
		* Open
		* Opens a new session
		*
		* @access   public
		* @return   void
		*/
		public function Open() : void
		{
			session_start();
			session_regenerate_id();
		}

		/**
		* Destroy
		* Destroys the session and data in it
		*
		* @access   public
		* @return   void
		*/
		public function Destroy() : void
		{
			session_destroy();
		}

		/**
		* Open
		* Closes the current session
		*
		* @access   public
		* @return   void
		*/
		public function Close() : void
		{
			
		}
	}

?>
