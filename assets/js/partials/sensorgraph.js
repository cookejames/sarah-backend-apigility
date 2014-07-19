(function( $ ) {
	'use strict';
	$.widget('drhouse.sensorgraph', {
		options: {
			palette:			new Rickshaw.Color.Palette(),
			values:				null,
			node:				0,
			loaderContainer:	'.chartLoader',
			chartContainer:		'.chartContainer',
			chartElement:		'.chart',
			legendElement:		'.legend',
			sliderElement:		'.slider',
			fetchMoreElement:	'.fetchResults',
			height:				300,
			responsive:			true,
			smooth:				4.5
		},
		
		_create: function() {
			if (this.options.values) {
				//values already provided, show the chart
				this.values = this.options.values;
				this._instantiateGraph(this.values);
			} else {
				//get initial values by ajax
				var self = this;
				
				//hide the chart and show the loader
				this.hideChart();
				this.showLoader();
				
				//fetch the values by ajax
				var now = parseInt(Date.now()/1000);
				this._fetchData(now, function(data){
					if (data.result && data.result.length > 0) {
						self.values = data.result;
						self._instantiateGraph(self.values);
						self.hideLoader(800, self.showChart(400));
					}
				});
			}
			
			
		},
		
		/**
		 * Show the ajax loader
		 */
		showLoader: function() {
			this.element.find(this.options.loaderContainer).height(this.options.height).show();
		},
		
		/**
		 * Hide the ajax loader
		 */
		hideLoader: function(duration, complete) {
			this.element.find(this.options.loaderContainer).slideUp(duration, complete);
		},
		
		/**
		 * Show the chart
		 */
		showChart: function(duration) {
			this.element.find(this.options.chartContainer).slideDown(duration);
			this.resizeGraph();
		},
		
		/**
		 * Hide the chart
		 */
		hideChart: function() {
			this.element.find(this.options.chartContainer).hide();
		},
		
		/**
		 * Create a graph and all its support structures
		 */
		_instantiateGraph: function(values) {
			this._addColorToValues(values, this.options.palette);
			this._addScaleToValues(values);
			this.graph = this._createGraph(values);
			this.hoverDetail = this._createHoverDetail(this.graph);
			this.legend = this._createLegend(this.graph);
			this.slider = this._createSlider(this.graph);
			this._createAxis(this.graph);
			this._mapTouchToMouseEvents($(this.graph.element));
			this._enableFetchEarlierResults();
			if (this.options.responsive) {
				this.makeResponsive();
			}
		},
		
		/**
		 * Enable fetching earlier results via the fetch earlier results link 
		 */
		_enableFetchEarlierResults: function() {
			var self = this;

			//fetch more results on click
			this.element.find(this.options.fetchMoreElement).click(function(){				
				var domain = self.graph.dataDomain();
				
				self._fetchData(domain[0], function(data, textStatus, jqXHR){
					if (data.result && data.result.length > 0) {
						//iterate through the result and prepend our graph data
						$.each(data.result, function(index, sensor){
							$.each(self.values, function(index, graphSensor){
								if (sensor.name == graphSensor.name) {
									graphSensor.data = sensor.data.concat(graphSensor.data);
								}
							});
						});
						//update the graph
						self._addScaleToValues(self.values);
						self.graph.update();
					}
				});
			});
		},
		
		/**
		 * Fetch data from the server
		 */
		_fetchData: function(before, success) {
			var self = this;
			$.post(
					'/api/fetch-sensor-values',
					{
						before:	before,
						node:	self.options.node
					}, 
					success,
					'json'
				);
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
		
		/**
		 * Add a scale to all the values
		 */
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
		
		/**
		 * Resize the graph to the size of its parent element
		 */
		resizeGraph: function() {
			var width = this.element.parent().width();
			this.element.find(this.options.sliderElement).width(width);
			
			if (this.graph) {
				this.graph.configure({
					width: width,
				});
				this.graph.render();
			}
		},
		
		/**
		 * Map the touchmove event to mousemove to show hover details when dragging
		 */
		_mapTouchToMouseEvents: function(element) {
			element.on('touchmove', function(event){
				//required on android to get touch events as you drag
				if( navigator.userAgent.match(/Android/i) ) {
					event.preventDefault();
				}
				
				var touches = event.originalEvent.changedTouches;
				var first = touches[0];
				
			    var simulatedEvent = document.createEvent("MouseEvent");
			    simulatedEvent.initMouseEvent('mousemove', true, true, window, 1, 
			    		first.screenX, first.screenY, 
			    		first.clientX, first.clientY, false, 
			    		false, false, false, 0, null);
			    event.target.dispatchEvent(simulatedEvent);
			});
		}
	});
}( jQuery ));