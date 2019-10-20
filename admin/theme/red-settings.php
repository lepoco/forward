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
	<div class="container">
		<div class="row">
			<div class="col-12">
				<button id="save-settings" class="btn btn-outline-dark">Save settings</button>
			</div>
			<div class="col-12">
				<form id="settings-form">
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<label for="siteurl">Site URL</label>
								<input type="text" class="form-control" id="siteurl" placeholder="<?php echo $this->DB['options']->get('siteurl')->value; ?>" value="<?php echo $this->DB['options']->get('siteurl')->value; ?>">
							</div>

						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="dashboardurl">Dashboard URL</label>
								<input type="text" class="form-control" id="dashboardurl" placeholder="<?php echo $this->DB['options']->get('dashboard')->value; ?>" value="<?php echo $this->DB['options']->get('dashboard')->value; ?>">
							</div>
						</div>
						<div class="col-12">
							<hr>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="redirect404">Redirect 404 page</label>
								<select class="form-control" id="redirect404">
									<option>Enabled</option>
									<option selected="selected">Disabled</option>
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="404url">Page to which redirect error 404</label>
								<input type="text" class="form-control" id="404url" placeholder="<?php echo $this->DB['options']->get('dashboard')->value; ?>" value="<?php echo $this->DB['options']->get('dashboard')->value; ?>">
							</div>
						</div>
						<div class="col-12">
							<hr>
						</div>
					</div>
					<div class="form-group">
						<label for="forcehttps">Force HTTPS <i>(ssl connection)</i> for redirects</label>
						<select class="form-control" id="forcehttps">
							<option>Enabled</option>
							<option selected="selected">Disabled</option>
						</select>
					</div>
					<div class="form-group">
						<label for="forcehttpsadmin">Force HTTPS <i>(ssl connection)</i> for dashboard</label>
						<select class="form-control" id="forcehttpsadmin">
							<option>Enabled</option>
							<option selected="selected">Disabled</option>
						</select>
					</div>
					<div class="row">
						<div class="col-4">
							<div class="form-group">
								<label>Users database</label>
								<input disabled type="text" class="form-control" placeholder="<?php echo DB_USERS; ?>" value="<?php echo DB_USERS; ?>">
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label>Options database</label>
								<input disabled type="text" class="form-control" placeholder="<?php echo DB_OPTIONS; ?>" value="<?php echo DB_OPTIONS; ?>">
							</div>
						</div>
						<div class="col-4">
							<div class="form-group">
								<label>Records database</label>
								<input disabled type="text" class="form-control" placeholder="<?php echo DB_RECORDS; ?>" value="<?php echo DB_RECORDS; ?>">
							</div>
						</div>
						<div class="col-12">
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
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php $this->footer(); ?>