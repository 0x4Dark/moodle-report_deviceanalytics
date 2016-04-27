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

use phpbrowscap\Browscap;
class deviceanalytics_data_storage{

    private static $instance;

    public function __construct() {
        self::$instance = $this;
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function deviceanalytics_user_loggedin(){
        global $USER;
        global $DB;

        $pluginsetting = $DB->get_record('report_deviceanalytics', array(), '*');
        if ($pluginsetting->status == 0) {
            return 0;
        }
        if ($pluginsetting->adminlog == 0) {
            if($this->getUserSystemRole($USER->id) == 'admin'){
                return 0;
            }
        }

        // Standard Values
        $currentDeviceData = new deviceanalytics_data_object();
        if ($pluginsetting->anonymous == 0) {
            $currentDeviceData->userid = $USER->id;
        }
        $currentDeviceData->userhash = deviceanalytics_data_object::get_identify_hash($_SESSION['USER']);
        $alreadyexits = $DB->get_record_sql('SELECT * FROM {report_deviceanalytics_data} WHERE userhash = ?', array($currentDeviceData->userhash));

        if (!empty($alreadyexits) || is_null($alreadyexits)) {
           return 0;
        }

        $currentDeviceData->userrole = $this->getUserSystemRole($USER->id);
        $currentDeviceData->objectdate = time();
        $currentDeviceData->activemoodlelang = $USER->lang;

        // Device Values
        $browscap = new Browscap(dirname(__FILE__).'/cache/');
        $browscap->doAutoUpdate = false;
        $info = $browscap->getBrowser();

        $deviceType = $info->Device_Type;
        $currentDeviceData->devicetype = $deviceType;
        $currentDeviceData->devicebrand = $info->Parent;
        $currentDeviceData->devicesystem = $info->Platform;
        $currentDeviceData->devicebrowser = $info->Browser;
        $currentDeviceData->devicebrowser_version = $info->Version;
        $currentDeviceData->devicepointing_method = $info->Device_Pointing_Method;

        $insertid = $DB->insert_record('report_deviceanalytics_data', $currentDeviceData, true);
           
        return $insertid;
    }

    public function report_deviceanalytics_update_screensize(
        $insertid,
        $devicedisplaysizex, 
        $devicedisplaysizey, 
        $devicewindowsizex, 
        $devicewindowsizey) {
        global $DB;
        $recordwithout = $DB->get_record('report_deviceanalytics_data', array('id' => $insertid), '*');
        $recordwithout->devicedisplaysizex = $devicedisplaysizex;
        $recordwithout->devicedisplaysizey = $devicedisplaysizey;
        $recordwithout->devicewindowsizex = $devicewindowsizex;
        $recordwithout->devicewindowsizey = $devicewindowsizey;

        $DB->update_record('report_deviceanalytics_data', $recordwithout);
    }

    private function getUserSystemRole($userid){
        // TODO - more specific
        if (is_siteadmin($userid)) {
           return "admin";
        }
        else {
            return "user";
        }
    }
}