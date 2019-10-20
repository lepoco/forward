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
								<label for="siteurl">Site URL</label>
								<input type="text" class="form-control" name="siteurl" id="siteurl" placeholder="<?php echo $this->DB['options']->get('siteurl')->value; ?>" value="<?php echo $this->DB['options']->get('siteurl')->value; ?>">
							</div>
							<div class="form-group">
								<label for="dashboardurl">Dashboard URL</label>
								<input type="text" class="form-control" name="dashboardurl" id="dashboardurl" placeholder="<?php echo $this->DB['options']->get('dashboard')->value; ?>" value="<?php echo $this->DB['options']->get('dashboard')->value; ?>">
							</div>
							<small>ATTENTION!<br/>Change URLs only if you have moved the site to a different domain or folder. Otherwise, access to the panel may be blocked.</small>
						</div>
						<div class="tab-pane fade" id="v-pills-redirects" role="tabpanel" aria-labelledby="v-pills-redirects-tab">
							<h2 class="display-4" style="font-size: 26px;">Redirects</h2>
							<div class="form-group">
								<label for="redirect404">Redirect 404 page</label>
								<select class="form-control" id="redirect404" name="redirect404">
									<option value="1">Enabled</option>
									<option value="2" selected="selected">Disabled</option>
								</select>
							</div>
							<div class="form-group">
								<label for="redirect404url">Page to which redirect error 404</label>
								<input type="text" class="form-control" id="redirect404url" id="redirect404url" placeholder="https://" value="<?php echo $this->DB['options']->get('404redirect')->value; ?>">
							</div>
							<hr>
							<div class="form-group">
								<label for="redirecthome">Redirect Home page</label>
								<select class="form-control" id="redirecthome" name="redirecthome">
									<option value="1">Enabled</option>
									<option value="2" selected="selected">Disabled</option>
								</select>
							</div>
							<div class="form-group">
								<label for="redirecthomeurl">Page to which redirect home page</label>
								<input type="text" class="form-control" name="redirecthomeurl" id="redirecthomeurl" placeholder="https://" value="<?php echo $this->DB['options']->get('homeredirect')->value; ?>">
							</div>
						</div>
						<div class="tab-pane fade" id="v-pills-cache" role="tabpanel" aria-labelledby="v-pills-cache-tab">
							<h2 class="display-4" style="font-size: 26px;">Cache</h2>
							<div class="form-group">
								<label for="enableredirectcache">Enable Cache for redirects database</label>
								<select class="form-control" id="enableredirectcache" name="enableredirectcache">
									<option value="1">Enabled</option>
									<option value="2" selected="selected">Disabled</option>
								</select>
							</div>
						</div>
						<div class="tab-pane fade" id="v-pills-encryption" role="tabpanel" aria-labelledby="v-pills-encryption-tab">
							<h2 class="display-4" style="font-size: 26px;">Connection encryption</h2>
							<div class="form-group">
								<label for="redirectSSL">Force HTTPS <i>(ssl connection)</i> for redirects</label>
								<select class="form-control" name="redirectSSL" id="redirectSSL">
									<option value="1">Enabled</option>
									<option value="2" selected="selected">Disabled</option>
								</select>
							</div>
							<div class="form-group">
								<label for="adminSSL">Force HTTPS <i>(ssl connection)</i> for dashboard</label>
								<select class="form-control" name="adminSSL" id="adminSSL">
									<option value="1">Enabled</option>
									<option value="2" selected="selected">Disabled</option>
								</select>
							</div>
						</div>
						<div class="tab-pane fade" id="v-pills-analytics" role="tabpanel" aria-labelledby="v-pills-analytics-tab">
							<h2 class="display-4" style="font-size: 26px;">Google Analytics</h2>
							<div class="form-group">
								<label for="jsredirect">JS Redirection</label>
								<select class="form-control" id="jsredirect" name="jsredirect">
									<option value="1">Enabled</option>
									<option value="2" selected="selected">Disabled</option>
								</select>
								<small>Enable redirection via JavaScript.</small>
							</div>
						</div>
						<div class="tab-pane fade" id="v-pills-captcha" role="tabpanel" aria-labelledby="v-pills-captcha-tab">
							<h2 class="display-4" style="font-size: 26px;">Google ReCaptcha V3</h2>
							<div class="form-group">
								<label for="captcha_site">ReCaptcha site key</label>
								<input type="text" class="form-control" id="captcha_site" name="captcha_site" placeholder="eg.: 9Lb5ib4UACCCCM8mXw2nit90d-7vCcLd1LjQHWXn">
							</div>
							<div class="form-group">
								<label for="captcha_secret">ReCaptcha secret key</label>
								<input type="text" class="form-control" id="captcha_secret" name="captcha_secret" placeholder="eg.: 9Lb5ib4UACCCCM8mXIAKcfHTbL7M3d-xHSWTyz-Q">
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
								<label>Users database</label>
								<input disabled type="text" class="form-control" placeholder="<?php echo DB_USERS; ?>" value="<?php echo DB_USERS; ?>">
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