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

<div id="red-dashboard">
	<div id="dashboard-stats">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-lg-4">
					<div class="stats-header">
						<svg viewBox="0 0 24 24"><path d="M6,16.5L3,19.44V11H6M11,14.66L9.43,13.32L8,14.64V7H11M16,13L13,16V3H16M18.81,12.81L17,11H22V16L20.21,14.21L13,21.36L9.53,18.34L5.75,22H3L9.47,15.66L13,18.64" /></svg>
						<div>
							<h1>Title</h1>
							<p>Total clicks</p>
						</div>
					</div>
					<div class="stats-header">
						<svg viewBox="0 0 24 24"><path d="M10.6 13.4A1 1 0 0 1 9.2 14.8A4.8 4.8 0 0 1 9.2 7.8L12.7 4.2A5.1 5.1 0 0 1 19.8 4.2A5.1 5.1 0 0 1 19.8 11.3L18.3 12.8A6.4 6.4 0 0 0 17.9 10.4L18.4 9.9A3.2 3.2 0 0 0 18.4 5.6A3.2 3.2 0 0 0 14.1 5.6L10.6 9.2A2.9 2.9 0 0 0 10.6 13.4M23 18V20H20V23H18V20H15V18H18V15H20V18M16.2 13.7A4.8 4.8 0 0 0 14.8 9.2A1 1 0 0 0 13.4 10.6A2.9 2.9 0 0 1 13.4 14.8L9.9 18.4A3.2 3.2 0 0 1 5.6 18.4A3.2 3.2 0 0 1 5.6 14.1L6.1 13.7A7.3 7.3 0 0 1 5.7 11.2L4.2 12.7A5.1 5.1 0 0 0 4.2 19.8A5.1 5.1 0 0 0 11.3 19.8L13.1 18A6 6 0 0 1 16.2 13.7Z" /></svg>
						<div>
							<h1>Title</h1>
							<p>Top language</p>
						</div>
					</div>
					<div class="stats-header">
						<svg viewBox="0 0 24 24"><path d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" /></svg>
						<div>
							<h1>Title</h1>
							<p>Top country</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6">
					
				</div>
			</div>
		</div>		
	</div>
	
	<div class="container" style="margin-top: 30px;">
		<div class="row">
			<div class="col-12" id="add-new-card">
				<form id="add-record-form" action="<?php echo $this->home_url().'dashboard/ajax/'; ?>">
					<div class="card">
						<div class="card-body">
							<?php $rand = RED::rand(6); ?>
							<input type="hidden" value="addRecord" name="action">
							<input type="hidden" value="<?php echo RED::encrypt('ajax_add_record_nonce', 'nonce'); ?>" name="nonce">
							<input type="hidden" value="<?php echo $rand; ?>" name="randValue">
							<div class="form-row">
								<div class="col">
									<div class="form-group">
										<label for="forward-url">URL</label>
										<input type="text" id="forward-url" name="forward-url" class="form-control" placeholder="https://">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="forward-slug">Slug <i>(optional)</i></label>
										<input type="text" id="forward-slug" name="forward-slug" class="form-control" placeholder="<?php echo $rand; ?>">
									</div>
								</div>
							</div>
						</div>
						<button type="submit" id="add-record-send" class="btn btn-dark">Add new</button>
					</div>
				</form>
			</div>
			<div class="col-12" id="links-table">
				<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Short URL</th>
							<th scope="col">Original URL</th>
							<th scope="col">Date created</th>
							<th scope="col">Clicks</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php

						$siteurl = $this->DB['options']->get('siteurl')->value;
						$records = $this->DB['records']->findAll();
						//$records = $this->DB['records']->orderBy('__created_at','ASC')->results();
						$c = 0;
						foreach($records as $record)
						{
							$c++;
							echo '<tr><th scope="row">'.$c.'</th><td><a target="_blank" rel="noopener" href="'.$siteurl.$record->getId().'">/'.$record->getId().'</a></td><td><a target="_blank" rel="noopener" href="'.$record->url.'">'.$record->url.'</a></td><td>'.$record->createdAt().'</td><td>'.$record->clicks.'</td><td class="td-buttons"><button class="btn btn-dark btn-icon"><svg style="width:18px;height:18px" viewBox="0 0 24 24"><path fill="#fff" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" /></svg></button> <button class="btn btn-dark btn-icon"><svg style="width:18px;height:18px" viewBox="0 0 24 24"><path fill="#fff" d="M20.37,8.91L19.37,10.64L7.24,3.64L8.24,1.91L11.28,3.66L12.64,3.29L16.97,5.79L17.34,7.16L20.37,8.91M6,19V7H11.07L18,11V19A2,2 0 0,1 16,21H8A2,2 0 0,1 6,19M8,19H16V12.2L10.46,9H8V19Z" /></svg></button></td></tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	window.onload = function() {
		jQuery('#add-record-send').on('click', function(e){
			e.preventDefault();
			jQuery.ajax({
				url: '<?php echo $this->home_url().'dashboard/ajax/'; ?>',
				type:'post',
				data:$("#add-record-form").serialize(),
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