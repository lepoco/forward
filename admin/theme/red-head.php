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
	<meta name="msapplication-TileImage" content="<?php echo self::media_url(); ?>/img/forward-fav.png" />
	<link rel="icon" href="<?php echo self::media_url(); ?>/img/forward-fav.png" sizes="192x192" />
	<link rel="apple-touch-icon-precomposed" href="<?php echo self::media_url(); ?>/img/forward-fav.png" />
	<?php self::queue_styles(); ?>
	<title><?php echo self::title(); ?></title>
	<style>
		body {
			font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
		}
	</style>
</head>
<body>
<section id="forward">
