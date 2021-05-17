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

use Forward\Core\Crypter;

defined('ABSPATH') or die('No script kiddies please!');

$this->getHeader();
?>
<section class="splash">
	<div class="splash__background">
		<picture>
			<?php $selectedBackground = $this->getBackgrounds(); ?>
			<source srcset="<?php echo $this->getImage($selectedBackground[2] . '.webp'); ?>" type="image/webp">
			<source srcset="<?php echo $this->getImage($selectedBackground[2] . '.jpeg'); ?>" type="image/jpeg">
			<img alt="Forward big background image" src="<?php echo $this->getImage($selectedBackground[2] . '.jpeg'); ?>">
		</picture>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-6" style="display: flex;align-items: center;">
				<picture class="splash__logo">
					<source srcset="<?php echo $this->getImage('forward-logo-wt.webp'); ?>" type="image/webp">
					<source srcset="<?php echo $this->getImage('forward-logo-wt.jpeg'); ?>" type="image/jpeg">
					<img alt="Forward logo" src="<?php echo $this->getImage('forward-logo-wt.jpeg'); ?>">
				</picture>
			</div>
			<div class="col-12 col-lg-6">
				<div class="splash__card">
					<div id="install-form" class="splash__card__body">
						<div id="install-form-alert" class="alert alert-danger" style="display:none;">
							<span></span>
						</div>

						<h1><?php $this->_e('Quick install'); ?></h1>
						<h2><?php echo $this->_e('Fast and efficient, almost like in a state office'); ?></h2>

						<form method="post" autocomplete="off" style="margin-top:2rem;">
							<input type="hidden" class="form-control" id="input_scriptname" value="<?php echo dirname($_SERVER["SCRIPT_NAME"]); ?>">
							<span>Default URL</span>
							<div class="form-group">
								<input type="text" class="form-control" id="input_baseuri" placeholder="<?php echo $this->Forward->Path->ScriptURI(); ?>" value="<?php echo $this->Forward->Path->ScriptURI(); ?>">
							</div>
							<span style="display:block;width:100%;margin-top:10px;">Database</span>
							<div class="row">
								<div class="col-12 col-lg-6">
									<div class="form-group">
										<input type="text" class="form-control" id="input_db_name" placeholder="Database name">
									</div>
								</div>
								<div class="col-12 col-lg-6">
									<div class="form-group">
										<input type="text" class="form-control" id="input_db_user" placeholder="Database user">
									</div>
								</div>
								<div class="col-12 col-lg-6">
									<div class="form-group" style="margin-top:10px;">
										<input type="text" class="form-control" id="input_db_password" placeholder="Database password">
									</div>
								</div>
								<div class="col-12 col-lg-6">
									<div class="form-group" style="margin-top:10px;">
										<input type="text" class="form-control" id="input_db_host" placeholder="Database host">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-lg-6">
									<div class="form-group" style="margin-top:10px;">
										<label for="input_user_name">Login</label>
										<input type="text" autocomplete="off" class="form-control" id="input_user_name" placeholder="login" value="admin">
									</div>
								</div>
								<div class="col-12 col-lg-6">
									<div class="input-group input-password-preview password-visible" style="margin-top:10px;">
										<label for="input_user_password" style="display:block;width:100%;">Password</label>
										<input type="text" autocomplete="new-password" class="form-control input-password-preview__field" id="input_user_password" name="input_user_password" placeholder="<?php $this->_e('Password'); ?>" value="<?php echo Crypter::salter(15); ?>">
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
								<div class="col-12">
									<span style="padding-top: 1rem;display: block;" class="def_password--strength"></span>
								</div>
							</div>
							<button id="install-forward" type="button" class="btn-forward block"><?php $this->_e('Install'); ?></button>
						</form>
					</div>
					<div id="install-progress" class="splash__card__body" style="display:none;">
						<div style="display: flex;align-items: center;">
							<img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzgiIGhlaWdodD0iMzgiIHZpZXdCb3g9IjAgMCAzOCAzOCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4gICAgPGRlZnM+ICAgICAgICA8bGluZWFyR3JhZGllbnQgeDE9IjguMDQyJSIgeTE9IjAlIiB4Mj0iNjUuNjgyJSIgeTI9IjIzLjg2NSUiIGlkPSJhIj4gICAgICAgICAgICA8c3RvcCBzdG9wLWNvbG9yPSIjNDQ0IiBzdG9wLW9wYWNpdHk9IjAiIG9mZnNldD0iMCUiLz4gICAgICAgICAgICA8c3RvcCBzdG9wLWNvbG9yPSIjNDQ0IiBzdG9wLW9wYWNpdHk9Ii42MzEiIG9mZnNldD0iNjMuMTQ2JSIvPiAgICAgICAgICAgIDxzdG9wIHN0b3AtY29sb3I9IiM0NDQiIG9mZnNldD0iMTAwJSIvPiAgICAgICAgPC9saW5lYXJHcmFkaWVudD4gICAgPC9kZWZzPiAgICA8ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPiAgICAgICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMSAxKSI+ICAgICAgICAgICAgPHBhdGggZD0iTTM2IDE4YzAtOS45NC04LjA2LTE4LTE4LTE4IiBpZD0iT3ZhbC0yIiBzdHJva2U9InVybCgjYSkiIHN0cm9rZS13aWR0aD0iMiI+ICAgICAgICAgICAgICAgIDxhbmltYXRlVHJhbnNmb3JtICAgICAgICAgICAgICAgICAgICBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iICAgICAgICAgICAgICAgICAgICB0eXBlPSJyb3RhdGUiICAgICAgICAgICAgICAgICAgICBmcm9tPSIwIDE4IDE4IiAgICAgICAgICAgICAgICAgICAgdG89IjM2MCAxOCAxOCIgICAgICAgICAgICAgICAgICAgIGR1cj0iMC45cyIgICAgICAgICAgICAgICAgICAgIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIiAvPiAgICAgICAgICAgIDwvcGF0aD4gICAgICAgICAgICA8Y2lyY2xlIGZpbGw9IiM0NDQiIGN4PSIzNiIgY3k9IjE4IiByPSIxIj4gICAgICAgICAgICAgICAgPGFuaW1hdGVUcmFuc2Zvcm0gICAgICAgICAgICAgICAgICAgIGF0dHJpYnV0ZU5hbWU9InRyYW5zZm9ybSIgICAgICAgICAgICAgICAgICAgIHR5cGU9InJvdGF0ZSIgICAgICAgICAgICAgICAgICAgIGZyb209IjAgMTggMTgiICAgICAgICAgICAgICAgICAgICB0bz0iMzYwIDE4IDE4IiAgICAgICAgICAgICAgICAgICAgZHVyPSIwLjlzIiAgICAgICAgICAgICAgICAgICAgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiIC8+ICAgICAgICAgICAgPC9jaXJjbGU+ICAgICAgICA8L2c+ICAgIDwvZz48L3N2Zz4=" alt="Loader" style="margin-right: 15px;">
							<h2>We are just trying to install Forward...</h2>
						</div>
					</div>
					<div id="install-done" class="splash__card__body" style="display:none;">
						<h1>Everything is ready!</h1>
						<h2>You will be redirected in a few seconds</h2>
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
		$this->getFooter();
		?>