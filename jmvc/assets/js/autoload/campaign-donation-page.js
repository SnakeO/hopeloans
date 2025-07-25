$(function()
{
	// only use in single-campaign page
	if( $('body.campaign-donation-page, body.campaign-donation').length == 0 ) {
		return;
	}

	// used in recurring donations:
	// /campaigns/donation/donate/?donate_amount=330&recurring=1
	if( qs('recurring') == '1' ) {
		$('#charitable_field_recurring_donation_element')[0].checked = true;
	}

	// loading icon
	$('.charitable-form-processing img').attr('src', site_url('/jmvc/assets/img/loading/multicolor-circle.gif'));
	
	// In Honor Of?
	
	// handle the checkbox switch
	$('#charitable_field_is_in_honor_of_element').change(function()
	{
		if( this.checked  )
		{
			$('#charitable_field_in_honor_of_name_element').attr('required', 'required');
			$('#charitable_field_in_honor_of_address_element').attr('required', 'required');

			$("#charitable_field_in_honor_of_name").fadeIn();
			$("#charitable_field_in_honor_of_address").fadeIn();
			$("#charitable_field_in_honor_of_email").fadeIn();

			$('#charitable_field_is_in_honor_of_element').val('Yes');
		}
		else 
		{
			$('#charitable_field_in_honor_of_name_element').removeAttr('required');
			$('#charitable_field_in_honor_of_address_element').removeAttr('required');

			$("#charitable_field_in_honor_of_name").fadeOut();
			$("#charitable_field_in_honor_of_address").fadeOut();
			$("#charitable_field_in_honor_of_email").fadeOut();

			$("#charitable_field_in_honor_of_name_element").val('');
			$("#charitable_field_in_honor_of_address_element").val('');
			$("#charitable_field_in_honor_of_email_element").val('');

			$('#charitable_field_is_in_honor_of_element').val('No');
		}
	});

	$('#charitable_field_is_in_honor_of_element').change();

	// position them in their own fieldset
	var fieldset = $('<fieldset id="charitable-in-honor-of-fields" class="charitable-fieldset"><div class="charitable-form-header">Honoring Someone?</div></fieldset>');

	fieldset.append( $('#charitable_field_is_in_honor_of').detach() );
	fieldset.append( $("#charitable_field_in_honor_of_name").detach() );
	fieldset.append( $("#charitable_field_in_honor_of_address").detach() );
	fieldset.append( $("#charitable_field_in_honor_of_email").detach() );

	fieldset.insertBefore( $('#charitable-gateway-fields') );
});