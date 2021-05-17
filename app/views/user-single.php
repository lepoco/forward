<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

namespace Forward\Views;

defined('ABSPATH') or die('No script kiddies please!');

$this->getHeader();
$this->getNavigation();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="content__title">
                <h1><?php echo $this->getHeaderTitle(); ?></h1>
                <span>User's account</span>
            </div>
        </div>
        <?php if ($this->ifUserExists()) : ?>
            <div class="col-12 col-lg-6">
                <div class="content__card">
                    <div class="content__card__body">
                        <span class="content__card__header"><?php echo $this->_e('Information'); ?></span>
                        <p>
                            <strong><?php $this->_e('Username'); ?></strong>
                            <br>
                            <span><?php echo $this->getUserData('user_display_name'); ?></span>
                        </p>
                        <p>
                            <strong>E-mail</strong>
                            <br>
                            <span><?php echo (empty($this->getUserData('user_email')) ? $this->__('Not specified') : $this->getUserData('user_email')); ?></span>
                        </p>
                        <p>
                            <strong><?php $this->_e('Last login'); ?></strong>
                            <br>
                            <span><?php echo (empty($this->getUserData('user_last_login')) ? $this->__('Never') : $this->getUserData('user_last_login')); ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="content__card">
                    <div class="content__card__body">
                        <span class="content__card__header"><?php echo $this->_e('Password change'); ?></span>
                        <form id="user-change_password" class="forward-form" action="<?php echo $this->ajaxGateway(); ?>" style="margin-top:.8rem;">
                            <input type="hidden" value="change_password" name="action">
                            <input type="hidden" value="<?php echo $this->getUserData('user_name'); ?>" name="username">
                            <input type="hidden" value="<?php echo $this->getUserData('user_id'); ?>" name="id">
                            <input type="hidden" value="<?php echo $this->ajaxNonce('change_password'); ?>" name="nonce">

                            <div class="form-group">
                                <input type="password" autocomplete="new-password" id="input_user_new_password" name="input_user_new_password" class="form-control password_strength_control" data-strength-target="input_user_password--strength" placeholder="<?php echo $this->_e('New password'); ?>">
                            </div>
                            <div class="form-group">
                                <input type="password" autocomplete="new-password" id="input_user_new_password_confirm" name="input_user_new_password_confirm" class="form-control password_strength_control" data-strength-target="input_user_password--strength" placeholder="<?php echo $this->_e('Confirm new password'); ?>">
                            </div>
                            <div>
                                <span class="input_user_password--strength"></span>
                            </div>

                            <button type="submit" class="btn-forward block"><?php echo $this->_e('Change password'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <form id="user-update" class="forward-form" action="<?php echo $this->ajaxGateway(); ?>" style="margin-top:1.5rem;">
                    <input type="hidden" value="update_user" name="action">
                    <input type="hidden" value="<?php echo $this->getUserData('user_id'); ?>" name="id">
                    <input type="hidden" value="<?php echo $this->ajaxNonce('update_user'); ?>" name="nonce">

                    <div class="form-group">
                        <label for="input_user_username"><?php echo $this->_e('Username'); ?></label>
                        <input type="text" class="form-control" id="input_user_username" name="input_user_username" placeholder="<?php echo $this->_e('Username'); ?>" value="<?php echo $this->getUserData('user_name'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_user_display_name"><?php echo $this->_e('User display name'); ?></label>
                        <input type="text" class="form-control" id="input_user_display_name" name="input_user_display_name" placeholder="<?php echo $this->_e('Display name'); ?>" value="<?php echo $this->getUserData('user_display_name'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="input_user_email"><?php echo $this->_e('E-mail'); ?></label>
                        <input type="email" class="form-control" id="input_user_email" name="input_user_email" placeholder="<?php echo $this->_e('E-mail'); ?>" value="<?php echo $this->getUserData('user_email'); ?>">
                    </div>
                    <button type="submit" class="btn-forward"><?php echo $this->_e('Update'); ?></button>
                </form>
            </div>
        <?php else : ?>
            <div class="col-12 col-lg-6">
                <strong>User with the given identifier does not exist</strong>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
$this->getFooter();
?>