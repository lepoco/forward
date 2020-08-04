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
							<source srcset="<?php echo $this->GetImage('forward-logo-wt.webp') ?>" type="image/webp">
							<source srcset="<?php echo $this->GetImage('forward-logo-wt.jpeg') ?>" type="image/jpeg">
							<img alt="Forward logo" src="<?php echo $this->GetImage('forward-logo-wt.jpeg') ?>">
						</picture>
					</div>
					<div class="col-12 col-lg-6">
					<div class="home-card">
						<div class="card" id="install-form">
							<div class="card-body">
								<div id="install-form-alert" class="alert alert-danger" style="display:none;">
									<span></span>
								</div>
								<form method="post" autocomplete="off">
									<h1>Quick Install</h1>
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
											<div class="form-group" style="margin-top:10px;">
												<label for="input_user_password">Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="text" autocomplete="new-password" class="form-control" id="input_user_password" placeholder="password" value="<?php echo Crypter::DeepSalter(15); ?>">
													<div class="input-group-addon">
														<a href=""><svg style="width:15px;height:15px" viewBox="0 0 24 24"><path fill="currentColor" d="M17,7H22V17H17V19A1,1 0 0,0 18,20H20V22H17.5C16.95,22 16,21.55 16,21C16,21.55 15.05,22 14.5,22H12V20H14A1,1 0 0,0 15,19V5A1,1 0 0,0 14,4H12V2H14.5C15.05,2 16,2.45 16,3C16,2.45 16.95,2 17.5,2H20V4H18A1,1 0 0,0 17,5V7M2,7H13V9H4V15H13V17H2V7M20,15V9H17V15H20M8.5,12A1.5,1.5 0 0,0 7,10.5A1.5,1.5 0 0,0 5.5,12A1.5,1.5 0 0,0 7,13.5A1.5,1.5 0 0,0 8.5,12M13,10.89C12.39,10.33 11.44,10.38 10.88,11C10.32,11.6 10.37,12.55 11,13.11C11.55,13.63 12.43,13.63 13,13.11V10.89Z" /></svg></a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12">
											<span class="def_password--strength"></span>
										</div>
									</div>
								</form>
							</div>
							<button id="install-forward" type="button" class="btn card-button btn-primary">Install</button>
						</div>
						<div class="card" id="install-progress" style="display: none;">
							<div class="card-body">
								<div style="display: flex;align-items: center;">
									<img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzgiIGhlaWdodD0iMzgiIHZpZXdCb3g9IjAgMCAzOCAzOCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4gICAgPGRlZnM+ICAgICAgICA8bGluZWFyR3JhZGllbnQgeDE9IjguMDQyJSIgeTE9IjAlIiB4Mj0iNjUuNjgyJSIgeTI9IjIzLjg2NSUiIGlkPSJhIj4gICAgICAgICAgICA8c3RvcCBzdG9wLWNvbG9yPSIjNDQ0IiBzdG9wLW9wYWNpdHk9IjAiIG9mZnNldD0iMCUiLz4gICAgICAgICAgICA8c3RvcCBzdG9wLWNvbG9yPSIjNDQ0IiBzdG9wLW9wYWNpdHk9Ii42MzEiIG9mZnNldD0iNjMuMTQ2JSIvPiAgICAgICAgICAgIDxzdG9wIHN0b3AtY29sb3I9IiM0NDQiIG9mZnNldD0iMTAwJSIvPiAgICAgICAgPC9saW5lYXJHcmFkaWVudD4gICAgPC9kZWZzPiAgICA8ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPiAgICAgICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMSAxKSI+ICAgICAgICAgICAgPHBhdGggZD0iTTM2IDE4YzAtOS45NC04LjA2LTE4LTE4LTE4IiBpZD0iT3ZhbC0yIiBzdHJva2U9InVybCgjYSkiIHN0cm9rZS13aWR0aD0iMiI+ICAgICAgICAgICAgICAgIDxhbmltYXRlVHJhbnNmb3JtICAgICAgICAgICAgICAgICAgICBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iICAgICAgICAgICAgICAgICAgICB0eXBlPSJyb3RhdGUiICAgICAgICAgICAgICAgICAgICBmcm9tPSIwIDE4IDE4IiAgICAgICAgICAgICAgICAgICAgdG89IjM2MCAxOCAxOCIgICAgICAgICAgICAgICAgICAgIGR1cj0iMC45cyIgICAgICAgICAgICAgICAgICAgIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIiAvPiAgICAgICAgICAgIDwvcGF0aD4gICAgICAgICAgICA8Y2lyY2xlIGZpbGw9IiM0NDQiIGN4PSIzNiIgY3k9IjE4IiByPSIxIj4gICAgICAgICAgICAgICAgPGFuaW1hdGVUcmFuc2Zvcm0gICAgICAgICAgICAgICAgICAgIGF0dHJpYnV0ZU5hbWU9InRyYW5zZm9ybSIgICAgICAgICAgICAgICAgICAgIHR5cGU9InJvdGF0ZSIgICAgICAgICAgICAgICAgICAgIGZyb209IjAgMTggMTgiICAgICAgICAgICAgICAgICAgICB0bz0iMzYwIDE4IDE4IiAgICAgICAgICAgICAgICAgICAgZHVyPSIwLjlzIiAgICAgICAgICAgICAgICAgICAgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiIC8+ICAgICAgICAgICAgPC9jaXJjbGU+ICAgICAgICA8L2c+ICAgIDwvZz48L3N2Zz4=" alt="Loader" style="margin-right: 15px;">
									<span>We are just trying to install Forward...</span>
								</div>
							</div>
						</div>
						<div class="card" id="install-done" style="display: none;">
							<div class="card-body">
								<h1>Everything is ready!</h1>
								<span>You will be redirected in a few seconds</span>
							</div>
						</div>
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
