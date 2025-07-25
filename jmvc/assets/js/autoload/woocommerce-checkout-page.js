$(function()
{
	// only use in woocommerce-checkout page
	if( $('body.woocommerce-checkout').length == 0 ) {
		return;
	}

	// re-enable HTML5 validation
	$( document.body ).bind( 'init_checkout', function()
	{
		$('form.checkout').removeAttr( 'novalidate' );
	});

	// In Honor Of?
	$('#is_in_honor_of_field .checkbox').wrapInner('<span></span>');
	$('#is_in_honor_of_field .checkbox').prepend( $('#is_in_honor_of_field .checkbox .input-checkbox').detach() )


	$("#in_honor_of_email_field").addClass('validate-email');
	
	// handle the checkbox switch
	$('#is_in_honor_of').change(function()
	{
		if( this.checked  )
		{
			$('#in_honor_of_name').attr('required', 'required');
			$("#in_honor_of_name_field").addClass('validate-required');

			$('#in_honor_of_address').attr('required', 'required');
			$("#in_honor_of_address_field").addClass('validate-required');

			$("#in_honor_of_name_field").fadeIn();
			$("#in_honor_of_address_field").fadeIn();
			$("#in_honor_of_email_field").fadeIn();

			$('#is_in_honor_of').val('Yes');
		}
		else 
		{
			$('#in_honor_of_name').removeAttr('required');
			$("#in_honor_of_name_field").removeClass('validate-required');

			$('#in_honor_of_address').removeAttr('required');
			$("#in_honor_of_address_field").removeClass('validate-required');

			$("#in_honor_of_name_field").fadeOut();
			$("#in_honor_of_address_field").fadeOut();
			$("#in_honor_of_email_field").fadeOut();

			$("#in_honor_of_name").val('');
			$("#in_honor_of_address").val('');
			$("#in_honor_of_email").val('');

			$('#is_in_honor_of').val('No');
		}
	});

	$('#is_in_honor_of').change();
});