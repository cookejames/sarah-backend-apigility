(function( $ ) {
	'use strict';
	$.widget('drhouse.sensorreadings', {
		options: {
			values:			{},
			template:		'index/partials/sensordisplay',
			updateInterval:	60 * 1000 //1 minute 
		},
		
		_create: function() {
			this._registerHelpers();
			this.update(this.options.values);
			this._createTimer();
		},
		
		_registerHelpers: function() {
			Handlebars.registerHelper("percentage", function(value, rangeMax, rangeMin) {
				  return value / (rangeMax - rangeMin) * 100;
			});
			
			Handlebars.registerHelper("fuzzyDate", function(phpTimestamp) {
				//get difference in seconds
				var seconds = parseInt(Date.now()/1000) - phpTimestamp;
				var minutes = parseInt(seconds / 60);
				var hours = parseInt(minutes / 60);
				
				if (seconds < 60) {
					return 'less than a minute';
				} else if (seconds == 60) {
					return 'a minute ago';
				} else if (seconds < 60 * 60) {
					return minutes + ' minutes ago';
				} else if (seconds == 60 * 60) {
					return 'an hour ago';
				} else if (seconds < 60 * 60 * 24) {
					return hours + ' hours ago';
				} else {
					return 'over a day ago';
				}
			});
			
			Handlebars.registerHelper('exists', function(variable, options) {
			    if (typeof variable !== 'undefined') {
			        return options.fn(this);
			    } else {
			        return options.inverse(this);
			    }
			});
		},
		
		update: function(values) {
			var self = this;
			$.each(values, function(index, sensor){
				self.element.find('#sensor' + sensor.id).html(self._getTemplateHtml(sensor));
			});
			this.options.values = values;
		},
		
		_createTimer: function() {
			var self = this;
			this.timer = setInterval(function(){self.update(self.options.values);}, this.options.updateInterval);
		},
		
		_getTemplateHtml: function(sensor) {
			return DrHouse.Templates[this.options.template](sensor);
		}
	});
}( jQuery ));