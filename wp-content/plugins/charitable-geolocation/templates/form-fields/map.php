<?php
/**
 * The template used to display map form fields.
 *
 * @package Charitable Geolocation/Templates
 * @author  Studio 164a
 * @since   1.1.0
 * @version 1.1.4
 */

if ( ! isset( $view_args['form'] ) || ! isset( $view_args['field'] ) ) {
	return;
}

/* Load the scripts */
if ( ! wp_script_is( 'charitable-geolocation', 'enqueued' ) ) {
	wp_enqueue_script( 'charitable-geolocation' );
}

$form        = $view_args['form'];
$field       = $view_args['field'];
$classes     = esc_attr( $view_args['classes'] );
$is_required = array_key_exists( 'required', $field ) && $field['required'];
$value       = array_key_exists( 'value', $field ) ? $field['value'] : '';
$latitude    = array_key_exists( 'latitude', $field ) ? $field['latitude'] : '';
$longitude   = array_key_exists( 'longitude', $field ) ? $field['longitude'] : '';
$place_id    = array_key_exists( 'place_id', $field ) ? $field['place_id'] : '';
$zoom        = ( $longitude && $latitude ) ? 'data-zoom="17"' : 'data-zoom="0"';

?>
<div id="charitable_field_<?php echo $field['key'] ?>" class="<?php echo $classes ?>">
	<?php if ( isset( $field['label'] ) ) : ?>
		<label for="charitable_field_<?php echo $field['key'] ?>_input">
			<?php echo $field['label'] ?>
			<?php if ( $is_required ) : ?>
				<abbr class="required" title="required">*</abbr>
			<?php endif ?>
		</label>
	<?php endif ?>
	<input type="text" name="<?php echo esc_attr( $field['key'] ) ?>" id="charitable_field_<?php echo $field['key'] ?>_input" value="<?php echo esc_attr( $value ) ?>" <?php echo charitable_get_arbitrary_attributes( $field ) ?> />
	<div class="charitable-map"
		data-search="charitable_field_<?php echo $field['key'] ?>_input"
		data-lat="<?php echo esc_attr( $latitude ) ?>"
		data-long="<?php echo esc_attr( $longitude ) ?>"
		data-placeid="<?php echo esc_attr( $place_id ) ?>"
		<?php echo $zoom ?>
		style="width: 100%; height: 300px;">    
	</div>
</div><!-- charitable_field_<?php echo $field['key'] ?> -->
