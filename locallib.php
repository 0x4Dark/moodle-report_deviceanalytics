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

defined('MOODLE_INTERNAL') || die();

/*CHARTS*/
$DADATATABLE = 'report_deviceanalytics_data';

function report_deviceanalytics_load_chart_datas(){
	global $DB, $DADATATABLE;
	$chartsdata = $DB->get_records($DADATATABLE);
	if(! empty($chartsdata) || ! is_null($chartsdata))
		return $chartsdata;
	else
		return NULL;
}

function report_deviceanalytics_create_chart_containers(){
	$chart_names = array();
	$chart_names[] = report_deviceanalytics_create_chart_container('device_types', 'dashboard_chart_device_types');
    $chart_names[] = report_deviceanalytics_create_chart_container('device_systems', 'dashboard_chart_device_systems');
    $chart_names[] = report_deviceanalytics_create_chart_container('device_browser', 'dashboard_chart_device_browser');
    $chart_names[] = report_deviceanalytics_create_chart_container('screen_sizes', 'dashboard_chart_screen_sizes');
    $chart_names[] = report_deviceanalytics_create_chart_container('window_sizes', 'dashboard_chart_window_sizes');
	return $chart_names;
}

function report_deviceanalytics_create_chart_querys($chart_data, $chart_ids){ ?>
	<script type="text/javascript">
		$(function () {
    		$(document).ready(function () {
    			<?php
    				//DEVICE TYPES
    				$device_types = array();
    				foreach ($chart_data as $entry) {
    					$type = $entry->device_type;
    					if(array_key_exists($type, $device_types))
    						$device_types[$entry->device_type]++;
    					else
    						$device_types[$entry->device_type] = 1;
    				}
    				report_deviceanalytics_create_pie_chart(
                        $chart_ids[0], 
                        $device_types, 
                        get_string('dashboard_chart_device_types_title', 'report_deviceanalytics')
                    );
                    //OPERATING SYSTEMS
                    $device_systems = array();
                    foreach ($chart_data as $entry) {
                        $system = $entry->device_system;
                        if(array_key_exists($system, $device_systems))
                            $device_systems[$entry->device_system]++;
                        else
                            $device_systems[$entry->device_system] = 1;
                    }
                    report_deviceanalytics_create_pie_chart(
                        $chart_ids[1], 
                        $device_systems, 
                        get_string('dashboard_chart_device_systems_title', 'report_deviceanalytics')
                    );
                    //DEVICE BROWSERS
                    $device_browser = array();
                    foreach ($chart_data as $entry) {
                        $browser = $entry->device_browser;
                        $browser_version = $entry->device_browser_version;
                        if(array_key_exists($browser, $device_browser)){
                            if(array_key_exists($entry->device_browser_version, $device_browser[$entry->device_browser]))
                                $device_browser[$entry->device_browser][$entry->device_browser_version]++;
                            else
                                $device_browser[$entry->device_browser][$entry->device_browser_version] = 1;
                        }
                        else{
                            $device_browser[$entry->device_browser] = array();
                            $device_browser[$entry->device_browser][$entry->device_browser_version] = 1;
                        }
                    }
                    report_deviceanalytics_create_pie_chart_subversion(
                        $chart_ids[2], 
                        $device_browser, 
                        get_string('dashboard_chart_device_browser_title', 'report_deviceanalytics')
                    );
                    //SCREEN SIZES
                    $screen_data = array_filter($chart_data, 'report_device_analytics_is_not_null');
                    $device_type_screen = array();
                    foreach ($screen_data as $sizes) {
                        $device_type_2 = $sizes->device_type;
                        $device_screen_sol = $sizes->device_display_size_x."x".$sizes->device_display_size_y;
                        if(array_key_exists($device_type_2, $device_type_screen)){
                            if(array_key_exists($device_screen_sol, $device_type_screen[$sizes->device_type]))
                                $device_type_screen[$sizes->device_type][$device_screen_sol]++;
                            else
                                $device_type_screen[$sizes->device_type][$device_screen_sol] = 1;
                        }else{
                            $device_type_screen[$sizes->device_type] = array();
                            $device_type_screen[$sizes->device_type][$sizes->device_display_size_x."x".$sizes->device_display_size_y] = 1;                        
                        }
                    }
                    report_deviceanalytics_create_scatter_chart(
                        $chart_ids[3], 
                        $device_type_screen, 
                        get_string('dashboard_chart_screen_sizes_title', 'report_deviceanalytics')
                    );
                    //WINDOW SIZES
                    $window_data = array_filter($chart_data, 'report_device_analytics_is_not_null');
                    $device_type_window = array();
                    foreach ($window_data as $sizes) {
                        $device_type_2 = $sizes->device_type;
                        $device_window_sol = $sizes->device_window_size_x."x".$sizes->device_window_size_y;
                        if(array_key_exists($device_type_2, $device_type_window)){
                            if(array_key_exists($device_window_sol, $device_type_window[$sizes->device_type]))
                                $device_type_window[$sizes->device_type][$device_window_sol]++;
                            else
                                $device_type_window[$sizes->device_type][$device_window_sol] = 1;
                        }else{
                            $device_type_window[$sizes->device_type] = array();
                            $device_type_window[$sizes->device_type][$sizes->device_window_size_x."x".$sizes->device_window_size_y] = 1;                        
                        }
                    }
                    report_deviceanalytics_create_scatter_chart(
                        $chart_ids[4], 
                        $device_type_window, 
                        get_string('dashboard_chart_window_sizes_title', 'report_deviceanalytics')
                    );
    			?>
    		});
    	});
    </script>
<?php }

function report_deviceanalytics_create_scatter_chart($container_id, $data_values, $title){ ?>
     $('#<?php echo $container_id; ?>').highcharts({
        chart: {
            type: 'scatter',
            zoomType: 'xy'
        },
        title: {
            text: '<?php echo $title; ?>'
        },
        xAxis: {
            title: {
                enabled: true,
                text: 'Width'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        },
        yAxis: {
            title: {
                text: 'Height'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'bottom',
            x: 0,
            y: -70,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
            borderWidth: 1
        },
        plotOptions: {
            scatter: {
                marker: {
                    radius: 5,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    }
                },
                states: {
                    hover: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                dataLabels: {
                    formatter: function() {
                        return this.point.value;
                    }
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x}x{point.y} count: {point.value}'
                }
            }
        },
        series: [
        <?php
            foreach ($data_values as $key => $value) {
                echo '{';
                    echo "name: '".$key."',";
                    echo "data: [";
                        foreach ($value as $size => $count) {
                            echo "{";
                                $parts = explode("x", $size);
                                echo "x: " .$parts[0]." ,";
                                echo "y: " .$parts[1]." ,";
                                echo "value: " .$count;
                            echo "},";
                        }
                    echo "]";
                echo '},';
            }
        ?>
       ]
    });
<?php
}

function report_deviceanalytics_create_pie_chart($container_id, $data_values, $title){ ?>
	$('#<?php echo $container_id; ?>').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '<?php echo $title; ?>'
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: '<?php echo $title; ?>',
            colorByPoint: true,
            data: [
            <?php
            	foreach ($data_values as $d_key => $d_value) {
            		echo '{';
            			echo "name: '".$d_key."',";
            			echo "y: ".$d_value;
            		echo '},';
            	}
            ?>
            ]
        }]
    });
<?php 
}

function report_deviceanalytics_create_pie_chart_subversion($container_id ,$data_values, $title){ ?>

$(function () {

    var colors = Highcharts.getOptions().colors,
        <?php
            $colorcounter = 0;
            echo 'categories = [';
                $broout = "";
                foreach ($data_values as $key => $value) {
                    $broout .= "'".$key."',";
                }
                $broout = rtrim($broout, ",");
                echo $broout;
            echo '],';
            echo 'data = [';
                foreach ($data_values as $key => $val) {
                    echo '{';
                        echo 'y: '. report_device_analytics_calc_numbers_of_version($val). ',';
                        echo 'color: colors['.$colorcounter.'],';
                        
                        echo 'drilldown: {';
                            echo "name: '".$key." versions',";
                            echo "categories: [";
                                $catout = "";
                                foreach ($val as $subkey => $count) {
                                    $catout .= "'".$key." " .$subkey."',";
                                }
                                $catout = rtrim($catout, ",");
                                echo $catout;
                            echo "],";
                            echo "data: [";
                                $countout = "";
                                foreach ($val as $subkey => $count) {
                                    $countout .= $count.", ";
                                }
                                $countout = rtrim($countout, ",");
                                echo $countout;
                            echo "],";
                            echo 'color: colors['.$colorcounter.']';
                        echo '}, ';
                    echo '},';
                    $colorcounter++;
                }
            echo '],';
        ?>
        browserData = [],
        versionsData = [],
        i,
        j,
        dataLen = data.length,
        drillDataLen,
        brightness;


    for (i = 0; i < dataLen; i += 1) {
        browserData.push({
            name: categories[i],
            y: data[i].y,
            color: data[i].color
        });
        drillDataLen = data[i].drilldown.data.length;
        for (j = 0; j < drillDataLen; j += 1) {
            brightness = 0.2 - (j / drillDataLen) / 5;
            versionsData.push({
                name: data[i].drilldown.categories[j],
                y: data[i].drilldown.data[j],
                color: Highcharts.Color(data[i].color).brighten(brightness).get()
            });
        }
    }
    $('#<?php echo $container_id; ?>').highcharts({
        chart: {
            type: 'pie'
        },
        title: {
            text: '<?php echo $title; ?>'
        },
        plotOptions: {
            pie: {
                shadow: false,
                center: ['50%', '50%']
            }
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        series: [{
            name: 'Browsers',
            data: browserData,
            size: '60%',
            dataLabels: {
                formatter: function () {
                    return this.y > 5 ? this.point.name : null;
                },
                color: '#ffffff',
                distance: -30
            }
        }, {
            name: 'Versions',
            data: versionsData,
            size: '80%',
            innerSize: '60%',
            dataLabels: {
                formatter: function () {
                    return this.y > 1 ? '<b>' + this.point.name + ':</b> ' + this.y + '%' : null;
                }
            }
        }]
    });
});

<?php
}

function report_device_analytics_is_not_null ($var) { 
    return !is_null($var->device_display_size_x); 
}

function report_device_analytics_calc_numbers_of_version($datarray){
    $returnnumber = 0;
    foreach ($datarray as $value) {
         $returnnumber += $value;
    }
    return $returnnumber;
}

function report_device_analytics_calc_percent($datarray, $calckey){
	$groundvalue = 0;
	$procvalue = $datarray[$calckey];
	foreach ($datarray as $val) {
		$groundvalue += $val;
	}
	return number_format((($procvalue/$groundvalue)*100),2);
}

function report_deviceanalytics_create_chart_container($chart_name, $header_name){
	global $OUTPUT;
	echo $OUTPUT->heading(get_string($header_name, 'report_deviceanalytics'), 4);
	echo $OUTPUT->container(NULL, 'chart', $chart_name);
	return $chart_name;
}
