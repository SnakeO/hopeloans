<?php

/*
 * Visual Composer Addon for Super Carousel
 */

if (!defined('ABSPATH')) {
    die('-1');
}

class SuperCarousel_VC {

    function __construct() {
        // We safely integrate with VC with this hook
        add_action('init', array($this, 'integrateWithVC'));
    }

    public function integrateWithVC() {

        // Check if Visual Composer is installed
        if (!defined('WPB_VC_VERSION') or ! function_exists('vc_map')) {
            return;
        }

        $args = array('post_type' => 'supercarousel', 'posts_per_page' => -1);
        $loop = new WP_Query($args);

        $supercarousels = [];

        foreach ($loop->posts as $row) {
            $supercarousels[$row->post_title] = $row->post_name;
        }

        vc_map(array(
            "name" => __("Super Carousel", 'supercarousel'),
            "description" => __("Place Super Carousel", 'supercarousel'),
            "base" => "supercarousel",
            "class" => "",
            "controls" => "full",
            "icon" => SUPER_CAROUSEL_URL . 'admin/images/supercarousel-icon-32x32.png',
            "category" => __('Media', 'supercarousel'),
            "params" => array(
                array(
                    'type' => 'dropdown',
                    'heading' => __('Super Carousel', 'supercarousel'),
                    'param_name' => 'slug',
                    'admin_label' => true,
                    'value' => $supercarousels,
                    'save_always' => true,
                    'description' => __('Select your Super Carousel.', 'supercarousel'),
                ),
            )
        ));
    }

}

// Finally initialize code
new SuperCarousel_VC();
