<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

	namespace Forward;

$this->head(); $this->menu(); ?>
<div id="red-users">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<button class="btn btn-primary" data-toggle="modal" data-target="#userModal">Add new user</button>
			</div>
			<div class="col-12" id="users-table">
				<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col">Date created</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php

						$users = $this->DB['users']->findAll();
						$c = 0;
						foreach($users as $user)
						{
							$c++;
							echo '<tr><th scope="row">'.$c.'</th><td>'.$user->getId().'</td><td>'.$user->email.'</td><td>'.$user->createdAt().'</td><td class="td-buttons"><button class="btn btn-dark btn-icon"><svg style="width:18px;height:18px" viewBox="0 0 24 24"><path fill="#fff" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" /></svg></button> <button class="btn btn-dark btn-icon"><svg style="width:18px;height:18px" viewBox="0 0 24 24"><path fill="#fff" d="M20.37,8.91L19.37,10.64L7.24,3.64L8.24,1.91L11.28,3.66L12.64,3.29L16.97,5.79L17.34,7.16L20.37,8.91M6,19V7H11.07L18,11V19A2,2 0 0,1 16,21H8A2,2 0 0,1 6,19M8,19H16V12.2L10.46,9H8V19Z" /></svg></button></td></tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form id="add-user-form" action="<?php echo $this->home_url().'dashboard/ajax/'; ?>">
				<div class="modal-body">
					<input type="hidden" value="addUser" name="action">
					<input type="hidden" value="nonce" name="<?php echo RED::encrypt('ajax_add_user_nonce', 'nonce'); ?>">
					<div class="form-group">
						<label for="userName">Login</label>
						<input type="text" class="form-control" id="userName" name="userName" aria-describedby="emailHelp" placeholder="Enter login">
					</div>
					<div class="form-group">
						<label for="userEmail">Email address</label>
						<input type="email" class="form-control" id="userEmail" name="userEmail" aria-describedby="emailHelp" placeholder="Enter email">
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