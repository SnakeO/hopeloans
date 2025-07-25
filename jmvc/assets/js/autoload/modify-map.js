jQuery(function($)
{
	setTimeout(function()
	{
		$('.ts-advanced-google-map-wrapper').on('click tap vtap touchmove', function(e) 
		{
			// only work with pinch/zoom
			if((e.originalEvent && e.originalEvent.touches && e.originalEvent.touches.length <= 1) {
				return true;
			}

		    $('.ts-advanced-google-map-wrapper > div').css("pointer-events", "auto");
		});

		$( '.ts-advanced-google-map-wrapper > div' ).on('mouseleave vmouseout', function() {
		  $('.ts-advanced-google-map-wrapper > div').css("pointer-events", "none"); 
		});

		$('.ts-advanced-google-map-wrapper > div').css("pointer-events", "none"); 
	}, 3000)
});