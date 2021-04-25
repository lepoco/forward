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
                <h1><?php echo $this->_e('Links'); ?></h1>
                <span>List of saved links</span>
            </div>
        </div>
        <div class="col-12">
            <table id="records-list-table" class="table table-striped records-list-table sortable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><?php $this->_e('Active'); ?></th>
                        <th scope="col"><?php $this->_e('Name'); ?></th>
                        <th class="no-sort" scope="col"><?php $this->_e('Target'); ?></th>
                        <th class="no-sort" scope="col"><?php $this->_e('Description'); ?></th>
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
                            $html .= '<td scope="row" data-sort-value="' . $record['record_id'] . '">' . $record['record_id'] . '</td>';
                            $html .= '<td data-sort-value="' . $record['record_active'] . '">' . ($record['record_active'] == 1 ? $this->__('Yes') : $this->__('No')) . '</td>';
                            $html .= '<td>' . $record['record_display_name'] . '</td>';
                            $html .= '<td class="table-record-url">' . $record['record_url'] . '</td>';
                            $html .= '<td>' . (empty($record['record_description']) ? 'Empty' : $record['record_description']) . '</td>';
                            $html .= '<td data-sort-value="' . $record['record_clicks'] . '">' . $record['record_clicks'] . '</td>';
                            $html .= '<td data-sort-value="' . $record['record_author'] . '">' . $record['record_author'] . '</td>';
                            $html .= '<td data-sort-value="' . strtotime($record['record_updated']) . '">' . $record['record_updated'] . '</td>';
                            $html .= '<td data-sort-value="' . strtotime($record['record_created']) . '">' . $record['record_created'] . '</td>';
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