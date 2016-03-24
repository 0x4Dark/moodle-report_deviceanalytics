<?php
	class deviceanalytics_redirector{
		public static function init($eventdata) {
			global $CFG;
	        if(isloggedin()){
	        	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
	        		$url = preg_replace("/^http:/i", "https:", $CFG->wwwroot);
	        		redirect($url.'/report/deviceanalytics/storage_helper_page.php');
				}else{
					redirect($CFG->wwwroot.'/report/deviceanalytics/storage_helper_page.php');
				}
	        }
		}
	}