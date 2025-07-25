$(function()
{
	// only use in hope-board page
	if( $('body.hope-board').length == 0 ) {
		return;
	}

	$('.hope-campaign-box').each(function(i, box)
	{
		box = $(box);
		btn = box.find('.add-to-fundraiser-btn');

		btn.click(function()
		{
			var id = box.attr('class').match(/id-(\d+)/)[1];
			var start_fundraiser_url = "/fundraiser-submission/?charitable_parent_id=" + id + "&post_title=My%20Fundraiser&goal=100&fundraiser_type=" + HopeCampaign.CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT;
			window.location = start_fundraiser_url;
			return false;
		})
	})

	
})