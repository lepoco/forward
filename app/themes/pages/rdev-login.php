<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2020, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;
	defined('ABSPATH') or die('No script kiddies please!');

	$this->GetHeader();
?>
			<div id="big-background">
				<picture>
					<source srcset="<?php echo $this->GetImage('bg.webp') ?>" type="image/webp">
					<source srcset="<?php echo $this->GetImage('bg.jpeg') ?>" type="image/jpeg">
					<img alt="Forward big background image" src="<?php echo $this->GetImage('bg.jpeg') ?>">
				</picture>
			</div>

			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-6" style="display: flex;align-items: center;">
						<picture class="forward-logo">
							<source srcset="<?php echo $this->GetImage('forward-logo-wt.webp'); ?>" type="image/webp">
							<source srcset="<?php echo $this->GetImage('forward-logo-wt.jpeg'); ?>" type="image/jpeg">
							<img alt="Forward logo" src="<?php echo $this->GetImage('forward-logo-wt.jpeg'); ?>">
						</picture>
					</div>
					<div class="col-12 col-lg-6">
						<div class="login-card">
							<form id="login-form" class="login-form">
								<div class="card">
									<div class="card-body">
										<h1><?php $this->_e('Sign in'); ?></h1>
										<input type="hidden" value="<?php echo $this->AjaxNonce( 'sign_in' ); ?>" name="nonce">
										<input type="hidden" value="sign_in" name="action">
										<div class="form-group">
											<label for="login"><?php $this->_e('Login'); ?></label>
											<input type="text" class="form-control" name="login" id="login" placeholder="<?php $this->_e('Enter username/email'); ?>">
										</div>
										<div class="form-group" style="margin-top: 10px;">
											<label for="password"><?php $this->_e('Password'); ?></label>
											<div class="input-group" id="show_hide_password">
												<input type="password" class="form-control" id="password" name="password" placeholder="<?php $this->_e('Password'); ?>">
												<div class="input-group-addon">
													<a href=""><svg style="width:15px;height:15px" viewBox="0 0 24 24"><path fill="currentColor" d="M17,7H22V17H17V19A1,1 0 0,0 18,20H20V22H17.5C16.95,22 16,21.55 16,21C16,21.55 15.05,22 14.5,22H12V20H14A1,1 0 0,0 15,19V5A1,1 0 0,0 14,4H12V2H14.5C15.05,2 16,2.45 16,3C16,2.45 16.95,2 17.5,2H20V4H18A1,1 0 0,0 17,5V7M2,7H13V9H4V15H13V17H2V7M20,15V9H17V15H20M8.5,12A1.5,1.5 0 0,0 7,10.5A1.5,1.5 0 0,0 5.5,12A1.5,1.5 0 0,0 7,13.5A1.5,1.5 0 0,0 8.5,12M13,10.89C12.39,10.33 11.44,10.38 10.88,11C10.32,11.6 10.37,12.55 11,13.11C11.55,13.63 12.43,13.63 13,13.11V10.89Z" /></svg></a>
												</div>
											</div>
										</div>
										<div id="login-alert" class="alert alert-danger fade show" role="alert" style="display: none;margin-top: 30px;">
											<strong><?php $this->_e('Holy guacamole!'); ?></strong> <?php $this->_e('You entered an incorrect login or password'); ?>
										</div>
									</div>
									<button type="submit" id="button-form" class="btn btn-primary"><?php $this->_e('Submit'); ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="splash-footer">
				Copyright © 2019-<?php echo date('Y'); ?> RapidDev | MIT License
				<br>
				<?php $this->_e('Background image'); ?>: <i>Joyston Judah</i>
				<br>
				<?php $this->_e('Logo font'); ?>: Questrial by <i>Joe Prince</i>
			</div>
<?php
	$this->GetFooter();
?>
