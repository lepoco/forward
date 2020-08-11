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

	use DateTime;

	$this->GetHeader();
	$this->GetNavigation();
?>
			<div id="rdev-dashboard" class="block-page distance-navbar">
				<div class="container-fluid">
					<div class="row row-no-gutter">
						<div class="col-12 col-lg-3 col-no-gutters" id="records_list">
							<div class="card links-header"><div class="card-body"><small><strong id="total_records_count"><?php echo count($this->Records()); ?></strong> <?php echo $this->_e('total links'); ?></small></div></div>
							<div id="links-copied" class="alert alert-success fade show" role="alert" style="display: none;margin: 0;border-radius: 0;">
								<div>
									<svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#155724" d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7M7.5,13.5L9,12L11,14L15.5,9.5L17,11L11,17L7.5,13.5Z" /></svg>
									<small style="font-size:13px;"><?php echo $this->_e('Link has been copied to your clipboard'); ?></small>
								</div>
							</div>
<?php $c = 0; foreach ($this->Records() as $record): $c++; ?>
							<div class="card links-card" data-clipboard-text="<?php echo $this->baseurl . $record['record_name']; ?>" data-id="<?php echo $record['record_id']; ?>">
								<div class="card-body">
									<div>
										<small><?php echo (new DateTime($record['record_created']))->format('Y-m-d'); ?></small>
										<h2><a class="shorted-url" data-clipboard-text="<?php echo $this->baseurl . $record['record_display_name']; ?>" target="_blank" rel="noopener" href="<?php echo $this->baseurl . $record['record_display_name']; ?>">/<?php echo $record['record_display_name']; ?></a></h2>
										<p><a target="_blank" rel="noopener" class="overflow-url" href="<?php echo $record['record_url'] ?>"><?php echo $record['record_url']; ?></a></p>
									</div>
									<span><?php echo $record['record_clicks']; ?></span>
								</div>
							</div>
<?php endforeach; ?>
						</div>
						<div id="dashboard-box" class="col-12 col-lg-9" style="padding-top:32px;padding-bottom:15px;height: inherit;overflow: auto;">
							<div class="container-fluid">
								<div class="row">
<?php if ($this->Forward->User->IsManager()): ?>
										<div class="col-12">
											<div id="add-alert" class="alert alert-danger fade show" role="alert" style="display: none;">
												<strong><?php echo $this->_e('Holy guacamole!'); ?></strong> <span id="error_text"> <?php echo $this->_e('Something went wrong!'); ?></span>
											</div>
											<div id="add-success" class="alert alert-success fade show" role="alert" style="display: none;">
												<strong><?php echo $this->_e('Success!'); ?></strong> <?php echo $this->_e('New link was added.'); ?>
											</div>
											<form id="add-record-form" action="<?php echo $this->AjaxGateway(); ?>">
												<input type="hidden" value="add_record" name="action">
												<input type="hidden" value="<?php echo $this->AjaxNonce( 'add_record' ); ?>" name="nonce">
												<input type="hidden" value="<?php echo $this->NewRecord(); ?>" id="input-rand-value" name="input-rand-value">
												<div class="row">
													<div class="col-8 col-lg-3">
														<div class="form-group">
															<input type="text" id="input-record-url" name="input-record-url" class="form-control" placeholder="https://">
														</div>
													</div>
													<div class="col-4 col-lg-3 col-no-gutters">
														<div class="form-group">
															<input type="text" id="input-record-slug" name="input-record-slug" class="form-control" placeholder="<?php echo $this->NewRecord(); ?>" value="<?php echo $this->NewRecord(); ?>">
														</div>
													</div>
													<div class="col-12 col-lg-3">
														<button type="submit" id="add-record-send" class="btn btn-block btn-outline-dark"><?php echo $this->_e('Add new'); ?></button>
													</div>
												</div>
											</form>
										</div>
<?php endif; ?>
									<div class="col-12" style="margin-top:32px;">
										<ul class="list-inline">
											<li class="list-inline-item">
												<div class="stats-header">
													<div>
														<svg viewBox="0 0 16 16" class="bi bi-share" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path fill-rule="evenodd" d="M11.724 3.947l-7 3.5-.448-.894 7-3.5.448.894zm-.448 9l-7-3.5.448-.894 7 3.5-.448.894z"/>
															<path fill-rule="evenodd" d="M13.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm0 10a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm-11-6.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
														</svg>
														<div>
															<h1><?php echo $this->TopReferrer(); ?></h1>
															<p><?php echo $this->_e('Top referrer'); ?></p>
														</div>
													</div>
												</div>
											</li>
											<li class="list-inline-item">
												<div class="stats-header">
													<div>
														<svg viewBox="0 0 16 16" class="bi bi-geo" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path d="M11 4a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
															<path d="M7.5 4h1v9a.5.5 0 0 1-1 0V4z"/>
															<path fill-rule="evenodd" d="M6.489 12.095a.5.5 0 0 1-.383.594c-.565.123-1.003.292-1.286.472-.302.192-.32.321-.32.339 0 .013.005.085.146.21.14.124.372.26.701.382.655.246 1.593.408 2.653.408s1.998-.162 2.653-.408c.329-.123.56-.258.701-.382.14-.125.146-.197.146-.21 0-.018-.018-.147-.32-.339-.283-.18-.721-.35-1.286-.472a.5.5 0 1 1 .212-.977c.63.137 1.193.34 1.61.606.4.253.784.645.784 1.182 0 .402-.219.724-.483.958-.264.235-.618.423-1.013.57-.793.298-1.855.472-3.004.472s-2.21-.174-3.004-.471c-.395-.148-.749-.336-1.013-.571-.264-.234-.483-.556-.483-.958 0-.537.384-.929.783-1.182.418-.266.98-.47 1.611-.606a.5.5 0 0 1 .595.383z"/>
														</svg>
														<div>
															<h1><?php echo $this->TopLanguage(); ?></h1>
															<p><?php echo $this->_e('Top language'); ?></p>
														</div>
													</div>
												</div>
											</li>
											<li class="list-inline-item">
												<div class="stats-header">
													<div>
														<svg viewBox="0 0 16 16" class="bi bi-bar-chart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path fill-rule="evenodd" d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5h-2v12h2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/>
														</svg>
														<div>
															<h1><?php echo $this->TotalClicks(); ?></h1>
															<p><?php echo $this->_e('Total clicks'); ?></p>
														</div>
													</div>
												</div>
											</li>
										</ul>
									</div>
									<div class="col-12" style="margin:0;">
										<hr>
									</div>
									<div class="col-12">
										<div id="single-record">
											<div class="row">
												<div class="col-10 col-md-11">
													<p id="preview-record-date"></p>
													<h2 id="preview-record-slug"></h2>
													<span><a id="preview-record-url" href="#" target="_blank" rel="noopener"></a></span>
												</div>
<?php if ($this->Forward->User->IsManager()): ?>
													<div class="col-2 col-md-1 remove-record">
														<a href="#" id="delete-record-icon"><svg viewBox="0 0 24 24"><path d="M20.37,8.91L19.37,10.64L7.24,3.64L8.24,1.91L11.28,3.66L12.64,3.29L16.97,5.79L17.34,7.16L20.37,8.91M6,19V7H11.07L18,11V19A2,2 0 0,1 16,21H8A2,2 0 0,1 6,19M8,19H16V12.2L10.46,9H8V19Z" /></svg></a>
													</div>
<?php endif; ?>
											</div>
											<div class="row">
												<div class="col-12 col-lg-6 pie-container">
													<div class="row">
														<div class="col-12">
															<p class="pie-header">browsers</p>
														</div>
														<div class="col-12 col-lg-6 col-no-gutters">
															<div class="pie-browsers pie-color-blue ct-pie-hover ct-perfect-fourth"></div>
														</div>
														<div class="col-12 col-lg-6">
															<ul class="pie-browsers-labels">
																<li class="pie-browsers-label-a">Label 1</li>
																<li class="pie-browsers-label-b">Label 2</li>
																<li class="pie-browsers-label-c">Label 3</li>
																<li class="pie-browsers-label-d">Label 4</li>
																<li class="pie-browsers-label-e">Label 5</li>
																<li class="pie-browsers-label-f">Label 6</li>
																<li class="pie-browsers-label-g">Label 7</li>
															</ul>
														</div>
													</div>
												</div>
												<div class="col-12 col-lg-6 pie-container">
													<div class="row">
														<div class="col-12">
															<p class="pie-header">platforms</p>
														</div>
														<div class="col-12 col-lg-6 col-no-gutters">
															<div class="pie-platforms pie-color-blue ct-pie-hover ct-perfect-fourth"></div>
														</div>
														<div class="col-12 col-lg-6">
															<ul class="pie-platforms-labels">
																<li class="pie-platforms-label-a">Label 1</li>
																<li class="pie-platforms-label-b">Label 2</li>
																<li class="pie-platforms-label-c">Label 3</li>
																<li class="pie-platforms-label-d">Label 4</li>
																<li class="pie-platforms-label-e">Label 5</li>
																<li class="pie-platforms-label-f">Label 6</li>
																<li class="pie-platforms-label-g">Label 7</li>
															</ul>
														</div>
													</div>
												</div>
												<div class="col-12 col-no-gutters" style="height: 220px;">
													<div class="ct-chart ct-perfect-fourth red-chart" style="height: 220px;"></div>
												</div>
												<div class="col-12">
													<div class="row">
														<div id="record-referrers" class="col-12 col-md-6">
														</div>
														<div id="record-locations" class="col-12 col-md-6">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php
	$this->GetFooter();
?>
