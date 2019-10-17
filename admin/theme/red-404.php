<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	$this->head(); ?>
	<section id="404" style="position: relative;display: flex;align-items: center;justify-content: center;flex-flow: column;height:100%;width:100%;min-height: 100vh;background: #555;text-align: center;">
		<canvas id="noise" style="z-index:100;position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;opacity:.05;"></canvas>
		<h1 style="font-size: 150px;color:#fff;" class="glitch-title" data-content="404!">404!</h1>
		<h2 style="font-size: 20px;color:#fff;">This should not happen</h2>
	</section>
	<script>
		const noise = () => {let canvas, ctx;let wWidth, wHeight;let noiseData = [];let frame = 0;let loopTimeout;const createNoise = () => {const idata = ctx.createImageData(wWidth, wHeight);const buffer32 = new Uint32Array(idata.data.buffer);const len = buffer32.length;for (let i = 0; i < len; i++) {if (Math.random() < 0.5) {buffer32[i] = 0xff000000;}}noiseData.push(idata);};const paintNoise = () => {if (frame === 9) {frame = 0;} else {frame++;}ctx.putImageData(noiseData[frame], 0, 0);};const loop = () => {paintNoise(frame);loopTimeout = window.setTimeout(() => {window.requestAnimationFrame(loop);}, (1000 / 25));};const setup = () => {wWidth = window.innerWidth;wHeight = window.innerHeight;canvas.width = wWidth;canvas.height = wHeight;for (let i = 0; i < 10; i++) {createNoise();}loop();};let resizeThrottle;const reset = () => {window.addEventListener('resize', () => {window.clearTimeout(resizeThrottle);resizeThrottle = window.setTimeout(() => {window.clearTimeout(loopTimeout);setup();}, 200);}, false);};const init = (() => {canvas = document.getElementById('noise');ctx = canvas.getContext('2d');setup();})();};noise();
	</script>
<?php $this->footer(); ?>