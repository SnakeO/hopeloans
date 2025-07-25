<?php
/**
 * Charitable Geolocation Ambassadors Hooks.
 *
 * @package     Charitable Geolocation/Functions/Campaign Form
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Include a location field in the campaign form.
 *
 * @see     Charitable_Geolocation_Campaign_Form::add_location_field()
 */
add_filter( 'charitable_campaign_submission_campaign_fields', array( Charitable_Geolocation_Campaign_Form::get_instance(), 'add_location_field' ), 10, 2 );

/**
 * Save the campaign location details.
 *
 * @see     Charitable_Geolocation_Campaign_Form::save_campaign_location_details()
 */
add_action( 'charitable_campaign_submission_save', array( Charitable_Geolocation_Campaign_Form::get_instance(), 'save_campaign_location_details' ), 10, 2 );
