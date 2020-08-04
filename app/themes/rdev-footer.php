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
		</section>
	<?php foreach ($this->scripts as $script): ?>
	<script type="text/javascript" src="<?php echo $script[0] . (isset($script[2]) ? '?ver=' . $script[2] : '') ?>" integrity="<?php echo $script[1]; ?>" crossorigin="anonymous"></script>
	<?php endforeach ?>
<?php if( method_exists( $this, 'Footer' ) ) { $this->Footer(); } ?>
</body>
</html>
