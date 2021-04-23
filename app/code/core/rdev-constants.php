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

/**
 *
 * Constants
 *
 * @author   Leszek Pomianowski <https://rdev.cc>
 * @license	MIT License
 * @access   public
 */
final class Constants
{
    public static $knownLanguages = array(
        'English (United States)' => array('en-us'),
        'English (United Kingdom)' => array('en-gb')
    );

    public static $knownOrigins = array(
        'Email / SMS / Direct' => array('direct'),
        'YouTube' => array('www.youtube.com', 'youtube.com'),
        'Facebook' => array('facebook.com', 'fb.com'),
        'Messenger' => array('l.messenger.com', 'messenger.com')
    );

    public static $forwardStyles = array(
        array('https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css', 'sha256-DU9iQBJ89dHP2iyusCg++0ych55DAx8QL6P8CYU64bI=', '5.0.0-beta3')
    );

    public static $forwardScripts = array(
        array('https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js', 'sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=', '3.6.0'),
        array('https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js', 'sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf', '5.0.0-beta3'),
        array('https://cdn.jsdelivr.net/npm/zxcvbn@4.4.2/dist/zxcvbn.js', 'sha256-9CxlH0BQastrZiSQ8zjdR6WVHTMSA5xKuP5QkEhPNRo=', '4.4.2'),
        array('https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js', 'sha256-DhdpoP64xch/Frz8CiBQE12en55NX+RhlPGRg6KWm5s=', '1.4.4'),
        array('https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js', 'sha256-Eb6SfNpZyLYBnrvqg4KFxb6vIRg+pLg9vU5Pv5QTzko=', '2.0.8'),
        array('https://cdn.jsdelivr.net/npm/jquery-tablesort@0.0.11/jquery.tablesort.min.js', 'sha256-2N0hMqOUWrnnwHS+QxWycq1c9kZO/+NHoJSziOI2DI4=', '0.0.11'),
        array('https://cdn.jsdelivr.net/npm/chart.js@3.1.1/dist/chart.min.js', 'sha256-lISRn4x2bHaafBiAb0H5C7mqJli7N0SH+vrapxjIz3k=', '3.1.1')
        //array('https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js', 'sha256-KSlsysqp7TXtFo/FHjb1T9b425x3hrvzjMWaJyKbpcI=', '3.6.0')
    );

    public static $backgrounds = array(
        array('Marcin Jóźwiak', 'Poznań, Poland', 'bg1_marcin-jozwiak'),
        array('Marcin Jóźwiak', 'Międzyzdroje, Poland', 'bg2_marcin-jozwiak'),
        array('Marcin Jóźwiak', 'Poznań, Poland', 'bg3_marcin-jozwiak'),
        array('Marcin Jóźwiak', 'Dziwnów, Poland', 'bg4_marcin-jozwiak'),
        array('Adam Borkowski', 'Warsaw, Poland', 'bg5_adam-borkowski'),
        array('Josh Hild', 'Zakopane, Poland', 'bg6_josh-hild')
    );
}
