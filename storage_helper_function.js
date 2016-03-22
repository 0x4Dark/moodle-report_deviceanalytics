require(['jquery'], function($) {
    $( document ).ready(function() {
    	var params = new Array();
    		var ajaxurl = 'ajaxcall.php?' + 'sesskey=' + M.cfg.sesskey;
    		var screensize = {'device_display_size_x': screen.width, 'device_display_size_y': screen.height, 'device_window_size_x': $(window).width(), 'device_window_size_y': $(window).height()}
    		$.ajax({
    			type: "GET",
  				url: ajaxurl,
  				data: screensize,
			}).done(function(html) {
  				//DEBUG
  				console.log(html);
  				//REDIRECT
  				
			});
	});
});