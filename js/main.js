function notify(text,type,delay,pos) {
	
	if (typeof(delay) == 'undefined') {
		delay=4000;
	}
	
	if (typeof(pos) == 'undefined') {
		var pos = 'topLeft';
	}
	
	switch(type) {
		case 'success': var ani='rubberBand'; break;
		case 'error': var ani='tada'; break;
		case 'warning': var ani='tada'; break;
		case 'alert': var ani='shake'; break;
		default: var ani='shake'; break;
	}
	
	var n = noty({
		theme: 'relax',
		text: text,
		layout: pos,
		timeout: delay,
		type: type,
		animation: {
			open: 'animated '+ani, // or Animate.css class names like: 'animated bounceInLeft'
			close: 'animated bounceOutLeft', // or Animate.css class names like: 'animated bounceOutLeft'
			easing: 'swing',
			speed: 500 // opening & closing animation speed
		}
	});
	
}

function refreshTooltips() {
	$('[data-toggle="tooltip"]').tooltip();
}