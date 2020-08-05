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

	$dashboard = $this->baseurl . $this->Forward->Options->Get( 'dashboard', 'dashboard' ) . '/';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container-fluid">
		<a class="navbar-brand" href="<?php echo $dashboard; ?>">
			<picture>
				<source srcset="<?php echo $this->GetImage('forward-logo-wt.webp'); ?>" type="image/webp">
				<source srcset="<?php echo $this->GetImage('forward-logo-wt.jpeg'); ?>" type="image/jpeg">
				<img alt="Forward logo" src="<?php echo $this->GetImage('forward-logo-wt.jpeg'); ?>">
			</picture>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto"></ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown user-dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<div>
							<div>
								<svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
  									<path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
								</svg>
							</div>
							<div>
								<div>
									<?php echo $this->Forward->User->Active()['user_display_name']; ?>
									<br/>
									<small><i><?php $this->_e($this->Forward->User->Active()['user_role']); ?></i></small>
								</div>
							</div>
						</div>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="<?php echo $dashboard . 'settings/' ?>">Settings</a>
						<a class="dropdown-item" href="<?php echo $dashboard . 'tools/' ?>">Tools</a>
						<a class="dropdown-item" href="<?php echo $dashboard . 'users/' ?>">Users</a>
						<a class="dropdown-item" href="<?php echo $dashboard . 'about/' ?>">About</a>
						<a class="dropdown-item" href="<?php echo $dashboard . 'signout/' ?>">Sign Out</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
