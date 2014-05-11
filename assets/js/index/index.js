$('document').ready(function(){
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