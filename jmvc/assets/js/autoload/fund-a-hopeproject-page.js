$(function()
{
	// only use in single-campaign page
	if( $('body.fund-a-hopeproject').length == 0 ) {
		return;
	}

	var oldhash = null;

	setInterval(function()
	{
		if( !window.location.hash || window.location.hash == oldhash ) {
			return;
		}

		// only listen to tabs
		if( window.location.hash.indexOf("#tab-") != 0 ) {
			return;
		}
		
		oldhash = window.location.hash;

		// show the map group displayed
		var group = window.location.hash.replace('#tab-', '');
		$('.ts-advanced-google-map-controls-groups').val(group).trigger('change')[0].sumo.reload();

	}, 500);
});

