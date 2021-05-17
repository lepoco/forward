<?php

/**
 * @package   Forward
 *
 * @author    RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link      https://www.rdev.cc/forward
 * @license   https://opensource.org/licenses/MIT
 */

namespace Forward\Components;

use Forward\Forward;

defined('ABSPATH') or die('No script kiddies please!');

/**
 *
 * Dashboard
 *
 * @author   Leszek Pomianowski <https://rdev.cc>
 * @license  MIT License
 * @access   public
 */
final class Dashboard
{
    /**
     * Forward class instance
     *
     * @var Forward
     * @access private
     */
    private Forward $Forward;

    /**
     * Current dashboard page
     *
     * @var string
     * @access private
     */
    private string $subpage;

    /**
     * List of available pages
     *
     * @var array
     * @access private
     */
    private static $pages = array(
        '__dashboard__',
        'ajax',
        'statistics',
        'signout',
        'users',
        'api',
        'records',
        'settings',
        'about',
        'login'
    );

    /**
     * __construct
     * Class constructor
     *
     * @access   public
     */
    public function __construct(Forward &$parent)
    {
        $this->Forward = $parent;

        $this->setPage();
        $this->isPageExists();

        if (!$this->Forward->User->IsLoggedIn()) {
            if ($this->subpage != 'login' && $this->subpage != 'ajax')
                $this->redirectTo($this->Forward->Options->Get('login', 'login'));
        } else {
            if ($this->subpage == 'login')
                $this->redirectTo();
        }

        if (trim($this->Forward->Path->getLevel(2)) != '' && $this->subpage != 'users') {
            $this->Forward->loadModel('404', 'Page not found');
        }

        if ($this->subpage == 'users')
            $user_id = ctype_digit($this->Forward->Path->getLevel(2)) ? intval($this->Forward->Path->getLevel(2)) : null;

        switch ($this->subpage) {
            case 'ajax':
                new Ajax($this->Forward);
                break;

            case '__dashboard__':
                $this->Forward->loadModel('dashboard', 'Dashboard');
                break;

            case 'statistics':
                $this->Forward->loadModel('statistics', 'Statistics');
                break;

            case 'api':
                $this->Forward->loadModel('api', 'JSON API');
                break;

            case 'records':
                $this->Forward->loadModel('records', 'Records');
                break;

            case 'settings':
                $this->Forward->loadModel('settings', 'Settings');
                break;

            case 'users':
                if ($user_id != null) {
                    $this->Forward->loadModel('user-single', 'Account');
                } else if (trim($this->Forward->Path->getLevel(2)) == '' || trim($this->Forward->Path->getLevel(2)) == 'list') {
                    $this->Forward->loadModel('users', 'Users');
                } else if (trim($this->Forward->Path->getLevel(2)) == 'add') {
                    $this->Forward->loadModel('users-add', 'Add user');
                } else {
                    $this->Forward->loadModel('404', 'Page not found');
                }
                break;

            case 'about':
                $this->Forward->loadModel('about', 'About');
                break;

            case 'login':
                $this->Forward->loadModel('login', 'Sign in');
                break;

            case 'signout':
                $this->Forward->Statistics->add('sign_out', 'action');
                $this->Forward->User->signOut();
                $this->Forward->Path->redirect($this->Forward->Options->Get('base_url', $this->Forward->Path->scriptURI()));
                break;

            default:
                $this->Forward->loadModel('404', 'Page not found');
                break;
        }
        exit;
    }

    /**
     * RedirectLogin
     * Redirect to login if illegal dashboard page
     *
     * @access   private
     */
    private function redirectTo($slug = null): void
    {
        $this->Forward->Path->redirect(
            $this->Forward->Options->get(
                'base_url',
                $this->Forward->Path->scriptURI()
            ) . $this->Forward->Options->get('dashboard', 'dashboard') . '/' . $slug
        );
    }

    /**
     * setPage
     * Defines current dashboard page
     *
     * @access   private
     */
    private function setPage(): void
    {
        if ($this->Forward->Path->getLevel(1) == null)
            $this->subpage = '__dashboard__';
        else
            $this->subpage = $this->Forward->Path->getLevel(1);
    }

    /**
     * isPageExists
     * Checks if the selected page exists
     *
     * @access   private
     */
    private function isPageExists(): void
    {
        if (!in_array($this->subpage, self::$pages))
            $this->Forward->loadModel('404', 'Page not found');
    }
}
