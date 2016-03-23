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

		public function deviceanalytics_user_loggedin(){
			global $USER;
			global $DB;

			$pluginsetting = $DB->get_record('tool_deviceanalytics_data', array(), '*');
			if($pluginsetting->status == 0){
				return 0;
			}
			if($pluginsetting->admin_log == 0){
				if($this->getUserSystemRole($USER->id) == 'admin'){
					return 0;
				}
			}

			//Standard Values
			$currentDeviceData = new deviceanalytics_data_object();
			if($pluginsetting->anonymous == 0){
				$currentDeviceData->user_id = $USER->id;
			}
			$currentDeviceData->user_hash = deviceanalytics_data_object::get_identify_hash($_SESSION['USER']);

			$alreadyexits = $DB->get_record_sql('SELECT * FROM {tool_deviceanalytics_data} WHERE user_hash = ?', array($currentDeviceData->user_hash));

			if(!empty($alreadyexits) || is_null($alreadyexits)){
				return 0;
			}

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

			$insert_id = $DB->insert_record('tool_deviceanalytics_data', $currentDeviceData, true);
			
			return $insert_id;
		}

		public function tool_deviceanalytics_update_screensize(
			$insert_id,
			$device_display_size_x, 
			$device_display_size_y, 
			$device_window_size_x, 
			$device_window_size_y){

			global $DB;
			$record_without = $DB->get_record('tool_deviceanalytics_data', array('id' => $insert_id), '*');
			$record_without->device_display_size_x = $device_display_size_x;
			$record_without->device_display_size_y = $device_display_size_y;
			$record_without->device_window_size_x = $device_window_size_x;
			$record_without->device_window_size_y = $device_window_size_y;

			$DB->update_record('tool_deviceanalytics_data', $record_without);
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