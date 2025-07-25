<?php
/**
 * Charitable Geolocation Template Hooks.
 *
 * Action/filter hooks used for Charitable Geolocation functions/templates
 *
 * @package     Charitable Geolocation/Functions/Templates
 * @version     1.0.0
 * @author      Eric Daams
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Campaigns loop, after the main title.
 *
 * @see charitable_geolocation_template_campaign_loop_location
 */
add_action( 'charitable_campaign_content_loop_after', 'charitable_geolocation_template_campaign_loop_location', 2 );
