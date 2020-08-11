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
?>
<!DOCTYPE html>
<html>
	<head lang="<?php echo $this->Forward->Translator->locale; ?>" role="contentinfo" dir="ltr" xmlns:og="http://ogp.me/ns#" xmlns:fb="//www.facebook.com/2008/fbml" itemscope="" itemtype="http://schema.org/WebPage" class="" role="banner" user-nonce="<?php echo $this->body_nonce; ?>">
		<title><?php echo $this->Title(); ?></title>
		<meta charset="utf-8">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=5, viewport-fit=cover, user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="google" value="notranslate"/>
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="msapplication-starturl" content="/">
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
		<meta name="apple-mobile-web-app-status-bar-style" content="#0077d4">
		<meta name="theme-color" content="#0077d4">
		<link rel="mask-icon" sizes="any" href="<?php echo $this->GetImage('forward-fav-256.png') ?>" color="#0077d4">
		<link rel="icon" href="<?php echo $this->GetImage('forward-fav-192.png') ?>" sizes="192x192" />
		<link rel="icon" href="<?php echo $this->GetImage('forward-fav-64.png') ?>" sizes="64x64" />
		<link rel="icon" href="<?php echo $this->GetImage('forward-fav-32.png') ?>" sizes="32x32" />
		<link rel="apple-touch-icon-precomposed" href="<?php echo $this->GetImage('forward-fav-256.png') ?>">
		<link rel="shortcut icon" href="<?php echo $this->GetImage('forward-fav-256.png') ?>" type="image/x-icon">
		<meta name="msapplication-TileImage" content="<?php echo $this->GetImage('forward-fav-256.png') ?>" />
		<meta name="description" content="Forward is a link shortener created by RapidDev." />
		<link rel="canonical" href="<?php echo $this->baseurl; ?>" />
<?php foreach ($this->prefetch as $dns): ?>
		<link rel="dns-prefetch" href="<?php echo $dns; ?>" />
<?php endforeach ?>
<?php foreach ($this->styles as $style): ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $style[0] . (isset($style[2]) ? '?ver=' . $style[2] : ''); ?>" integrity="<?php echo $style[1]; ?>" crossorigin="anonymous" />
<?php endforeach ?>
		<meta name="twitter:card" content="summary">
		<meta property="og:title" content="Forward - Link shortener.">
		<meta property="og:site_name" content="Forward" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo $this->baseurl; ?>" />
		<meta http-equiv="Content-Security-Policy" content="base-uri <?php echo $this->baseurl; ?>; default-src <?php echo $this->baseurl; ?> <?php echo ($this->Forward->Path->ssl ? 'https://' : 'http://') ?>cdnjs.cloudflare.com <?php echo ($this->Forward->Path->ssl ? 'https://' : 'http://') ?>fonts.googleapis.com 'unsafe-inline'; child-src 'none'; font-src *.googleapis.com; img-src <?php echo $this->baseurl; ?> 'self' data:; script-src 'nonce-<?php echo $this->js_nonce; ?>' 'unsafe-inline' <?php echo $this->baseurl; ?> <?php echo ($this->Forward->Path->ssl ? 'https://' : 'http://') ?>*.cloudflare.com">
		<script type="application/ld+json" nonce="<?php echo $this->js_nonce; ?>">
			{"@context":"https://schema.org","@graph":[{"@type":"WebSite","@id":"<?php echo $this->baseurl; ?>#website","url":"<?php echo $this->baseurl; ?>","name":"Forward","description":"<?php $this->_e('Create your own link shortener'); ?>.","inLanguage":"pl-PL"},{"@type":"ImageObject","@id":"<?php echo $this->baseurl; ?>#primaryimage","inLanguage":"pl-PL","url":"<?php echo $this->GetImage('forward-fav-256.png') ?>","width":256,"height":256,"caption":"Forward"},{"@type":"WebPage","@id":"<?php echo $this->baseurl; ?>#webpage","url":"<?php echo $this->baseurl; ?>","name":"Forward - Link shortener","isPartOf":{"@id":"<?php echo $this->baseurl; ?>#website"},"primaryImageOfPage":{"@id":"<?php echo $this->baseurl; ?>#primaryimage"},"datePublished":"<?php echo date(DATE_ATOM); ?>","dateModified":"<?php echo date(DATE_ATOM); ?>","description":"<?php $this->_e('Create your own link shortener'); ?>.","inLanguage":"<?php echo $this->Forward->Translator->locale; ?>","potentialAction":[{"@type":"ReadAction","target":["<?php echo $this->baseurl; ?>"]}]}]}
		</script>
		<script type="text/javascript" nonce="<?php echo $this->js_nonce; ?>">
			let forward = {pagenow: '<?php echo $this->name; ?>', usernonce: '<?php echo $this->body_nonce; ?>', baseurl: '<?php echo $this->baseurl; ?>', version: '<?php echo FORWARD_VERSION; ?>', ajax: '<?php echo ($this->name != 'home' ? $this->AjaxGateway() : ''); ?>', getrecord: '<?php echo $this->AjaxNonce( 'get_record_data' ) ?>'};</script>
<?php if( $this->Forward->User->IsLoggedIn() && $this->name != 'home' ): ?>
		<script type="text/javascript" nonce="<?php echo $this->js_nonce; ?>">
			let visitor_data = {languages: {<?php $c = 0; foreach ($this->GetLanguages() as $key => $lang) {
				$c++;
				echo ($c > 1 ? ', ' : '') . $key . ': "' . $lang . '"';
			} ?>}, origins: {<?php $c = 0; foreach ($this->GetOrigins() as $key => $origin) {
				$c++;
				echo ($c > 1 ? ', ' : '') . $key . ': "' . $origin . '"';
			} ?>}, platforms: {<?php $c = 0; foreach ($this->GetPlatforms() as $key => $platform) {
				$c++;
				echo ($c > 1 ? ', ' : '') . $key . ': "' . $platform . '"';
			} ?>}, agents: {<?php $c = 0; foreach ($this->GetAgents() as $key => $agent) {
				$c++;
				echo ($c > 1 ? ', ' : '') . $key . ': "' . $agent . '"';
			} ?>}};
		</script>
<?php endif; ?>
<?php if( method_exists( $this, 'Header' ) ) { $this->Header(); } ?>
	</head>
	<body class="<?php echo 'page-' . $this->name; ?>">
		<section id="forward" style="height: 100%;">
