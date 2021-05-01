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

$this->GetHeader();
$this->GetNavigation();
?>
<div class="container-fluid" style="margin-bottom:2.2rem;">
    <div class="row">
        <div class="col-12">
            <div class="content__title">
                <h1><?php $this->_e('Add user'); ?></h1>
                <span>Add new user</span>
            </div>
        </div>
        <div class="col-12">
            <form id="user-add-form" class="forward-form" action="<?php echo $this->AjaxGateway(); ?>">
                <input type="hidden" value="add_user" name="action">
                <input type="hidden" value="<?php echo $this->AjaxNonce('add_user'); ?>" name="nonce">

                <div class="form-group">
                    <label for="input_user_username"><?php echo $this->_e('Username'); ?></label>
                    <input type="text" class="form-control" id="input_user_username" name="input_user_username" placeholder="<?php echo $this->_e('Username'); ?>">
                </div>
                <div class="form-group">
                    <label for="input_user_display_name"><?php echo $this->_e('Username'); ?></label>
                    <input type="text" class="form-control" id="input_user_display_name" name="input_user_display_name" placeholder="<?php echo $this->_e('Display name'); ?>">
                </div>
                <div class="form-group">
                    <label for="input_user_email"><?php echo $this->_e('E-mail'); ?></label>
                    <input type="email" class="form-control" id="input_user_email" name="input_user_email" placeholder="<?php echo $this->_e('E-mail'); ?>">
                </div>
                <div class="form-group">
                    <label for="input_user_password"><?php echo $this->_e('Password'); ?></label>
                    <input autocomplete="new-password" type="password" class="form-control password_strength_control" data-strength-target="input_user_password--strength" id="input_user_password" name="input_user_password" placeholder="<?php echo $this->_e('Password'); ?>">
                </div>
                <div>
                    <span class="input_user_password--strength"></span>
                </div>
                <div class="form-group">
                    <label for="input_user_password_confirm"><?php echo $this->_e('Confirm password'); ?></label>
                    <input autocomplete="disabled" type="password" class="form-control" id="input_user_password_confirm" name="input_user_password_confirm" placeholder="<?php echo $this->_e('Confirm password'); ?>">
                </div>
                <div class="form-group">
                    <label for="input_user_type"><?php echo $this->_e('Rank'); ?></label>
                    <select class="form-control" id="input_user_type" name="input_user_type">
                        <option value="1"><?php echo $this->_e('Analyst'); ?></option>
                        <option value="2"><?php echo $this->_e('Manager'); ?></option>
                        <option value="3"><?php echo $this->_e('Administrator'); ?></option>
                    </select>
                </div>
                <button type="send" class="btn-forward"><?php $this->_e('Add new user'); ?></button>
            </form>
        </div>
    </div>
</div>
<?php
$this->GetFooter();
?>