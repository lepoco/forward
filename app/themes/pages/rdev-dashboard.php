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

	$this->GetHeader();
	$this->GetNavigation();
?>
			<div id="red-dashboard" class="block-page distance-navbar">
				<div class="container-fluid">
					<div class="row row-no-gutter">
						<div class="col-12 col-lg-3 col-no-gutters" id="records_list">
							<div class="card links-header"><div class="card-body"><small><strong id="total_records_count"><?php echo count($this->Records()); ?> </strong><?php echo $this->_e('total links'); ?></small></div></div>
							<div id="links-copied" class="alert alert-success fade show" role="alert" style="display: none;margin: 0;border-radius: 0;">
								<div>
									<svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#155724" d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7M7.5,13.5L9,12L11,14L15.5,9.5L17,11L11,17L7.5,13.5Z" /></svg>
									<small><?php echo $this->_e('Link has been copied to your clipboard'); ?></small>
								</div>
							</div>
<?php $c = 0; foreach ($this->Records() as $record): $c++; ?>
							<div class="card links-card links-card-hp <?php echo ($c == 1 ? ' id="first-record"':''); ?>" data-clipboard-text="<?php echo $this->baseurl . $record['record_name']; ?>">
								<div class="card-body">
									<div>
										<small><?php echo $record['record_created']; ?></small>
										<h2><a class="shorted-url" data-clipboard-text="<?php echo $this->baseurl . $record['record_display_name']; ?>" target="_blank" rel="noopener" href="<?php echo $this->baseurl . $record['record_display_name']; ?>">/<?php echo $record['record_display_name']; ?></a></h2>
										<p><a target="_blank" rel="noopener" href="<?php echo $record['record_url'] ?>"><?php echo $this->ShortUrl($record['record_url']); ?></a></p>
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
												<input type="hidden" value="<?php echo $this->AjaxNonce( 'sign_in' ); ?>" name="nonce">
												<input type="hidden" value="hp echo $rand; ?>" id="randValue" name="randValue">
												<div class="row">
													<div class="col-8 col-lg-3">
														<div class="form-group">
															<input type="text" id="forward-url" name="forward-url" class="form-control" placeholder="https://">
														</div>
													</div>
													<div class="col-4 col-lg-3 col-no-gutters">
														<div class="form-group">
															<input type="text" id="forward-slug" name="forward-slug" class="form-control" placeholder="<?php echo $this->NewRecord(); ?>" value="<?php echo $this->NewRecord(); ?>">
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
													<svg viewBox="0 0 24 24"><path d="M6,16.5L3,19.44V11H6M11,14.66L9.43,13.32L8,14.64V7H11M16,13L13,16V3H16M18.81,12.81L17,11H22V16L20.21,14.21L13,21.36L9.53,18.34L5.75,22H3L9.47,15.66L13,18.64" /></svg>
													<div>
														<h1><?php echo $this->TotalClicks(); ?></h1>
														<p><?php echo $this->_e('Total clicks'); ?></p>
													</div>
												</div>
											</li>
											<li class="list-inline-item">
												<div class="stats-header">
													<svg viewBox="0 0 24 24"><path d="M10.6 13.4A1 1 0 0 1 9.2 14.8A4.8 4.8 0 0 1 9.2 7.8L12.7 4.2A5.1 5.1 0 0 1 19.8 4.2A5.1 5.1 0 0 1 19.8 11.3L18.3 12.8A6.4 6.4 0 0 0 17.9 10.4L18.4 9.9A3.2 3.2 0 0 0 18.4 5.6A3.2 3.2 0 0 0 14.1 5.6L10.6 9.2A2.9 2.9 0 0 0 10.6 13.4M23 18V20H20V23H18V20H15V18H18V15H20V18M16.2 13.7A4.8 4.8 0 0 0 14.8 9.2A1 1 0 0 0 13.4 10.6A2.9 2.9 0 0 1 13.4 14.8L9.9 18.4A3.2 3.2 0 0 1 5.6 18.4A3.2 3.2 0 0 1 5.6 14.1L6.1 13.7A7.3 7.3 0 0 1 5.7 11.2L4.2 12.7A5.1 5.1 0 0 0 4.2 19.8A5.1 5.1 0 0 0 11.3 19.8L13.1 18A6 6 0 0 1 16.2 13.7Z" /></svg>
													<div>
														<h1>hp echo $top_referrer; ?></h1>
														<p><?php echo $this->_e('Top referrer'); ?></p>
													</div>
												</div>
											</li>
											<li class="list-inline-item">
												<div class="stats-header">
													<svg viewBox="0 0 24 24"><path d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" /></svg>
													<div>
														<h1>hp echo $top_lang; ?></h1>
														<p><?php echo $this->_e('Top language'); ?></p>
													</div>
												</div>
											</li>
										</ul>
									</div>
									<div class="col-12">
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
												<div class="col-6 col-no-gutters">
													<div class="pie-chart1 ct-perfect-fourth"></div>
												</div>
												<div class="col-6 col-no-gutters">
													<div class="pie-chart2 ct-perfect-fourth"></div>
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
