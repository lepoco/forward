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

use Mysqli;

defined('ABSPATH') or die('No script kiddies please!');

final class Database
{
    /**
     * Database instance
     *
     * @var object
     * @access protected
     */
    protected $connection;

    /**
     * Current query
     *
     * @var object
     * @access protected
     */
    protected $query;

    /**
     * Enable showing errors
     *
     * @var boolean
     * @access protected
     */
    protected $show_errors = false;

    /**
     * Current query
     *
     * @var object
     * @access protected
     */
    protected $query_closed = true;

    /**
     * Current query
     *
     * @var object
     * @access public
     */
    public $query_count = 0;

    /**
     * Establishes a connection to the database, or returns an error
     *
     * @access public
     */
    public function __construct()
    {
        if (defined('FORWARD_DEBUG'))
            if (FORWARD_DEBUG)
                $this->show_errors = true;

        $this->connection = new Mysqli(FORWARD_DB_HOST, FORWARD_DB_USER, FORWARD_DB_PASS, FORWARD_DB_NAME);

        if ($this->connection->connect_error)
            $this->error('Failed to connect to MySQL - ' . $this->connection->connect_error);

        $this->connection->set_charset('utf8');
    }

    /**
     * Queries the database
     *
     * @access   public
     * @param    string $query
     * @param    func_num_args (optional)
     * @return   object Database
     */
    public function query($query): Database
    {
        if (!$this->query_closed)
            $this->query->close();

        if ($this->query = $this->connection->prepare($query)) {
            if (func_num_args() > 1) {
                $x = func_get_args();
                $args = array_slice($x, 1);
                $types = '';
                $args_ref = array();
                foreach ($args as $k => &$arg) {
                    if (is_array($args[$k])) {
                        foreach ($args[$k] as $j => &$a) {
                            $types .= $this->_gettype($args[$k][$j]);
                            $args_ref[] = &$a;
                        }
                    } else {
                        $types .= $this->_gettype($args[$k]);
                        $args_ref[] = &$arg;
                    }
                }
                array_unshift($args_ref, $types);
                call_user_func_array(array($this->query, 'bind_param'), $args_ref);
            }
            $this->query->execute();

            if ($this->query->errno)
                $this->error('Unable to process MySQL query (check your params) - ' . $this->query->error);

            $this->query_closed = false;
            $this->query_count++;
        } else {
            $this->error('Unable to prepare MySQL statement (check your syntax) - ' . $this->connection->error);
        }
        return $this;
    }

    /**
     * Returns the result of the query
     *
     * @access   public
     * @return   array
     */
    public function fetchAll(): array
    {
        $params = array();
        $row = array();
        $meta = $this->query->result_metadata();

        while ($field = $meta->fetch_field())
            $params[] = &$row[$field->name];

        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            $r = array();
            foreach ($row as $key => $val)
                $r[$key] = $val;

            $result[] = $r;
        }
        $this->query->close();
        $this->query_closed = true;
        return $result;
    }

    /**
     * Returns the result array of the query
     *
     * @access   public
     * @return   array
     */
    public function fetchArray(): array
    {
        $params = array();
        $row = array();
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field())
            $params[] = &$row[$field->name];

        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch())
            foreach ($row as $key => $val)
                $result[$key] = $val;

        $this->query->close();
        $this->query_closed = true;
        return $result;
    }

    /**
     * Returns the number of results
     *
     * @access   public
     * @return   int
     */
    public function numRows()
    {
        $this->query->store_result();
        return $this->query->num_rows;
    }

    /**
     * Returns the number of rows that have been modified
     *
     * @access   public
     * @return   int $affected_rows
     */
    public function affectedRows()
    {
        return $this->query->affected_rows;
    }

    /**
     * Gets the identifier of the last changed row
     *
     * @access   public
     * @return   int $insert_id
     */
    public function lastInsertID()
    {
        return $this->connection->insert_id;
    }

    /**
     * Returns an error message
     *
     * @access   public
     * @return   string "error" (kills the script)
     */
    public function error(string $error): void
    {
        if ($this->show_errors)
            exit($error);
    }

    /**
     * Closes the database connection.
     *
     * @access   public
     * @return   bool true/false
     */
    public function close(): bool
    {
        return $this->connection->close();
    }

    /**
     * Returns the type of the variable
     *
     * @access   private
     * @param	$var
     * @return   string $type
     */
    private function _gettype($var): string
    {
        if (is_string($var)) return 's';
        if (is_float($var)) return 'd';
        if (is_int($var)) return 'i';
        return 'b';
    }
}
