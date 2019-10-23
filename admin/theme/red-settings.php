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
		<input type="hidden" value="save_settings" name="action">
		<input type="hidden" value="<?php echo RED::encrypt('ajax_save_settings_nonce', 'nonce'); ?>" name="nonce">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-3" style="margin-bottom: 50px;">
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="v-pills-main-tab" data-toggle="pill" href="#v-pills-main" role="tab" aria-controls="v-pills-main" aria-selected="true"><?php echo $this->e('Main'); ?></a>
						<a class="nav-link" id="v-pills-redirects-tab" data-toggle="pill" href="#v-pills-redirects" role="tab" aria-controls="v-pills-redirects" aria-selected="false"><?php echo $this->e('Redirects'); ?></a>
						<a class="nav-link" id="v-pills-cache-tab" data-toggle="pill" href="#v-pills-cache" role="tab" aria-controls="v-pills-cache" aria-selected="false"><?php echo $this->e('Cache'); ?></a>
						<a class="nav-link" id="v-pills-captcha-tab" data-toggle="pill" href="#v-pills-captcha" role="tab" aria-controls="v-pills-captcha" aria-selected="false"><?php echo $this->e('Captcha'); ?></a>
						<a class="nav-link" id="v-pills-encryption-tab" data-toggle="pill" href="#v-pills-encryption" role="tab" aria-controls="v-pills-encryption" aria-selected="false"><?php echo $this->e('Encryption'); ?></a>
						<a class="nav-link" id="v-pills-analytics-tab" data-toggle="pill" href="#v-pills-analytics" role="tab" aria-controls="v-pills-analytics" aria-selected="false"><?php echo $this->e('Analytics'); ?></a>
						<a class="nav-link" id="v-pills-languages-tab" data-toggle="pill" href="#v-pills-languages" role="tab" aria-controls="v-pills-languages" aria-selected="false"><?php echo $this->e('Languages'); ?></a>
						<a class="nav-link" id="v-pills-miscellaneous-tab" data-toggle="pill" href="#v-pills-miscellaneous" role="tab" aria-controls="v-pills-miscellaneous" aria-selected="false"><?php echo $this->e('Miscellaneous'); ?></a>
					</div>
					<hr>
					<button id="save-settings" type="submit" class="btn btn-block btn-outline-dark"><?php echo $this->e('Save settings'); ?></button>
				</div>
				<div class="col-12 col-md-9">
					<div id="alert-error" class="alert alert-danger fade show" role="alert" style="display: none;">
						<strong>Holy guacamole!</strong> <span id="error_text">Something went wrong!</span>
					</div>
					<div id="alert-success" class="alert alert-success fade show" role="alert" style="display: none;">
						<strong>Success!</strong> Settings have been saved.
					</div>
					<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade show active" id="v-pills-main" role="tabpanel" aria-labelledby="v-pills-main-tab">
							<h2 class="display-4" style="font-size: 26px;"><?php echo $this->e('URLs'); ?></h2>
							<div class="form-group">
								<label for="site_url"><?php echo $this->e('Main website URL'); ?></label>
								<input type="text" class="form-control" name="site_url" id="site_url" placeholder="<?php echo $this->RED->DB['options']->get('siteurl')->value; ?>" value="<?php echo $this->RED->DB['options']->get('siteurl')->value; ?>">
							</div>
							<div class="form-group">
								<label for="dashboard_url"><?php echo $this->e('Dashboard URL'); ?></label>
								<input type="text" class="form-control" name="dashboard_url" id="dashboard_url" placeholder="<?php echo $this->RED->DB['options']->get('dashboard')->value; ?>" value="<?php echo $this->RED->DB['options']->get('dashboard')->value; ?>">
							</div>
							<small><span class="uppercase"><strong><?php echo $this->e('Attention'); ?>!</strong></span><br/><?php echo $this->e('Change URLs only if you have moved the site to a different domain or folder. Otherwise, access to the panel may be blocked.') ?></small>
						</div>
						<div class="tab-pane fade" id="v-pills-redirects" role="tabpanel" aria-labelledby="v-pills-redirects-tab">
							<h2 class="display-4" style="font-size: 26px;"><?php echo $this->e('Redirects'); ?></h2>
							<div class="form-group">
								<label for="redirect_404"><?php echo $this->e('Redirect 404 page'); ?></label>
								<select class="form-control" id="redirect_404" name="redirect_404">
									<?php
										$option = $this->RED->DB['options']->get('redirect_404')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Enabled'); ?></option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Disabled'); ?></option>
								</select>
							</div>
							<div class="form-group">
								<label for="redirect_404_url"><?php echo $this->e('URL to which redirect error 404'); ?></label>
								<input type="text" class="form-control" id="redirect_404_url" name="redirect_404_url" placeholder="https://" value="<?php echo $this->RED->DB['options']->get('redirect_404_url')->value; ?>">
							</div>
							<hr>
							<div class="form-group">
								<label for="redirect_home"><?php echo $this->e('Redirect Home page'); ?></label>
								<select class="form-control" id="redirect_home" name="redirect_home">
									<?php
										$option = $this->RED->DB['options']->get('redirect_home')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Enabled'); ?></option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Disabled'); ?></option>
								</select>
							</div>
							<div class="form-group">
								<label for="redirect_home_url"><?php echo $this->e('URL to which redirect home page'); ?></label>
								<input type="text" class="form-control" name="redirect_home_url" id="redirect_home_url" placeholder="https://" value="<?php echo $this->RED->DB['options']->get('redirect_home_url')->value; ?>">
							</div>
						</div>
						<div class="tab-pane fade" id="v-pills-cache" role="tabpanel" aria-labelledby="v-pills-cache-tab">
							<h2 class="display-4" style="font-size: 26px;"><?php echo $this->e('Cache') ?></h2>
							<div class="form-group">
								<label for="cache_redirects"><?php echo $this->e('Enable Cache for records database'); ?></label>
								<select class="form-control" id="cache_redirects" name="cache_redirects">
									<?php
										$option = $this->RED->DB['options']->get('cache_redirects')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Enabled'); ?></option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Disabled'); ?></option>
								</select>
							</div>
						</div>
						<div class="tab-pane fade" id="v-pills-captcha" role="tabpanel" aria-labelledby="v-pills-captcha-tab">
							<h2 class="display-4" style="font-size: 26px;">Google ReCaptcha V3</h2>
							<div class="form-group">
								<label for="captcha_site"><?php echo $this->e('ReCaptcha site key'); ?></label>
								<input type="text" class="form-control" id="captcha_site" name="captcha_site" value="<?php echo $this->RED->DB['options']->get('captcha_site')->value; ?>" placeholder="<?php echo $this->e('eg.:'); ?> 9Lb5ib4UACCCCM8mXw2nit90d-7vCcLd1LjQHWXn">
							</div>
							<div class="form-group">
								<label for="captcha_secret"><?php echo $this->e('ReCaptcha secret key'); ?></label>
								<input type="text" class="form-control" id="captcha_secret" name="captcha_secret" placeholder="<?php echo $this->e('eg.:'); ?> 9Lb5ib4UACCCCM8mXIAKcfHTbL7M3d-xHSWTyz-Q" value="<?php echo $this->RED->DB['options']->get('captcha_secret')->value; ?>">
							</div>
							<small>
								<?php echo sprintf($this->e('You can enable %s for admin panel login.'), '<a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="noopener">Google ReCaptcha V3</a>'); ?>
								<br>
								<?php echo $this->e('Leave these fields blank if you want to disable ReCaptcha V3'); ?>
							</small>
						</div>
						<div class="tab-pane fade" id="v-pills-encryption" role="tabpanel" aria-labelledby="v-pills-encryption-tab">
							<h2 class="display-4" style="font-size: 26px;"><?php echo $this->e('Connection encryption'); ?></h2>
							<div class="form-group">
								<label for="redirect_ssl"><?php echo $this->e('Force SSL connection for redirects'); ?></label>
								<select class="form-control" name="redirect_ssl" id="redirect_ssl">
									<?php
										$option = $this->RED->DB['options']->get('redirect_ssl')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Enabled'); ?></option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Disabled'); ?></option>
								</select>
							</div>
							<div class="form-group">
								<label for="dashboard_ssl"><?php echo $this->e('Force SSL connection for dashboard'); ?></label>
								<select class="form-control" name="dashboard_ssl" id="dashboard_ssl">
									<?php
										$option = $this->RED->DB['options']->get('dashboard_ssl')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Enabled'); ?></option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Disabled'); ?></option>
								</select>
							</div>
							<small>
								<?php echo $this->e('You don\'t have to spend money on certificates from companies like Comodo or RapidSSL.'); ?>
								<br>
								<?php echo $this->e('You can generate a free certificate with'); ?> <a href="https://letsencrypt.org/" target="_blank" rel="noopener">Let's Encrypt</a>.
								<hr>
								<?php echo $this->e('SSL is recommended.'); ?>
								<br>
								<?php echo $this->e('You protect both yourself and your users against a number of attacks. MIDM and Session Hijacking are one of the most dangerous. Never put safety second.'); ?>
							</small>
						</div>
						<div class="tab-pane fade" id="v-pills-analytics" role="tabpanel" aria-labelledby="v-pills-analytics-tab">
							<h2 class="display-4" style="font-size: 26px;">Google Analytics</h2>
							<div class="form-group">
								<label for="js_redirect"><?php echo $this->e('JS Redirection'); ?></label>
								<select class="form-control" id="js_redirect" name="js_redirect">
									<?php
										$option = $this->RED->DB['options']->get('js_redirect')->value;
									?>
									<option value="1"<?php echo $option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Enabled'); ?></option>
									<option value="2"<?php echo !$option ? ' selected="selected"' : ""; ?>><?php echo $this->e('Disabled'); ?></option>
								</select>
							</div>
							<div class="form-group">
								<label for="gtag"><?php echo $this->e('Tracking Code (gtag)'); ?></label>
								<input type="text" class="form-control" id="gtag" name="gtag" placeholder="<?php echo $this->e('eg.:'); ?> UA-111112222-2" value="<?php echo $this->RED->DB['options']->get('gtag')->value; ?>">
							</div>
							<div class="form-group">
								<label for="js_redirect_after"><?php echo $this->e('Redirect after:'); ?></label>
								<select class="form-control" name="js_redirect_after" id="js_redirect_after">
									<?php
										$option = $this->RED->DB['options']->get('js_redirect_after')->value;
									?>
									<option value="0"<?php echo $option==0 ? ' selected="selected"' : ""; ?>><?php echo $this->e('Immediately'); ?></option>
									<option value="500"<?php echo $option==500 ? ' selected="selected"' : ""; ?>>500ms</option>
									<option value="1000"<?php echo $option==1000 ? ' selected="selected"' : ""; ?>>1000ms <i>(1 <?php echo $this->e('second'); ?>)</i></option>
									<option value="2000"<?php echo $option==2000 ? ' selected="selected"' : ""; ?>>2000ms <i>(2 <?php echo $this->e('seconds'); ?>)</i></option>
									<option value="3000"<?php echo $option==3000 ? ' selected="selected"' : ""; ?>>3000ms <i>(3 <?php echo $this->e('seconds'); ?>)</i></option>
								</select>
							</div>
							<small>
								<span class="uppercase"><strong><?php echo $this->e('Attention'); ?>!</strong></span>
								<br>
								<?php echo $this->e('JavaScript redirection and the use of Google Analytics may not work. This method is less effective and is not recommended.'); ?>
								<br>
								<?php echo $this->e('Anyway, if you want you can use it.'); ?>
							</small>
						</div>
						<div class="tab-pane fade" id="v-pills-languages" role="tabpanel" aria-labelledby="v-pills-languages-tab">
							<h2 class="display-4" style="font-size: 26px;"><?php echo $this->e('Languages'); ?></h2>
							<div class="form-group">
								<label for="language_type"><?php echo $this->e('Choose how languages are detected'); ?></label>
								<select class="form-control" id="language_type" name="language_type">
									<?php
										$option = $this->RED->DB['options']->get('language_type')->value;
									?>
									<option value="1"<?php echo $option==1 ? ' selected="selected"' : ""; ?>><?php echo $this->e('Automatically (browser)'); ?></option>
									<option disabled value="2"<?php echo $option==2 ? ' selected="selected"' : ""; ?>><?php echo $this->e('Automatically (geolocation)'); ?></option>
									<option value="3"<?php echo $option==3 ? ' selected="selected"' : ""; ?>><?php echo $this->e('Permanently defined'); ?></option>
								</select>
							</div>
							<div class="form-group">
								<label for="language_select"><?php echo $this->e('Statically defined language'); ?></label>
								<select class="form-control" id="language_select" name="language_select">
									<?php
										$option = $this->RED->DB['options']->get('language_select')->value;
									?>
									<option value="en"<?php echo $option=='en' ? ' selected="selected"' : ""; ?>>English</option>
									<option value="pl"<?php echo $option=='pl' ? ' selected="selected"' : ""; ?>>Polski</option>
									<option value="de"<?php echo $option=='de' ? ' selected="selected"' : ""; ?>>Deutsch</option>
								</select>
							</div>
						</div>
						<div class="tab-pane fade" id="v-pills-miscellaneous" role="tabpanel" aria-labelledby="v-pills-miscellaneous-tab">
							<h2 class="display-4" style="font-size: 26px;"><?php echo $this->e('Miscellaneous'); ?></h2>
							<p>
								<?php echo sprintf($this->e('You can change these options only in the %s file'), '<strong>red-config.php</strong>'); ?>
								<br>
								<small><?php $p = str_replace('\\','/',trim(ADMPATH.'red-config.php')); echo $p; ?></small>
							</p>
							<div class="form-group">
								<label><?php echo $this->e('Dashboard path for URL'); ?></label>
								<input disabled type="text" class="form-control" value="/<?php echo RED_DASHBOARD; ?>/">
							</div>
							<div class="form-group">
								<label><?php echo $this->e('Users database'); ?></label>
								<input disabled type="text" class="form-control" value="<?php echo DB_USERS; ?>">
							</div>
							<div class="form-group">
								<label><?php echo $this->e('Options database'); ?></label>
								<input disabled type="text" class="form-control" value="<?php echo DB_OPTIONS; ?>">
							</div>
							<div class="form-group">
								<label><?php echo $this->e('Records database'); ?></label>
								<input disabled type="text" class="form-control" value="<?php echo DB_RECORDS; ?>">
							</div>
							<div class="form-group">
								<label><?php echo $this->e('Cryptographic method for passwords'); ?></label>
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
								<small><?php echo $this->e('Changing the cryptographic method will make all passwords stop working.'); ?></small>
							</div>
							<hr>
							<div class="form-group">
								<label><?php echo $this->e('Debugging'); ?></label>
								<input disabled type="text" class="form-control" value="<?php echo (RED_DEBUG ? $this->e('Enabled') : $this->e('Disabled')); ?>">
								<small><?php echo $this->e('Remember to turn off debugging if you have stopped testing the page.'); ?></small>
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
			if(jQuery('#alert-error').is(':visible')){jQuery('#alert-error').slideToggle(400,function(){jQuery('#add-alert').hide();});}
			if(jQuery('#alert-success').is(':visible')){jQuery('#alert-success').slideToggle(400,function(){jQuery('#add-success').hide();});}

			jQuery.ajax({
				url: '<?php echo $this->home_url().'dashboard/ajax/'; ?>',
				type:'post',
				data:$("#settings-form").serialize(),
				success:function(e)
				{
					if(e == 's01')
					{
						jQuery('#alert-success').slideToggle();
						window.setTimeout(function(){
							jQuery('#alert-success').slideToggle(400, function(){jQuery('#alert-success').hide();});
						}, 5000);
					}
					else
					{
						var error_text = 'An error has occurred.';
						if(e == 'e_invalid_404')
						{
							var error_text = 'The 404 page redirect URL is not valid.';
						}
						else if(e == 'e_invalid_home')
						{
							var error_text = 'The home page redirect URL is not valid.';
						}

						jQuery('#error_text').text(error_text);
						jQuery('#alert-error').slideToggle();
					}

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