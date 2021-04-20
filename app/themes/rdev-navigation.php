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

$dashboard = $this->baseurl . $this->Forward->Options->Get('dashboard', 'dashboard') . '/';
?>
<nav class="forward-header">
	<div class="forward-header__brand">
		<a href="<?php echo $dashboard; ?>">
			<picture>
				<source srcset="<?php echo $this->GetImage('forward-logo-wt.webp'); ?>" type="image/webp">
				<source srcset="<?php echo $this->GetImage('forward-logo-wt.jpeg'); ?>" type="image/jpeg">
				<img alt="Forward logo" src="<?php echo $this->GetImage('forward-logo-wt.jpeg'); ?>">
			</picture>
		</a>
	</div>
	<div class="forward-header__navigation">
		<form action="#" class="forward-header__navigation__searchbox">
			<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search" autocomplete="off"> <button class="btn btn-primary" type="submit"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z" />
					<path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z" />
				</svg></button>
		</form>
		<ul class="nav ml-auto">
			<li class="nav-item dropdown"><a class="nav-link" href="#" id="notificationDropdown" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-bell-outline mdi-1x"></i></a>
				<div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="notificationDropdown">
					<div class="dropdown-header">
						<h6 class="dropdown-title">Notifications</h6>
						<p class="dropdown-title-text">You have 4 unread notification</p>
					</div>
					<div class="dropdown-body">
						<div class="dropdown-list">
							<div class="icon-wrapper rounded-circle bg-inverse-primary text-primary"><i class="mdi mdi-alert"></i></div>
							<div class="content-wrapper"><small class="name">Storage Full</small> <small class="content-text">Server storage almost full</small></div>
						</div>
						<div class="dropdown-list">
							<div class="icon-wrapper rounded-circle bg-inverse-success text-success"><i class="mdi mdi-cloud-upload"></i></div>
							<div class="content-wrapper"><small class="name">Upload Completed</small> <small class="content-text">3 Files uploded successfully</small></div>
						</div>
						<div class="dropdown-list">
							<div class="icon-wrapper rounded-circle bg-inverse-warning text-warning"><i class="mdi mdi-security"></i></div>
							<div class="content-wrapper"><small class="name">Authentication Required</small> <small class="content-text">Please verify your password to continue using cloud services</small></div>
						</div>
					</div>
					<div class="dropdown-footer"><a href="#">View All</a></div>
				</div>
			</li>
			<li class="nav-item dropdown"><a class="nav-link" href="#" id="messageDropdown" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-message-outline mdi-1x"></i> <span class="notification-indicator notification-indicator-primary notification-indicator-ripple"></span></a>
				<div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="messageDropdown">
					<div class="dropdown-header">
						<h6 class="dropdown-title">Messages</h6>
						<p class="dropdown-title-text">You have 4 unread messages</p>
					</div>
					<div class="dropdown-body">
						<div class="dropdown-list">
							<div class="image-wrapper"><img class="profile-img" src="../assets/images/profile/male/image_1.png" alt="profile image">
								<div class="status-indicator rounded-indicator bg-success"></div>
							</div>
							<div class="content-wrapper"><small class="name">Clifford Gordon</small> <small class="content-text">Lorem ipsum dolor sit amet.</small></div>
						</div>
						<div class="dropdown-list">
							<div class="image-wrapper"><img class="profile-img" src="../assets/images/profile/female/image_2.png" alt="profile image">
								<div class="status-indicator rounded-indicator bg-success"></div>
							</div>
							<div class="content-wrapper"><small class="name">Rachel Doyle</small> <small class="content-text">Lorem ipsum dolor sit amet.</small></div>
						</div>
						<div class="dropdown-list">
							<div class="image-wrapper"><img class="profile-img" src="../assets/images/profile/male/image_3.png" alt="profile image">
								<div class="status-indicator rounded-indicator bg-warning"></div>
							</div>
							<div class="content-wrapper"><small class="name">Lewis Guzman</small> <small class="content-text">Lorem ipsum dolor sit amet.</small></div>
						</div>
					</div>
					<div class="dropdown-footer"><a href="#">View All</a></div>
				</div>
			</li>
			<li class="nav-item dropdown"><a class="nav-link" href="#" id="appsDropdown" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-apps mdi-1x"></i></a>
				<div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="appsDropdown">
					<div class="dropdown-header">
						<h6 class="dropdown-title">Apps</h6>
						<p class="dropdown-title-text mt-2">Authentication required for 3 apps</p>
					</div>
					<div class="dropdown-body border-top pt-0"><a class="dropdown-grid"><i class="grid-icon mdi mdi-jira mdi-2x"></i> <span class="grid-tittle">Jira</span> </a><a class="dropdown-grid"><i class="grid-icon mdi mdi-trello mdi-2x"></i> <span class="grid-tittle">Trello</span> </a><a class="dropdown-grid"><i class="grid-icon mdi mdi-artstation mdi-2x"></i> <span class="grid-tittle">Artstation</span> </a><a class="dropdown-grid"><i class="grid-icon mdi mdi-bitbucket mdi-2x"></i> <span class="grid-tittle">Bitbucket</span></a></div>
					<div class="dropdown-footer"><a href="#">View All</a></div>
				</div>
			</li>
		</ul>
	</div>
</nav>

<div class="forward-page">
	<div class="sidebar">
		<div class="sidebar__navigation">
			<strong class="sidebar__navigation__title">Main</strong>
			<ul class="sidebar__navigation__menu">
				<li class="<?php echo $this->name == 'dashboard' ? ' active' : '' ?>">
					<a href="<?php echo $dashboard; ?>">
						<span>Dashboard</span>
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-grid-1x2" viewBox="0 0 16 16">
							<path d="M6 1H1v14h5V1zm9 0h-5v5h5V1zm0 9v5h-5v-5h5zM0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V1zm1 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1h-5z" />
						</svg>
					</a>
				</li>
				<li class="<?php echo $this->name == 'statistics' ? ' active' : '' ?>">
					<a href="<?php echo $dashboard . 'statistics/'; ?>">
						<span>Statistics</span>
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-grid-1x2" viewBox="0 0 16 16">
							<path d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
						</svg>
					</a>
				</li>
				<li>
					<a href="<?php echo $dashboard . 'user/list/'; ?>">
						<span>Users</span>
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-grid-1x2" viewBox="0 0 16 16">
							<path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
						</svg>
					</a>
				</li>
				<li class="<?php echo $this->name == 'api' ? ' active' : '' ?>">
					<a href="<?php echo $dashboard . 'api/'; ?>">
						<span>API</span>
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-grid-1x2" viewBox="0 0 16 16">
							<path d="M2.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C3.25 2 2.49 2.759 2.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6zM13.886 7.9v.163c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456V7.332c-1.114 0-1.49-.362-1.49-1.456V4.352C13.51 2.759 12.75 2 11.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6z" />
						</svg>
					</a>
				</li>
				<li class="<?php echo $this->name == 'settings' ? ' active' : '' ?>">
					<a href="<?php echo $dashboard . 'settings/'; ?>">
						<span>Settings</span>
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-grid-1x2" viewBox="0 0 16 16">
							<path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
							<path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
						</svg>
					</a>
				</li>
			</ul>
			<strong class="sidebar__navigation__title">Docs</strong>
			<ul class="sidebar__navigation__menu">
				<li>
					<a href="https://github.com/rapiddev/Forward" target="_blank" rel="noopener">
						<span>GitHub</span>
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-grid-1x2" viewBox="0 0 16 16">
							<path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
						</svg>
					</a>
				</li>
				<li class="<?php echo $this->name == 'about' ? ' active' : '' ?>">
					<a href="<?php echo $dashboard . 'about/'; ?>">
						<span>About</span>
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-grid-1x2" viewBox="0 0 16 16">
							<path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
							<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
						</svg>
					</a>
				</li>
			</ul>
			<strong class="sidebar__navigation__title">Session</strong>
			<ul class="sidebar__navigation__menu">
				<li>
					<a href="<?php echo $dashboard . 'user/' . $this->Forward->User->Active()['user_id']; ?>">
						<span>Account</span>
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-grid-1x2" viewBox="0 0 16 16">
							<path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z" />
							<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
						</svg>
					</a>
				</li>
				<li>
					<a href="<?php echo $dashboard . 'signout/'; ?>">
						<span>Sign Out</span>
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-grid-1x2" viewBox="0 0 16 16">
							<path d="M7.5 1v7h1V1h-1z" />
							<path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z" />
						</svg>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="content">


		<?php /*
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
							<li class="nav-item">
								<a class="nav-link nav-link-icon<?php echo $this->name == 'dashboard' ? ' active' : '' ?>" href="<?php echo $dashboard; ?>">
									<!--
									<svg viewBox="0 0 16 16" class="bi bi-columns-gap" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M6 1H1v3h5V1zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12h-5v3h5v-3zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8H1v7h5V8zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6h-5v7h5V1zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z"/>
									</svg>
									-->
									<?php $this->_e('Dashboard'); ?>
								</a>
							</li>
							<?php /*
							<li class="nav-item">
								<a class="nav-link nav-link-icon<?php echo $this->name == 'statistics' ? ' active' : '' ?>" href="<?php echo $dashboard . 'statistics/'; ?>">
									<!--
									<svg viewBox="0 0 16 16" class="bi bi-columns-gap" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5h-2v12h2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/>
									</svg>
									-->

									<?php $this->_e('Statistics'); ?>
								</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link nav-link-icon<?php echo $this->name == 'settings' ? ' active' : '' ?>" href="<?php echo $dashboard . 'settings/'; ?>">
									<!--
									<svg viewBox="0 0 16 16" class="bi bi-columns-gap" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M6 1H1v3h5V1zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm14 12h-5v3h5v-3zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5zM6 8H1v7h5V8zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H1zm14-6h-5v7h5V1zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1h-5z"/>
									</svg>
									-->
									<?php $this->_e('Settings'); ?>
								</a>
							</li>
							<?php /*
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle nav-link-icon<?php echo $this->name == 'settings' ? ' active' : '' ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
									<!--
									<svg viewBox="0 0 16 16" class="bi bi-sliders" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M14 3.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0zM11.5 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM7 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0zM4.5 10a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm9.5 3.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0zM11.5 15a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
										<path fill-rule="evenodd" d="M9.5 4H0V3h9.5v1zM16 4h-2.5V3H16v1zM9.5 14H0v-1h9.5v1zm6.5 0h-2.5v-1H16v1zM6.5 9H16V8H6.5v1zM0 9h2.5V8H0v1z"/>
									</svg>
									-->

									<?php $this->_e('Settings'); ?>
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
									<li><a class="dropdown-item" href="<?php echo $dashboard . 'settings/'; ?>"><?php $this->_e('Settings'); ?></a></li>
									<li><a class="dropdown-item" href="<?php echo $dashboard . 'tools/'; ?>"><?php $this->_e('Tools'); ?></a></li>
									<li><a class="dropdown-item" href="<?php echo $dashboard . 'user/list/'; ?>"><?php $this->_e('Users'); ?></a></li>
									<li><hr class="dropdown-divider"></li>
									<li><a class="dropdown-item" href="<?php echo $dashboard . 'about/'; ?>"><?php $this->_e('About'); ?></a></li>
								</ul>
							</li>
							
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle nav-link-icon" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
									<!--
									<svg viewBox="0 0 16 16" class="bi bi-person-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
										<path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
									</svg>
									-->

									<?php echo $this->Forward->User->Active()['user_name']; ?>
								</a>
								<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
									<li>
										<a class="dropdown-item disabled" disabled="disabled" href="<?php echo $dashboard . 'user/' . $this->Forward->User->Active()['user_id']; ?>">
										Profile settings
									</a>
									</li>
									<li>
										<hr class="dropdown-divider">
									</li>
									<li>
										<a class="dropdown-item" href="<?php echo $dashboard . 'signout/'; ?>">
											<svg width="15px" height="15px" viewBox="0 0 16 16" class="bi bi-person-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" d="M5.578 4.437a5 5 0 1 0 4.922.044l.5-.866a6 6 0 1 1-5.908-.053l.486.875z"/>
												<path fill-rule="evenodd" d="M7.5 8V1h1v7h-1z"/>
											</svg>

											Sign Out
										</a>
									</li>
								</ul>
							</li>
							<!--
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
							-->
						</ul>
					</div>
				</div>
			</nav>
*/ ?>