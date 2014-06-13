$('document').ready(function() {
	var palette = new Rickshaw.Color.Palette();
	
	//add color to each element
	$.each(SENSOR_VALUES, function(index, value){
		value.color = palette.color();
		value.yFormatter = function(y){
			var scaled =  y / value.scalingFactor;
			if (value.valueType == 'float') {
				return scaled.toFixed(2) + value.units;
			} else {
				return parseInt(scaled) + value.units;
			}
		};
	});
	
	var graph = new Rickshaw.Graph( {
		element: $('#sensorGraph .chart')[0],
		height: 300,
		renderer: 'line',
		series: SENSOR_VALUES
	} );

	graph.render();

	var hoverDetail = new Rickshaw.Graph.HoverDetail( {
		graph: graph,
        xFormatter: function(x) {
            return new Date(x * 1000).toString(); 
        },
	} );

	var legend = new Rickshaw.Graph.Legend( {
		graph: graph,
		element: $('#sensorGraph .legend')[0]

	} );

	var shelving = new Rickshaw.Graph.Behavior.Series.Toggle( {
		graph: graph,
		legend: legend
	} );

	var slider = new Rickshaw.Graph.RangeSlider( {
		graph: graph,
		element: $('#sensorGraph .slider')[0]
	} );

	var x_axis = new Rickshaw.Graph.Axis.Time( {
		graph: graph
	} );
	x_axis.render();
	
	//fetch more results on click
	$('#sensorGraph .fetchResults').click(function(){
		var self = this;
		$(self).hide();
		$.post(
			'/api/fetch-sensor-values',
			{
				before: FIRST_VALUE
			},
			function(data, textStatus, jqXHR){
				if (data.result && data.result.length > 0) {
					//show the button if we have a valid result
					$(self).show();
					//iterate through the result and prepend our graph data
					$.each(data.result, function(index, sensor){
						$.each(SENSOR_VALUES, function(index, graphSensor){
							if (sensor.name == graphSensor.name) {
								graphSensor.data = sensor.data.concat(graphSensor.data);
							}
						});
					});
					///update the first value we have
					FIRST_VALUE = data.result[0].data[0].x_date;
					//update the graph
					graph.update();
				}
			},
			'json'
		);
	});
	
	var resizeGraph = function(){
		var width = $('#sensorGraph').parent().width();
		$('#sensorGraph .slider').width(width);
		graph.configure({
			width: width,
		});
		graph.render();
	};
	
	//make graph width responsive
	$(window).on('resize', function(){
		resizeGraph();
	});
	
	//resize on opening the tab - should refactor so independant of the tabs
	$('.heading a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var href = $(e.target).attr('href');
		if (href == '#sensorGraphTab') {
			resizeGraph();
		}
	});
});