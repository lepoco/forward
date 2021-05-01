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

$this->GetHeader();
$this->GetNavigation();
?>
<div class="container-fluid" style="margin-bottom:2.2rem;">
    <div class="row">
        <div class="col-12">
            <div class="content__title">
                <h1>JSON API</h1>
                <span>Access to data via other services</span>
            </div>
        </div>
        <div class="col-12" style="margin-top: 1rem;">
            <a href="<?php echo $this->baseurl . $this->Forward->Options->Get('dashboard', 'dashboard') . '/api/add/'; ?>" class="btn-forward"><?php $this->_e('Add new token'); ?></a>
        </div>
    </div>
</div>
<?php
$this->GetFooter();
?>