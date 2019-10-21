<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;
	defined('ABSPATH') or die('No script kiddies please!');

	$this->head(); $this->menu();
?>
<div id="red-settings">
	<form id="settings-form" action="<?php echo $this->home_url().'dashboard/ajax/'; ?>">
		<input type="hidden" value="saveSettings" name="action">
		<input type="hidden" value="<?php echo RED::encrypt('ajax_save_settings_nonce', 'nonce'); ?>" name="nonce">
		<div class="container">
			<div class="row">
				<div class="col-12">
				</div>
				<div class="col-12 col-md-3" style="margin-bottom: 50px;">
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="v-pills-main-tab" data-toggle="pill" href="#v-pills-main" role="tab" aria-controls="v-pills-main" aria-selected="true">Main</a>
						<a class="nav-link" id="v-pills-redirects-tab" data-toggle="pill" href="#v-pills-redirects" role="tab" aria-controls="v-pills-redirects" aria-selected="false">Redirects</a>
						<a class="nav-link" id="v-pills-cache-tab" data-toggle="pill" href="#v-pills-cache" role="tab" aria-controls="v-pills-cache" aria-selected="false">Cache</a>
						<a class="nav-link" id="v-pills-encryption-tab" data-toggle="pill" href="#v-pills-encryption" role="tab" aria-controls="v-pills-encryption" aria-selected="false">Encryption</a>
						<a class="nav-link" id="v-pills-analytics-tab" data-toggle="pill" href="#v-pills-analytics" role="tab" aria-controls="v-pills-analytics" aria-selected="false">Analytics</a>
						<a class="nav-link" id="v-pills-captcha-tab" data-toggle="pill" href="#v-pills-captcha" role="tab" aria-controls="v-pills-captcha" aria-selected="false">Captcha</a>
						<a class="nav-link" id="v-pills-miscellaneous-tab" data-toggle="pill" href="#v-pills-miscellaneous" role="tab" aria-controls="v-pills-miscellaneous" aria-selected="false">Miscellaneous</a>
					</div>
					<hr>
					<button id="save-settings" type="submit" class="btn btn-block btn-outline-dark">Save settings</button>
				</div>
				<div class="col-12 col-md-9">
					<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade show active" id="v-pills-main" role="tabpanel" aria-labelledby="v-pills-main-tab">
							<h2 class="display-4" style="font-size: 26px;">URLs</h2>
							<div class="form-group">
								<label for="site_url">Site URL</label>
								<input type="text" class="form-control" name="site_url" id="site_url" placeholder="<?php echo $this->DB['options']->get('siteurl')->value; ?>" value="<?php echo $this->DB['options']->get('siteurl')->value; ?>">
							</div>
							<div class="form-group">
								<label for="dashboard_url">Dashboard URL</label>
								<input type="text" class="form-control" name="dashboard_url" id="dashboard_url" placeholder="<?php echo $this->DB['options']->get('dashboard')->value; ?>" value="<?php echo $this->DB['options']->get('dashboard')->value; ?>">
							</div>
							<small>ATTENTION!<br/>Change URLs only if you have moved the site to a different domain or folder. Otherwise, access to the panel may be blocked.</small>
						</div>
						<div class="tab-pane fade" id="v-pills-redirects" role="tabpanel" aria-labelledby="v-pills-redirects-tab">
							<h2 class="display-4" style="font-size: 26px;">Redirects</h2>
							<div class="form-group">
								<label for="redirect_404">Redirect 404 page</label>
								<select class="form-control" id="redirect_404" name="redirect_404">
									<?php
										$option = $this->DB['options']->get('redirect_404')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>>Enabled</option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>>Disabled</option>
								</select>
							</div>
							<div class="form-group">
								<label for="redirect_404_url">Page to which redirect error 404</label>
								<input type="text" class="form-control" id="redirect_404_url" name="redirect_404_url" placeholder="https://" value="<?php echo $this->DB['options']->get('redirect_404_url')->value; ?>">
							</div>
							<hr>
							<div class="form-group">
								<label for="redirect_home">Redirect Home page</label>
								<select class="form-control" id="redirect_home" name="redirect_home">
									<?php
										$option = $this->DB['options']->get('redirect_home')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>>Enabled</option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>>Disabled</option>
								</select>
							</div>
							<div class="form-group">
								<label for="redirect_home_url">Page to which redirect home page</label>
								<input type="text" class="form-control" name="redirect_home_url" id="redirect_home_url" placeholder="https://" value="<?php echo $this->DB['options']->get('redirect_home_url')->value; ?>">
							</div>
						</div>
						<div class="tab-pane fade" id="v-pills-cache" role="tabpanel" aria-labelledby="v-pills-cache-tab">
							<h2 class="display-4" style="font-size: 26px;">Cache</h2>
							<div class="form-group">
								<label for="cache_redirects">Enable Cache for redirects database</label>
								<select class="form-control" id="cache_redirects" name="cache_redirects">
									<?php
										$option = $this->DB['options']->get('cache_redirects')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>>Enabled</option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>>Disabled</option>
								</select>
							</div>
						</div>
						<div class="tab-pane fade" id="v-pills-encryption" role="tabpanel" aria-labelledby="v-pills-encryption-tab">
							<h2 class="display-4" style="font-size: 26px;">Connection encryption</h2>
							<div class="form-group">
								<label for="redirect_ssl">Force HTTPS <i>(ssl connection)</i> for redirects</label>
								<select class="form-control" name="redirect_ssl" id="redirect_ssl">
									<?php
										$option = $this->DB['options']->get('redirect_ssl')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>>Enabled</option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>>Disabled</option>
								</select>
							</div>
							<div class="form-group">
								<label for="admin_ssl">Force HTTPS <i>(ssl connection)</i> for dashboard</label>
								<select class="form-control" name="admin_ssl" id="admin_ssl">
									<?php
										$option = $this->DB['options']->get('admin_ssl')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>>Enabled</option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>>Disabled</option>
								</select>
							</div>
							<small>
								You don't have to spend money on certificates from companies like Comodo or RapidSSL.
								<br>
								You can generate a free certificate with <a href="https://letsencrypt.org/" target="_blank" rel="noopener">Let's Encrypt</a>.
								<hr>
								SSL is recommended.
								<br>
								You protect both yourself and your users against a number of attacks. MIDM and Session Hijacking are one of the most dangerous. Never put safety second.
							</small>
						</div>
						<div class="tab-pane fade" id="v-pills-analytics" role="tabpanel" aria-labelledby="v-pills-analytics-tab">
							<h2 class="display-4" style="font-size: 26px;">Google Analytics</h2>
							<div class="form-group">
								<label for="js_redirect">JS Redirection</label>
								<select class="form-control" id="js_redirect" name="js_redirect">
									<?php
										$option = $this->DB['options']->get('js_redirect')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>>Enabled</option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>>Disabled</option>
								</select>
							</div>
							<div class="form-group">
								<label for="gtag">Tracking Code (gtag)</label>
								<input type="text" class="form-control" id="gtag" name="gtag" placeholder="eg.: UA-111112222-2" value="<?php echo $this->DB['options']->get('gtag')->value; ?>">
							</div>
							<div class="form-group">
								<label for="js_redirect_after">Redirect after:</label>
								<select class="form-control" name="js_redirect_after" id="js_redirect_after">
									<?php
										$option = $this->DB['options']->get('js_redirect_after')->value;
									?>
									<option value="0"<?php echo $option==0 ? ' selected="selected"' : ""; ?>>Immediately</option>
									<option value="500"<?php echo $option==500 ? ' selected="selected"' : ""; ?>>500ms</option>
									<option value="1000"<?php echo $option==1000 ? ' selected="selected"' : ""; ?>>1000ms <i>(1 second)</i></option>
									<option value="2000"<?php echo $option==2000 ? ' selected="selected"' : ""; ?>>2000ms <i>(2 seconds)</i></option>
									<option value="3000"<?php echo $option==3000 ? ' selected="selected"' : ""; ?>>3000ms <i>(3 seconds)</i></option>
								</select>
							</div>
							<small>
								<strong>ATTENTION!</strong>
								<br>
								JavaScript redirection and the use of Google Analytics may not work. This method is less effective and is not recommended.
								<br>
								Anyway, if you want you can use it.
							</small>
						</div>
						<div class="tab-pane fade" id="v-pills-captcha" role="tabpanel" aria-labelledby="v-pills-captcha-tab">
							<h2 class="display-4" style="font-size: 26px;">Google ReCaptcha V3</h2>
							<div class="form-group">
								<label for="captcha_site">ReCaptcha site key</label>
								<input type="text" class="form-control" id="captcha_site" name="captcha_site" value="<?php echo $this->DB['options']->get('captcha_site')->value; ?>" placeholder="eg.: 9Lb5ib4UACCCCM8mXw2nit90d-7vCcLd1LjQHWXn">
							</div>
							<div class="form-group">
								<label for="captcha_secret">ReCaptcha secret key</label>
								<input type="text" class="form-control" id="captcha_secret" name="captcha_secret" placeholder="eg.: 9Lb5ib4UACCCCM8mXIAKcfHTbL7M3d-xHSWTyz-Q" value="<?php echo $this->DB['options']->get('captcha_secret')->value; ?>">
							</div>
							<small>
								You can enable <a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="noopener">Google ReCaptcha V3</a> for admin panel login.
								<br>
								Leave these fields blank if you want to disable ReCaptcha V3
							</small>
						</div>
						<div class="tab-pane fade" id="v-pills-miscellaneous" role="tabpanel" aria-labelledby="v-pills-miscellaneous-tab">
							<h2 class="display-4" style="font-size: 26px;">Miscellaneous</h2>
							<p>
								You can change these options only in the <strong>red-config.php</strong> file
								<br>
								<small><?php $p = str_replace('\\','/',trim(ADMPATH.'red-config.php')); echo $p; ?></small>
							</p>
							<div class="form-group">
								<label>Users database</label>
								<input disabled type="text" class="form-control" placeholder="<?php echo DB_USERS; ?>" value="<?php echo DB_USERS; ?>">
							</div>
							<div class="form-group">
								<label>Options database</label>
								<input disabled type="text" class="form-control" placeholder="<?php echo DB_OPTIONS; ?>" value="<?php echo DB_OPTIONS; ?>">
							</div>
							<div class="form-group">
								<label>Records database</label>
								<input disabled type="text" class="form-control" placeholder="<?php echo DB_RECORDS; ?>" value="<?php echo DB_RECORDS; ?>">
							</div>
							<div class="form-group">
								<label>Cryptographic method for passwords</label>
								<input disabled type="text" class="form-control" value="<?php
								switch(RED_ALGO)
								{
									case 1: //PASSWORD_BCRYPT
									echo 'CRYPT_BLOWFISH algorithm to create the hash';
									break;
									case 2: //PASSWORD_ARGON2I
									echo 'Argon2i hashing algorithm to create the hash';
									break;
									case 3: //PASSWORD_ARGON2ID
									echo 'Argon2id hashing algorithm to create the hash';
									break;
									default: //PASSWORD_DEFAULT
									echo 'DEFAULT - bcrypt algorithm (default as of PHP 5.5.0)';
									break;
								}

								?>">
								<small>Changing the cryptographic method will make all passwords stop working.</small>
								<hr>
								<div class="form-group">
									<label>Debugging</label>
									<input disabled type="text" class="form-control" value="<?php echo (RED_DEBUG ? 'Enabled' : 'Disabled'); ?>">
									<small>Remember to turn off debugging if you have stopped testing the page.</small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	window.onload = function() {
		jQuery('#save-settings').on('click', function(e){
			e.preventDefault();
			jQuery.ajax({
				url: '<?php echo $this->home_url().'dashboard/ajax/'; ?>',
				type:'post',
				data:$("#settings-form").serialize(),
				success:function(e)
				{
					console.log(e);
				},
				fail:function(xhr, textStatus, errorThrown){
					console.log(xhr);
					console.log(textStatus);
					alert(errorThrown);
				}
			});
		});
	};
</script>
<?php $this->footer(); ?>