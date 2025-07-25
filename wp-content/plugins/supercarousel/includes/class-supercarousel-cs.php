<?php

/*
 * Visual Composer Addon for Super Carousel
 */

if (!defined('ABSPATH')) {
    die('-1');
}

class SuperCarousel_CS {

    function __construct() {
        add_action('cornerstone_register_elements', [$this, 'cornerstone_register_elements']);
        add_filter('cornerstone_icon_map', [$this, 'cornerstone_icon_map']);
    }

    public function cornerstone_register_elements() {
        if (function_exists('cornerstone_register_element')) {
            cornerstone_register_element('SuperCarouselCornerStone', 'cs-super-carousel', SUPER_CAROUSEL_PATH . 'includes/cornerstone');
        }
    }

    public function cornerstone_icon_map($icon_map = []) {
        $icon_map['cs-super-carousel'] = SUPER_CAROUSEL_URL . 'public/images/icons.svg';
        return $icon_map;
    }

}

// Finally initialize code
new SuperCarousel_CS();
