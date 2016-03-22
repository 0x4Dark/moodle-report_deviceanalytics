<?php
	class deviceanalytics_data_object{

		public $user_id, $user_hash, $user_role, $object_date, $active_moodle_lang;
		public $device_type, $device_system, $device_browser, $device_browser_version, $device_display_size_x, $device_display_size_y, $device_window_size_x, $device_window_size_y, $device_pointing_method;
		public $http_user_ag, $http_ssl, $http_acc_lang;

		public function __construct() {
	        $this->http_user_ag = htmlentities($_SERVER['HTTP_USER_AGENT']);
	        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
	        	$this->http_ssl = $_SERVER['HTTPS'];
	        else
	        	$this->http_ssl = 'off';
	        $this->http_acc_lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	    }

	    public static function get_identify_hash($user_session){
	    	$user_session = $user_session->sesskey;
	    	$salt = sha1(md5($user_session));
			return $anonymous_hash = md5($user_session.$salt);
		}

	    public function _data_object_debug(){
	    	var_dump(get_object_vars($this));
	    }

	}