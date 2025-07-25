$(function()
{
	var datepicker = null; // date picker
	var LEAST_DAYS = 1;
	LEAST_DAYS -= 1;	// off by one bug?

	if( $('body.fundraiser-submission').length == 0 ) {
		return;
	}

	$('#charitable_field_post_title_element').attr('placeholder', 'YOUR FUNDRAISER NAME')
	$('#charitable_field_goal_element').attr('placeholder', '$');

	var opts = {
		dateLimit: '30 days',
		showDropdowns: false,
		alwaysShowCalendars: true,
		linkedCalendars: false,
		autoApply: true,
		parentEl: '#funding-info .funding-time-group',
		opens: 'right',
		minDate: moment().format('L')
	};

	// editing an existing fundraiser?
	if( $('#start_date').length > 0 )
	{
		opts['startDate'] = moment( $('#start_date').val() );
		opts['endDate'] = moment( $('#end_date').val() );
	}

	$('.days-left').daterangepicker(opts);
	datepicker = $('.days-left').data('daterangepicker');

	// fix the calendar float
	$('#funding-info .funding-time-group').append('<div style="clear:both"></div>');
	$('#funding-info').append('<div style="clear:both"></div>');

	// show the daterange initially
	$('.days-left').click();

	// calendar is wonky on load
	setTimeout(function()
	{
		$(window).resize();
	}, 100)

	window.getDaysSelected = function()
  	{
  		if( datepicker == null ) 
  		{
  			return {
				start: null,
				end: null,
				num_days: 0
			}
  		}

  		var start = datepicker.startDate.format('YYYY-MM-DD');
		var end = datepicker.endDate.format('YYYY-MM-DD')

		var a = moment(end);
		var b = moment(start);
		var num_days = a.diff(b, 'days')

		return {
			start: start,
			end: end,
			num_days: num_days
		}
  	}

	$('.days-left').on('apply.daterangepicker', function(ev, picker) 
	{
		var dayinfo = getDaysSelected();
		$('.num-days').text(dayinfo.num_days)

		// inject the fields we need
		if( $('#end_date').length == 0 ) {
			$('#charitable-campaign-submission-form').append('<input type="hidden" id="start_date" name="start_date" />');
			$('#charitable-campaign-submission-form').append('<input type="hidden" id="end_date" name="end_date" />');
		}

		$('#start_date').val(dayinfo.start);
		$('#end_date').val(dayinfo.end);
		
  	});

  	// submission verification
  	$('#charitable-campaign-submission-form').submit(function()
  	{
  		var errors = [];
  		$('.errors').html('');

  		// title
  		if( $.trim($('#charitable_field_post_title_element').val()) == '' ) {
  			errors.push("<li>You must fill in a fundraiser title.</li>")
  		}

  		/*
  		// desription
  		if( $.trim($('#charitable_field_description_element').val()) == '' ) {
  			errors.push("<li>You must fill in a fundraiser description.</li>")
  		}
  		*/

  		// goal
  		if( $.trim($('#charitable_field_goal_element').val()) == '' ) {
  			errors.push("<li>You must fill in a fundraiser goal.</li>")
  		}

  		// days selected
  		var dayinfo = getDaysSelected();
  		var day_noun = (LEAST_DAYS+1) > 1 ? "days" : "day";
  		if( dayinfo.start == null || dayinfo.num_days < LEAST_DAYS )  {
  			errors.push("<li>You must select at least " + (LEAST_DAYS+1) + ' ' + day_noun + " for a fundraiser.</li>");
  		}

  		if( errors.length > 0 ) {
  			$('.errors').html(errors.join("\n"));
  			return false;
  		}

  		return true;
  	});

  	// hijack the "NEXT" button from the non-visible right calendar and click it
  	// when the left calendar is pressed
  	/*
  	$('.left.calendar thead').on('click', '.prev', hijackCalendarNextBtn);
  	$('.days-left').on('show.daterangepicker', hijackCalendarNextBtn);
  	$('.days-left').on('showCalendar.daterangepicker', hijackCalendarNextBtn);
  	$('.days-left').on('apply.daterangepicker', hijackCalendarNextBtn);
  	$('.days-left').on('cancel.daterangepicker', hijackCalendarNextBtn);
  	$('.days-left').on('click', 'td', hijackCalendarNextBtn);
  	*/
  
  	/*
  	setInterval(hijackCalendarNextBtn, 500);	// ugly but necessary

  	function hijackCalendarNextBtn()
  	{
  		$('.left.calendar thead tr:first').off('click', 'th:last', hijackCalendarNextBtnClick);
  		$('.left.calendar thead tr:first').on('click', 'th:last', hijackCalendarNextBtnClick);
  	}

  	function hijackCalendarNextBtnClick()
	{
		$('.right.calendar thead .next i').click();
	}
	*/  	
})