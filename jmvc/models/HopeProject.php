<?php

/* REPLACED WITH HopeCampaign
class HopeProject extends JModelBase
{
	use ACFModelTrait;
	public static $post_type = 'hope-project';

	protected $post;

	public function __construct($id)
	{
		parent::__construct($id);

		$this->start_funded_at = (float)$this->start_funded_at;	// @CAMPAIGN: hook into 'charitable_campaign_donated_amount' filter
		$this->goal = (float)$this->goal;
	}

	public static function setupFilters()
	{
		// we modified plugins/ts-googlemaps-for-vc/assets/ts_gmvc_googlemap.php:1379 / function TS_VCSC_GoogleMapsPlus_Single()
		// by adding a 3rd parameter to the shortcode_atts() function: "array(), $atts, 'gmaps_plus_single' ));"
		// so that we can have a filter here to inject the Hope Project address
		add_filter( "shortcode_atts_gmaps_plus_single", function($out, $pairs, $atts, $shortcode)
		{
			// only hijack the address that we specify should be a hope-project-address
			if( @$atts['marker_address'] != 'hope-project-address' ) {
				return $out;
			}

			global $post;
			$project = new HopeProject($post->ID);

			$atts['marker_address'] = $project->location_marker['address'];
			$out['marker_address'] = $project->location_marker['address'];
			return $out;
		}, 10, 4);

		// Let's inject some hopeloan data into SuperCarousel by hooking into the filters
		add_filter('SuperCarousel_Post_customkey', function($data)
		{
			$post_id = $data['ID'];
			return do_shortcode("[hope-project-progressbar post_id=$post_id]");
		}, 10, 3);

		// use {tags} for the hope category icon
		add_filter('SuperCarousel_Post_tags', function($data)
		{
			$post_id = $data['ID'];
			return do_shortcode("[hope-project-category-icon-img post_id=$post_id]");
		}, 10, 3);
	}

	public static function makeShortcodes()
	{
		add_shortcode('hope-project-class', function($attrs)
		{
			global $post;
			$project = new HopeProject($post->ID);

			// health, education, clean-water, agriculture
			$proj_cat = get_term($project->category);
			return "hope-project-$proj_cat->slug";
		});

		add_shortcode('hope-project-category-name', function($attrs)
		{
			global $post;
			$project = new HopeProject($post->ID);

			// health, education, clean-water, agriculture
			$proj_cat = get_term($project->category);
			return $proj_cat->name;
		});

		add_shortcode('hope-project-category-icon-img', function($attrs)
		{
			$attrs = shortcode_atts(array(
				'post_id'	=> null,
				'size' 		=> 'small',	// small, large
			), $attrs);

			if( $attrs['post_id'] ) {
				$project = new HopeProject($attrs['post_id']);
			}
			else {
				global $post;
				$project = new HopeProject($post->ID);
			}

			$icon_field = ($attrs['size'] == 'small') ? 'small_icon' : 'big_icon';

			// health, education, clean-water, agriculture
			$proj_cat = get_term($project->category);
			$icon = get_field($icon_field, 'project_category_' . $proj_cat->term_id);

			return '<img src="' . $icon['url'] . '" class="project_category_icon ' . $attrs['size'] . ' ' . $proj_cat->slug . '" />';
		});

		add_shortcode('hope-project-progressbar', function($attrs)
		{
			$attrs = shortcode_atts(array(
				'post_id'		=> null,
				'progress_type' => 'number',	// number, percent
				'template'		=> 'default',	// hashtag will be replaced w/a number: "$# TO GO", "# FUNDED"
			), $attrs);

			if( $attrs['post_id'] ) {
				$project = new HopeProject($attrs['post_id']);
			}
			else {
				global $post;
				$project = new HopeProject($post->ID);
			}

			$amt_togo = $project->leftToRaise();
			$pct_completed = $project->percentCompleted();
			$template = $attrs['template'];

			if( $attrs['progress_type'] == 'number' ) 
			{
				$template = ($template != 'default' ? $template : '$# TO GO');
				$number = number_format($amt_togo, 0);
				$message = str_replace('#', $number, $template);
			}
			else if( $attrs['progress_type'] == 'percent' ) 
			{
				$template = ($template != 'default' ? $template : '#% FUNDED');
				$pct = round($pct_completed, 3) * 100;
				$message = str_replace('#', $pct, $template);
			}

			return '<span class="hope-project-progressbar" data-started-at="' . $project->start_funded_at . '" data-goal="' . $project->goal . '" data-donated="' . $project->amountDonated() . '" data-pct="' . $pct_completed . '"><span class="inner">' . $message . '</span></span>';
		});

		// this will output the slugs of all the current categories which are being searched, space delimited.
		// we are making this available to the front-end via: https://wow-ss.s3.amazonaws.com/7agaLzw.png (/wp-admin/admin.php?page=toolset-settings)
		// and using it in a nested shortcode here: https://wow-ss.s3.amazonaws.com/3dVbKZs.png (/wp-admin/admin.php?page=views-editor&view_id=1496)
		add_shortcode('hope-project-categories-searched', function($attrs)
		{
			// either via page load
			if( @$_REQUEST['wpv-project_category'] ) {
				return implode(' ', $_REQUEST['wpv-project_category']);
			}

			// or AJAX
			else if( $_REQUEST['search']['dps_general'] )
			{
				$slugs = [];

				foreach($_REQUEST['search']['dps_general'] as $item) 
				{
					if( $item['name'] != "wpv-project_category[]" ) {
						continue;
					}

					$slugs[] = $item['value'];
				}

				return implode(' ', $slugs);
			}
			

			return '';
		});

		// show the correct "similar projects" carousel based on the category of the current post
		add_shortcode('hope-project-similar-projects-carousel', function($attrs)
		{
			global $post;
			$project = new HopeProject($post->ID);

			// health, education, clean-water, agriculture
			$proj_cat = get_term($project->category);

			$carousels = array(
				'education'		=> "[supercarousel slug='hope-projects-education']",
				'health'		=> "[supercarousel slug='hope-projects-health']",
				'clean-water'	=> "[supercarousel slug='hope-projects-clean-water']",
				'agriculture'	=> "[supercarousel slug='hope-projects-agriculture']"
			);

			return do_shortcode($carousels[$proj_cat->slug]);
		});

		// some properties that we expose via shortcode
		
		// amount left to raise
		add_shortcode('hope-project-amount-left-to-raise', function($attrs)
		{
			global $post;
			$project = new HopeProject($post->ID);

			$attrs = shortcode_atts(array(
				'number_format' => 'true',	// 1000 -> 1,000
			), $attrs);

			$left_to_raise = ceil($project->leftToRaise());
			return $left_to_raise < 0 ? 0 : $left_to_raise;
		});
	}

	// how much of the project has been funded by donations?
	public function amountDonated()
	{
		$amount_donated = get_post_meta($this->ID, 'amount_donated', true);

		if( !$amount_donated ) {
			return 0;
		}

		return (float)$amount_donated;
	}

	// how much more funding do we need to hit the goal?
	// if the goal is passed, a negative number will be returned;
	public function leftToRaise()
	{
		return $this->goal - $this->start_funded_at - $this->amountDonated();
	}

	// what percentage is this project funded? It will be 100% (1.0) maximum by default
	// number between 0-1.0 by default, or greater than 1.0 if max_100 is false
	public function percentCompleted($max_100=true)
	{
		$total_funded = $this->start_funded_at + $this->amountDonated();
		$pct = $total_funded / $this->goal;

		if( $max_100 && $pct > 1.0 ) {
			return 1.0;
		}

		return $pct;
	}

	// has the goal been met?
	public function isComplete()
	{
		return $this->leftToRaise() <= 0;
	}
	
}
*/