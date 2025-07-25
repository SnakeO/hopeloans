$(function()
{
	// only use in home page
	if( $('body.home').length == 0 ) {
		return;
	}

	// flipper
	var flipper;

	function flipTick(final, onDone) 
	{
		var curr = flipper.getTime().time;	// current flip value 
		var flipping_distance = final - curr;
		var increment_by = 1;

		if( flipping_distance <= 0 ) 
		{
			if( typeof onDone == 'function' ) {
				onDone();
			}

			return;
		}

		// flipping_distance (>=) : increment_by mapping
		var increment_map = {
			100000 : {by: 2511, ms: 30},
			50000 : {by: 1211, ms: 30},
			25000 : {by: 611, ms: 30},
			10000: {by: 311, ms: 30},
			5000: {by: 261, ms: 50},
			1000: {by: 261, ms: 70},
			100: {by: 51, ms: 70},
			10: {by: 3, ms: 70},
			5: {by: 1, ms: 100},
			3: {by: 1, ms: 200},
			2: {by: 1, ms: 400},
			1: {by: 1, ms: 500},
		}

		// figure out how fast we are incrementing this tick
		// distance_marker loops from low to high (1 to 100000)
		var increment;
		for( var distance_marker in increment_map ) {
			if( flipping_distance >= distance_marker ) {
				increment = increment_map[distance_marker];
			}
		}

		var increment_dist = increment.by;
		var increment_speed = increment.ms;
		
		
		/*
		//var easing = 0.7;
		var increment_dist_range = {min: 1, max: 50000};
		var increment_speed_range = {min: 30, max: 100};

		// percentage
		//var pct_done = curr / final;
		//var pct_left = 1 - pct_done;

		// logarithmic percentage, for easing
		var pct_done = logarithmicPct({min:1, max:final}, curr);
		var pct_left = 1 - pct_done;

		var increment_dist = Math.ceil( increment_dist_range.min + ( (increment_dist_range.max-increment_dist_range.min) * pct_left) );
		var increment_speed = Math.ceil( increment_speed_range.min + ( (increment_speed_range.max-increment_speed_range.min) * pct_left) );

		//console.log(pct_left, 'pct', increment_dist, 'increment', increment_speed, 'ms')
		*/

		// don't overshoot
		increment_dist = Math.min(increment_dist, flipping_distance);

		// tick
		flipper.increment(increment_dist);
		
		// set up next tick
		setTimeout(function()
		{
			flipTick(final)
		}, increment_speed);
	}

	function logarithmicPct(range, linear_val)
	{
		var min_log = Math.log10(range.min);
		var max_log = Math.log10(range.max);
		var log_range = max_log - min_log;

		var log_pct = ( Math.log10(linear_val) - min_log ) / log_range;

		//console.log(range, linear_val, min_log, max_log, log_range, log_pct );
		
		return log_pct; 
	}

	flipper = new FlipClock($('.flipper'), 1, {
		clockFace: 'Counter',
		minimumDigits: 6
	});

	flipTick(flipper_data.lives_transformed_start_num, function()
	{
		/*
		setInterval(function()
		{
			flipper.increment();
		}, 3000)
		*/
	})
});