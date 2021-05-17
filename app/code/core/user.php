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

use DateTime;

defined('ABSPATH') or die('No script kiddies please!');

final class User
{
    /**
     * Forward database class instance
     *
     * @var Database
     * @access private
     */
    private ?Database $database;

    /**
     * Active user id
     *
     * @var int
     * @access private
     */
    private ?int $id;

    /**
     * Current user
     *
     * @var array
     * @access private
     */
    private $User;

    /**
     * __construct
     * Class constructor
     *
     * @access   public
     */
    public function __construct(?Database &$database)
    {
        $this->database = $database;
    }

    /**
     * Sign in selected user
     *
     * @param	array $user
     * @access   public
     */
    public function signIn(array $user): void
    {
        $token = Crypter::Encrypt(Crypter::salter(32), 'token');

        if ($this->database == null)
            $this->database = new Database();

        $query = $this->database->query(
            "UPDATE forward_users SET user_token = ?, user_last_login = ? WHERE user_id = ?",
            $token,
            (new DateTime())->format('Y-m-d H:i:s'),
            $user['user_id']
        );

        $this->id = $user['user_id'];

        Session::regenerate();

        Session::clear();
        Session::set('l', true);
        Session::set('u', $user['user_id']);
        Session::set('r', $user['user_role']);
        Session::set('t', $token);
    }

    /**
     * Sign out selected user and destroy session
     *
     * @access   public
     */
    public function signOut(): void
    {
        if (Session::isset(['u', 't', 'r'])) {
            if ($this->User == null)
                $this->getUserById(Session::get('u'));

            $query = $this->database->query(
                "UPDATE forward_users SET user_token = ? WHERE user_id = ?",
                Crypter::Encrypt(Crypter::salter(32), 'token'),
                $this->User['user_id'],
            );
        }

        Session::destroy();
    }

    /**
     * Checks if the user is correctly logged in
     *
     * @access   public
     */
    public function isLoggedIn(): bool
    {
        if (Session::isset(['u', 't', 'r'])) {
            if ($this->User == null)
                $this->getUserById(Session::get('u'));

            if ($this->User != null) {
                if (isset($this->User['user_token'], $this->User['user_role'])) {
                    if (Crypter::compare(Session::get('t'), $this->User['user_token'], 'token', false)  && Session::get('r') == $this->User['user_role']) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function current(): array
    {
        if ($this->User == null)
            $this->getUserById($this->id);

        return $this->User;
    }

    /**
     * Get's user by id
     *
     * @param	int $id
     * @access   public
     */
    private function getUserById(int $id)
    {
        if ($this->database != null) {
            $query = $this->database->query("SELECT * FROM forward_users WHERE user_id = ?", $id)->fetchArray();

            if ($query != null) {
                $this->id = $query['user_id'];
                $this->User = $query;
            }
        }
    }

    /**
     * Get's user by username
     *
     * @param    string $username
     * @access   public
     */
    public function getByName(string $username)
    {
        return $this->database->query("SELECT * FROM forward_users WHERE user_name = ?", $username)->fetchArray();
    }

    /**
     * Get's user by e-mail
     *
     * @param    string $email
     * @access   public
     */
    public function getByEmail(string $email)
    {
        return $this->database->query("SELECT * FROM forward_users WHERE user_email = ?", $email)->fetchArray();
    }

    /**
     * Get's user by e-mail
     *
     * @param    int $id
     * @access   public
     */
    public function getById(int $id)
    {
        return $this->database->query("SELECT * FROM forward_users WHERE user_id = ?", $id)->fetchArray();
    }

    /**
     * IsAdmin
     * Is current user admin
     *
     * @param    bool
     * @access   public
     */
    public function isAdmin(): bool
    {
        if ($this->User == null)
            $this->getUserById($this->id);

        if (Session::isset('r')) {
            if ($this->User['user_role'] == Session::get('r') && $this->User['user_role'] == 'admin')
                return true;
        }

        return false;
    }

    /**
     * IsManager
     * Is current user admin or manager
     *
     * @param    bool
     * @access   public
     */
    public function isManager(): bool
    {
        if ($this->isAdmin())
            return true;

        if (Session::isset('r')) {
            if ($this->User['user_role'] == Session::get('r') && $this->User['user_role'] == 'manager')
                return true;
        }

        return false;
    }
}
