<?php

define('CAMPAIGN_IS_A_HOPE_PROJECT', 'hope_project');
define('CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT', 'earmarked_for_hope_project');
define('CAMPAIGN_EARMARKED_FOR_HOPE_LOAN', 'earmarked_for_hope_loan');
define('CAMPAIGN_NON_EARMARKED_DONATION', 'non_earmarked_donation');

class HopeCampaign extends JModelBase
{
	use ACFModelTrait;
	public static $post_type = 'campaign';
	public static $instances = array();
	public static $HOPELOAN_CAMPAIGN_ID = 1727;
	public static $DONATION_CAMPAIGN_ID = 1728;
	public static $STANDALONE_CAMPAIGN_ID = 1760;
	//public static $DEFAULT_THUMBNAIL_ID = 1681;

	public $charity;    		// the chartiable campaign (Charitable_Campaign)
	protected $parent = null;	// parent HopeCampaign (if any)

	// We use this instead of the constructor because of all the filters/actions each instance utilizes.
	// We don't want to duplicate these filters/actions.
	public static function get($id)
	{
		if( !@self::$instances[$id] ) {
			self::$instances[$id] = new HopeCampaign($id);
		}

		return self::$instances[$id];
	}

	public function __construct($id)
	{
		parent::__construct($id);

		$this->start_funded_at = (float)$this->start_funded_at; // @CAMPAIGN: hook into 'charitable_campaign_donated_amount' filter

		// chartiable campaign tools
		$this->charity = new Charitable_Campaign($id);
		$this->setStartingFunding();

		// parent campaign (if any)
		if( $this->isChildCampaign() ) {
			$this->parent = HopeCampaign::get($this->post()->post_parent);
		}

		$this->verifyCompleteness();
	}

	protected function setStartingFunding()
	{
		add_filter('charitable_campaign_donated_amount', function($amount, $this_charity, $sanitize)
		{
			// ignore any charity that's not ours
			if( $this_charity->ID != $this->charity->ID ) {
				return $amount;
			}

			return $amount + $this->start_funded_at;
			
		}, 10, 3);

		// at least 1 donor (if we have a start_funded_at amount)
		add_filter('charitable_campaign_donor_count', function($num_donors, $this_charity) 
		{
			// ignore any charity that's not ours
			if( $this_charity->id != $this->charity->id ) {
				return;
			}

			if( $num_donors > 0 || $this->start_funded_at == 0 ) {
				return $num_donors;
			}

			return 1;

		}, 10, 2);

		// favor the short description over the long one
		add_filter('wpv_filter_post_excerpt', function($excerpt)
		{
			global $post;

			$short_description = esc_textarea( get_post_meta( $post->ID, '_campaign_description', true ) );

			if( $short_description ) {
				return $short_description;
			}

			return $excerpt;

		}, 10, 1);
	}

	protected function verifyCompleteness()
	{
		// taxonomy field ids for type project-completeness
		// we use this taxonomy to hide complete items from SuperCarousel
		$COMPLETE_ID = 34;
		$RUNNING_ID = 35;

		// make sure our "is_complete" flag is synced
		$is_complete = get_field('is_complete', $this->ID, false);
		$this_is_complete = $this->isComplete();
		$terms = wp_get_post_terms( $this->ID, 'project-completeness' );

		//var_dump($this->id, 'this_is_complete', $this_is_complete, 'is_complete', $is_complete, '$terms[0]->term_id', $terms[0]->term_id, 'COMPLETE_ID', $COMPLETE_ID);
		if( $is_complete === '' || $this_is_complete != $is_complete || count($terms) != 1 || ($this_is_complete && $terms[0]->term_id != $COMPLETE_ID) ) 
		{
			// our ACF field
			update_field('is_complete', (int)$this_is_complete, $this->ID);

			$term = $this_is_complete ? $COMPLETE_ID : $RUNNING_ID;
			wp_set_post_terms( $this->ID, $term, 'project-completeness', false );
		}
	}

	public static function setupFilters()
	{
		// we modified plugins/ts-googlemaps-for-vc/assets/ts_gmvc_googlemap.php:1379 / function TS_VCSC_GoogleMapsPlus_Single()
		// by adding a 3rd parameter to the shortcode_atts() function: "array(), $atts, 'gmaps_plus_single' ));"
		// so that we can have a filter here to inject the Hope Campaign address
		add_filter( "shortcode_atts_gmaps_plus_single", function($out, $pairs, $atts, $shortcode)
		{
			global $post;
			$hope_campaign = HopeCampaign::get($post->ID);

			// only hijack the address that we specify should be a hope-campaign-address
			if( @$atts['marker_address'] != 'hope-campaign-address' || $hope_campaign->fundraiser_type != CAMPAIGN_IS_A_HOPE_PROJECT ) {
				return $out;
			}
		
			$out['marker_position'] = 'coordinates';
			$out['marker_latitude'] = $hope_campaign->_campaign_latitude;
			$out['marker_longitude'] = $hope_campaign->_campaign_longitude;

			return $out;
		}, 10, 4);

		// Let's inject some hope campaign data into SuperCarousel by hooking into the filters
		add_filter('SuperCarousel_Post_customkey', function($data)
		{
			$post_id = $data['ID'];
			return do_shortcode("[hope-campaign-progressbar post_id=$post_id]");
		}, 10, 3);

		// use {tags} for the hope category icon
		add_filter('SuperCarousel_Post_tags', function($data)
		{
			$post_id = $data['ID'];
			return do_shortcode("[hope-campaign-category-icon-img post_id=$post_id]");
		}, 10, 3);

		add_filter('jakesval', function()
		{
			return 'jakeyval';
		});

		// we use this to populate the dropdown in formidable form when the user
		// selects which hope project they want to fundraise for
		add_filter('frm_setup_new_fields_vars', array('HopeCampaign', 'hopeProjectToDropdown'), 20, 2);
		add_filter('frm_setup_edit_fields_vars', array('HopeCampaign', 'hopeProjectToDropdown'), 20, 2); //use this function on edit too
	
		// we use this to populate the dropdown in formidable form when the user
		// selects which hope loan they want to fundraise for
		add_filter('frm_setup_new_fields_vars', array('HopeCampaign', 'hopeLoanToDropdown'), 20, 2);
		add_filter('frm_setup_edit_fields_vars', array('HopeCampaign', 'hopeLoanToDropdown'), 20, 2);
	
		// There are there some donation fields that are required, that we don't necessarily
		// want to be required. Not sure what will break but here we go.
		add_filter( 'charitable_form_missing_fields', function($missing, $uh_this, $fields, $submitted)
		{
			$dont_care = ['Short Description', 'First name', 'Last name'];
			foreach($missing as &$miss) {

				if ( in_array($miss, $dont_care) ) {
					unset($miss);
				}
			}
		}, 10, 4);

		// default thumbnail id
		add_filter( 'get_post_metadata', function($always_null, $object_id, $meta_key, $single)
		{
			$post = get_post($object_id);

			if( $post->post_type != 'campaign' ) {
				return null;
			}

			if($meta_key == '_thumbnail_id') 
			{
				global $wpdb;
				$thumbnail_query = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE post_id=$object_id AND meta_key='_thumbnail_id'");
				
				// already has one?
				if( @$thumbnail_query[0]->meta_value ) {
					return @$thumbnail_query[0]->meta_value;
				}

				// figure out what kind of campaign it is
				$fundraiser_type = get_field('fundraiser_type', $object_id);

				$default_headers = array(
					CAMPAIGN_IS_A_HOPE_PROJECT => null,
					CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT => get_field('hope_project_fundraiser_header_image', 'option'),
					CAMPAIGN_EARMARKED_FOR_HOPE_LOAN => get_field('hope_loan_fundraiser_header_image', 'option'),
					CAMPAIGN_NON_EARMARKED_DONATION => get_field('donation_fundraiser_header_image', 'option')
				);

				return $default_headers[$fundraiser_type];
			}
			/*
			else if($meta_key == 'is_complete') 
			{
				$campaign = HopeCampaign::get($object_id);
				return $campaign->isComplete();
			}
			*/

			return null;

		}, 10, 4);


		/*
		add_filter( 'wpv_filter_query', function($query_args, $view_settings, $view_id)
		{
			var_dump($view_id, $view_settings, $query_args);
		}, 99, 3 );
		
		add_filter('acf/load_value/key=field_5a2ecbca1740b', function($value, $post_id, $field)
		{
			$campaign = HopeCampaign::get($post_id);
			return $campaign->isComplete();
		}, 10, 3);	
		
		add_filter('acf/load_value/name=is_complete', function($value, $post_id, $field)
		{
			$campaign = HopeCampaign::get($post_id);
			return $campaign->isComplete();
		}, 10, 3);	
		*/


		// body css classes
		add_filter( 'body_class', function( $classes ) 
		{
			if( !$charity = charitable_get_current_campaign() ) {
				return $classes;
			}

			$body_classes = [];

			$campaign = HopeCampaign::get($charity->ID);

			$body_classes[] = $campaign->percentCompleted() >= 1 ? 'campaign-complete' : 'campaign-running';
			$body_classes[] =  'campaign-status-' . $campaign->charity->get_status_key();
			$body_classes[] = $campaign->isChildCampaign() ? 'campaign-is-child' : 'campaign-is-parent';
			$body_classes[] = $campaign->fundraiser_type;

    		return array_merge( $classes, $body_classes );
		});

		// allow scheduled campaigns to be seen by admins or the campaign owner
		add_filter('the_posts', function($posts)
		{
			global $wp_query, $wpdb;

			if( !is_single() ) {
				return $posts;
			}

			if($wp_query->post_count == 0)
			{
				$new_posts = $wpdb->get_results($wp_query->request);
			}

			$post = $new_posts[0];

			// we only care about campaigns
			if( $post->post_type != 'campaign' ) {
				return $posts;
			}

			// we only want to show future posts to either admins or the owner of the campaign
			if( $post->post_author == get_current_user_id() || current_user_can('manage_options')  ) {
				return $new_posts;
			}

			return $posts;
		});
	}

	// we use this to populate the dropdown in formidable form when the user
	// selects which hope project they want to fundraise for
	public static function hopeProjectToDropdown($values, $field)
	{
		// add the id of any fields that you want this dropdown to populate
		$dropdown_formidable_field_ids = [108];
		if(in_array($field->id, $dropdown_formidable_field_ids))
		{ 
			$posts = get_posts( array(
				'post_type' 	=> 'campaign', 
				'post_status' 	=> 'publish', 
				'numberposts' => 999, 
				'orderby' => 'title', 
				'order' => 'ASC')
			);

			unset($values['options']);
			$values['options'] = array('');
			
			foreach($posts as $p)
			{
				$campaign = HopeCampaign::get($p->ID);

				if( $campaign->isChildCampaign() || $campaign->isComplete() ) {
					continue;
				}

				if( in_array($p->ID, [HopeCampaign::$HOPELOAN_CAMPAIGN_ID, HopeCampaign::$DONATION_CAMPAIGN_ID, HopeCampaign::$STANDALONE_CAMPAIGN_ID]) ) {
					continue;
				}
			
				$values['options'][$p->ID] = "$campaign->post_title |  $" . number_format($campaign->leftToRaise());
			}

			$values['use_key'] = true; //this will set the field to save the post ID instead of post title
		}
		return $values;
	}

	// we use this to populate the dropdown in formidable form when the user
	// selects which hope project they want to fundraise for
	public static function hopeLoanToDropdown($values, $field)
	{
		// add the id of any fields that you want this dropdown to populate
		$dropdown_formidable_field_ids = [68];
		if(in_array($field->id, $dropdown_formidable_field_ids))
		{ 
			$posts = get_posts( array(
				'post_type' 	=> 'product', 
				'post_status' 	=> 'publish', 
				'numberposts' => 999, 
				'orderby' => 'title', 
				'order' => 'ASC')
			);

			unset($values['options']);
			$values['options'] = array('');
			
			foreach($posts as $p){
				$post = get_post($p->ID);
				$product = wc_get_product( $p->ID );
				$values['options'][$p->ID] = "$post->post_title |  $" . $product->get_price();
			}

			$values['use_key'] = true; //this will set the field to save the post ID instead of post title
		}

		//var_dump($values['options']);
		return $values;
	}

	public static function setupActions()
	{
		// share some variables with javascript
		add_action('wp_enqueue_scripts', function()
		{
			wp_localize_script( 'jquery', 'HopeCampaign', array(
				'CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT' 	=> CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT,
				'CAMPAIGN_EARMARKED_FOR_HOPE_LOAN'		=> CAMPAIGN_EARMARKED_FOR_HOPE_LOAN,
				'CAMPAIGN_NON_EARMARKED_DONATION'		=> CAMPAIGN_NON_EARMARKED_DONATION
			));
		}, 10, 1);

		// whenever the single.php page is loaded in, make sure the post being loaded in has a HopeCampaign hot n ready
		add_action('the_post', function($post, $query)
		{
			if(!is_single()) {
				return $post;
			}

			global $post;

			// setup actions/filters necessary for this campaign
			if( $post->post_type == self::$post_type ) {
				HopeCampaign::get($post->ID);

				global $wp_filter;
				
				/*
				remove_filter( 'charitable_campaign_summary', 'charitable_template_campaign_percentage_raised' );
				remove_filter( 'charitable_campaign_summary', 'charitable_template_campaign_donation_summary' );
				remove_filter( 'charitable_campaign_summary', 'charitable_template_campaign_donor_count' );
				remove_filter( 'charitable_campaign_summary', 'charitable_template_campaign_time_left' );
				remove_filter( 'charitable_campaign_summary', 'charitable_template_donate_button' );
				*/
			
				// regular ole "remove filter" didn't work for some reason
				$wp_filter['charitable_campaign_summary']->callbacks = array();
				$wp_filter['charitable_campaign_content_before']->callbacks = array();
			}

			return $post;
		}, 11, 2);

		// set donation amount if it's in the URL
		add_action( 'the_post', function($post)
		{
			if( @!$_REQUEST['donate_amount'] ) {
				return $post;
			}

			$processor = Charitable_Donation_Processor::get_instance();
			if ( !$processor->get_campaign() ) {
				var_dump("no processor campagin!", $processor);
			}

			charitable_get_session()->add_donation( $processor->get_campaign()->ID, $_REQUEST['donate_amount'] );
			//$donations_url = charitable_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $processor->get_campaign()->ID ) );
			//wp_redirect( $donations_url );
			
			return $post;
		}, 22);
	}

	public static function makeShortcodes()
	{
		add_shortcode('hope-campaign-class', function($attrs)
		{
			global $post;
			$hope_campaign = HopeCampaign::get($post->ID);

			// health, education, clean-water, agriculture
			$proj_cat = get_term($hope_campaign->category);
			$completed_class = $hope_campaign->isComplete() ? 'complete' : 'in-progress';

			return "hope-campaign-box hope-campaign-$proj_cat->slug $completed_class id-$hope_campaign->id";
		});

		add_shortcode('hope-campaign-category-name', function($attrs)
		{
			global $post;
			$hope_campaign = HopeCampaign::get($post->ID);

			// health, education, clean-water, agriculture
			$proj_cat = get_term($hope_campaign->category);
			return $proj_cat->name;
		});

		add_shortcode('hope-campaign-category-icon-img', function($attrs)
		{
			$attrs = shortcode_atts(array(
				'post_id'   => null,
				'size'	 => 'small', // small, large
			), $attrs);

			if( $attrs['post_id'] ) {
				$hope_campaign = HopeCampaign::get($attrs['post_id']);
			}
			else {
				global $post;
				$hope_campaign = HopeCampaign::get($post->ID);
			}

			$icon_field = ($attrs['size'] == 'small') ? 'small_icon' : 'big_icon';

			// health, education, clean-water, agriculture
			$proj_cat = get_term($hope_campaign->category);
			$icon = get_field($icon_field, 'project_category_' . $proj_cat->term_id);

			return '<img src="' . $icon['url'] . '" class="project_category_icon ' . $attrs['size'] . ' ' . $proj_cat->slug . '" />';
		});

		add_shortcode('hope-campaign-progressbar', function($attrs)
		{
			$attrs = shortcode_atts(array(
				'post_id'       => null,
				'progress_type' => 'number',    // number, percent
				'template'      => 'default',   // hashtag will be replaced w/a number: "$# TO GO", "# FUNDED"
				'completed_msg' => 'COMPLETED'
			), $attrs);

			if( $attrs['post_id'] ) {
				$hope_campaign = HopeCampaign::get($attrs['post_id']);
			}
			else {
				global $post;
				$hope_campaign = HopeCampaign::get($post->ID);
			}

			$amt_togo = $hope_campaign->leftToRaise();
			$pct_completed = $hope_campaign->percentCompleted();
			$template = $attrs['template'];

			if( $attrs['progress_type'] == 'number' ) 
			{
				$template = ($template != 'default' ? $template : '$# TO GO');
				$number = number_format($amt_togo, 0);

				if($number <= 0) {
					$message = $attrs['completed_msg'];
				}
				else {
					$message = str_replace('#', $number, $template);
				}
			}
			else if( $attrs['progress_type'] == 'percent' ) 
			{
				$template = ($template != 'default' ? $template : '#% FUNDED');
				$pct = round($pct_completed, 3) * 100;
				$message = str_replace('#', $pct, $template);
			}

			$proj_cat = get_term($hope_campaign->category);
			$completed_class = $hope_campaign->isComplete() ? 'complete' : 'in-progress';

			return '<span class="hope-campaign-progressbar ' . "$proj_cat->slug $completed_class" . '" data-started-at="' . $hope_campaign->start_funded_at . '" data-goal="' . $hope_campaign->goal() . '" data-donated="' . $hope_campaign->amountDonated() . '" data-pct="' . $pct_completed . '"><span class="inner bar"><!-- This is the bar --></span><span class="message">' . $message . '</span></span>';
		});

		// this will output the slugs of all the current categories which are being searched, space delimited.
		// we are making this available to the front-end via: https://wow-ss.s3.amazonaws.com/7agaLzw.png (/wp-admin/admin.php?page=toolset-settings)
		// and using it in a nested shortcode here: https://wow-ss.s3.amazonaws.com/3dVbKZs.png (/wp-admin/admin.php?page=views-editor&view_id=1597)
		add_shortcode('hope-campaign-categories-searched', function($attrs)
		{
			// either via page load
			if( @$_REQUEST['wpv-campaign_category'] ) {
				return implode(' ', $_REQUEST['wpv-campaign_category']);
			}

			// or AJAX
			else if( @$_REQUEST['search']['dps_general'] )
			{
				$slugs = [];

				foreach($_REQUEST['search']['dps_general'] as $item) 
				{
					if( $item['name'] != "wpv-campaign_category[]" ) {
						continue;
					}

					$slugs[] = $item['value'];
				}

				return implode(' ', $slugs);
			}
			

			return '';
		});

		// show the correct "similar projects" carousel based on the category of the current post
		add_shortcode('hope-campaign-similar-projects-carousel', function($attrs)
		{
			global $post;
			$hope_campaign = HopeCampaign::get($post->ID);

			// health, education, clean-water, agriculture
			$proj_cat = get_term($hope_campaign->category);

			$carousels = array(
				'education'     => "[supercarousel slug='hope-campaigns-education']",
				'health'        => "[supercarousel slug='hope-campaigns-health']",
				'clean-water'   => "[supercarousel slug='hope-campaigns-clean-water']",
				'agriculture'   => "[supercarousel slug='hope-campaigns-agriculture']"
			);

			return do_shortcode($carousels[$proj_cat->slug]);
		});

		// show the DONATE button, which pops open a modal to donate to the campaign
		add_shortcode('hope-campaign-donate-btn', function($attrs)
		{
			global $post;
			$hope_campaign = HopeCampaign::get($post->ID);

			// already done? Show messaging instead of donate button
			if( $hope_campaign->isComplete() ) 
			{
				if( $hope_campaign->has_achieved_goal() ) 
				{
					return JView::get('hope-campaign/donate/funding-complete', array(
						'hope_campaign' => $hope_campaign
					));
				}
				else
				{
					echo "<!-- hope_campaign->isComplete() && !hope_campaign->has_achieved_goal() -->\n";
					return JView::get('hope-campaign/donate/campaign-ended', array(
						'hope_campaign' => $hope_campaign
					));
				}
			}
			else if( $hope_campaign->charity->has_ended() ) 
			{
				echo "<!-- hope_campaign->charity->has_ended() -->\n";
				return JView::get('hope-campaign/donate/campaign-ended', array(
					'hope_campaign' => $hope_campaign
				));
			}
			else if( $hope_campaign->post_status != 'publish' )
			{
				if( $hope_campaign->post_status == 'future' )
				{
					return JView::get('hope-campaign/donate/campaign-in-the-future', array(
						'hope_campaign' => $hope_campaign
					));
				}
				else
				{
					return JView::get('hope-campaign/donate/campaign-not-published', array(
						'hope_campaign' => $hope_campaign
					));
				}
			}

			return JView::get('hope-campaign/donate/button', array(
				'hope_campaign' => $hope_campaign
			));
		});

		/* some properties that we expose via shortcode */
		/* -------------------------------------------- */

		// amount left to raise
		add_shortcode('hope-campaign-amount-left-to-raise', function($attrs)
		{
			global $post;
			$hope_campaign = HopeCampaign::get($post->ID);

			$attrs = shortcode_atts(array(
				'number_format' => 'true',  // 1000 -> 1,000
			), $attrs);

			$left_to_raise = ceil($hope_campaign->leftToRaise());
			return $left_to_raise < 0 ? 0 : $left_to_raise;
		});

		add_shortcode('hope-campaign-goal', function($attrs)
		{
			global $post;
			$hope_campaign = HopeCampaign::get($post->ID);

			return $hope_campaign->goal();
		});

		add_shortcode('hope-campaign-standalone-donation-form', function($attrs)
		{
			return JView::get('hope-campaign/donate/standalone-donate-form', array(
				null
			));
		});
	}

	// how much of the project has been funded by donations?
	public function amountDonated()
	{
		return $this->charity->get_donated_amount(true);
	}

	// how much more funding do we need to hit the goal?
	// if the goal is passed, a negative number will be returned;
	public function leftToRaise()
	{
		return $this->goal() - $this->amountDonated();
	}

	// how many days does this campaign have left to run?
	public function daysLeft()
	{
		$diff = strtotime($this->charity->end_date) - time();
		return ceil($diff / (60 * 60 * 24));
	}

	// how many days does this campaign running in total
	public function runTimeInDays()
	{
		$diff = strtotime($this->charity->end_date) - strtotime($this->post_date);
		return ceil($diff / (60 * 60 * 24));
	}

	// what percentage is this project funded? It will be 100% (1.0) maximum by default
	// number between 0-1.0 by default, or greater than 1.0 if max_100 is false
	public function percentCompleted($max_100=true)
	{
		$pct = $this->charity->get_percent_donated_raw()/100;

		if( $max_100 && $pct > 1.0 ) {
			return 1.0;
		}

		return $pct;
	}

	public function goal()
	{
		return $this->charity->get_goal();  // meta: _campaign_goal
	}

	public function isChildCampaign()
	{
		return $this->post()->post_parent != null;
	}

	// is the campaign complete?
	public function isComplete()
	{
		// has the goal been met?
		if( $this->charity->get_goal() && $this->charity->has_achieved_goal() ) {
			return true;
		}

		// has our parent goal been bet (if we have one?)
		if( $this->isChildCampaign() && $this->parent->isComplete() ) {
			return true;
		}

		// has the running time ended?
		if( $this->charity->has_ended() ) {
			return true;
		}
		
		return false;
	}

	// proxy to the $charity
	public function __call($method, $args)
	{
		if( method_exists($this->charity, $method) ) {
			return call_user_func_array(array($this->charity, $method), $args);
		}
	}

	/*
	public function __get($key)
	{
		if( !isset($this->$key) ) {
			return @$this->charity->$key;
		}
	}
	*/
	
}