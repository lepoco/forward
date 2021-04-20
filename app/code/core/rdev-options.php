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
 * Options
 *
 * @author   Leszek Pomianowski <https://rdev.cc>
 * @license	MIT License
 * @access   public
 */
class Options
{
	/**
	 * Database instance
	 *
	 * @var Database
	 * @access private
	 */
	private $database;

	/**
	 * Options table
	 *
	 * @var array
	 * @access private
	 */
	private $options = array();

	/**
	 * __construct
	 * Class constructor
	 *
	 * @access   public
	 */
	public function __construct($db)
	{
		if ($db != null) {
			$this->database = $db;
			$this->Init();
		}
	}

	/**
	 * Init
	 * Get options from database
	 *
	 * @access   private
	 */
	private function Init()
	{
		$query = $this->database->query('SELECT * FROM forward_options')->fetchAll();

		if (!empty($query)) {
			foreach ($query as $option) {
				$this->options[$option['option_name']] = $option['option_value'];
			}
		}
	}

	/**
	 * Update
	 * Update option in array and database
	 *
	 * @access   public
	 */
	public function Update($name, $value)
	{
		$query = null;

		if ($this->database != null) {
			if (isset($this->options[$name])) {
				if ($this->options[$name] != $value)
					$query = $this->database->query("UPDATE forward_options SET option_value = ? WHERE option_name = ?", $this->SerializeType($value), $name);
			} else {
				$query = $this->database->query("INSERT INTO forward_options (option_value, option_name) VALUES (?,?)", $this->SerializeType($value), $name);
			}
		}

		$this->options[$name] = $value;
	}

	/**
	 * Get
	 * Get option from array
	 *
	 * @access   public
	 */
	public function Get($name, $default = NULL, $raw = false)
	{
		if (isset($this->options[$name])) {
			return ($raw ? $this->options[$name] : $this->DeserializeType($this->options[$name]));
		} else {
			return $default;
		}
	}

	/**
	 * DeserializeType
	 * Returns parsed option to selected data type
	 *
	 * @access   public
	 */
	private function DeserializeType($option)
	{
		if ($option === 'true') {
			return true;
		} else if ($option === 'false') {
			return false;
		} else if (is_int($option)) {
			return intval($option);
		} else {
			return $option;
		}
	}

	/**
	 * SerializeType
	 * Returns serialized option to db format
	 *
	 * @access   public
	 */
	private function SerializeType($option)
	{
		if ($option === true) {
			return 'true';
		} else if ($option === false) {
			return 'false';
		} else {
			return $option;
		}
	}
}
