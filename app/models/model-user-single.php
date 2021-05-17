<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

namespace Forward\Models;

use Forward\Core\Models;

defined('ABSPATH') or die('No script kiddies please!');

final class Model extends Models
{
    private $selectedUserId = null;
    private $currentUserId = null;

    private $selectedUser = null;

    protected function Init(): void
    {
        $this->selectedUserId = ctype_digit($this->Forward->Path->getLevel(2)) ? intval($this->Forward->Path->getLevel(2)) : null;
        $this->currentUserId = $this->Forward->User->current()['user_id'];

        $this->getUser();
    }

    protected function getUser()
    {
        $user = $this->Forward->User->getById($this->selectedUserId);

        if (!empty($user))
            $this->selectedUser = $user;
    }

    protected function ifUserExists()
    {
        return !empty($this->selectedUser);
    }

    protected function getUserData($prop)
    {
        if (!empty($this->selectedUser)) {
            if (isset($this->selectedUser[$prop])) {
                return $this->selectedUser[$prop];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    protected function getHeaderTitle()
    {
        if ($this->selectedUserId == $this->currentUserId) {
            return $this->__('My Account');
        } else if ($this->ifUserExists()) {
            return $this->getUserData('user_display_name');
        } else {
            return 'User #' . $this->selectedUserId;
        }
    }
}
