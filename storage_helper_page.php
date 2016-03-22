<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Defines the version and other meta-info about the plugin
 *
 * Setting the $plugin->version to 0 prevents the plugin from being installed.
 * See https://docs.moodle.org/dev/version.php for more info.
 *
 * @package    tool_deviceanalytics
 * @copyright  2016 Mark Heumueller <mark.heumueller@gmx.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('lib.php');
require_login();
if ((isset($_SERVER['HTTPS'])) and ('on' == $_SERVER['HTTPS'])) {
    $CFG->httpswwwroot = 'https://'.$_SERVER['HTTP_HOST'];
} else {
    $CFG->httpwwwroot = 'http://'.$_SERVER['HTTP_HOST'];
}
$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);
$PAGE->set_url('/admin/tool/deviceanalytics/storage_helper_page.php');
$PAGE->set_pagelayout('redirect');
$PAGE->requires->css('/admin/tool/deviceanalytics/css/storage_helper_page_css.css');
$PAGE->requires->jquery();
$PAGE->requires->js('/admin/tool/deviceanalytics/storage_helper_function.js');
echo $OUTPUT->header();
echo $OUTPUT->footer();