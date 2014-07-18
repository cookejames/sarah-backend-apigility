(function( $ ) {
	'use strict';
	$.widget('drhouse.sensorgraph', {
		options: {
			palette:		new Rickshaw.Color.Palette(),
			values:			{},
			chartElement:	'.chart',
			legendElement:	'.legend',
			sliderElement:	'.slider',
			responsive:		true,
			smooth:			4.5
		},
		
		_create: function() {
			this._addColorToValues(this.options.values, this.options.palette);
			this._addScaleToValues(this.options.values);
			this.graph = this._createGraph(this.options.values);
			this.hoverDetail = this._createHoverDetail(this.graph);
			this.legend = this._createLegend(this.graph);
			this.slider = this._createSlider(this.graph);
			this._createAxis(this.graph);

			if (this.options.responsive) {
				this.makeResponsive();
			}
		},
		
		/**
		 * Make the graph responsive on window sizing
		 */
		makeResponsive: function() {
			var self = this;
			//make graph width responsive
			$(window).on('resize', function(){
				self.resizeGraph();
			});
		},
		
		/**
		 * Add palette colors to each of the sensor values
		 */
		_addColorToValues: function(values, palette) {
			//add color to each element
			$.each(values, function(index, value){
				value.color = palette.color();
			});
		},
		
		_addScaleToValues: function(values) {
			$.each(values, function(index, value){
				var range;
				if (value.graphStart == null) {
					range = d3.extent(value.data, function(d){return d.y;});
				} else {
					range = [value.graphStart, d3.max(value.data, function(d){return d.y;})];
				}
				value.scale = d3.scale.linear().domain(range);
			});
		},
		
		/**
		 * Create the rickshaw graph
		 */
		_createGraph: function(values) {
			var graph = new Rickshaw.Graph( {
				element: this.element.find(this.options.chartElement)[0],
				height: 300,
				renderer: 'line',
				series: values
			} );
			graph.render();
			
			//create the graph smoother
			var smoother = new Rickshaw.Graph.Smoother( {
				graph: graph,
			} );
			smoother.setScale(this.options.smooth);
			
			return graph;
		},
		
		/**
		 * Create the graph hover details with date formatting
		 */
		_createHoverDetail: function(graph) {
			var hoverDetail = new Rickshaw.Graph.HoverDetail({
				graph: graph,
		        xFormatter: function(x) {
		            return new Date(x * 1000).toString(); 
		        },
		        formatter: function(series, x, y, formattedX, formattedY, d) {
		        	var value = (series.valueType == 'float') ? formattedY : parseInt(y);
		        	value += (series.units) ? series.units : ''; 
		        	return series.name + ':&nbsp;' + value;
		        }
			});
			
			return hoverDetail;
		},
	
		/**
		 * Create the graph legend with series toggle
		 */
		_createLegend: function(graph) {
			var legend = new Rickshaw.Graph.Legend( {
				graph: graph,
				element: this.element.find(this.options.legendElement)[0]
		
			} );
			
			var shelving = new Rickshaw.Graph.Behavior.Series.Toggle( {
				graph: graph,
				legend: legend
			} );
			
			return legend;
		},
	
		/**
		 * Create graph slider
		 */
		_createSlider: function(graph) {
			var slider = new Rickshaw.Graph.RangeSlider( {
				graph: graph,
				element: this.element.find(this.options.sliderElement)[0]
			} );
			return slider;
		},
		
		/**
		 * Create graph axis
		 */
		_createAxis: function(graph) {
			var x_axis = new Rickshaw.Graph.Axis.Time( {
				graph: graph
			} );
			x_axis.render();
		},
		
		/* will re-add functionality later
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
		*/
		
		/**
		 * Resize the graph to the size of its parent element
		 */
		resizeGraph: function() {
			var width = this.element.parent().width();
			this.element.find(this.options.sliderElement).width(width);
			this.graph.configure({
				width: width,
			});
			this.graph.render();
		}
	});
}( jQuery ));