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
 * @package    report_deviceanalytics
 * @copyright  2016 Mark Heumueller <mark.heumueller@gmx.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class which holds all saveable data
  *
 * @package    report_deviceanalytics
 * @copyright  2016 Mark Heumueller <mark.heumueller@gmx.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class deviceanalytics_data_object{

    /**
     * @var ID of the user $userid
     */
    public $userid;

    /**
     * @var "userrole" check if is admin $userrole
     */
    public $userrole;

    /**
     * @var currenttime in timestamp $objectdata
     */
    public $objectdate;

    /**
     * @var user used moodlelang $activemoodlelang
     */
    public $activemoodlelang;

    /**
     * @var created hash $userhash
     */
    public $userhash;

    /**
     * @var type of device $devicetype
     */
    public $devicetype;

    /**
     * @var operating system $devicesystem
     */
    public $devicesystem;

    /**
     * @var current used browser $devicebrowser
     */
    public $devicebrowser;

    /**
     * @var version of used browser $devicebrowserversion
     */
    public $devicebrowserversion;

    /**
     * @var width of devicescreen $devicedisplaysizex
     */
    public $devicedisplaysizex;

    /**
     * @var height of devicescreen $devicedisplaysizey
     */
    public $devicedisplaysizey;

    /**
     * @var width of browser $devicewindowsizex
     */
    public $devicewindowsizex;

    /**
     * @var height of browser $devicewindowsizey
     */
    public $devicewindowsizey;

    /**
     * @var interation method $devicepointingmethod
     */
    public $devicepointingmethod;

    /**
     * @var http user agent $httpuserag
     */
    public $httpuserag;

    /**
     * @var is ssl used $httpssl
     */
    public $httpssl;

    /**
     * @var http active lang $httpacclang
     */
    public $httpacclang;

    /**
     * Construct for object
     */
    public function __construct() {
        $this->httpuserag = htmlentities($_SERVER['HTTP_USER_AGENT']);
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $this->httpssl = $_SERVER['HTTPS'];
        } else {
            $this->httpssl = 'off';
        }
        $this->httpacclang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }
    /**
     * Creating a hash based on userrsession - used for anonymization
     * @param moodle_session $usersession
     * @return String hash
     */
    public static function get_identify_hash($usersession) {
        $usersession = $usersession->sesskey;
        $salt = sha1(md5($usersession));
        return $anonymoushash = md5($usersession.$salt);
    }

    /**
     * Debug function
     * @deprecated
     */
    public function _data_object_debug() {
        var_dump(get_object_vars($this));
    }
}