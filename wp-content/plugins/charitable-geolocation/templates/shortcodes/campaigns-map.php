<?php
/**
 * Displays the campaign map.
 *
 * @package Charitable Geolocation/Templates/Shortcodes
 * @author  Studio 164a
 * @since   1.0.0
 * @since   1.1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

$campaigns = $view_args['campaigns'];
$zoom      = 'auto' == $view_args['zoom'] ? 2 : $view_args['zoom'];
$width     = $view_args['width'];
$height    = $view_args['height'];

if ( ! $campaigns->have_posts() ) :
	return;
endif;

/* Load the scripts */
if ( ! wp_script_is( 'charitable-geolocation', 'enqueued' ) ) {
	wp_enqueue_script( 'charitable-geolocation' );
}

$markers = array();

while ( $campaigns->have_posts() ) :

	$campaigns->the_post();

	$campaign  = charitable_get_campaign( get_the_ID() );
	$latitude  = get_post_meta( $campaign->ID, '_campaign_latitude', true );
	$longitude = get_post_meta( $campaign->ID, '_campaign_longitude', true );
	$location  = get_post_meta( $campaign->ID, '_campaign_location', true );

	if ( empty( $latitude ) || empty( $longitude ) || empty( $location ) ) {
		continue;
	}

	$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $campaign->ID ) );

	/**
	 * Filter the marker data.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Marker data.
	 */
	$markers[] = apply_filters( 'charitable_geolocation_markers_data', array(
		'latitude'    => $latitude,
		'longitude'   => $longitude,
		'address'     => $location,
		'title'       => get_the_title( $campaign->ID ),
		'link'        => get_permalink( $campaign->ID ),
		'thumbnail'   => $thumbnail_src[0],
		'description' => esc_attr( $campaign->description ),
	), $campaign );

endwhile;

?>
<div class="charitable-map"
	data-markers='<?php echo json_encode( $markers ) ?>'
	data-zoom="<?php echo $zoom ?>"
	style="<?php printf( 'width: %s; height: %s;', $width, $height ) ?>">    
</div>
