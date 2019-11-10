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
?>
<div id="red-about">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-3">
				<picture id="forward-logo">
					<source srcset="<?php echo $this->home_url().RED_MEDIA; ?>/img/forward-logo-bk.webp" type="image/webp">
					<source srcset="<?php echo $this->home_url().RED_MEDIA; ?>/img/forward-logo-bk.jpeg" type="image/jpeg">
					<img alt="This is my face" src="<?php echo $this->home_url().RED_MEDIA; ?>/img/forward-logo-bk.jpeg">
				</picture>
				<hr>
				<h2 class="display-4" style="font-size: 31px;margin: 0;">Forward</h2>
				<p><small><i>version <?php echo RED_VERSION; ?></i></small></p>
			</div>
			<div class="col-12 col-md-9">
				<p>
					Forward is a content management system created to shorten links and collect analytics.
					<br>
					It is available under the MIT license.
				</p>
				<span>The project is available on GitHub</span>
				<div id="github-about">
					<a href="https://github.com/rapiddev/forward" target="_blank" rel="noopener">
						<svg style="width:18px;height:18px" fill="#000" viewBox="0 0 24 24"><path d="M12,2A10,10 0 0,0 2,12C2,16.42 4.87,20.17 8.84,21.5C9.34,21.58 9.5,21.27 9.5,21C9.5,20.77 9.5,20.14 9.5,19.31C6.73,19.91 6.14,17.97 6.14,17.97C5.68,16.81 5.03,16.5 5.03,16.5C4.12,15.88 5.1,15.9 5.1,15.9C6.1,15.97 6.63,16.93 6.63,16.93C7.5,18.45 8.97,18 9.54,17.76C9.63,17.11 9.89,16.67 10.17,16.42C7.95,16.17 5.62,15.31 5.62,11.5C5.62,10.39 6,9.5 6.65,8.79C6.55,8.54 6.2,7.5 6.75,6.15C6.75,6.15 7.59,5.88 9.5,7.17C10.29,6.95 11.15,6.84 12,6.84C12.85,6.84 13.71,6.95 14.5,7.17C16.41,5.88 17.25,6.15 17.25,6.15C17.8,7.5 17.45,8.54 17.35,8.79C18,9.5 18.38,10.39 18.38,11.5C18.38,15.32 16.04,16.16 13.81,16.41C14.17,16.72 14.5,17.33 14.5,18.26C14.5,19.6 14.5,20.68 14.5,21C14.5,21.27 14.66,21.59 15.17,21.5C19.14,20.16 22,16.42 22,12A10,10 0 0,0 12,2Z" /></svg>
						<p>Create your own link shortener</p>
					</a>
				</div>
				<hr>
				<h4>Used technologies & things</h1>
					<ul class="list-unstyled">
						<li><i>Filebase</i> by the Timothy Marois<br><a href="https://github.com/tmarois/Filebase">https://github.com/tmarois/Filebase</a><br><small>Filebase is open-sourced software licensed under the MIT license.</small></li>
						<li><i>Chartist.js</i> by the Gion Kunz<br><a href="https://github.com/gionkunz/chartist-js">https://github.com/gionkunz/chartist-js</a><br><small>Chartist.js is open-sourced software licensed under the DO WHAT THE FUCK YOU WANT TO PUBLIC and MIT license.</small></li>
						<li><i>Bootstrap</i> by the Bootstrap team<br><a href="https://getbootstrap.com/">https://getbootstrap.com/</a><br><small>Bootstrap is open-sourced software licensed under the MIT license.</small></li>
						<li><i>jQuery</i> by the jQuery Foundation<br><a href="https://jquery.org/">https://jquery.org/</a><br><small>jQuery is open-sourced software licensed under the MIT license.</small></li>
						<li><i>Clipboard.js</i> by the Zeno Rocha<br><a href="https://github.com/zenorocha/clipboard.js/">https://github.com/zenorocha/clipboard.js/</a><br><small>Clipboard.js is open-sourced software licensed under the MIT license.</small></li>
						<li><i>Material Design Icons</i> by the Google and other creators | Maintained by Austin Andrews<br><a href="https://materialdesignicons.com/">https://materialdesignicons.com/</a><br><small>Material Design Icons is open-sourced software licensed under the Apache License 2.0.</small></li>
						<li><i>Picture of mountains</i> by the Joyston Judah<br><a href="https://www.pexels.com/@joyston-judah-331625">https://www.pexels.com/@joyston-judah-331625</a><br><small>Photos from the Pexels portal support the idea of open source.</small></li>
						<li><i>Questrial font</i> by the Joe Prince<br><a href="https://fonts.google.com/specimen/Questrial">https://fonts.google.com/specimen/Questrial</a><br><small>Filebase is open-sourced font licensed under the Open Font License.</small></li>
					</ul>
				<hr>
				<p>
					<button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#collapseLicense" aria-expanded="false" aria-controls="collapseLicense">
						License
					</button>
				</p>
				<div class="collapse" id="collapseLicense">
					<div class="card card-body">
						<small>
							Copyright (c) 2019 RapidDev
							<br>
							Leszek Pomianowski
							<br>
							https://rdev.cc/
							<br><br>
							Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
							<br><br>
							The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
							<br><br>
							THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
						</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->footer(); ?>