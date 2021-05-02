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

$selectedBackground = Constants::$backgrounds[rand(0, count(Constants::$backgrounds) - 1)];
$this->GetHeader();
?>
<section class="splash">
	<div class="splash__background">
		<picture>
			<source srcset="<?php echo $this->GetImage($selectedBackground[2] . '.webp'); ?>" type="image/webp">
			<source srcset="<?php echo $this->GetImage($selectedBackground[2] . '.jpeg'); ?>" type="image/jpeg">
			<img alt="Forward big background image" src="<?php echo $this->GetImage($selectedBackground[2] . '.jpeg'); ?>">
		</picture>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-6" style="display: flex;align-items: center;">
				<picture class="splash__logo">
					<source srcset="<?php echo $this->GetImage('forward-logo-wt.webp'); ?>" type="image/webp">
					<source srcset="<?php echo $this->GetImage('forward-logo-wt.jpeg'); ?>" type="image/jpeg">
					<img alt="Forward logo" src="<?php echo $this->GetImage('forward-logo-wt.jpeg'); ?>">
				</picture>
			</div>
			<div class="col-12 col-lg-6">
				<div class="splash__card">
					<div class="splash__card__body">
						<h1><?php $this->_e('Sign in'); ?></h1>
						<h2><?php echo $this->_e('Short links manager'); ?></h2>
						<form id="login-form" class="login-form">
							<input type="hidden" value="<?php echo $this->AjaxNonce('sign_in'); ?>" name="nonce">
							<input type="hidden" value="sign_in" name="action">
							<div class="form-group">
								<input type="text" class="form-control" name="login" id="login" placeholder="<?php $this->_e('Enter username/email'); ?>">
							</div>
							<div class="form-group" style="margin-top: 10px;">
								<div class="input-group input-password-preview password-hidden">
									<input type="password" class="form-control input-password-preview__field" id="password" name="password" placeholder="<?php $this->_e('Password'); ?>">
									<div class="input-group-addon">
										<a href="#">
											<svg class="input-password-preview__eyeclosed" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
												<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z" />
												<path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z" />
												<path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z" />
											</svg>
											<svg class="input-password-preview__eyeopen" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
												<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
												<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
											</svg>
										</a>
									</div>
								</div>
							</div>
							<div id="login-alert" class="alert alert-danger fade show" role="alert" style="display: none;margin-top: 30px;">
								<strong><?php $this->_e('Holy guacamole!'); ?></strong> <?php $this->_e('You entered an incorrect login or password'); ?>
							</div>
							<button type="submit" id="button-form" class="btn-forward block"><?php $this->_e('Submit'); ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="splash__footer">
		Copyright © 2019-<?php echo date('Y'); ?> Leszek Pomianowski | MIT License
		<br>
		<?php $this->_e('Background image'); ?>: <i><?php echo $selectedBackground[1] . ' ' . $this->__('created by') . ' ' . $selectedBackground[0]; ?></i>
		<br>
		<?php $this->_e('Logo font'); ?>: Questrial by <i>Joe Prince</i>
	</div>
</section>
<div>
	<div>
		<?php
		$this->GetFooter();
		?>