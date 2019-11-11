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

	$this->head();

	$captcha_site = $this->RED->DB['options']->get('captcha_site')->value;
	$captcha_secret = $this->RED->DB['options']->get('captcha_secret')->value;
?>

<div id="big-background">
	<picture>
		<source srcset="<?php echo $this->home_url(); ?>media/img/bg.webp" type="image/webp">
		<source srcset="<?php echo $this->home_url(); ?>media/img/bg.jpeg" type="image/jpeg">
		<img alt="This is my face" src="<?php echo $this->home_url(); ?>media/img/bg.jpeg">
	</picture>
</div>
<section id="red-login">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-6" style="display: flex;align-items: center;">
				<picture id="forward-logo">
					<source srcset="<?php echo $this->home_url(); ?>media/img/forward-logo-wt.webp" type="image/webp">
					<source srcset="<?php echo $this->home_url(); ?>media/img/forward-logo-wt.jpeg" type="image/jpeg">
					<img alt="This is my face" src="<?php echo $this->home_url(); ?>media/img/forward-logo-wt.jpeg">
				</picture>
			</div>
			<div class="col-12 col-lg-6">
				<div id="login-card">
					<form id="login-form" action="<?php echo $this->home_url().'dashboard/ajax/'; ?>">
						<div class="card">
							<div class="card-body">
								<h1>Sign in</h1>
								<input type="hidden" value="<?php echo RED::encrypt('ajax_sign_in_nonce', 'nonce'); ?>" name="nonce">
								<input type="hidden" value="sign_in" name="action">
								<?php echo !empty($captcha_site) && !empty($captcha_secret) ? '<div id="reCaptcha"></div>' : ''; ?>
								<div class="form-group">
									<label for="login">Login</label>
									<input type="text" class="form-control" name="login" id="login" placeholder="Enter login/email">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" name="password" id="password" placeholder="Password">
								</div>
								<div id="login-alert" class="alert alert-danger fade show" role="alert" style="display: none;">
									<strong>Holy guacamole!</strong> Incorrect login or password.
								</div>
							</div>
							<button type="submit" id="button-form" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?php

	

	if(!empty($captcha_site) && !empty($captcha_secret))
	{
		echo '<script src="https://www.google.com/recaptcha/api.js?onload=onloadCaptcha&render='.$captcha_site.'"></script>';
		echo '<script>var onloadCaptcha = function(){console.log("Captcha loaded");grecaptcha.render("reCaptcha",{
            "sitekey": "'.$captcha_site.'",
            "callback": onSubmit
        });}</script>';
	}

?>
<script>
	window.onload = function() {
		jQuery('#button-form').on('click', function(e){
			e.preventDefault();

			if(jQuery('#login-alert').is(':visible'))
			{
				jQuery('#login-alert').slideToggle();
			}
			
			jQuery.ajax({
				url: '<?php echo $this->home_url().RED_DASHBOARD.'/ajax/'; ?>',
				type:'post',
				data:$("#login-form").serialize(),
				success:function(e)
				{
					if(e == 's01')
					{
						location.reload();
					}
					else
					{
						jQuery('#login-alert').slideToggle();
					}
				},
				fail:function(xhr, textStatus, errorThrown){
					jQuery('#login-alert').slideToggle();
				}
			});
		});
	};
</script>
<?php $this->footer(); ?>