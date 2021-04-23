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
                <h1><?php echo $this->_e('Records'); ?></h1>
                <span>List of saved links</span>
            </div>
        </div>
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ACT</th>
                        <th scope="col"><?php $this->_e('Name'); ?></th>
                        <th scope="col"><?php $this->_e('Description'); ?></th>
                        <th scope="col"><?php $this->_e('Target'); ?></th>
                        <th scope="col"><?php $this->_e('Clicks'); ?></th>
                        <th scope="col"><?php $this->_e('Author'); ?></th>
                        <th scope="col"><?php $this->_e('Modified'); ?></th>
                        <th scope="col"><?php $this->_e('Created'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $this->Forward->Database->query("SELECT * FROM forward_records WHERE record_active = true ORDER BY record_id DESC")->fetchAll();

                    if (!empty($query)) {
                        foreach ($query as $record) {
                            $html = '<tr>';
                            $html .= '<th scope="row">' . $record['record_id'] . '</td>';
                            $html .= '<td>' . $record['record_active'] . '</td>';
                            $html .= '<td>' . $record['record_display_name'] . '</td>';
                            $html .= '<td>' . $record['record_description'] . '</td>';
                            $html .= '<td class="table-record-url">' . $record['record_url'] . '</td>';
                            $html .= '<td>' . $record['record_clicks'] . '</td>';
                            $html .= '<td>' . $record['record_author'] . '</td>';
                            $html .= '<td>' . $record['record_updated'] . '</td>';
                            $html .= '<td>' . $record['record_created'] . '</td>';
                            echo $html . '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$this->GetFooter();
?>