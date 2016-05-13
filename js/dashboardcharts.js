var dtlabels;
var dslabels;
function createCharts(datas){
	Chart.defaults.global.responsive = true;

	// DEVICE TYPE
	dtlabels = getTypeLabels(datas);
	var dtdatas = getTypeDatas(datas);
	var dtcolors = getRandomColors(dtlabels.length);

	var devicetypecanvas = $("#chart_devicetypes");
	var devicetypechart = new Chart(devicetypecanvas, {
    	type: 'pie',
	    data: {
	        labels: dtlabels,
	        datasets: [{
	            data: dtdatas,
	            backgroundColor: dtcolors
	        }]
	    },
	});

	// DEVICE SYSTEM
	dslabels = getSystemLabels(datas);
	var dsdatas = getSystemDatas(datas);
	var dscolors = getRandomColors(dslabels.length);

	var devicesystemcanvas = $("#chart_devicesystems");
	var devicesystemchart = new Chart(devicesystemcanvas, {
    	type: 'bar',
	    data: {
	        labels: dslabels,
	        datasets: [{
	        	label: "Percent",
	          	data: dsdatas,
	           	backgroundColor: dscolors
	        }]
	    },options: {
            legend: {
                display: false,
            }
        }
	});

	// DEVICE DISPLAY
	var filtereddatas = datas;
	for(var fkey in filtereddatas){
		if(filtereddatas[fkey].devicedisplaysizex == null){
			delete filtereddatas[fkey];
		}
	}
	getDisplayDatasets(filtereddatas);
}

function getDisplayDatasets(datas){
	var datasets = [];
	var databuffer = [];
	var datacon = [];
	for(ddata in datas){
		var point = {device: datas[ddata].devicetype, x: datas[ddata].devicedisplaysizex, y: datas[ddata].devicedisplaysizey};
		databuffer.push(point);
	}
	for(var l = 0; l < dtlabels.length; l++){
		var dbd = databuffer.filter(function( obj ) {
  			return obj.device == dtlabels[l];
		});
		datacon[dtlabels[l]] = dbd;
	}

	console.log(datacon);

	return datasets;
}

function getGround(datas){
	var groundval = 0;
	for (var i in datas) {
		groundval += datas[i];
	}
	return groundval;
}

function getPercent(ground, data){
	var per = (data/ground) * 100;
	return Math.round (per * 100) / 100;
}

function getTypeLabels(datas){
	var td = [];
	$.each(datas, function(index, value) {
		if($.inArray(value.devicetype, td) === -1) td.push(value.devicetype);
	});
	return td;
}

function getSystemLabels(datas){
	var td = [];
	$.each(datas, function(index, value) {
		if($.inArray(value.devicesystem, td) === -1) td.push(value.devicesystem);
	});
	return td;
}

function getTypeDatas(datas){
	var dtdatas = [];
	$.each(datas, function(index, value) {
		if(typeof dtdatas[value.devicetype] === 'undefined') {
			dtdatas[value.devicetype] = 1;
		}else{
			dtdatas[value.devicetype] += 1;
		}
	});
	var groundval = getGround(dtdatas);
	var dtwrap = [];
	for (var i in dtdatas) {
		dtwrap.push(getPercent(groundval,dtdatas[i]));
	}
			
	return dtwrap;
}

function getSystemDatas(datas){
	var dtdatas = [];
	$.each(datas, function(index, value) {
		if(typeof dtdatas[value.devicesystem] === 'undefined') {
			dtdatas[value.devicesystem] = 1;
		}else{
			dtdatas[value.devicesystem] += 1;
		}
	});
	var groundval = getGround(dtdatas);
	var dtwrap = [];
	for (var i in dtdatas) {
		dtwrap.push(getPercent(groundval,dtdatas[i]));
	}
	return dtwrap;
}


function getRandomColors(num){
	var colors = [];
	for (i = 0; i < num; i++) { 
    	colors.push(getRandomColor());
    }
    return colors;
}

function getRandomColor() {
    var value = Math.random() * 0xFF | 0;
	var grayscale = (value << 16) | (value << 8) | value;
	return '#' + grayscale.toString(16);
}