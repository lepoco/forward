<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

namespace Forward;

defined('ABSPATH') or die('No script kiddies please!');

$this->GetHeader();
$this->GetNavigation();
?>
<div class="container-fluid" style="margin-bottom:2.2rem;">
	<div class="row">
		<div class="col-12">
			<div class="content__title">
				<h1><?php $this->_e('Users'); ?></h1>
				<span>Application users</span>
			</div>
		</div>
		<div class="col-12">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col"><?php $this->_e('Username'); ?></th>
						<th scope="col">E-Mail</th>
						<th scope="col"><?php $this->_e('Role'); ?></th>
						<th scope="col"><?php $this->_e('Last login'); ?></th>
						<th scope="col"><?php $this->_e('Registered'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php

					$user_roles = array(
						'admin' => $this->__('Administrator'),
						'analyst' => $this->__('Analyst'),
						'manager' => $this->__('Manager')
					);

					foreach ($this->GetUsers() as $user) {
						$html = '<tr>';
						$html .= '<th scope="row">' . $user['user_id'] . '</td>';
						$html .= '<td><a href="' . $this->baseurl . $this->Forward->Options->Get('dashboard', 'dashboard') . '/users/' . $user['user_id'] . '">' . $user['user_display_name'] . '</a></td>';
						$html .= '<td>' . (empty($user['user_email']) ? $this->__('Not specified') : $user['user_email']) . '</td>';
						$html .= '<td>' . $user_roles[$user['user_role']] . '</td>';
						$html .= '<td>' . $user['user_last_login'] . '</td>';
						$html .= '<td>' . $user['user_registered'] . '</td>';
						echo $html . '</tr>';
					}
					?>
				</tbody>
			</table>
		</div>
		<div class="col-12" style="margin-top: 1rem;">
			<a href="<?php echo $this->baseurl . $this->Forward->Options->Get('dashboard', 'dashboard') . '/users/add/'; ?>" class="btn-forward"><?php $this->_e('Add new user'); ?></a>
		</div>
	</div>
</div>
<?php
$this->GetFooter();
?>