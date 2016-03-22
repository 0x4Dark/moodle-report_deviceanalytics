<?php
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

		public function deviceanalytics_user_loggedin(
			$device_display_size_x, 
			$device_display_size_y, 
			$device_window_size_x, 
			$device_window_size_y){
			
			global $USER;
			global $DB;

			//Standard Values
			$currentDeviceData = new deviceanalytics_data_object();
			$currentDeviceData->user_id = $USER->id;
			$currentDeviceData->user_hash = deviceanalytics_data_object::get_identify_hash($_SESSION['USER']);
			$currentDeviceData->user_role = $this->getUserSystemRole($USER->id);
			$currentDeviceData->object_date = time();
			$currentDeviceData->active_moodle_lang = $USER->lang;

			//Device Values
			$browscap = new Browscap(dirname(__FILE__).'/cache/');
			$browscap->doAutoUpdate = false;
			$info = $browscap->getBrowser();

			$deviceType = $info->Device_Type;
			$currentDeviceData->device_type = $deviceType;
			$currentDeviceData->device_brand = $info->Parent;
			$currentDeviceData->device_system = $info->Platform;
			$currentDeviceData->device_browser = $info->Browser;
			$currentDeviceData->device_browser_version = $info->Version;
			$currentDeviceData->device_pointing_method = $info->Device_Pointing_Method;

			//Screen Values
			$currentDeviceData->device_display_size_x = $device_display_size_x;
			$currentDeviceData->device_display_size_y = $device_display_size_y;
			$currentDeviceData->device_window_size_x = $device_window_size_x;
			$currentDeviceData->device_window_size_y = $device_window_size_y;

			//DEBUG
			if (strcmp(ini_get('display_errors'), 'On') == 0) {
				$currentDeviceData->_data_object_debug();
			}
		}

		private function getUserSystemRole($userid){
			//TODO - more specific
			if (is_siteadmin($userid)) {
				return "admin";
			}
			else{
				return "user";
			}
		}
	}