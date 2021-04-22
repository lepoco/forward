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
    private $selectedUser = null;
    private $currentUser = null;

    protected function Init(): void
    {
        $this->selectedUser = ctype_digit($this->Forward->Path->GetLevel(2)) ? intval($this->Forward->Path->GetLevel(2)) : null;
        $this->currentUser = $this->Forward->User->Active()['user_id'];
    }

    protected function GetHeaderTitle()
    {
        if ($this->selectedUser == $this->currentUser) {
            return $this->__('My Account');
        } else {
            return 'User with ID: ' . $this->selectedUser;
        }
    }
}
