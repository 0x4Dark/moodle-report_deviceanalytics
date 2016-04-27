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

// CHARTS
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
    $chartnames = array();
    $chartnames[] = report_deviceanalytics_create_chart_container('device_types', 'dashboard_chart_device_types');
    $chartnames[] = report_deviceanalytics_create_chart_container('device_systems', 'dashboard_chart_device_systems');
    $chartnames[] = report_deviceanalytics_create_chart_container('device_browser', 'dashboard_chart_device_browser');
    $chartnames[] = report_deviceanalytics_create_chart_container('screen_sizes', 'dashboard_chart_screen_sizes');
    $chartnames[] = report_deviceanalytics_create_chart_container('window_sizes', 'dashboard_chart_window_sizes');
    return $chartnames;
}

function report_deviceanalytics_create_chart_querys($chartdata, $chartids){ ?>
    <script type="text/javascript">
        $(function () {
            $(document).ready(function () {
                <?php
                    // DEVICE TYPES
                    $devicetypes = array();
                    foreach ($chartdata as $entry) {
                        $type = $entry->devicetype;
                        if (array_key_exists($type, $devicetypes)) {
                            $devicetypes[$entry->devicetype]++;
                        }
                        else {
                            $devicetypes[$entry->devicetype] = 1;
                        }
                    }
                    report_deviceanalytics_create_pie_chart(
                        $chartids[0], 
                        $devicetypes, 
                        get_string('dashboard_chart_device_types_title', 'report_deviceanalytics')
                    );
                    // OPERATING SYSTEMS
                    $devicesystems = array();
                    foreach ($chartdata as $entry) {
                        $system = $entry->devicesystem;
                        if (array_key_exists($system, $devicesystems)) {
                            $devicesystems[$entry->devicesystem]++;
                        }
                        else {
                            $devicesystems[$entry->devicesystem] = 1;
                        }
                    }
                    report_deviceanalytics_create_pie_chart(
                        $chartids[1], 
                        $devicesystems, 
                        get_string('dashboard_chart_device_systems_title', 'report_deviceanalytics')
                    );
                    // DEVICE BROWSERS
                    $devicebrowser = array();
                    foreach ($chartdata as $entry) {
                        $browser = $entry->devicebrowser;
                        $browserversion = $entry->devicebrowserversion;
                        if (array_key_exists($browser, $devicebrowser)) {
                            if (array_key_exists($entry->devicebrowserversion, $devicebrowser[$entry->devicebrowser])) {
                                $devicebrowser[$entry->devicebrowser][$entry->devicebrowserversion]++;
                            }
                            else {
                                $devicebrowser[$entry->devicebrowser][$entry->devicebrowserversion] = 1;
                            }
                        }
                        else {
                            $devicebrowser[$entry->devicebrowser] = array();
                            $devicebrowser[$entry->devicebrowser][$entry->devicebrowserversion] = 1;
                        }
                    }
                    report_deviceanalytics_create_pie_chart_subversion(
                        $chartids[2], 
                        $devicebrowser, 
                        get_string('dashboard_chart_device_browser_title', 'report_deviceanalytics')
                    );
                    // SCREEN SIZES
                    $screendata = array_filter($chartdata, 'report_device_analytics_is_not_null');
                    $devicetypescreen = array();
                    foreach ($screendata as $sizes) {
                        $devicetype2 = $sizes->devicetype;
                        $devicescreensol = $sizes->devicedisplaysizex."x".$sizes->devicedisplaysizey;
                        if (array_key_exists($devicetype2, $devicetypescreen)) {
                            if (array_key_exists($devicescreensol, $devicetypescreen[$sizes->devicetype])) {
                                $devicetypescreen[$sizes->devicetype][$devicescreensol]++;
                            }
                            else {
                                $devicetypescreen[$sizes->devicetype][$devicescreensol] = 1;
                            }
                        }
                        else {
                            $devicetypescreen[$sizes->devicetype] = array();
                            $devicetypescreen[$sizes->devicetype][$sizes->devicedisplaysizex."x".$sizes->devicedisplaysizey] = 1;                        
                        }
                    }
                    report_deviceanalytics_create_scatter_chart(
                        $chartids[3], 
                        $devicetypescreen, 
                        get_string('dashboard_chart_screen_sizes_title', 'report_deviceanalytics')
                    );
                    // WINDOW SIZES
                    $windowdata = array_filter($chartdata, 'report_device_analytics_is_not_null');
                    $devicetypewindow = array();
                    foreach ($windowdata as $sizes) {
                        $devicetype2 = $sizes->devicetype;
                        $devicewindowsol = $sizes->devicewindowsizex."x".$sizes->devicewindowsizey;
                        if (array_key_exists($devicetype2, $devicetypewindow)) {
                            if (array_key_exists($devicewindowsol, $devicetypewindow[$sizes->devicetype])) {
                                $devicetypewindow[$sizes->devicetype][$devicewindowsol]++;
                            }
                            else {
                                $devicetypewindow[$sizes->devicetype][$devicewindowsol] = 1;
                            }
                        }
                        else {
                            $devicetypewindow[$sizes->devicetype] = array();
                            $devicetypewindow[$sizes->devicetype][$sizes->devicewindowsizex."x".$sizes->devicewindowsizey] = 1;                        
                        }
                    }
                    report_deviceanalytics_create_scatter_chart(
                        $chartids[4], 
                        $devicetypewindow, 
                        get_string('dashboard_chart_window_sizes_title', 'report_deviceanalytics')
                    );
                ?>
            });
        });
    </script>
<?php }

function report_deviceanalytics_create_scatter_chart($containerid, $datavalues, $title){ ?>
     $('#<?php echo $containerid; ?>').highcharts({
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
            foreach ($datavalues as $key => $value) {
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

function report_deviceanalytics_create_pie_chart($containerid, $datavalues, $title){ ?>
    $('#<?php echo $containerid; ?>').highcharts({
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
                foreach ($datavalues as $dkey => $dvalue) {
                    echo '{';
                        echo "name: '".$dkey."',";
                        echo "y: ".$dvalue;
                    echo '},';
                }
            ?>
            ]
        }]
    });
<?php 
}

function report_deviceanalytics_create_pie_chart_subversion($containerid ,$datavalues, $title){ ?>
$(function () {
    var colors = Highcharts.getOptions().colors,
        <?php
            $colorcounter = 0;
            echo 'categories = [';
                $broout = "";
                foreach ($datavalues as $key => $value) {
                    $broout .= "'".$key."',";
                }
                $broout = rtrim($broout, ",");
                echo $broout;
            echo '],';
            echo 'data = [';
                foreach ($datavalues as $key => $val) {
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
    $('#<?php echo $containerid; ?>').highcharts({
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
    return !is_null($var->devicedisplaysizex); 
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

function report_deviceanalytics_create_chart_container($chartname, $headername){
    global $OUTPUT;
    echo $OUTPUT->heading(get_string($headername, 'report_deviceanalytics'), 4);
    echo $OUTPUT->container(NULL, 'chart', $chartname);
    return $chartname;
}
