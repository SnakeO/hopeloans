$(function()
{
	// only use in single-campaign page
	if( $('body.single-campaign').length == 0 ) {
		return;
	}

	// donate button
	$('.hope-campaign-donate .donate_btn').click(function()
	{
		window.location.href = window.location.href + 'donate/?donate_amount=' + parseFloat($('.donate_amount').val());
		return false;
	});

	$('.fundraise-btn').click(function()
	{
		var id = $('body').attr('class').match(/postid-(\d+)/)[1];
		var fundraisr_title = encodeURI('My Fundraiser for ' + $('h1').text());
		var goal = parseFloat($('.donate_amount').val()) ? parseFloat($('.donate_amount').val()) : 100;
 		var start_fundraiser_url = "/fundraiser-submission/?charitable_parent_id=" + id + "&post_title=" + fundraisr_title + "&goal=" + goal + "&fundraiser_type=" + HopeCampaign.CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT;
		window.location = start_fundraiser_url;

		$(this).find('button').text("Please Wait...");
		return false;
	});
});