$('document').ready(function(){
	$('.heading a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var href = $(e.target).attr('href');
		$(href).find('.sensorGraph').sensorgraph('resizeGraph');
	});
	
	$('#pumpOn').click(function(){
		$.post(
			'/api/turn-pump-on',
			{
				pumpon: true
			},
			function(data, textStatus, jqXHR){
				if (data.result) {
					$('<div>Pump turning on</div>').dialog();
				} else {
					$('<div>Could not turn pump on</div>').dialog();
				}
			},
			'json'
		);
	});
});