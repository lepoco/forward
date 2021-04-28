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
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="content__title">
				<h1><?php $this->_e('Settings'); ?></h1>
				<span>Configuration of your manager</span>
			</div>
		</div>
		<div class="col-12 settings-page">
			<form id="settings-form" class="forward-form" action="<?php echo $this->AjaxGateway(); ?>">
				<input type="hidden" value="save_settings" name="action">
				<input type="hidden" value="<?php echo $this->AjaxNonce('save_settings'); ?>" name="nonce">

				<div class="row">
					<div class="col-12 col-lg-6">
						<h2 class="display-4" style="font-size: 26px;"><?php echo $this->_e('Redirects'); ?></h2>
						<div class="form-group">
							<label for="input_redirect_404"><?php echo $this->_e('Redirect 404 page'); ?></label>
							<select class="form-control" id="input_redirect_404" name="input_redirect_404">
								<?php
								$option = $this->Forward->Options->Get('redirect_404');
								?>
								<option value="1" <?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Enabled'); ?></option>
								<option value="2" <?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Disabled'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label for="input_redirect_404_direction"><?php echo $this->_e('URL to which redirect error 404'); ?></label>
							<input type="text" class="form-control" id="input_redirect_404_direction" name="input_redirect_404_direction" placeholder="https://" value="<?php echo $this->Forward->Options->Get('redirect_404_direction'); ?>">
						</div>

						<div class="form-group">
							<label for="input_redirect_home"><?php echo $this->_e('Redirect home page'); ?></label>
							<select class="form-control" id="input_redirect_home" name="input_redirect_home">
								<?php
								$option = $this->Forward->Options->Get('redirect_home');
								?>
								<option value="1" <?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Enabled'); ?></option>
								<option value="2" <?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Disabled'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label for="input_redirect_home_direction"><?php echo $this->_e('URL to which redirect error home'); ?></label>
							<input type="text" class="form-control" id="input_redirect_home_direction" name="input_redirect_home_direction" placeholder="https://" value="<?php echo $this->Forward->Options->Get('redirect_home_direction'); ?>">
						</div>

						<h2 class="display-4" style="font-size: 26px;"><?php echo $this->_e('Languages'); ?></h2>
						<div class="form-group">
							<label for="input_language_type"><?php echo $this->_e('Choose how languages are detected'); ?></label>
							<select class="form-control" id="input_language_type" name="input_language_type">
								<?php
								$option = $this->Forward->Options->Get('dashboard_language_mode');
								?>
								<option value="1" <?php echo $option == 1 ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Automatically (browser)'); ?></option>
								<option disabled value="2" <?php echo $option == 2 ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Automatically (geolocation)'); ?></option>
								<option value="3" <?php echo $option == 3 ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Permanently defined'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label for="input_language_select"><?php echo $this->_e('Statically defined language'); ?></label>
							<select class="form-control" id="input_language_select" name="input_language_select">
								<?php
								$option = $this->Forward->Options->Get('dashboard_language');
								?>
								<option value="en_US" <?php echo $option == 'en_US' ? ' selected="selected"' : ""; ?>>English</option>
								<option value="pl_PL" <?php echo $option == 'pl_PL' ? ' selected="selected"' : ""; ?>>Polski</option>
								<option value="de_DE" <?php echo $option == 'de_DE' ? ' selected="selected"' : ""; ?>>Deutsch</option>
							</select>
						</div>

						<h2 class="display-4" style="font-size: 26px;"><?php echo $this->_e('Connection encryption'); ?></h2>
						<div class="form-group">
							<label for="input_force_redirect_ssl"><?php echo $this->_e('Force SSL connection for redirects'); ?></label>
							<select class="form-control" name="input_force_redirect_ssl" id="input_force_redirect_ssl">
								<?php
								$option = $this->Forward->Options->Get('force_redirect_ssl');
								?>
								<option value="1" <?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Enabled'); ?></option>
								<option value="2" <?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Disabled'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label for="input_force_dashboard_ssl"><?php echo $this->_e('Force SSL connection for dashboard'); ?></label>
							<select class="form-control" name="input_force_dashboard_ssl" id="input_force_dashboard_ssl">
								<?php
								$option = $this->Forward->Options->Get('force_dashboard_ssl');
								?>
								<option value="1" <?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Enabled'); ?></option>
								<option value="2" <?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Disabled'); ?></option>
							</select>
						</div>
						<small>
							<?php echo $this->_e('You don\'t have to spend money on certificates from companies like Comodo or RapidSSL.'); ?>
							<br>
							<?php echo $this->_e('You can generate a free certificate with'); ?> <a href="https://letsencrypt.org/" target="_blank" rel="noopener">Let's Encrypt</a>.
							<hr>
							<?php echo $this->_e('SSL is recommended.'); ?>
							<br>
							<?php echo $this->_e('You protect both yourself and your users against a number of attacks. MIDM and Session Hijacking are one of the most dangerous. Never put safety second.'); ?>
						</small>

						<h2 class="display-4" style="font-size: 26px;"><?php echo $this->_e('URLs'); ?></h2>
						<div class="form-group">
							<label for="input_base_url"><?php echo $this->_e('Main website URL'); ?></label>
							<input type="text" class="form-control" name="input_base_url" id="input_base_url" placeholder="<?php echo $this->Forward->Options->Get('base_url'); ?>" value="<?php echo $this->Forward->Options->Get('base_url'); ?>">
							<small><span class="uppercase"><strong><?php echo $this->_e('Attention'); ?>!</strong></span><br /><?php echo $this->_e('Change URLs only if you have moved the site to a different domain or folder. Otherwise, access to the panel may be blocked.') ?></small>
						</div>
						<div class="form-group">
							<label for="input_dashboard_url"><?php echo $this->_e('Dashboard URL'); ?></label>
							<input type="text" class="form-control" name="input_dashboard_url" id="input_dashboard_url" placeholder="<?php echo $this->Forward->Options->Get('dashboard'); ?>" value="<?php echo $this->Forward->Options->Get('dashboard'); ?>">
						</div>
						<div class="form-group">
							<label for="input_login_url"><?php echo $this->_e('Login URL'); ?></label>
							<input type="text" class="form-control" name="input_login_url" id="input_login_url" placeholder="<?php echo $this->Forward->Options->Get('login'); ?>" value="<?php echo $this->Forward->Options->Get('login'); ?>">
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<h2 class="display-4" style="font-size: 26px;"><?php echo $this->_e('Cache') ?></h2>
						<div class="form-group">
							<label for="input_cache"><?php echo $this->_e('Enable Cache for records database'); ?></label>
							<select class="form-control" id="input_cache" name="input_cache">
								<?php
								$option = $this->Forward->Options->Get('cache');
								?>
								<option value="1" <?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Enabled'); ?></option>
								<option value="2" <?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Disabled'); ?></option>
							</select>
						</div>

						<h2 class="display-4" style="font-size: 26px;">Google ReCaptcha V3</h2>
						<div class="form-group">
							<label for="input_dashboard_captcha_public"><?php echo $this->_e('ReCaptcha site key'); ?></label>
							<input type="text" class="form-control" id="input_dashboard_captcha_public" name="input_dashboard_captcha_public" value="<?php echo $this->Forward->Options->Get('dashboard_captcha_public'); ?>" placeholder="<?php echo $this->_e('eg.:'); ?> 9Lb5ib4UACCCCM8mXw2nit90d-7vCcLd1LjQHWXn">
						</div>
						<div class="form-group">
							<label for="input_dashboard_captcha_secret"><?php echo $this->_e('ReCaptcha secret key'); ?></label>
							<input type="text" class="form-control" id="input_dashboard_captcha_secret" name="input_dashboard_captcha_secret" placeholder="<?php echo $this->_e('eg.:'); ?> 9Lb5ib4UACCCCM8mXIAKcfHTbL7M3d-xHSWTyz-Q" value="<?php echo $this->Forward->Options->Get('dashboard_captcha_secret'); ?>">
						</div>
						<small>
							<?php echo sprintf($this->_e('You can enable %s for admin panel login.'), '<a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="noopener">Google ReCaptcha V3</a>'); ?>
							<br>
							<?php echo $this->_e('Leave these fields blank if you want to disable ReCaptcha V3'); ?>
						</small>

						<h2 class="display-4" style="font-size: 26px;">Google Analytics</h2>
						<div class="form-group">
							<label for="input_js_redirect"><?php echo $this->_e('JS Redirection'); ?></label>
							<select class="form-control" id="input_js_redirect" name="input_js_redirect">
								<?php
								$option = $this->Forward->Options->Get('js_redirect');
								?>
								<option value="1" <?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Enabled'); ?></option>
								<option value="2" <?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Disabled'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label for="input_google_analytics"><?php echo $this->_e('Tracking Code (gtag)'); ?></label>
							<input type="text" class="form-control" id="input_google_analytics" name="input_google_analytics" placeholder="<?php echo $this->_e('eg.:'); ?> UA-111112222-2" value="<?php echo $this->Forward->Options->Get('google_analytics'); ?>">
						</div>
						<div class="form-group">
							<label for="input_js_redirect_after"><?php echo $this->_e('Redirect after:'); ?></label>
							<select class="form-control" name="input_js_redirect_after" id="input_js_redirect_after">
								<?php
								$option = $this->Forward->Options->Get('js_redirect_after');
								?>
								<option value="0" <?php echo $option == 0 ? ' selected="selected"' : ""; ?>><?php echo $this->_e('Immediately'); ?></option>
								<option value="500" <?php echo $option == 500 ? ' selected="selected"' : ""; ?>>500ms</option>
								<option value="1000" <?php echo $option == 1000 ? ' selected="selected"' : ""; ?>>1000ms <i>(1 <?php echo $this->_e('second'); ?>)</i></option>
								<option value="2000" <?php echo $option == 2000 ? ' selected="selected"' : ""; ?>>2000ms <i>(2 <?php echo $this->_e('seconds'); ?>)</i></option>
								<option value="3000" <?php echo $option == 3000 ? ' selected="selected"' : ""; ?>>3000ms <i>(3 <?php echo $this->_e('seconds'); ?>)</i></option>
							</select>
						</div>
						<small>
							<span class="uppercase"><strong><?php echo $this->_e('Attention'); ?>!</strong></span>
							<br>
							<?php echo $this->_e('JavaScript redirection and the use of Google Analytics may not work. This method is less effective and is not recommended.'); ?>
							<br>
							<?php echo $this->_e('Anyway, if you want you can use it.'); ?>
						</small>

						<h2 class="display-4" style="font-size: 26px;"><?php echo $this->_e('Miscellaneous'); ?></h2>
						<p>
							<?php echo sprintf($this->__('You can change these options only in the %s file'), '<strong>config.php</strong>'); ?>
							<br>
							<small><?php echo str_replace('\\', '/', trim(APPPATH . 'config.php')); ?></small>
						</p>
						<div class="form-group">
							<label><?php echo $this->_e('Database name'); ?></label>
							<input disabled type="text" class="form-control" value="<?php echo FORWARD_DB_NAME; ?>">
							<small>constant: <strong>FORWARD_DB_NAME</strong></small>
						</div>
						<div class="form-group">
							<label><?php echo $this->_e('Cryptographic method for passwords'); ?></label>
							<input disabled type="text" class="form-control" value="<?php

																					switch (FORWARD_ALGO) {
																						case '2y': //PASSWORD_BCRYPT
																							echo 'CRYPT_BLOWFISH algorithm to create the hash';
																							break;
																						case 'argon2i': //PASSWORD_ARGON2I
																							echo 'Argon2i hashing algorithm to create the hash';
																							break;
																						case 'argon2id': //PASSWORD_ARGON2ID
																							echo 'Argon2id hashing algorithm to create the hash';
																							break;
																						default: //PASSWORD_DEFAULT
																							echo 'DEFAULT - bcrypt algorithm (default as of PHP 5.5.0)';
																							break;
																					}

																					?>">
							<small>constant: <strong>FORWARD_ALGO</strong></small>
							<p class="p-warning"><small><?php echo $this->_e('Changing the cryptographic method will make all passwords stop working.'); ?></small></p>
						</div>
						<hr>
						<div class="form-group">
							<label><?php echo $this->_e('Debugging'); ?></label>
							<input disabled type="text" class="form-control" value="<?php echo (FORWARD_DEBUG ? $this->_e('Enabled') : $this->_e('Disabled')); ?>">
							<small><?php echo $this->_e('Remember to turn off debugging if you have stopped testing the page.'); ?></small>
						</div>
					</div>
				</div>

				<div class="settings-page__save">
					<button id="save-settings" type="submit" class="btn-forward"><?php echo $this->_e('Save settings'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
$this->GetFooter();
?>