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

final class Session
{
    /**
     * Opens a new session
     *
     * @access   public
     * @return   void
     */
    public static function open(): void
    {
        session_start();
        session_regenerate_id();
    }

    /**
     * Regenerates a session
     *
     * @access   public
     * @return   void
     */
    public static function regenerate(): void
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_regenerate_id();
        }
    }

    /**
     * Destroys the session and data in it
     *
     * @access   public
     * @return   void
     */
    public static function destroy(): void
    {
        session_destroy();
    }

    /**
     * Checks if the id or id's in the session exists
     *
     * @access   public
     * @return   bool
     */
    public static function isset($args): bool
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            return false;
        }

        if (is_array($args)) {
            if (!is_array($_SESSION)) {
                return false;
            }

            for ($i = 0; $i < count($args); $i++) {
                if (!isset($_SESSION[$args[$i]])) {
                    return false;
                }
            }

            return true;
        } else {
            return isset($_SESSION[$args]);
        }
    }

    /**
     * Clears all session data
     *
     * @access   public
     * @return   void
     */
    public static function clear(): void
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            $_SESSION = array();
        }
    }

    /**
     * Get's a session data
     *
     * @access   public
     * @return   mixed
     */
    public static function get(string $id)
    {
        if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION[$id])) {
            return $_SESSION[$id];
        } else {
            return null;
        }
    }

    /**
     * Set's a session data
     *
     * @access   public
     * @return   void
     */
    public static function set(string $id, $value): void
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            self::open();
        }

        if (!is_array($_SESSION)) {
            self::clear();
        }

        $_SESSION[$id] = $value;
    }
}
