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
?>
<!DOCTYPE html>
<html lang="en" role="banner">
<head role="contentinfo">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="msapplication-navbutton-color" content="#343a40">
	<meta name="description" content="Forward is a link shortener created by RapidDev" />
	<meta name="apple-mobile-web-app-status-bar-style" content="#343a40">
	<meta name="theme-color" content="#343a40">
	<meta name="mobile-web-app-capable" content="no">
	<meta name="apple-mobile-web-app-capable" content="no">
	<meta name="msapplication-starturl" content="/">
	<meta name="msapplication-TileImage" content="<?php echo $this->script_uri; ?>media/img/forward-fav.png" />
	<link rel="icon" href="<?php echo $this->script_uri; ?>media/img/forward-fav.png" sizes="192x192" />
	<link rel="apple-touch-icon-precomposed" href="<?php echo $this->script_uri; ?>media/img/forward-fav.png" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo $this->script_uri; ?>media/css/red.css">
	<title>Forward | Install</title>
	<style>
		body {
			font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
		}
		#javascript-error {
			display:none;background-color: #f3f3f3;color:#b0aea8;position: fixed;width: 100%;height:100%;justify-content: center;align-items: center;z-index: 100001;left: 0;right: 0;bottom:0;padding:15px;
		}
	</style>
	<noscript>
		<style>
			#javascript-error {display: flex !important;}
		</style>
	</noscript>
</head>
<body>
<section id="javascript-error">
	<img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA2MzAgNjMwIj48cmVjdCB3aWR0aD0iNjMwIiBoZWlnaHQ9IjYzMCIgZmlsbD0iI2Y3ZGYxZSIvPjxwYXRoIGQ9Im00MjMuMiA0OTIuMTljMTIuNjkgMjAuNzIgMjkuMiAzNS45NSA1OC40IDM1Ljk1IDI0LjUzIDAgNDAuMi0xMi4yNiA0MC4yLTI5LjIgMC0yMC4zLTE2LjEtMjcuNDktNDMuMS0zOS4zbC0xNC44LTYuMzVjLTQyLjcyLTE4LjItNzEuMS00MS03MS4xLTg5LjIgMC00NC40IDMzLjgzLTc4LjIgODYuNy03OC4yIDM3LjY0IDAgNjQuNyAxMy4xIDg0LjIgNDcuNGwtNDYuMSAyOS42Yy0xMC4xNS0xOC4yLTIxLjEtMjUuMzctMzguMS0yNS4zNy0xNy4zNCAwLTI4LjMzIDExLTI4LjMzIDI1LjM3IDAgMTcuNzYgMTEgMjQuOTUgMzYuNCAzNS45NWwxNC44IDYuMzRjNTAuMyAyMS41NyA3OC43IDQzLjU2IDc4LjcgOTMgMCA1My4zLTQxLjg3IDgyLjUtOTguMSA4Mi41LTU0Ljk4IDAtOTAuNS0yNi4yLTEwNy44OC02MC41NHptLTIwOS4xMyA1LjEzYzkuMyAxNi41IDE3Ljc2IDMwLjQ1IDM4LjEgMzAuNDUgMTkuNDUgMCAzMS43Mi03LjYxIDMxLjcyLTM3LjJ2LTIwMS4zaDU5LjJ2MjAyLjFjMCA2MS4zLTM1Ljk0IDg5LjItODguNCA4OS4yLTQ3LjQgMC03NC44NS0yNC41My04OC44MS01NC4wNzV6Ii8+PC9zdmc+" alt="JavaScript ERROR" style="max-width:70px;width:100%;margin-right:15px;">
	<p style="margin:0"><b>JavaScript Error</b><br />This page cannot work <br/> correctly without JavaScript.</p>
</section>
<section id="forward">
	<div id="big-background">
		<picture>
			<source srcset="<?php echo $this->script_uri; ?>media/img/bg.webp" type="image/webp">
			<source srcset="<?php echo $this->script_uri; ?>media/img/bg.jpeg" type="image/jpeg">
			<img alt="Forward background" src="<?php echo $this->script_uri; ?>media/img/bg.jpeg">
		</picture>
	</div>
	<section id="red-install">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-6" style="display: flex;align-items: center;">
					<picture id="forward-logo">
						<source srcset="<?php echo $this->script_uri; ?>media/img/forward-logo-wt.webp" type="image/webp">
						<source srcset="<?php echo $this->script_uri; ?>media/img/forward-logo-wt.jpeg" type="image/jpeg">
						<img alt="Forward logo" src="<?php echo $this->script_uri; ?>media/img/forward-logo-wt.jpeg">
					</picture>
				</div>
				<div class="col-12 col-lg-6">
					<div id="login-card">
						<div class="card" id="install-form">
							<div class="card-body">
								<div>
									<h1>Install</h1>
									<input type="hidden" class="form-control" id="refFolder" value="<?php echo dirname($_SERVER["SCRIPT_NAME"]); ?>">
									<span>Default URL</span>
									<div class="form-group">
										<input type="text" class="form-control" id="defaultUrl" placeholder="<?php echo $this->script_uri; ?>" value="<?php echo $this->script_uri; ?>">
									</div>
									<span>Databases</span>
									<div class="row">
										<div class="col-12 col-lg-4">
											<div class="form-group">
												<input type="text" class="form-control" id="optionsDB" placeholder="db_options" value="db_options">
											</div>
										</div>
										<div class="col-12 col-lg-4">
											<div class="form-group">
												<input type="text" class="form-control" id="recordsDB" placeholder="db_records" value="db_records">
											</div>
										</div>
										<div class="col-12 col-lg-4">
											<div class="form-group">
												<input type="text" class="form-control" id="usersDB" placeholder="db_users" value="db_users">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 col-lg-6">
											<div class="form-group">
												<label for="defUser">Login</label>
												<input type="text" class="form-control" id="defUser" placeholder="admin" value="admin">
											</div>
										</div>
										<div class="col-12 col-lg-6">
											<div class="form-group">
												<label for="defPassw">Password</label>
												<input type="text" class="form-control" id="defPassw" placeholder="admin" value="admin">
											</div>
										</div>
									</div>
								</div>
							</div>
							<button id="install-forward" class="btn btn-primary">Install</button>
						</div>
						<div class="card" id="install-progress" style="display: none;">
							<div class="card-body">
								<div style="display: flex;align-items: center;">
									<img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzgiIGhlaWdodD0iMzgiIHZpZXdCb3g9IjAgMCAzOCAzOCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4gICAgPGRlZnM+ICAgICAgICA8bGluZWFyR3JhZGllbnQgeDE9IjguMDQyJSIgeTE9IjAlIiB4Mj0iNjUuNjgyJSIgeTI9IjIzLjg2NSUiIGlkPSJhIj4gICAgICAgICAgICA8c3RvcCBzdG9wLWNvbG9yPSIjNDQ0IiBzdG9wLW9wYWNpdHk9IjAiIG9mZnNldD0iMCUiLz4gICAgICAgICAgICA8c3RvcCBzdG9wLWNvbG9yPSIjNDQ0IiBzdG9wLW9wYWNpdHk9Ii42MzEiIG9mZnNldD0iNjMuMTQ2JSIvPiAgICAgICAgICAgIDxzdG9wIHN0b3AtY29sb3I9IiM0NDQiIG9mZnNldD0iMTAwJSIvPiAgICAgICAgPC9saW5lYXJHcmFkaWVudD4gICAgPC9kZWZzPiAgICA8ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPiAgICAgICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMSAxKSI+ICAgICAgICAgICAgPHBhdGggZD0iTTM2IDE4YzAtOS45NC04LjA2LTE4LTE4LTE4IiBpZD0iT3ZhbC0yIiBzdHJva2U9InVybCgjYSkiIHN0cm9rZS13aWR0aD0iMiI+ICAgICAgICAgICAgICAgIDxhbmltYXRlVHJhbnNmb3JtICAgICAgICAgICAgICAgICAgICBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iICAgICAgICAgICAgICAgICAgICB0eXBlPSJyb3RhdGUiICAgICAgICAgICAgICAgICAgICBmcm9tPSIwIDE4IDE4IiAgICAgICAgICAgICAgICAgICAgdG89IjM2MCAxOCAxOCIgICAgICAgICAgICAgICAgICAgIGR1cj0iMC45cyIgICAgICAgICAgICAgICAgICAgIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIiAvPiAgICAgICAgICAgIDwvcGF0aD4gICAgICAgICAgICA8Y2lyY2xlIGZpbGw9IiM0NDQiIGN4PSIzNiIgY3k9IjE4IiByPSIxIj4gICAgICAgICAgICAgICAgPGFuaW1hdGVUcmFuc2Zvcm0gICAgICAgICAgICAgICAgICAgIGF0dHJpYnV0ZU5hbWU9InRyYW5zZm9ybSIgICAgICAgICAgICAgICAgICAgIHR5cGU9InJvdGF0ZSIgICAgICAgICAgICAgICAgICAgIGZyb209IjAgMTggMTgiICAgICAgICAgICAgICAgICAgICB0bz0iMzYwIDE4IDE4IiAgICAgICAgICAgICAgICAgICAgZHVyPSIwLjlzIiAgICAgICAgICAgICAgICAgICAgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiIC8+ICAgICAgICAgICAgPC9jaXJjbGU+ICAgICAgICA8L2c+ICAgIDwvZz48L3N2Zz4=" alt="Loader" style="margin-right: 15px;">
									<span>Forward will be ready in a moment!</span>
								</div>
							</div>
						</div>
						<div class="card" id="install-done" style="display: none;">
							<div class="card-body">
								<h1>Everything is ready!</h1>
								<span>You will be redirected in a few seconds</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>
<script src="<?php echo $this->script_uri; ?>media/js/jquery-3.4.1.js" crossorigin="anonymous"></script>
<script>
	jQuery('#install-forward').on('click', function(e){
		e.preventDefault();

		jQuery('#install-form').slideUp(400, function(){
			jQuery('#install-progress').slideDown(400);
		});

		jQuery.ajax({
			url: '<?php echo $this->script_uri; ?>',
			type:'post',
			data:{
				action: 'setup',
				refFolder: jQuery('#refFolder').val(),
				defaultUrl: jQuery('#defaultUrl').val(),
				refFolder: jQuery('#refFolder').val(),
				optionsDB: jQuery('#optionsDB').val(),
				recordsDB: jQuery('#recordsDB').val(),
				usersDB: jQuery('#usersDB').val(),
				defUser: jQuery('#defUser').val(),
				defPassw: jQuery('#defPassw').val(),
			},
			success:function(e)
			{
				console.log(e);

				if(e == 'success'){
					window.setTimeout(function(){
						jQuery('#install-progress').fadeOut(400, function()
						{
							jQuery('#install-done').fadeIn(400);
							window.setTimeout(function(){
								window.location.href = jQuery('#defaultUrl').val()+'dashboard';
							}, 3000);
						});
					}, 1000);	
				}
			},
			fail: function(xhr, textStatus, errorThrown){
				jQuery('#install-progress').slideUp(400);
				console.log(xhr);
				console.log(textStatus);
				alert(errorThrown);
			}
		});
	});
</script>
</body>
</html>