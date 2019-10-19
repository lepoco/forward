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

	$records = $this->DB['records']->select('__id,__created_at,url,clicks,referrers,locations')->orderBy('__created_at', 'DESC')->results();
	$siteurl = $this->DB['options']->get('siteurl')->value;

	$total_clicks = 0;

	$locations = array();
	$referrers = array();

	foreach ($records as $key => $record)
	{
		$total_clicks += $record['clicks'];

		if(is_array($record['locations']))
		{
			foreach ($record['locations'] as $location => $count)
			{
				if(array_key_exists($location, $locations))
				{
					$locations[$location] += $count;
				}
				else
				{
					$locations[$location] = $count;
				}
			}
		}

		if(is_array($record['referrers']))
		{
			foreach ($record['referrers'] as $referrer => $count)
			{
				if(array_key_exists($referrer, $referrers))
				{
					$referrers[$referrer] += $count;
				}
				else
				{
					$referrers[$referrer] = $count;
				}
			}
		}
	}

	if(count($locations) == 0)
		$locations = array('unknown' => 0);
	arsort($locations);

	if(count($referrers) == 0)
		$referrers = array('unknown' => 0);
	arsort($referrers);

	switch (array_key_first($locations)) {
		case 'en-us':
			$top_lang = 'English';
			break;
		
		default:
			$top_lang = array_key_first($locations);
			break;
	}

	if(array_key_first($referrers) == 'direct')
		$top_referrer = 'Email, SMS, Direct';
	else
		$top_referrer = array_key_first($referrers);

?>

<div id="red-dashboard">
	<div id="dashboard-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-lg-3 col-no-gutters" style="background-color: #fff;height: inherit; overflow: auto;">
					<ul class="list-unstyled" id="links-list">
						<li><div class="card links-card"><div class="card-body"><small><strong id="total_records_count"><?php echo count($records); ?></strong> total links</small></div></div></li>
						<?php foreach ($records as $key => $record): ?>
							<li>
								<div class="card links-card">
									<div class="card-body">
										<div>
											<small><?php echo date('Y-m-d', $record['__created_at']); ?></small>
											<h2><a target="_blank" rel="noopener" href="<?php echo $siteurl.$record['__id']; ?>">/<?php echo $record['__id']; ?></a></h2>
											<p><a target="_blank" rel="noopener" href="<?php echo $record['url'] ?>"><?php echo substr(str_replace(array('https://www.', 'https://'), array('', ''), $record['url']), 0, 35); ?>...</a></p>
										</div>
										<span><?php echo $record['clicks']; ?></span>
									</div>
								</div>
							</li>
						<?php endforeach ?>
					</ul>
				</div>
				<div class="col-12 col-lg-9 col-no-gutters">
					<div class="container-fluid" style="margin-top:32px;">
						<div class="row">
							<div class="col-12">
								<div id="add-alert" class="alert alert-danger fade show" role="alert" style="display: none;">
									<strong>Holy guacamole!</strong> <span id="error_text">Something went wrong!</span>
								</div>
								<div id="add-success" class="alert alert-success fade show" role="alert" style="display: none;">
									<strong>Success!</strong> New link was added.
								</div>
								<form class="form-inline" id="add-record-form" action="<?php echo $this->home_url().'dashboard/ajax/'; ?>">
									<?php

										//Find unical slug
										$rand = 'sad2';
										$sucRand = true;
										while ($sucRand) {
											$slug = $this->DB['records']->select('__id,url')->where('__id','=',$rand)->results();
											if(isset($slug[0]))
												$rand = RED::rand(6);
											else
												$sucRand = false;
										}
									?>
									<input type="hidden" value="addRecord" name="action">
									<input type="hidden" value="<?php echo RED::encrypt('ajax_add_record_nonce', 'nonce'); ?>" name="nonce">
									<input type="hidden" value="<?php echo $rand; ?>" id="randValue" name="randValue">
									<div class="form-group mx-sm-3 mb-2">
										<input type="text" id="forward-url" name="forward-url" class="form-control" placeholder="https://">
									</div>
									<div class="form-group mx-sm-3 mb-2">
										<input type="text" id="forward-slug" name="forward-slug" class="form-control" placeholder="<?php echo $rand; ?>">
									</div>
									<button type="submit" id="add-record-send" class="btn btn-outline-dark mb-2">Add new</button>
								</form>
							</div>
							<div class="col-12" style="margin-top:32px;">
								<ul class="list-inline">
									<li class="list-inline-item">
										<div class="stats-header">
											<svg viewBox="0 0 24 24"><path d="M6,16.5L3,19.44V11H6M11,14.66L9.43,13.32L8,14.64V7H11M16,13L13,16V3H16M18.81,12.81L17,11H22V16L20.21,14.21L13,21.36L9.53,18.34L5.75,22H3L9.47,15.66L13,18.64" /></svg>
											<div>
												<h1><?php echo $total_clicks; ?></h1>
												<p>Total clicks</p>
											</div>
										</div>
									</li>
									<li class="list-inline-item">
										<div class="stats-header">
											<svg viewBox="0 0 24 24"><path d="M10.6 13.4A1 1 0 0 1 9.2 14.8A4.8 4.8 0 0 1 9.2 7.8L12.7 4.2A5.1 5.1 0 0 1 19.8 4.2A5.1 5.1 0 0 1 19.8 11.3L18.3 12.8A6.4 6.4 0 0 0 17.9 10.4L18.4 9.9A3.2 3.2 0 0 0 18.4 5.6A3.2 3.2 0 0 0 14.1 5.6L10.6 9.2A2.9 2.9 0 0 0 10.6 13.4M23 18V20H20V23H18V20H15V18H18V15H20V18M16.2 13.7A4.8 4.8 0 0 0 14.8 9.2A1 1 0 0 0 13.4 10.6A2.9 2.9 0 0 1 13.4 14.8L9.9 18.4A3.2 3.2 0 0 1 5.6 18.4A3.2 3.2 0 0 1 5.6 14.1L6.1 13.7A7.3 7.3 0 0 1 5.7 11.2L4.2 12.7A5.1 5.1 0 0 0 4.2 19.8A5.1 5.1 0 0 0 11.3 19.8L13.1 18A6 6 0 0 1 16.2 13.7Z" /></svg>
											<div>
												<h1><?php echo $top_referrer; ?></h1>
												<p>Top referrer</p>
											</div>
										</div>
									</li>
									<li class="list-inline-item">
										<div class="stats-header">
											<svg viewBox="0 0 24 24"><path d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" /></svg>
											<div>
												<h1><?php echo $top_lang; ?></h1>
												<p>Top language</p>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	window.onload = function() {
		jQuery('#add-record-send').on('click', function(e){
			e.preventDefault();
			if(jQuery('#add-alert').is(':visible')){
				jQuery('#add-alert').slideToggle();
			}
			if(jQuery('#add-success').is(':visible')){
				jQuery('#add-success').slideToggle();
			}

			jQuery.ajax({
				url: '<?php echo $this->home_url().'dashboard/ajax/'; ?>',
				type:'post',
				data:$("#add-record-form").serialize(),
				success:function(e)
				{
					if(e == 'success')
					{
						jQuery('#add-success').slideToggle();

						jQuery('#total_records_count').html(parseInt(jQuery('#total_records_count').html()) + 1);


						var slug = jQuery('#forward-slug').val();
						if(slug == '')
						{
							slug = jQuery('#randValue').val();
						}
						var url = '<?php echo $this->home_url(); ?>'+slug;
						var target = jQuery('#forward-url').val();
						var target_shorted = jQuery('#forward-url').val();
						var date = '<?php echo date('Y-m-d', time()) ?>';

						jQuery("#links-list li:first").after('<div class="card links-card"><div class="card-body"><div><small>'+date+'</small><h2><a target="_blank" rel="noopener" href="'+url+'">/'+slug+'</a></h2><p><a target="_blank" rel="noopener" href="'+target_shorted+'">'+target+'...</a></p></div><span>0</span></div></div>');;


						window.setTimeout(function(){
							jQuery('#add-success').slideToggle()
						}, 3000);
					}else{
						var error_text = 'Unknown';

						if(e == 'error_2')
						{
							error_text = 'The form verification key is invalid.';
						}
						else if(e == 'error_3')
						{
							error_text = 'The form content is not valid.';
						}
						else if(e == 'error_4')
						{
							error_text = 'You must provide a url.';
						}
						else if(e == 'error_5')
						{
							error_text = 'This url has already been added.';
						}
						else if(e == 'error_6')
						{
							error_text = 'Shortcut with this slug already exists.';
						}

						jQuery('#error_text').html(error_text);
						jQuery('#add-alert').slideToggle();
					}
					console.log(e);
				},
				fail:function(xhr, textStatus, errorThrown){
					console.log(xhr);
					console.log(textStatus);
					console.log(errorThrown);
					jQuery('#add-alert').slideToggle();
				}
			});
		});
	};
</script>
<?php $this->footer(); ?>