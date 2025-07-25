<?php 
/**
 * Displays the location within campaign loops. 
 *
 * @author  Studio 164a
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @var Charitable_Campaign
 */
$campaign = $view_args[ 'campaign' ];

?>
<div class="campaign-location" 
    data-latitude="<?php echo get_post_meta( $campaign->ID, '_campaign_latitude', true ) ?>" 
    data-longitude="<?php echo get_post_meta( $campaign->ID, '_campaign_longitude', true ) ?>">
    <?php echo get_post_meta( $campaign->ID, '_campaign_location', true ) ?>
</div>    