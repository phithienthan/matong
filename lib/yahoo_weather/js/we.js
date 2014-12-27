function getWeather(id){
	jQuery.ajax({
		method: "POST",url: 'index.php',
		data : {
			'cmd':'we_change',
			'id':id
		},
		beforeSend: function(){
			jQuery('#we_loading').fadeIn(100);
		},
		success: function(content){
			jQuery('#we_loading').hide()
			if(content){
				eval(content);
				jQuery('.we-info').html(weather);
			}
		}
	});
}
