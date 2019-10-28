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

	$footer_media = $this->home_url().RED_MEDIA;
?>
</section>
<script src="<?php echo $footer_media; ?>/js/jquery-3.4.1.js" crossorigin="anonymous"></script>
<script src="<?php echo $footer_media; ?>/js/popper.min.js"></script>
<script src="<?php echo $footer_media; ?>/js/bootstrap.min.js"></script>
<?php if (RED_PAGE == '_forward_dashboard'): ?>
<script src="<?php echo $footer_media; ?>/js/chartist.min.js"></script>
<?php endif ?>
</body>
</html>