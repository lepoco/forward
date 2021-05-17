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
$this->getNavigation();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="content__title">
				<h1><?php $this->_e('Statistics'); ?></h1>
				<span>Aggregate information about your links</span>
			</div>
		</div>
		<div class="col-12 col-lg-4">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('Visits today'); ?></span>
					<h3><?php echo $this->visitsToday(); ?></h3>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-4">
			<div class="content__card">
				<div class="content__card__body">
					<span class="content__card__header"><?php echo $this->_e('AJAX Queries today'); ?></span>
					<h3><?php echo $this->queriesToday(); ?></h3>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$this->getFooter();
?>