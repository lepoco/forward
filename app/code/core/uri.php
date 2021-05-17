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

final class Uri
{
    /**
     * Current first level page
     *
     * @access   public
     * @var object
     */
    public $pagenow = NULL;

    /**
     * Whole URL path
     *
     * @access   public
     * @var object
     */
    public $trace = array();

    /**
     * Whole URL path
     *
     * @access   public
     * @var object
     */
    public $ssl = FALSE;

    public function __construct()
    {
        if (!empty($_SERVER['HTTPS']))
            $this->ssl = TRUE;
    }

    /**
     * scriptURI
     * Returns the curent request url
     *
     * @access   public
     * @return   string
     */
    public function requestURI(): string
    {
        return self::urlFix(($this->ssl ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    /**
     * scriptURI
     * Returns the curent script url
     *
     * @access   public
     * @return   string
     */
    public function scriptURI(): string
    {
        return self::urlFix(($this->ssl ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    }

    /**
     * Stops the script and makes a redirect
     *
     * @access   public
     * @return   string
     */
    public function redirect(string $url): void
    {
        header('Expires: on, 01 Jan 1970 00:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Location: ' . $url);

        exit;
    }

    /**
     * Returns the selected level
     *
     * @access   public
     * @return   string
     */
    public function getLevel(int $lvl): string
    {
        if (isset($this->trace[$lvl + 1]))
            return $this->trace[$lvl + 1];
        else
            return '';
    }

    /**
     * Analyzes and determines the current url
     *
     * @access   public
     * @return   void
     */
    public function parse(): void
    {
        $this->trace = explode('/', parse_url(urldecode('/' . trim(str_replace(rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'), '', $_SERVER['REQUEST_URI']), '/')))['path']);

        if (!isset($this->trace[0], $this->trace[1])) {
            $this->pagenow = 'unknown';
        } else {
            $this->pagenow = filter_var($this->trace[1], FILTER_SANITIZE_STRING);
        }
    }

    /**
     * Removes unnecessary parentheses and validates the url
     *
     * @access   public
     * @param    string $p
     * @return   string
     */
    public static function urlFix(string $p): string
    {
        $p = str_replace('\\', '/', trim($p));
        return (substr($p, -1) != '/') ? $p .= '/' : $p;
    }
}
