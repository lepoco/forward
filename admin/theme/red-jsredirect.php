<?php
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2020, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	namespace Forward;
	defined('ABSPATH') or die('No script kiddies please!');
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo self::title(); ?></title>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $this->VIEW_DATA['gtag']; ?>"></script>

	<meta charset="utf-8">
	<meta name="robots" content="noindex">
	<meta name="googlebot" content="noindex">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Forward is a link shortener created by RapidDev" />
	<meta name="mobile-web-app-capable" content="no">
	<meta name="apple-mobile-web-app-capable" content="no">
	<meta name="msapplication-starturl" content="/">
	<meta name="msapplication-TileImage" content="<?php echo self::media_url(); ?>/img/forward-fav.png" />
	<link rel="icon" href="<?php echo self::media_url(); ?>/img/forward-fav.png" sizes="192x192" />
	<link rel="apple-touch-icon-precomposed" href="<?php echo self::media_url(); ?>/img/forward-fav.png" />
	<meta name="apple-mobile-web-app-status-bar-style" content="#343a40">
	<meta name="theme-color" content="#343a40">
	<meta name="msapplication-navbutton-color" content="#343a40">
	<style>html {max-width: 100%;margin:0;background: #343a40;}body{margin:0;padding: 25px;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-size:1rem;font-weight:400;line-height:1.5;color:#fff;}h1, p {margin: 0;padding: 0;}a {color: #fff;}</style>
</head>
<body>
	<canvas id="noise" style="z-index:100;position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;opacity:.05;"></canvas>
	<h1><?php echo self::title(); ?></h1>
	<p><?php echo $this->e('You will be redirected in a few seconds...'); ?></p>
	<br>
	<a href="<?php echo $this->VIEW_DATA['url']; ?>"><?php echo $this->VIEW_DATA['url']; ?></a>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag("js", new Date());
		gtag("config", "<?php echo $this->VIEW_DATA['gtag']; ?>");

		const noise = () => {let canvas, ctx;let wWidth, wHeight;let noiseData = [];let frame = 0;let loopTimeout;const createNoise = () => {const idata = ctx.createImageData(wWidth, wHeight);const buffer32 = new Uint32Array(idata.data.buffer);const len = buffer32.length;for (let i = 0; i < len; i++) {if (Math.random() < 0.5) {buffer32[i] = 0xff000000;}}noiseData.push(idata);};const paintNoise = () => {if (frame === 9) {frame = 0;} else {frame++;}ctx.putImageData(noiseData[frame], 0, 0);};const loop = () => {paintNoise(frame);loopTimeout = window.setTimeout(() => {window.requestAnimationFrame(loop);}, (1000 / 25));};const setup = () => {wWidth = window.innerWidth;wHeight = window.innerHeight;canvas.width = wWidth;canvas.height = wHeight;for (let i = 0; i < 10; i++) {createNoise();}loop();};let resizeThrottle;const reset = () => {window.addEventListener('resize', () => {window.clearTimeout(resizeThrottle);resizeThrottle = window.setTimeout(() => {window.clearTimeout(loopTimeout);setup();}, 200);}, false);};const init = (() => {canvas = document.getElementById('noise');ctx = canvas.getContext('2d');setup();})();};noise();
	</script>
	<script defer="defer">
		window.onload=function()
		{
			setTimeout(function()
			{
				window.location.replace("<?php echo $this->VIEW_DATA['url']; ?>");
			},
			<?php echo $this->RED->DB['options']->get('js_redirect_after')->value ?>);
		};
	</script>
</body>
</html>