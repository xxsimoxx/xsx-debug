jQuery(document).ready(function(){
	jQuery(".xsx-debug-toggle").click(function(){
		var answer=confirm(xsx_debug_translation.message);
		if ( answer ){
			jQuery.ajax({
				type: "POST",
				url: xsx_debug_translation.url,
				data : {
					"action": "xsx_debug_toggle",
				},
				dataType : "json",
				cache: false,
			});
			jQuery("<div id='xsx-loader-wrapper'><div id='xsx-circle'><div></div></div></div>").prependTo(document.body).delay(4000);
			setTimeout(function() {
				location.reload();
			}, 4000);
		}
	});
});