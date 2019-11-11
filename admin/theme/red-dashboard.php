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

	/** Essential database information */
	$records = $this->RED->DB['records']->select('__id,__created_at,name,url,clicks,stats,referrers,locations')->orderBy('__created_at', 'DESC')->results();

	/** Default values for the representation of general data */
	$total_clicks = 0;
	$locations = array();
	$referrers = array();
	$top_referrer = $this->e('Unknown');
	$top_lang = $this->e('Unknown');

	/** Current date for printing the pie chart */
	$date = array(
		'y' => date('Y', time()),
		'm' => date('m', time()),
		'd' => date('d', time())
	);
	$date['days'] = cal_days_in_month(CAL_GREGORIAN, (int)$date['m'], (int)$date['y']);

	/** Unique slug for the new URL */
	$rand = RED::rand(6);
	$sucRand = true;
	while ($sucRand) {
		$slug = $this->RED->DB['records']->select('__id,url')->where('__id','=',strtolower($rand))->results();
		if(isset($slug[0]))
			$rand = RED::rand(6);
		else
			$sucRand = false;
	}
?>

<div id="red-dashboard" class="block-page distance-navbar">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-lg-3 col-no-gutters" id="records_list">
				<div class="card links-header"><div class="card-body"><small><strong id="total_records_count"><?php echo count($records); ?></strong> <?php echo $this->e('total links'); ?></small></div></div>
				<div id="links-copied" class="alert alert-success fade show" role="alert" style="display: none;margin: 0;border-radius: 0;">
					<div>
						<svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#155724" d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7M7.5,13.5L9,12L11,14L15.5,9.5L17,11L11,17L7.5,13.5Z" /></svg>
						<small><?php echo $this->e('Link has been copied to your clipboard'); ?></small>
					</div>
				</div>
				<?php $c = 0;
				foreach ($records as $key => $record):

					/** Records counter */
					$c++;

					/** Total clicks */
					$total_clicks += $record['clicks'];

					/** Most popular location */
					if(is_array($record['locations']))
						foreach ($record['locations'] as $location => $count)
							if(array_key_exists($location, $locations))
								$locations[$location] += $count;
							else
								$locations[$location] = $count;
					/** Sort by most popular location */
					if(count($locations) == 0)
						$locations = array($this->e('Unknown') => 0);
					arsort($locations);

					/** Most popular referrer */
					if(is_array($record['referrers']))
						foreach ($record['referrers'] as $referrer => $count)
							if(array_key_exists($referrer, $referrers))
								$referrers[$referrer] += $count;
							else
								$referrers[$referrer] = $count;
					/** Sort by most popular refferer */
					if(count($referrers) == 0)
						$referrers = array($this->e('Unknown') => 0);
					arsort($referrers);
					
					/** Daily statistics */
					$stats = '';
					if(is_array($record['stats']) && isset($record['stats'][$date['y'].'-'.$date['m']]))
						for ($i=1; $i <= $date['days']; $i++)
							$stats .= ($i > 1 ? '/' : '').(isset($record['stats'][$date['y'].'-'.$date['m']][$i]) ? $record['stats'][$date['y'].'-'.$date['m']][$i] : '0');
					else
						for($i=1; $i <= $date['days']; $i++)
							$stats .= ($i > 1 ? '/': '').'0';
					$record['stats'] = $stats;

					/** Shorter URL */
					$preURL = str_replace(array('https://www.', 'https://'), array('', ''), $record['url']);
					if(strlen($preURL) > 35)
						$preURL = substr($preURL, 0, 35).'...';
					
					/** Get the name of the most popular location */
					switch (key($locations))
					{
						case 'en-us':
							$top_lang = $this->e('English');
							break;
						case 'pl-pl': case 'en-pl':
							$top_lang = $this->e('Poland');
							break;
						default:
							$top_lang = key($locations);
							break;
					}

					/** Get the name of the most popular refferer */
					if(key($referrers) == 'direct')
						$top_referrer = $this->e('Email, SMS, Direct');
					else
						$top_referrer = key($referrers);

					/** Refferers for display in HTML data */
					$record_referrers = '';
					if(is_array($record['referrers']))
						foreach ($record['referrers'] as $key => $value)
							$record_referrers .= (!empty($record_referrers) ? '~' : '').$key.'~'.$value;

					/** Locations for display in HTML data */
					$record_locations = '';
					if(is_array($record['locations']))
						foreach ($record['locations'] as $key => $value)
							$record_locations .= (!empty($record_locations) ? '~' : '').$key.'~'.$value;
					?>
					<div class="card links-card links-card-<?php echo $record['name']; ?>"<?php echo ($c == 1 ? ' id="first-record"':''); ?> data-clipboard-text="<?php echo $this->home_url().$record['name']; ?>" data-locations="<?php echo $record_locations; ?>" data-referrers="<?php echo $record_referrers; ?>" data-daily="<?php echo $record['stats']; ?>" data-date="<?php echo date('Y-m-d H:i', $record['__created_at']); ?>" data-url="<?php echo $record['url']; ?>" data-slug="<?php echo $record['name']; ?>" data-clicks="<?php echo $record['clicks']; ?>">
						<div class="card-body">
							<div>
								<small><?php echo date('Y-m-d', $record['__created_at']); ?></small>
								<h2><a class="shorted-url" data-clipboard-text="<?php echo $this->home_url().$record['name']; ?>" target="_blank" rel="noopener" href="<?php echo $this->home_url().$record['name']; ?>">/<?php echo $record['name']; ?></a></h2>
								<p><a target="_blank" rel="noopener" href="<?php echo $record['url'] ?>"><?php echo $preURL; ?></a></p>
							</div>
							<span><?php echo $record['clicks']; ?></span>
						</div>
					</div>
				<?php endforeach ?>
			</div>
			<div class="col-12 col-lg-9" style="padding-top:32px;padding-bottom:15px;height: inherit;overflow: auto;">
				<div class="container-fluid">
					<div class="row">
						<?php if ($this->RED->is_manager()): ?>
						<div class="col-12">
							<div id="add-alert" class="alert alert-danger fade show" role="alert" style="display: none;">
								<strong><?php echo $this->e('Holy guacamole!'); ?></strong> <span id="error_text"><?php echo $this->e('Something went wrong!'); ?></span>
							</div>
							<div id="add-success" class="alert alert-success fade show" role="alert" style="display: none;">
								<strong><?php echo $this->e('Success!'); ?></strong> <?php echo $this->e('New link was added.'); ?>
							</div>
							<form id="add-record-form" action="<?php echo $this->home_url().'dashboard/ajax/'; ?>">
								<input type="hidden" value="add_record" name="action">
								<input type="hidden" value="<?php echo RED::encrypt('ajax_add_record_nonce', 'nonce'); ?>" name="nonce">
								<input type="hidden" value="<?php echo $rand; ?>" id="randValue" name="randValue">
								<div class="row">
									<div class="col-8 col-lg-3">
										<div class="form-group">
											<input type="text" id="forward-url" name="forward-url" class="form-control" placeholder="https://">
										</div>
									</div>
									<div class="col-4 col-lg-3 col-no-gutters">
										<div class="form-group">
											<input type="text" id="forward-slug" name="forward-slug" class="form-control" placeholder="<?php echo $rand; ?>">
										</div>
									</div>
									<div class="col-12 col-lg-3">
										<button type="submit" id="add-record-send" class="btn btn-block btn-outline-dark"><?php echo $this->e('Add new'); ?></button>
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
											<h1><?php echo $total_clicks; ?></h1>
											<p><?php echo $this->e('Total clicks'); ?></p>
										</div>
									</div>
								</li>
								<li class="list-inline-item">
									<div class="stats-header">
										<svg viewBox="0 0 24 24"><path d="M10.6 13.4A1 1 0 0 1 9.2 14.8A4.8 4.8 0 0 1 9.2 7.8L12.7 4.2A5.1 5.1 0 0 1 19.8 4.2A5.1 5.1 0 0 1 19.8 11.3L18.3 12.8A6.4 6.4 0 0 0 17.9 10.4L18.4 9.9A3.2 3.2 0 0 0 18.4 5.6A3.2 3.2 0 0 0 14.1 5.6L10.6 9.2A2.9 2.9 0 0 0 10.6 13.4M23 18V20H20V23H18V20H15V18H18V15H20V18M16.2 13.7A4.8 4.8 0 0 0 14.8 9.2A1 1 0 0 0 13.4 10.6A2.9 2.9 0 0 1 13.4 14.8L9.9 18.4A3.2 3.2 0 0 1 5.6 18.4A3.2 3.2 0 0 1 5.6 14.1L6.1 13.7A7.3 7.3 0 0 1 5.7 11.2L4.2 12.7A5.1 5.1 0 0 0 4.2 19.8A5.1 5.1 0 0 0 11.3 19.8L13.1 18A6 6 0 0 1 16.2 13.7Z" /></svg>
										<div>
											<h1><?php echo $top_referrer; ?></h1>
											<p><?php echo $this->e('Top referrer'); ?></p>
										</div>
									</div>
								</li>
								<li class="list-inline-item">
									<div class="stats-header">
										<svg viewBox="0 0 24 24"><path d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" /></svg>
										<div>
											<h1><?php echo $top_lang; ?></h1>
											<p><?php echo $this->e('Top language'); ?></p>
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
									<?php if ($this->RED->is_manager()): ?>
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
<?php if ($this->RED->is_manager()): ?>
<div class="modal fade" id="delete-record-modal" tabindex="-1" role="dialog" aria-labelledby="delete-record-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<h4><?php echo $this->e('Delete record'); ?></h4>
				<span><?php echo sprintf($this->e('Are you sure you want to delete the %s record?'), '<strong><span id="delete-record-name"></span></strong>'); ?></span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->e('Cancel'); ?></button>
				<button type="submit" id="delete-record-confirm" type="button" class="btn btn-danger"><?php echo $this->e('Delete record'); ?></button>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<script>

var strings = {
	referrers: '<?php echo $this->e('Referrers'); ?>',
	locations: '<?php echo $this->e('Locations'); ?>',
	direct: '<?php echo $this->e('Email, SMS, Direct'); ?>',
	unknown: '<?php echo $this->e('Unknown'); ?>',
	enus: '<?php echo $this->e('English'); ?>',
	plpl: '<?php echo $this->e('Poland'); ?>',
	enpl: '<?php echo $this->e('Poland'); ?>',
	error1: '<?php echo $this->e('Something went wrong!'); ?>',
	error7: '<?php echo $this->e('You must provide a URL!'); ?>',
	error8: '<?php echo $this->e('A record with this ID already exists!'); ?>',
	error10: '<?php echo $this->e('The URL you entered is not valid!'); ?>'
};

function __(string)
{
	if(string in strings)
		return strings[string];
	else
		return string;
}

window.onload = function() {

	/** Record info */
	var record_id = null;
	var record_data = null;

	/** Initial chart and changing charts content */
	jQuery(function()
	{
		var bar_chart_height = 200;
		var bar_chart_labels = [<?php for($i=1; $i <= $date['days']; $i++){echo ($i > 1 ? ', ': '').'\''.$i.'\'';} ?>];

		function display_record(r,e,u,x,y){
			if(jQuery('#record-referrers').is(':visible')){
				jQuery('#record-locations').slideToggle(400).hide();
				jQuery('#record-referrers').slideToggle(400).hide();
			}

			if(x != ''){
				x = x.split('~');
				jQuery('#record-referrers').html('<strong>'+strings.referrers+'</strong><br/>');
				for (var i = 0; i < x.length / 2 + 1; i+=2) {
					jQuery('#record-referrers').append('<span>'+__(x[i])+': '+x[i+1]+'</span><br />');
				}
				jQuery('#record-referrers').delay(400).slideToggle(400);
			}
			if(y != ''){
				y = y.split('~');
				jQuery('#record-locations').html('<strong>'+strings.locations+'</strong><br/>');
				for (var i = 0; i < y.length / 2 + 1; i+=2) {
					jQuery('#record-locations').append('<span>'+__(y[i].replace(/-/g, ''))+': '+y[i+1]+'</span><br />');
				}
				jQuery('#record-locations').delay(400).slideToggle(400);
			}

			jQuery("#preview-record-slug").html("/"+r),jQuery("#preview-record-date").html(e),jQuery("#preview-record-url").attr("href",u),jQuery("#delete-record-icon").attr("data-id",r),jQuery("#preview-record-url").html(u)}
		function bar_chart_animate(e){var t=new Chartist.Bar(".ct-chart",{labels:bar_chart_labels,series:[e]},{height:bar_chart_height,axisX:{position:"start"},axisY:{position:"end"}}),a=0;t.on("created",function(){a=0}),t.on("draw",function(e){if(a++,"label"===e.type&&"x"===e.axis.units.pos)e.element.animate({y:{begin:10*a,dur:500,from:e.y-100,to:e.y,easing:"easeOutQuart"},opacity:{begin:10*a,dur:500,from:0,to:1,easing:"easeOutQuart"}});else if("label"===e.type&&"y"===e.axis.units.pos)e.element.animate({x:{begin:10*a,dur:500,from:e.x+100,to:e.x,easing:"easeOutQuart"},opacity:{begin:10*a,dur:500,from:0,to:1,easing:"easeOutQuart"}});else if("bar"===e.type)e.element.animate({y1:{begin:10*a,dur:500,from:0,to:e.y1,easing:"easeOutQuart"},opacity:{begin:10*a,dur:500,from:0,to:1,easing:"easeOutQuart"}});else if("grid"===e.type){var t={begin:10*a,dur:500,from:e[e.axis.units.pos+"1"]-30,to:e[e.axis.units.pos+"1"],easing:"easeOutQuart"},i={begin:10*a,dur:500,from:e[e.axis.units.pos+"2"]-100,to:e[e.axis.units.pos+"2"],easing:"easeOutQuart"},n={};n[e.axis.units.pos+"1"]=t,n[e.axis.units.pos+"2"]=i,n.opacity={begin:10*a,dur:500,from:0,to:1,easing:"easeOutQuart"},e.element.animate(n)}})}
		var prev_record = jQuery('#first-record').data();
		record_data = prev_record;
		record_id = record_data.id;
		display_record(prev_record.slug, prev_record.date, prev_record.url, prev_record.referrers, prev_record.locations);
		bar_chart_animate(prev_record.daily.split('/'));

		jQuery('.links-card').on('click', function()
		{
			var data = jQuery(this).data();
			record_data = data;
			record_id = record_data.id;
			display_record(data.slug, data.date, data.url, data.referrers, data.locations);
			bar_chart_animate(data.daily.split('/'));
		});
	});
	<?php if ($this->RED->is_manager()): ?>

	/** AJAX - Delete record */
	jQuery('#delete-record-icon').on('click', function(e){
		e.preventDefault();
		jQuery('#delete-record-name').html(record_data.slug);
		jQuery('#delete-record-confirm').attr('data-id', record_data.slug);
		jQuery('#delete-record-modal').modal('show');
	});
	jQuery('#delete-record-confirm').on('click', function(e){
		e.preventDefault();
		var data = record_data;
		jQuery.ajax({
			url: '<?php echo $this->home_url().'dashboard/ajax/'; ?>',
			type:'post',
			data: 'action=remove_record&nonce=<?php echo RED::encrypt('ajax_remove_record_nonce', 'nonce'); ?>&record_id='+data.slug,
			success:function(e)
			{
				if(e == 's01'){
					jQuery('#delete-record-modal').modal('hide');
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

	/** Copy to clipboard **/
	jQuery('.shorted-url').on('click', function(e){e.preventDefault();});
	function clipboard_alert(){
		if(jQuery('#links-copied').is(':hidden'))
		{
			jQuery('#links-copied').slideToggle();
			window.setTimeout(function(){
				jQuery('#links-copied').slideToggle(400, function(){jQuery('#links-copied').hide();});
			}, 3000);
		}
	}
	var clipboard_link = new ClipboardJS('.shorted-url');
	var clipboard_card = new ClipboardJS('.links-card');
	clipboard_link.on('success', function(e){clipboard_alert();});
	clipboard_card.on('success', function(e){clipboard_alert();});

	/** AJAX - Add new record */
	jQuery(function()
	{
		jQuery('#add-record-send').on('click', function(e){
			e.preventDefault();
			if(jQuery('#add-alert').is(':visible')){jQuery('#add-alert').slideToggle(400,function(){jQuery('#add-alert').hide();});}
			if(jQuery('#add-success').is(':visible')){jQuery('#add-success').slideToggle(400,function(){jQuery('#add-success').hide();});}
			jQuery.ajax({
				url: '<?php echo $this->home_url().'dashboard/ajax/'; ?>',
				type:'post',
				data:$("#add-record-form").serialize(),
				success:function(e)
				{
					if(e == 's01')
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

						jQuery("#records_list div:first").after('<div class="card links-card"><div class="card-body"><div><small>'+date+'</small><h2><a target="_blank" rel="noopener" href="'+url+'">/'+slug+'</a></h2><p><a target="_blank" rel="noopener" href="'+target_shorted+'">'+target+'...</a></p></div><span>0</span></div></div>');;

						window.setTimeout(function(){
							jQuery('#add-success').slideToggle(400, function(){jQuery('#add-success').hide();});
						}, 3000);
					}else{
						var error_text = strings.error1;

						if(e == 'e07')
						{
							error_text = strings.error7;
						}
						else if(e == 'e08')
						{
							error_text = strings.error8;
						}
						else
						{
							error_text = string.error10;
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
	});
	<?php endif; ?>
};
</script>
<?php $this->footer(); ?>