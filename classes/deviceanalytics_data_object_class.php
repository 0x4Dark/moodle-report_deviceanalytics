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

class deviceanalytics_data_object{
    public $userid, $userhash, $userrole, $objectdate, $activemoodlelang;
    public $devicetype, $device_system, $devicebrowser, $devicebrowserversion, 
    $devicedisplaysizex, $devicedisplaysizey, $devicewindowsizex, 
    $devicewindowsizey, $devicepointingmethod;
    public $httpuserag, $httpssl, $httpacclang;
    
    public function __construct() {
        $this->httpuserag = htmlentities($_SERVER['HTTP_USER_AGENT']);
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $this->httpssl = $_SERVER['HTTPS'];
        }
        else {
            $this->httpssl = 'off';
        }
        $this->httpacclang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }
    public static function get_identify_hash($user_session){
        $usersession = $usersession->sesskey;
        $salt = sha1(md5($usersession));
        return $anonymoushash = md5($usersession.$salt);
    }

    public function _data_object_debug(){
        var_dump(get_object_vars($this));
    }
}