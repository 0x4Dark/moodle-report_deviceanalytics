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

defined('MOODLE_INTERNAL') || die();
 
//GLOBAL
$string['pluginname'] = 'Device Analytics';
//DASHBOARD
$string['dashboard_name'] = 'Dashboard';
$string['dashboard_nojs_error_message'] = 'Dashboard Charts only works if Javascript is enabled';
$string['dashboard_title'] = $string['pluginname'].' Dashboard'; 
$string['dashboard_chart_device_types'] = 'Device Types';
$string['dashboard_chart_device_types_title'] = 'device type distributions';
$string['dashboard_chart_device_systems'] = 'Operating Systems';
$string['dashboard_chart_device_systems_title'] = 'device os';
$string['dashboard_chart_device_browser'] = 'Browser';
$string['dashboard_chart_device_browser_title'] = 'device browsers';
$string['dashboard_chart_device_browser_version'] = 'browser version';
$string['dashboard_chart_screen_sizes'] = 'Screen Sizes';
$string['dashboard_chart_screen_sizes_title'] = 'most common user screen solutions';
$string['dashboard_chart_window_sizes'] = 'Window Sizes';
$string['dashboard_chart_window_sizes_title'] = 'most common user window solutions';
$string['dashboard_chart_pointing_method'] = 'Device Pointing Methode';
$string['dashboard_chart_pointing_method_title'] = 'device interactive input methode';
//SETTINGS
$string['settings_name'] = 'Settings';
$string['settings_title'] = $string['pluginname'].' Settings';
$string['settings_starttime'] = 'Starttime';
$string['settings_status'] = 'Active';
$string['settings_anonymous'] = 'Anonymize';
$string['settings_anonymous_description'] = 'If the user data will be stored anonymously';
$string['settings_admin_log'] = 'Admin Log';
$string['settings_cancelled'] = 'Nothing was changed!';
$string['settings_updated'] = 'Settings was updated successfully!';