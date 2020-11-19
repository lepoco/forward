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
										<a class="dropdown-item" href="<?php echo $dashboard . 'user/' . $this->Forward->User->Active()['user_id']; ?>">
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
