<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

namespace Forward\Views;

defined('ABSPATH') or die('No script kiddies please!');

$this->getHeader();
?>
<section class="splash">
	<div class="splash__background">
		<picture>
			<?php $selectedBackground = $this->getBackgrounds(); ?>
			<source srcset="<?php echo $this->getImage($selectedBackground[2] . '.webp'); ?>" type="image/webp">
			<source srcset="<?php echo $this->getImage($selectedBackground[2] . '.jpeg'); ?>" type="image/jpeg">
			<img alt="Forward big background image" src="<?php echo $this->getImage($selectedBackground[2] . '.jpeg'); ?>">
		</picture>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-6" style="display: flex;align-items: center;">
				<picture class="splash__logo">
					<source srcset="<?php echo $this->getImage('forward-logo-wt.webp'); ?>" type="image/webp">
					<source srcset="<?php echo $this->getImage('forward-logo-wt.jpeg'); ?>" type="image/jpeg">
					<img alt="Forward logo" src="<?php echo $this->getImage('forward-logo-wt.jpeg'); ?>">
				</picture>
			</div>
			<div class="col-12 col-lg-6">
				<div class="splash__card">
					<div class="splash__card__body">
						<h1>Forward</h1>
						<h2><?php echo $this->_e('Short links manager'); ?></h2>
						<a href="https://github.com/rapiddev/forward" target="_blank" rel="noopener" class="btn-forward block">
							<svg style="width:18px;height:18px;margin-right:8px;" fill="currentColor" viewBox="0 0 24 24">
								<path d="M12,2A10,10 0 0,0 2,12C2,16.42 4.87,20.17 8.84,21.5C9.34,21.58 9.5,21.27 9.5,21C9.5,20.77 9.5,20.14 9.5,19.31C6.73,19.91 6.14,17.97 6.14,17.97C5.68,16.81 5.03,16.5 5.03,16.5C4.12,15.88 5.1,15.9 5.1,15.9C6.1,15.97 6.63,16.93 6.63,16.93C7.5,18.45 8.97,18 9.54,17.76C9.63,17.11 9.89,16.67 10.17,16.42C7.95,16.17 5.62,15.31 5.62,11.5C5.62,10.39 6,9.5 6.65,8.79C6.55,8.54 6.2,7.5 6.75,6.15C6.75,6.15 7.59,5.88 9.5,7.17C10.29,6.95 11.15,6.84 12,6.84C12.85,6.84 13.71,6.95 14.5,7.17C16.41,5.88 17.25,6.15 17.25,6.15C17.8,7.5 17.45,8.54 17.35,8.79C18,9.5 18.38,10.39 18.38,11.5C18.38,15.32 16.04,16.16 13.81,16.41C14.17,16.72 14.5,17.33 14.5,18.26C14.5,19.6 14.5,20.68 14.5,21C14.5,21.27 14.66,21.59 15.17,21.5C19.14,20.16 22,16.42 22,12A10,10 0 0,0 12,2Z" />
							</svg>
							<p>Forward | <?php echo $this->description(); ?></p>
						</a>
						<small><?php echo $this->_e('Access to the site requires administrator privileges'); ?></small>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="splash__footer">
		Copyright © 2019-<?php echo date('Y'); ?> Leszek Pomianowski | MIT License
		<br>
		<?php $this->_e('Background image'); ?>: <i><?php echo $selectedBackground[1] . ' ' . $this->__('created by') . ' ' . $selectedBackground[0]; ?></i>
		<br>
		<?php $this->_e('Logo font'); ?>: Questrial by <i>Joe Prince</i>
	</div>
</section>
<div>
	<div>
		<?php
		$this->getFooter();
		?>