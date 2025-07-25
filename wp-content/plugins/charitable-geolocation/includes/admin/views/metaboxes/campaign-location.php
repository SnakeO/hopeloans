<?php
/**
 * Renders the location field for the Campaign post type.
 *
 * @package Charitable Geolocation/Admin/Views
 * @author  Studio 164a
 * @since   1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

global $post;

/* Load the scripts */
if ( ! wp_script_is( 'charitable-geolocation', 'enqueued' ) ) {
	wp_enqueue_script( 'charitable-geolocation' );
}

$description = array_key_exists( 'description', $view_args ) ? '<span class="charitable-helper">' . $view_args['description'] . '</span>' : '';
$location    = get_post_meta( $post->ID, '_campaign_location', true );
$longitude   = get_post_meta( $post->ID, '_campaign_longitude', true );
$latitude    = get_post_meta( $post->ID, '_campaign_latitude', true );
$place_id    = get_post_meta( $post->ID, '_gmaps_place_id', true );

if ( $longitude && $latitude ) {
    $data = 'data-search="campaign-location-search" data-zoom="17" data-lat="' . esc_attr( $latitude ) . '" data-long="' . esc_attr( $longitude ) . '"';

    if ( $place_id ) {
        $data .= ' data-placeid="' . esc_attr( $place_id ) . '"';
    }
} else {
    $data = 'data-search="campaign-location-search" data-zoom="2"';
}

?>
<div class="charitable-map" <?php echo $data ?> style="width: 100%; height: 400px;"></div>
<input type="text" name="_campaign_location" id="campaign-location-search" value="<?php echo $location ?>" />
<?php echo $description ?>
