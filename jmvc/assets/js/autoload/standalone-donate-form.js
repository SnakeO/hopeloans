$(function()
{
	if( $('.standalone-donate-form').length == 0 ) {
		return;
	}

	$('.standalone-donate-form').each(function(i, donate_form)
	{
		donate_form = $(donate_form);

		// update the impact we're having
		$(this).find('.donate_amount').on('change keyup', function()
		{
			var impact_amount = ''
			var impact_object = 'Families';

			var donate_amt = donate_form.find('.donate_amount').val();

			if( donate_amt == '' || isNaN(donate_amt) ) {
				impact_amount = '?';
			}
			else 
			{
				$(this).val = parseInt(donate_amt);
				impact_amount = Math.ceil(parseInt(donate_amt) / 30);

				if( parseInt(donate_amt)  == 1 ) {
					impact_object = 'Family';
				}
			}

			donate_form.find('.impact .amount').text(impact_amount);
			donate_form.find('.impact .object').text(impact_object);
		})

		// recurring or single time?
		donate_form.find('.buttons button').click(function()
		{
			donate_form.find('.buttons button').removeClass('selected');
			$(this).addClass('selected');
		});

		$(this).find('.donate_btn').click(function()
		{
			var donate_amt = donate_form.find('.donate_amount').val();
			var is_recurring = donate_form.find('.buttons button.selected').data('recurring-param-val');

			if( isNaN(donate_amt) || donate_amt == 0 ) 
			{
				alert("Please enter an amount to donate.");
				return false;
			}

			window.location = "/campaigns/donation/donate/?donate_amount=" + donate_amt + "&recurring=" + is_recurring;
			$(this).text('THANKS')
			return false;
		});
	});
});