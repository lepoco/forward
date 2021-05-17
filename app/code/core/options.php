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

defined('ABSPATH') or die('No script kiddies please!');

final class Options
{
    /**
     * Database instance
     *
     * @var Core\Database
     * @access private
     */
    private ?Database $database;

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
    public function __construct(?Database $db)
    {
        if ($db != null) {
            $this->database = $db;
            $this->setup();
        }
    }

    /**
     * Get options from database
     *
     * @access   private
     */
    private function setup(): void
    {
        $query = $this->database->query('SELECT * FROM forward_options')->fetchAll();

        if (!empty($query)) {
            foreach ($query as $option) {
                $this->options[$option['option_name']] = $option['option_value'];
            }
        }
    }

    /**
     * Update option in array and database
     *
     * @var      string $name
     * @var      mixed  $value
     * @access   public
     */
    public function update(string $name, $value = null): void
    {
        $query = null;

        if ($this->database != null) {
            if (isset($this->options[$name])) {
                if ($this->options[$name] != $value)
                    $query = $this->database->query("UPDATE forward_options SET option_value = ? WHERE option_name = ?", $this->serializeType($value), $name);
            } else {
                $query = $this->database->query("INSERT INTO forward_options (option_value, option_name) VALUES (?,?)", $this->serializeType($value), $name);
            }
        }

        $this->options[$name] = $value;
    }

    /**
     * Get option from array
     *
     * @param      string $name
     * @param      mixed  $default
     * @param      mixed  $raw
     * @access     public
     */
    public function get(string $name, $default = null, $raw = false)
    {
        if (isset($this->options[$name])) {
            return ($raw ? $this->options[$name] : $this->deserializeType($this->options[$name]));
        } else {
            return $default;
        }
    }

    /**
     * Returns parsed option to selected data type
     *
     * @access   public
     */
    private function deserializeType($option)
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
     * Returns serialized option to db format
     *
     * @access   public
     */
    private function serializeType($option)
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
