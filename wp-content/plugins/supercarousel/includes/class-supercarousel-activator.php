<?php

class SuperCarousel_Activator {

    public static function activate() {
        global $wpdb;

        $sql = "UPDATE " . $wpdb->term_taxonomy . " SET taxonomy = 'supercontentcat' WHERE taxonomy = 'super_category'";
        $wpdb->query($sql);

        @unlink(SUPER_CAROUSEL_PATH . 'admin/js/supercarouseladminmerged.js');
        @unlink(SUPER_CAROUSEL_PATH . 'public/js/supercarouselmerged.js');
        @unlink(SUPER_CAROUSEL_PATH . 'public/css/supercarouselmerged.css');
    }

}
