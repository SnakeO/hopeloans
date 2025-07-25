$(function()
{
	// only use in single-campaign page
	if( $('body.start-a-fundraiser').length == 0 ) {
		return;
	}

	// add a dollar sign placeholder to the "I want to donate" amount
	//$('#form_start-a-fundraiser-hope-projects #field_goal').attr('placeholder', '$');

	function findPriceOfHopeLoanProduct()
	{
		var selected = $('.start-a-hope-loans-fundraiser #field_hopeloan option:selected').text();
		var bits = selected.split('|');
		var price_per = parseFloat($.trim(bits[1].replace('$', '')));

		return price_per;
	}

	$('.start-a-hope-loans-fundraiser #field_hopeloan').on('change', function()
	{
		if( $('.start-a-hope-loans-fundraiser #field_quantity').val() == '' ) {
			$('.start-a-hope-loans-fundraiser #field_quantity').val('1');
		}

		var qty = $('.start-a-hope-loans-fundraiser #field_quantity').val();
		var price_per = findPriceOfHopeLoanProduct();
		var amt = price_per * qty;

		$('.start-a-hope-loans-fundraiser .per').text('$' + price_per);
		$('.start-a-hope-loans-fundraiser #field_amount').val(amt);
	})

	$('.start-a-hope-loans-fundraiser #field_quantity').on('change update keyup', function()
	{
		var price_per = findPriceOfHopeLoanProduct();
		var qty = $('.start-a-hope-loans-fundraiser #field_quantity').val();
		var amt = price_per * qty;

		if( !isNaN(amt) ) {
			$('.start-a-hope-loans-fundraiser #field_amount').val(amt);
		}
	});

	$('.start-a-hope-loans-fundraiser #field_amount').on('change update keyup', function()
	{
		var price_per = findPriceOfHopeLoanProduct();
		var amt = parseFloat($('.start-a-hope-loans-fundraiser #field_amount').val());
		var qty = Math.floor(amt/price_per);

		if( !isNaN(qty) ) {
			$('.start-a-hope-loans-fundraiser #field_quantity').val(qty);
		}
	});

	$('#form_start-a-fundraiser-donation-amount #field_goal2').on('change update keyup', function()
	{
		var amount = parseFloat($(this).val());
		var num_helps = Math.floor(amount / 70);

		if( !isNaN(num_helps) ) {
			$('#form_start-a-fundraiser-donation-amount #field_helps').val(num_helps);
			$('#form_start-a-fundraiser-donation-amount .cost').text(amount);
		}
	});

	$('#form_start-a-fundraiser-donation-amount #field_helps').on('change update keyup', function()
	{
		var num_helps = parseFloat($(this).val());
		var amount = num_helps * 70;

		if( !isNaN(amount) ) {
			$('#form_start-a-fundraiser-donation-amount #field_goal2').val(amount);
			$('#form_start-a-fundraiser-donation-amount .cost').text(amount);
		}
	});
});