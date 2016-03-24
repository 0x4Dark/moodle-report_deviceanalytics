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
 * @package    report_deviceanalytics
 * @copyright  2016 Mark Heumueller <mark.heumueller@gmx.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*LOADING MOODLE*/
require_once(dirname(__FILE__).'/../../config.php');

/*DEBUG*/
error_reporting(E_ALL);
ini_set('display_errors', 'On');

/*GLOBAL REQUIREMENTS*/
global $CFG;
global $PAGE;
global $OUTPUT;
global $DB;
global $USER;
global $ADMIN;

/*HELPER*/
$time_format = 'd-m-Y G:i:s';

/*TABLE*/
$db_tables = array();
$db_tables['deviceanalytics'] = 'report_deviceanalytics';
$db_tables['deviceanalytics_data'] = 'report_deviceanalytics_data';
$db_tables['deviceanalytics_settings'] = 'report_deviceanalytics_settings';

/*EXTERN LIBS*/
require_once('libs/Browscap.php');

/*INCLUDES*/
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/formslib.php');
require_once('admin/settings_form.php');

include_once('redirector.php');
include_once('classes/deviceanalytics_data_storage_class.php');
include_once('classes/deviceanalytics_data_object_class.php');
require_once('locallib.php');
