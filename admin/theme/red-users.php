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
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" id="add-user-send" type="button" class="btn btn-primary">Add user</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<h1>Delete user</h1>
				<span>Are you sure you want to delete user D?</span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" id="add-user-send" type="button" class="btn btn-danger">Delete user</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<h1>Delete user</h1>
				<span>Are you sure you want to delete user D?</span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<script>
	window.onload = function() {
		jQuery('#add-user-send').on('click', function(e){
			e.preventDefault();
			jQuery.ajax({
				url: '<?php echo $this->home_url().'dashboard/ajax/'; ?>',
				type:'post',
				data:$("#add-user-form").serialize(),
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