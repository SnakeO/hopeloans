$(function()
{
	// only affect supercarousel
	if( $('.supercrsl').length == 0 ) {
		return;
	}

	// hide items from the supercarousel
	$('.super_overlay_title > .super_clickaction[title="One-Time or Recurring Donation (DO NOT TRASH)"]').parents('.super_imagewrap').parent().remove()
	$('.super_overlay_title > .super_clickaction[title="Parent Campaign for Hope Loans Fundraiser (DO NOT TRASH)"]').parents('.super_imagewrap').parent().remove()
	$('.super_overlay_title > .super_clickaction[title="Parent Campaign for Donation Fundraiser (DO NOT TRASH)"]').parents('.super_imagewrap').parent().remove()
})