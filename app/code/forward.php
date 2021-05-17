<?php

/**
 * @package   Forward
 *
 * @author    RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link      https://www.rdev.cc/forward
 * @license   https://opensource.org/licenses/MIT
 */

namespace Forward;

use Forward\Components\{Dashboard, Redirect};
use Forward\Models;

defined('ABSPATH') or die('No script kiddies please!');

final class Forward
{
    /**
     * Information about the address from the Uri class
     *
     * @access public
     */
    public ?Core\Uri $Path;

    /**
     * Class for translating text strings
     *
     * @access public
     */
    public ?Core\Translator $Translator;

    /**
     * A global class that stores options
     *
     * @access public
     */
    public ?Core\Options $Options;

    /**
     * A set of user management tools
     *
     * @access public
     */
    public ?Core\User $User;

    /**
     * A set of statistics tools
     *
     * @access public
     */
    public ?Core\Statistics $Statistics;

    /**
     * Master database instance, requires config.php
     *
     * @access public
     */
    public ?Core\Database $Database;

    /**
     * __construct
     * Triggers and instances all necessary classes
     *
     * @access   public
     * @return   Forward
     */
    public function __construct()
    {
        $this->setup();

        //If the configuration file does not exist or is damaged, start the installation
        if (!defined('FORWARD_DB_NAME')) {
            $this->loadModel('install', 'Installer');
        } else {
            //Mechanism of action depending on the first part of the url
            switch ($this->Path->GetLevel(0)) {
                case '':
                case null:
                    $this->loadModel('home', 'Create your own link shortener');
                    break;

                case $this->Options->Get('dashboard', 'dashboard'):
                case $this->Options->Get('login', 'login'):
                    Core\Session::open();
                    new Dashboard($this);
                    break;

                default:
                    new Redirect($this);
                    break;
            }
        }

        $this->exit(); //Just in case
    }

    /**
     * Checks if the configuration file exists
     *
     * @access   private
     * @return   bool
     */
    private function isConfig(): bool
    {
        if (is_file(APPPATH . 'config.php')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Instances all necessary classes
     *
     * @access   private
     * @return   void
     */
    private function setup(): void
    {
        $this->setupPath();
        $this->setupTranslator();
        $this->setupDatabase();
        $this->setupOptions();
        $this->setupUser();
        $this->setupStatistics();
    }

    /**
     * Initializes the Uri class
     *
     * @access   private
     * @return   void
     */
    private function setupPath(): void
    {
        $this->Path = new Core\Uri();
        $this->Path->Parse();
    }

    /**
     * Initializes the Translator class
     *
     * @access   private
     * @return   void
     */
    private function setupTranslator(): void
    {
        $this->Translator = new Core\Translator();
    }

    /**
     * Initializes the Database class
     *
     * @access   private
     * @return   void
     */
    private function setupDatabase(): void
    {
        if ($this->isConfig()) {
            $this->Database = new Core\Database();
        } else {
            $this->Database = null;
        }
    }

    /**
     * Initializes the Options class
     *
     * @access   private
     * @return   void
     */
    private function setupOptions(): void
    {
        $this->Options = new Core\Options($this->Database);
    }

    /**
     * Initializes the User class
     *
     * @access   private
     * @return   void
     */
    private function setupUser(): void
    {
        $this->User = new Core\User($this->Database);
    }

    /**
     * Initializes the Statistics class
     *
     * @access   private
     */
    public function setupStatistics($tag = null, $type = 'page'): void
    {
        $this->Statistics = new Core\Statistics($this);
    }

    /**
     * Loads the page model (logic)
     * The page model is inherited from Forward\Core\Models
     *
     * @access   private
     * @return   void
     */
    public function loadModel(string $name, string $displayname = null)
    {
        //$this->Forward->Statistics->add($name);

        if (is_file(APPPATH . "/models/model-$name.php")) {
            require_once APPPATH . "/models/model-$name.php";
            (new Models\Model($this, $name, $displayname))->print();
        } else {
            if (is_file(APPPATH . "/views/$name.php")) {
                (new Core\Models($this, $name, $displayname))->print();
            } else {
                $this->error("Unable to find model '$name'");
            }
        }
    }

    /**
     * Kill script
     *
     * @access   public
     */
    public function exit(bool $destroySession = false)
    {
        if ($destroySession) {
            Core\Session::destroy();
        }

        exit;
    }

    /**
     * Custom error handling
     *
     * @param	 string $message
     * @param	 bool   $suspend
     * @access   public
     */
    public function error(string $message, bool $suspend = false)
    {
        $r_message = '<br/><strong>Forward Error</strong><br/><br/><i>' . date('Y-m-d h:i:s a', time()) . '</i><br/>';

        if (is_file(APPPATH . 'config.php')) {
            if (DEFINED('FORWARD_DEBUG')) {
                if (FORWARD_DEBUG)
                    echo $r_message . $message;
            } else {
                echo $r_message . $message . '<br/><i>Configuration file <strong>EXISTS</strong> but FORWARD_DEBUG constant could not be found ...</i>';
            }
        } else {
            echo $r_message . $message . '<br/><i>Configuration file does not exist...</i>';
        }

        if ($suspend) {
            $this->exit();
        }
    }
}
