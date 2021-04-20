<?php

/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019-2021, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */

namespace Forward;

defined('ABSPATH') or die('No script kiddies please!');
?>
<?php if ($this->Forward->User->IsLoggedIn() && $this->name != 'home') : ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 no-gutters">
				<div class="content__snackbar">
					<div id="global-snackbar" class="info content__snackbar__body">
						<div>
							<h2>Message</h2>
							<p>Content</p>
						</div>
						<button class="btn btn-sm" type="button">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
								<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
							</svg>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
</div>
</div>
<?php foreach ($this->scripts as $script) : ?>
	<script type="text/javascript" src="<?php echo $script[0] . (isset($script[2]) ? '?ver=' . $script[2] : '') ?>" <?php echo (!empty($script[1]) ? ' integrity="' . $script[1] . '"' : ''); ?> crossorigin="anonymous"></script>
<?php endforeach ?>
<?php if (method_exists($this, 'Footer')) {
	$this->Footer();
} ?>
</body>

</html>