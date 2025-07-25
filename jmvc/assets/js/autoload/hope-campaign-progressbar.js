// handles the dynamic progressbars

$(function()
{
	if( $('.hope-campaign-progressbar').length == 0 ) {
		return;
	}

	$('.hope-campaign-progressbar').each(function(i, progressbar)
	{
		var width = parseFloat($(progressbar).data('pct')) * 100;
		$(progressbar).find('.inner.bar').css('width', width + '%');
	});
});

