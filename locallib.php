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

/*CHARTS*/
$DADATATABLE = 'tool_deviceanalytics_data';

function tool_deviceanalytics_load_chart_datas(){
	global $DB, $DADATATABLE;
	$chartsdata = $DB->get_records($DADATATABLE);
	if(! empty($chartsdata) || ! is_null($chartsdata))
		return $chartsdata;
	else
		return NULL;
}

function tool_deviceanalytics_create_chart_containers(){
	$chart_names = array();
	$chart_names[] = tool_deviceanalytics_create_chart_container('device_types', 'dashboard_chart_device_types');
	return $chart_names;
}

function tool_deviceanalytics_create_chart_querys($chart_data, $chart_ids){ ?>
	<script type="text/javascript">
		$(function () {
    		$(document).ready(function () {
    			<?php
    				//DEVICE TYPES
    				$device_types = array();
    				foreach ($chart_data as $entry) {
    					$type = $entry->device_type;
    					if(array_key_exists( $type,$device_types))
    						$device_types[$entry->device_type]++;
    					else
    						$device_types[$entry->device_type] = 1;
    				}
    				tool_deviceanalytics_create_pie_chart($chart_ids[0], $device_types, get_string('dashboard_chart_device_types_title', 'tool_deviceanalytics'));
    			?>
    		});
    	});
    </script>
<?php }

function tool_deviceanalytics_create_pie_chart($container_id, $data_values, $title){ ?>
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
<?php }

//deprecated
function tool_device_analytics_calc_percent($datarray, $calckey){
	$groundvalue = 0;
	$procvalue = $datarray[$calckey];
	foreach ($datarray as $val) {
		$groundvalue += $val;
	}
	return number_format((($procvalue/$groundvalue)*100),2);
}

function tool_deviceanalytics_create_chart_container($chart_name, $header_name){
	global $OUTPUT;
	echo $OUTPUT->heading(get_string($header_name, 'tool_deviceanalytics'), 4);
	echo $OUTPUT->container(NULL, 'chart', $chart_name);
	return $chart_name;
}
