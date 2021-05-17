<?php

/**
 * @package   Forward
 *
 * @author    RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link      https://www.rdev.cc/forward
 * @license   https://opensource.org/licenses/MIT
 */

namespace Forward\Views\Components;

defined('ABSPATH') or die('No script kiddies please!');
?>
<?php if ($this->Forward->User->isLoggedIn() && $this->name != 'home') : ?>
<?php endif; ?>
</div>
</div>
<div class="snackbar">
	<div id="global-snackbar" class="info snackbar__body">
		<div style="width: 100%;display:flex;align-items: center;justify-content: space-between;">
			<div>
				<h2 id="global-snackbar-header" class="snackbar__body__header"></h2>
				<p id="global-snackbar-message" class="snackbar__body__message"></p>
			</div>
			<button id="global-snackbar-dismiss" class="btn btn-sm" type="button">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
					<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
				</svg>
			</button>
		</div>
	</div>
</div>
<div class="root-toast-container">
	<div id="global-toast-container" class="toast-container"></div>
</div>
<?php foreach ($this->scripts as $script) : ?>
	<script type="<?php echo (isset($script[3]) && $script[3] == 'module' ? 'module' : 'text/javascript'); ?>" src="<?php echo $script[0] . (isset($script[2]) ? '?ver=' . $script[2] : '') ?>" <?php echo (!empty($script[1]) ? 'integrity="' . $script[1] . '" ' : ''); ?>crossorigin="anonymous"></script>
<?php endforeach ?>
<?php if (method_exists($this, 'footer')) {
	$this->footer();
} ?>
</body>

</html>