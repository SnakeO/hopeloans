<?php

namespace templatedata\loaders;

class Hope_loans {
	
	function __construct()
	{

	}

	// /fundraiser-submission/
	function page($slug)
	{
		add_action('wp_enqueue_scripts', function() use ($slug)
		{
			wp_enqueue_style( 'daterangepicker', site_url('jmvc/assets/bower/bootstrap-daterangepicker/daterangepicker.css'), [], JMVC_ASSETS_VER, $media = 'all' );

			wp_enqueue_script( 'moment', site_url('jmvc/assets/bower/moment/moment.js'), ['jquery'], JMVC_ASSETS_VER );
			wp_enqueue_script( 'daterangepicker', site_url('jmvc/assets/bower/bootstrap-daterangepicker/daterangepicker.js'), ['moment'], JMVC_ASSETS_VER);
			
			// home page uses the counters
			if( $slug == 'home' )
			{
				wp_enqueue_script( 'flipclock', site_url('jmvc/assets/bower/flipclock/compiled/flipclock.js'), ['jquery'], JMVC_ASSETS_VER );
				wp_enqueue_style( 'flipclock', site_url('jmvc/assets/bower/flipclock/compiled/flipclock.css'), [], JMVC_ASSETS_VER, $media = 'all' );
			
				wp_localize_script( 'flipclock', 'flipper_data', array(
					'lives_transformed_start_num' => get_field('lives_transformed_start_num')
				));
			}

		}, 10);

		add_filter('charitable_ambassadors_form_submission_buttons_primary_new_text', function()
		{
			return 'Save Campaign &raquo;';
		});
	}
}