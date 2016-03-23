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
$string['pluginname'] = 'Geräte Analytik';
//DASHBOARD
$string['dashboard_name'] = 'Übersicht';
$string['dashboard_nojs_error_message'] = 'Die Übersicht Grafiken funktionieren nur, wenn Javascript aktiviert ist';
$string['dashboard_title'] = $string['pluginname'].' Übersicht'; 
$string['dashboard_chart_device_types'] = 'Geräte Typen';
$string['dashboard_chart_device_types_title'] = 'Verteilung von Geräte Typen';
$string['dashboard_chart_device_systems'] = 'Betriebssysteme';
$string['dashboard_chart_device_systems_title'] = 'Geräte Betriebssysteme';
$string['dashboard_chart_device_browser'] = 'Browser';
$string['dashboard_chart_device_browser_title'] = 'Geräte Browser';
$string['dashboard_chart_device_browser_version'] = 'Browser Version';
$string['dashboard_chart_screen_sizes'] = 'Bildschirmauflösung';
$string['dashboard_chart_screen_sizes_title'] = 'meist genutzte Bildschirmauflösung';
$string['dashboard_chart_window_sizes'] = 'Fenstergröße';
$string['dashboard_chart_window_sizes_title'] = 'meist genutzte Fenstergröße';
$string['dashboard_chart_pointing_method'] = 'Eingabemethode';
$string['dashboard_chart_pointing_method_title'] = 'Geräte Interaktionsmethode';
//SETTINGS
$string['settings_name'] = 'Einstellungen';
$string['settings_title'] = $string['pluginname'].' Einstellungen';
$string['settings_starttime'] = 'Startzeit';
$string['settings_status'] = 'Aktiv';
$string['settings_anonymous'] = 'Anonymisiert';
$string['settings_anonymous_description'] = 'ob Nutzerdaten zuortbar seien sollen';
$string['settings_admin_log'] = 'Admin Log';
$string['settings_cancelled'] = 'Es wurde nichts verändert!';
$string['settings_updated'] = 'Einstellungen wurden erfolgreich aktualisiert!';