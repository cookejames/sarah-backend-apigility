$('document').ready(function() {
	var palette = new Rickshaw.Color.Palette();
	
	//add color to each element
	$.each(SENSOR_VALUES, function(index, value){
		value.color = palette.color();
	});
	
	var graph = new Rickshaw.Graph( {
		element: $('#sensorGraph .chart')[0],
		height: 300,
		renderer: 'line',
		series: SENSOR_VALUES
	} );

	graph.render();

	var hoverDetail = new Rickshaw.Graph.HoverDetail( {
		graph: graph
	} );

	var legend = new Rickshaw.Graph.Legend( {
		graph: graph,
		element: $('#sensorGraph .legend')[0]

	} );

	var shelving = new Rickshaw.Graph.Behavior.Series.Toggle( {
		graph: graph,
		legend: legend
	} );

	var axes = new Rickshaw.Graph.Axis.Time( {
		graph: graph
	} );
	axes.render();
	
	//make graph width responsive
	$(window).on('resize', function(){
		var width = $('#sensorGraph').parent().width();
		graph.configure({
			width: width,
		});
		graph.render();
	});
});