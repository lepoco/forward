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
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="content__title">
                <h1><?php echo $this->GetHeaderTitle(); ?></h1>
                <span>Application users</span>
            </div>
        </div>
        <div class="col-12">

        </div>
    </div>
</div>
<?php
$this->GetFooter();
?>