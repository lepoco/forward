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
 * Model [Dashboard]
 *
 * @author   Leszek Pomianowski <https://rdev.cc>
 * @license	MIT License
 * @access   public
 */
class Model extends Models
{
    private $selectedUserId = null;
    private $currentUserId = null;

    private $selectedUser = null;

    protected function Init(): void
    {
        $this->selectedUserId = ctype_digit($this->Forward->Path->GetLevel(2)) ? intval($this->Forward->Path->GetLevel(2)) : null;
        $this->currentUserId = $this->Forward->User->Active()['user_id'];

        $this->GetUser();
    }

    protected function GetUser()
    {
        $user = $this->Forward->User->GetById($this->selectedUserId);

        if (!empty($user))
            $this->selectedUser = $user;
    }

    protected function IfUserExists()
    {
        return !empty($this->selectedUser);
    }

    protected function GetUserData($prop)
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

    protected function GetHeaderTitle()
    {
        if ($this->selectedUserId == $this->currentUserId) {
            return $this->__('My Account');
        } else if ($this->IfUserExists()) {
            return $this->GetUserData('user_display_name');
        } else {
            return 'User #' . $this->selectedUserId;
        }
    }
}
