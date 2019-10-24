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

	$users = $this->RED->DB['users']->findAll();
?>
<div id="red-users">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-3" style="margin-bottom: 40px;">
				<h5 style="margin:0"><?php echo $this->e('Administrator'); ?></h5>
				<small><?php echo $this->e('Has full permissions to do everything.'); ?></small>
				<hr>
				<h5 style="margin:0"><?php echo $this->e('Manager'); ?></h5>
				<small><?php echo $this->e('Can add and delete records. Cannot change settings or add users.'); ?></small>
				<hr>
				<h5 style="margin:0"><?php echo $this->e('Analyst'); ?></h5>
				<small><?php echo $this->e('Can only view data.'); ?></small>
				<hr>
				<button id="add-user" data-toggle="modal" data-target="#addUserModal" class="btn btn-block btn-outline-dark"><?php echo $this->e('Add new user'); ?></button>
			</div>
			<div class="col-12 col-md-9">
				<div id="alert-success" class="alert alert-success fade show" role="alert" style="display: none;">
					<strong><?php echo $this->e('Success!'); ?></strong> <span id="alert-success-text"><?php echo $this->e('A new user has been added.'); ?></span>
				</div>
				<?php
					foreach($users as $user)
					{
						$html  = '<div class="card user-card"><div class="card-body"><div class="row">';
						$html .= '<div class="col-12 col-sm-6" style="display:flex;align-items:center;padding-bottom:5px;padding-top:5px;">';
						$html .= '<div><h2>'.$user->getId().'</h2><p><i>'.$user->email.'</i></p><small>'.( $user->role == 'admin' ? $this->e('Administrator') : ( $user->role == 'analyst' ? $this->e('Analyst') : $this->e('Manager')) ).'</small></div></div>';
						$html .= '<div class="col-12 col-sm-6">';
						$html .= '<span><small>'.$this->e('Date created').':</small></span><p>'.$user->createdAt().'</p>';
						$html .= '<span><small>'.$this->e('Last login').':</small></span><p>'.($user->lastlogin != NULL ? date('Y-m-d H:i:s', $user->lastlogin) : $this->e('Never')).'</p>';
						$html .= '</div></div></div>';
						$html .= '<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-secondary">'.$this->e('Edit').'</button><button type="button" class="btn btn-secondary" data-userid="'.$user->getId().'" data-toggle="modal" data-target="#deleteUserModal">'.$this->e('Delete').'</button></div>';
						$html .= '</div>';
						echo $html;
					}

				?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<form id="add-user-form" action="<?php echo $this->home_url().'dashboard/ajax/'; ?>">
				<div class="modal-body">
					<div id="alert-error" class="alert alert-danger fade show" role="alert" style="display: none;">
						<strong><?php echo $this->e('Holy guacamole!'); ?></strong> <span id="error_text"><?php echo $this->e('Something went wrong!'); ?></span>
					</div>
					<input type="hidden" value="add_user" name="action">
					<input type="hidden" value="<?php echo $this->RED->encrypt('ajax_add_user_nonce', 'nonce'); ?>" name="nonce">
					<div class="form-group">
						<label for="userName">Login</label>
						<input type="text" class="form-control" id="userName" name="userName" aria-describedby="emailHelp" placeholder="Enter login">
					</div>
					<div class="form-group">
						<label for="userEmail">Email address</label>
						<input type="email" class="form-control" id="userEmail" name="userEmail" aria-describedby="emailHelp" placeholder="Enter email">
					</div>
					<div class="form-group">
						<label for="userRole">Role</label>
						<select class="form-control" id="userRole" name="userRole">
							<option value="analyst"><?php echo $this->e('Analyst'); ?></option>
							<option value="manager"><?php echo $this->e('Manager'); ?></option>
							<option value="admin"><?php echo $this->e('Administrator'); ?></option>
						</select>
					</div>
					<div class="row">
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="userPassword">Password</label>
								<input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Password">
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="userPasswordConfirm">Confirm password</label>
								<input type="password" class="form-control" id="userPasswordConfirm" name="userPasswordConfirm" placeholder="Password">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->e('Close'); ?></button>
					<button type="submit" id="add-user-send" type="button" class="btn btn-primary"><?php echo $this->e('Add user'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<h1><?php echo $this->e('Delete user'); ?></h1>
				<span>Are you sure you want to delete user D?</span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->e('Close'); ?></button>
				<button type="submit" id="add-user-send" type="button" class="btn btn-danger"><?php echo $this->e('Delete user'); ?></button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<h1><?php echo $this->e('Error'); ?></h1>
				<span><?php echo $this->e('You cannot delete yourself!'); ?></span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->e('Cancel'); ?></button>
			</div>
		</div>
	</div>
</div>
<script>
	window.onload = function() {
		jQuery('#add-user-send').on('click', function(e){
			e.preventDefault();
			if(jQuery('#alert-error').is(':visible')){jQuery('#alert-error').slideToggle(400,function(){jQuery('#add-alert').hide();});}
			if(jQuery('#alert-success').is(':visible')){jQuery('#alert-success').slideToggle(400,function(){jQuery('#add-success').hide();});}
			jQuery.ajax({
				url: '<?php echo $this->home_url().'dashboard/ajax/'; ?>',
				type:'post',
				data:$("#add-user-form").serialize(),
				success:function(e)
				{
					if(e == 's01')
					{
						jQuery('#addUserModal').modal('hide');
						jQuery('#alert-success').slideToggle();
						window.setTimeout(function(){
							jQuery('#alert-success').slideToggle(400, function(){jQuery('#alert-success').hide();});
						}, 9000);
					}
					else
					{
						var error_text = '<?php echo $this->e('Something went wrong!'); ?>';
						if(e == 'e07')
						{
							var error_text = '<?php echo $this->e('Login, password and email fields are required!'); ?>';
						}
						if(e == 'e08')
						{
							var error_text = '<?php echo $this->e('User with this login already exists!'); ?>';
						}
						else if(e == 'e12')
						{
							var error_text = '<?php echo $this->e('Passwords do not match!'); ?>';
						}
						else if(e == 'e13')
						{
							var error_text = '<?php echo $this->e('Password is too short!'); ?>';
						}
						else if(e == 'e14')
						{
							var error_text = '<?php echo $this->e('The password is too simple. Use letters, numbers and special characters!'); ?>';
						}
						else if(e == 'e15')
						{
							var error_text = '<?php echo $this->e('Email field is invalid!'); ?>';
						}
						else if(e == 'e16')
						{
							var error_text = '<?php echo $this->e('Login field contains illegal characters!'); ?>';
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