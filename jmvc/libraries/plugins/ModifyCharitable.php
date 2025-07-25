<?php
/**
 * Chartiable Mods
 */

class ModifyCharitable
{
	function __construct()
	{
		$this->modifyCharitableDisplayDates();
		$this->saveOurCharitableFields();
		$this->overrideNonEditableFields();
		$this->injectFieldsIntoCampaignData();
		$this->earmarkDonations();
		$this->addInHonorOfFields();
	}

	function injectFieldsIntoCampaignData()
	{
		// inject a variable so that we can have a "parent fundraiser" id added to the 
		// "create a fundraiser" page
		add_filter( 'charitable_campaign_submission_campaign_fields' , function($fields, $form)
		{
			if( !isset($_REQUEST['charitable_parent_id']) ) {
				return $fields;
			}

			$fields['charitable_parent_id'] = array(
				'value'     => $_REQUEST['charitable_parent_id'],
				'priority'  => 1, // Adjust this to change where the field is inserted.
				'data_type' => 'meta',
				'required'  => false,
				'clear'     => false,
				'type'      => 'hidden',
			);
			
			return $fields;
		}, 10, 2 ); 

		add_filter( 'charitable_campaign_submission_campaign_fields', function($campaign_fields, $this_Charitable_Ambassadors_Campaign_Form)
		{
			$campaign = $this_Charitable_Ambassadors_Campaign_Form->get_campaign();
			$campaign_fields['start_date'] 	= array(
				'label'         => 'Start Date',
				'type'          => 'hidden',
				'priority'      => 2,
				'required'      => false,
				'fullwidth'     => false,
				'value'         => $campaign->post_date,
				'data_type'     => 'meta',
				'editable'      => false,
			);

			$campaign_fields['end_date'] 	= array(
				'label'         => 'End Date',
				'type'          => 'hidden',
				'priority'      => 2,
				'required'      => false,
				'fullwidth'     => false,
				'value'         => $campaign->end_date,
				'data_type'     => 'meta',
				'editable'      => false,
			);

			$campaign_fields['end_date'] 	= array(
				'label'         => 'End Date',
				'type'          => 'hidden',
				'priority'      => 2,
				'required'      => false,
				'fullwidth'     => false,
				'value'         => $campaign->end_date,
				'data_type'     => 'meta',
				'editable'      => false,
			);

			$campaign_fields['fundraiser_type'] 	= array(
				'label'         => 'Fundraiser Type',
				'type'          => 'hidden',
				'priority'      => 2,
				'required'      => false,
				'fullwidth'     => false,
				'value'         => get_field('fundraiser_type', $campaign->ID),
				'data_type'     => 'meta',
				'editable'      => false,
			);

			$campaign_fields['earmark_identifier'] 	= array(
				'label'         => 'Fundraiser Type',
				'type'          => 'hidden',
				'priority'      => 2,
				'required'      => false,
				'fullwidth'     => false,
				'value'         => $campaign->earmark_identifier,
				'data_type'     => 'meta',
				'editable'      => false,
			);

			return $campaign_fields;
		}, 100, 2);
	}

	function modifyCharitableDisplayDates()
	{
		add_filter( 'charitable_campaign_time_left', function($time_left, $fundraiser )
		{
			$end_date = get_post_meta( $fundraiser->ID, '_campaign_end_date', true );
			return "<span class='time-left'>" . date('m/d/Y', strtotime($fundraiser->post_date)) . "</span> to <span class='time-left'>" . date('m/d/Y', strtotime($end_date)) . "</span>";
		}, 100, 2);
	}

	function saveOurCharitableFields()
	{
		// we want to set the "parent fundraiser" by giving this 
		// charitable fundraiser a parent post, assuming it has one!
		add_action('charitable_campaign_submission_save', function($submitted, $campaign_id, $user_id, $form)
		{
			if( !isset($submitted['charitable_parent_id']) ) {
				return;
			}

			$post = get_post($campaign_id);

			$parent_post = get_post($submitted['charitable_parent_id']);
			$parent_campaign = HopeCampaign::get($parent_post->ID);
			$child_campaign = HopeCampaign::get($post->ID);

			// make sure the charitable_parent_id is a parent
			
			$parent_check = ($parent_post != null) && ($parent_post->post_type == 'campaign');
			if( !$parent_check ) {
				// error! This is not a parent chartiable item
				wp_delete_post($post->ID, true);
				die("ERROR: Parent fundraiser ($post->post_title) with id $post->ID is not a parent campaign! Go back and try again.");
			}

			// make sure that they are not trying to raise more than the parent campaign needs
			if( $child_campaign->goal() > $parent_campaign->leftToRaise() ) {
				// error! They are trying to raise too much money
				wp_delete_post($post->ID, true);
				die("ERROR: Parent fundraiser ($parent_campaign->post_title) only has $" . $parent_campaign->leftToRaise() . " left to raise. Your goal ($" . $child_campaign->goal() . ") must be less than or equal to that. Go back and try again.");
			}

			// attach the parent campaign
			wp_update_post(array(
				'ID'			=> $post->ID,
				'post_parent' 	=> $submitted['charitable_parent_id']
			));

			/*
			// copy the category over from parent
			$parent_cat = get_term($parent_campaign->category);
			wp_set_post_terms( $post->ID, [$parent_cat->term_id], 'campaign_category', false );
			*/

		}, 10, 4);

		// save custom variables (future posts, fundraiser_type, earmark, post terms)
		add_filter( 'charitable_campaign_submission_core_data', function($values, $user_id, $submitted, $Charitable_Ambassadors_Campaign_Form_obj)
		{
			if(@$submitted['parent_id']) {
				$parent_id = $submitted['parent_id'];
				$values['post_parent'] = $submitted['parent_id'];
			}
			else 
			{
				$campaign = HopeCampaign::get($values['ID']);
				$parent_id = $campaign->parent_id;
			}

			$parent = HopeCampaign::get($parent_id);

			// we want to set a "start date" for charitable posts in the future if necessary.
			// Make sure "Timezone" is set to UTC in Wordpress Settings: https://wow-ss.s3.amazonaws.com/MjdC8Ia.png
			$start_date = $submitted['start_date'];
			$today = gmdate('Y-m-d');

			$values['post_date'] = $start_date;
			$values['post_date_gmt'] = $start_date;//gmdate($submitted['start_date']);

			if( strtotime($start_date) > strtotime($today) ) 
			{
				$values['post_status'] = 'pending';

				add_action('charitable_campaign_submission_save', function($submitted, $campaign_id, $user_id, $form)
				{
					// this will trigger the post to publish in the future
					check_and_publish_future_post($campaign_id);
				}, 10, 4);
			}
			
			// earmark this project
			if( $submitted['fundraiser_type'] == CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT )
			{
				$values['meta_input'] = array(
					'fundraiser_type' 	=> CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT
				);
			}

			if( $submitted['fundraiser_type'] == CAMPAIGN_EARMARKED_FOR_HOPE_LOAN )
			{
				$values['meta_input'] = array(
					'fundraiser_type' 		=> CAMPAIGN_EARMARKED_FOR_HOPE_LOAN,
					'earmark_identifier' 	=> $submitted['earmark_identifier'],
					//'hide_from_frontend' 	=> true
				);
			}

			if( $submitted['fundraiser_type'] == CAMPAIGN_NON_EARMARKED_DONATION )
			{
				$values['meta_input'] = array(
					'fundraiser_type' 		=> CAMPAIGN_NON_EARMARKED_DONATION,
					//'hide_from_frontend'	=> true
				);
			}

			add_action('charitable_campaign_submission_save', function($submitted, $campaign_id, $user_id, $form) use ($parent)
			{
				wp_set_post_terms($campaign_id, $parent->category, 'campaign_category', false);
			}, 10, 4);
			
			return $values;
		}, 10, 4 );
	}

	function overrideNonEditableFields()
	{
		$orig_fields = null;

		add_action('charitable_campaign_submission_fields', function($fields) use ($orig_fields)
		{
			/*
			// base overrides only on the editable field, not on what the post_status is
			foreach ( $fields as $section_key => $section ) 
			{
				if ( ! isset( $section['fields'] ) ) {
					continue;
				}

				foreach ( $section['fields'] as $field_key => $field ) 
				{
					if ( isset( $field['editable'] ) && false === $field['editable'] ) {
						unset( $fields[ $section_key ]['fields'][ $field_key ] );
					}
				}
			}
			*/

			// save for later
			$orig_fields = $fields;

			// there will be a call in Charitable_Ambassadors_Campaign_Form::filter_non_editable_fields() which
			// will break our array, so we hook into this action after to restore our value
			add_action('charitable_campaign_submission_fields', function($fields) use ($orig_fields)
			{
				return $orig_fields;
			}, 10, 1);

			return $fields;
		}, -1, 1);
	}

	function earmarkDonations()
	{
		add_action( 'charitable_after_save_donation', function($donation_id, $processor)
		{
			$charity = charitable_get_current_campaign();
			$campaign = HopeCampaign::get($charity->ID);

			if( $campaign->fundraiser_type == CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT ) 
			{
				$parent = HopeCampaign::get($charity->post_parent);
				update_field('earmark', "Hope Project | $parent->ID | $parent->post_title", $donation_id);
			}
			else if( $campaign->fundraiser_type == CAMPAIGN_EARMARKED_FOR_HOPE_LOAN ) 
			{
				$campaign = HopeCampaign::get($charity->ID);
				$earmark = get_post($campaign->earmark_identifier);
				update_field('earmark', "Hope Loan | $campaign->earmark_identifier | $earmark->post_title", $donation_id);
			}
			else if( $campaign->fundraiser_type == CAMPAIGN_NON_EARMARKED_DONATION ) 
			{
				update_field('earmark', "None | Donation Fundraiser", $donation_id);
			}
			else if( $campaign->fundraiser_type == CAMPAIGN_IS_A_HOPE_PROJECT ) 
			{
				if( $campaign->id == HopeCampaign::$STANDALONE_CAMPAIGN_ID  )
				{
					update_field('earmark', "None | Donation Widget", $donation_id);
				}
			}
		});
	}

	// "In Honor Of" donation fields
	function addInHonorOfFields()
	{
		add_action( 'init', function()
		{
			$is_in_honor_of_field = new Charitable_Donation_Field( 'is_in_honor_of', array(
				'label' => 'Is this gift in honor of someone?',
				'data_type' => 'meta',
				'donation_form' => array(
					'type'			=> 'checkbox',
					'show_after' 	=> 'phone',
					'required'   	=> false,
				),
				'admin_form' 		=> true,
				'show_in_meta' 		=> true,
				'show_in_export' 	=> true,
				'email_tag' => array(
					'description' => 'Is this gift in honor of someone?'
				)
			));

			$in_honor_of_name_field = new Charitable_Donation_Field( 'in_honor_of_name', array(
				'label' => 'Honor - Name',
				'data_type' => 'meta',
				'donation_form' => array(
					'type'			=> 'text',
					'show_after' 	=> 'is_in_honor_of',
					'required'   	=> false
				),
				'admin_form' 		=> true,
				'show_in_meta' 		=> true,
				'show_in_export' 	=> true,
				'email_tag' => array(
					'description' => 'Honor - Name'
				)
			));

			$in_honor_of_address_field = new Charitable_Donation_Field( 'in_honor_of_address', array(
				'label' => 'Honor - Address',
				'data_type' => 'meta',
				'donation_form' => array(
					'type'			=> 'text',
					'show_after' 	=> 'in_honor_of_name',
					'required'   	=> false,
				),
				'admin_form' 		=> true,
				'show_in_meta' 		=> true,
				'show_in_export' 	=> true,
				'email_tag' => array(
					'description' => 'Honor - Address'
				)
			));

			$in_honor_of_email_field = new Charitable_Donation_Field( 'in_honor_of_email', array(
				'label' => 'Honor - Email',
				'data_type' => 'meta',
				'donation_form' => array(
					'type'			=> 'email',
					'show_after' 	=> 'in_honor_of_address',
					'required'   	=> false,
				),
				'admin_form' 		=> true,
				'show_in_meta' 		=> true,
				'show_in_export' 	=> true,
				'email_tag' => array(
					'description' => 'Honor - Email'
				)
			));
			
			charitable()->donation_fields()->register_field( $is_in_honor_of_field );
			charitable()->donation_fields()->register_field( $in_honor_of_name_field );
			charitable()->donation_fields()->register_field( $in_honor_of_address_field );
			charitable()->donation_fields()->register_field( $in_honor_of_email_field );
		});
	}
}