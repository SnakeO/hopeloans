<?php

class SuperCarousel_AdminPage {

    private $page;

    public function admin_supercarousel_page() {
        $this->page = [];
        $this->page['superpage'] = 'supercarousel';
        $this->page['superheading'] = 'Super Carousel';
        $this->page['superposttype'] = 'supercarousel';
        return $this->render();
    }

    public function admin_supercontent_page() {
        $this->page = [];
        $this->page['superpage'] = 'supercarousel-content';
        $this->page['superheading'] = 'Super Content';
        $this->page['superposttype'] = 'supercontent';
        return $this->render();
    }

    public function admin_superimage_page() {
        $this->page = [];
        $this->page['superpage'] = 'supercarousel-image';
        $this->page['superheading'] = 'Super Image';
        $this->page['superposttype'] = 'superimage';
        return $this->render();
    }

    public function get_custom_post_types() {
        $args = [];
        $args['public'] = true;
        $args['_builtin'] = false;
        return array_merge(['post' => 'post'], get_post_types($args));
    }

    public function get_super_images() {
        global $wpdb;
        $tbl_posts = $wpdb->posts;
        $results = $wpdb->get_results("SELECT ID, post_title FROM " . $wpdb->posts . " WHERE post_type='superimage' AND post_status = 'publish'");
        return $results;
    }

    public function get_super_contents() {
        global $wpdb;
        $tbl_posts = $wpdb->posts;
        $sql = "SELECT term_id, `name` FROM " . $wpdb->terms . " WHERE term_id IN (SELECT term_id FROM " . $wpdb->term_taxonomy . " WHERE taxonomy='supercontentcat')";
        $results = $wpdb->get_results($sql);
        return $results;
    }

    public function save_preview_template() {
        $preview_name = sanitize_title(SuperCarousel_Common::super_get_post('preview_name'));
        $preview_data = SuperCarousel_Common::super_get_post('preview_data');
        $tab = SuperCarousel_Common::super_get_post('tab');
        $key = 'supertem_' . $tab . '_' . $preview_name;
        update_option($key, $preview_data);
    }

    public function delete_preview_template() {
        $tab = SuperCarousel_Common::super_get_post('tab');
        $preview_name = SuperCarousel_Common::super_get_post('preview_name');
        delete_option($preview_name);
    }

    public function load_preview_template() {
        $tab = SuperCarousel_Common::super_get_post('tab');
        $preview_name = SuperCarousel_Common::super_get_post('preview_name');
        $key = $preview_name;

        $returnarr = [];
        $returnarr['tab'] = $tab;
        $returnarr['preview_data'] = json_decode(stripslashes(get_option($key)));

        echo wp_send_json($returnarr);
    }

    public function load_select_preview_template() {
        $tab = SuperCarousel_Common::super_get_post('tab');
        $key = "supertem_" . $tab . "_%";
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM " . $wpdb->options . " WHERE option_name LIKE '$key'", OBJECT);

        $returnarr = [];
        $returnarr['tab'] = $tab;
        $returnarr['preview_names'] = [];
        foreach ($results as $result) {
            $returnarr['preview_names'][] = $result->option_name;
        }
        echo wp_send_json($returnarr);
    }

    public function render() {
        extract($this->page);
        include SUPER_CAROUSEL_PATH . 'admin/views/supercarousel-page.php';
    }

    public function check_supercarousel_delete() {

        $id = (int) SuperCarousel_Common::super_get_post('id');

        $returnarr = array();
        $returnarr['msg'] = '';

        if ($id > 0) {
            wp_delete_post($id);
            $returnarr['msg'] = 'deleted';
        }
        echo wp_send_json($returnarr);
    }

    public function check_supercarousel_savex() {

        $page = SuperCarousel_Common::super_get_post('page');
        $act = SuperCarousel_Common::super_get_post('act');
        $id = (int) SuperCarousel_Common::super_get_post('id');

        if ($page == 'supercarousel') {

            $postarr = array();
            $postarr['post_title'] = SuperCarousel_Common::super_get_post('super_title');
            $data = isset($_POST['super']) ? $_POST['super'] : array();
            $data = SuperCarousel_Common::super_clean_array($data);
            $returnarr = array();
            if ($act == 'edit' and $id > 0) {
                $postarr['ID'] = $id;
                wp_update_post($postarr);
                $returnarr['msg'] = 'saved';
            } else if ($act == 'add') {
                $postarr['post_type'] = 'supercarousel';
                $postarr['post_status'] = 'publish';
                $post_id = wp_insert_post($postarr);
                $returnarr['msg'] = 'added';
                $returnarr['post_id'] = $post_id;
            }
            wp_send_json($returnarr);
        }
    }

    public function check_supercontent_save() {

        $page = SuperCarousel_Common::super_get_post('page');
        $act = SuperCarousel_Common::super_get_post('act');
        $id = (int) SuperCarousel_Common::super_get_post('id');

        if ($page == 'supercontent') {

            $postarr = array();
            $postarr['post_title'] = SuperCarousel_Common::super_get_post('super_title');
            $postarr['post_content'] = SuperCarousel_Common::super_get_post('super_content');
            $postarr['post_excerpt'] = SuperCarousel_Common::super_get_post('super_excerpt');
            $postarr['menu_order'] = SuperCarousel_Common::super_get_post('content_menu_order');
            $super_content_terms = isset($_POST['super_content_terms']) ? $_POST['super_content_terms'] : array();
            $super_content_terms = SuperCarousel_Common::super_clean_array($super_content_terms);
            $super_content_terms = array_map('intval', $super_content_terms);
            $super_content_terms = array_unique($super_content_terms);
            $returnarr = array();
            if ($act == 'edit' and $id > 0) {

                $postarr['ID'] = $id;
                wp_update_post($postarr);
                $returnarr['msg'] = 'saved';

                $post_terms = get_the_terms($id, 'supercontentcat');
                $term_ids = array();
                if ($post_terms) {
                    foreach ($post_terms as $row) {
                        if (!in_array($row->term_id, $super_content_terms)) {
                            $term_ids[] = $row->term_id;
                        }
                    }
                }

                if (count($term_ids)) {
                    wp_remove_object_terms($id, $term_ids, 'supercontentcat');
                }

                wp_set_object_terms($id, $super_content_terms, 'supercontentcat');
            } else if ($act == 'add') {
                $postarr['post_type'] = 'supercontent';
                $postarr['post_status'] = 'publish';
                $post_id = wp_insert_post($postarr);

                wp_set_post_terms($post_id, $super_content_terms, 'supercontentcat');

                $returnarr['msg'] = 'added';
                $returnarr['post_id'] = $post_id;
            }
            wp_send_json($returnarr);
        }
    }

    public function check_superimage_save() {

        $page = SuperCarousel_Common::super_get_post('page');
        $act = SuperCarousel_Common::super_get_post('act');
        $id = (int) SuperCarousel_Common::super_get_post('id');

        if ($page == 'superimage') {

            $postarr = array();
            $postarr['post_title'] = SuperCarousel_Common::super_get_post('super_title');
            $superimage = (isset($_POST['superimage']) and is_array($_POST['superimage'])) ? $_POST['superimage'] : array();
            $superimage = SuperCarousel_Common::super_serialize($superimage);
            $returnarr = array();
            if ($act == 'edit' and $id > 0) {
                $postarr['ID'] = $id;
                wp_update_post($postarr);
                update_post_meta($id, 'superimages', $superimage);
                $returnarr['msg'] = 'saved';
            } else if ($act == 'add') {
                $postarr['post_type'] = 'superimage';
                $postarr['post_status'] = 'publish';
                $post_id = wp_insert_post($postarr);
                $returnarr['msg'] = 'added';
                $returnarr['post_id'] = $post_id;
                update_post_meta($post_id, 'superimages', $superimage);
            }
            wp_send_json($returnarr);
        }
    }

    public function check_supercarousel_save() {

        $page = SuperCarousel_Common::super_get_post('page');
        $act = SuperCarousel_Common::super_get_post('act');
        $id = (int) SuperCarousel_Common::super_get_post('id');

        if ($page == 'supercarousel') {

            $postarr = array();
            $postarr['post_title'] = SuperCarousel_Common::super_get_post('super_title');
            $super_csscode_global = SuperCarousel_Common::super_get_post('super_csscode_global');
            $data = isset($_POST['super']) ? $_POST['super'] : array();
            $data = SuperCarousel_Common::super_clean_array($data);

            $supertemplate = (isset($_POST['supertemplate']) and is_array($_POST['supertemplate'])) ? $_POST['supertemplate'] : array();
            $supertemplate = SuperCarousel_Common::super_serialize($supertemplate);

            $returnarr = array();
            if ($act == 'edit' and $id > 0) {
                $postarr['ID'] = $id;
                wp_update_post($postarr);
                update_post_meta($id, 'supertemplate', $supertemplate);
                update_option('supercarousel_css_updated', '1');
                update_option('super_csscode_global', $super_csscode_global);
                $returnarr['msg'] = 'saved';
            } else if ($act == 'add') {
                $postarr['post_type'] = 'supercarousel';
                $postarr['post_status'] = 'publish';
                $post_id = wp_insert_post($postarr);
                update_post_meta($post_id, 'supertemplate', $supertemplate);
                update_option('supercarousel_css_updated', '1');
                update_option('super_csscode_global', $super_csscode_global);
                $returnarr['msg'] = 'added';
                $returnarr['post_id'] = $post_id;
            }
            wp_send_json($returnarr);
        }
    }

    public function check_supercontent_category() {

        $act = SuperCarousel_Common::super_get_post('act');
        $term = SuperCarousel_Common::super_get_post('term');
        $term_id = (int) SuperCarousel_Common::super_get_post('term_id');
        $post_id = (int) SuperCarousel_Common::super_get_post('post_id');

        if ($act == 'add') {
            wp_insert_term($term, 'supercontentcat');
        } else if ($act == 'edit' and $term_id > 0) {
            wp_update_term($term_id, 'supercontentcat', array('name' => $term));
        } else if ($act == 'delete' and $term_id > 0) {
            wp_delete_term($term_id, 'supercontentcat');
        }
        include(SUPER_CAROUSEL_PATH . 'admin/views/supercontent-category.php');
    }

    public function search_post_types() {
        global $wpdb;

        $term = SuperCarousel_Common::super_get_post('term');

        $args = array(
            'public' => true,
            '_builtin' => false
        );

        $returnarr = [];

        $returnarr[] = ['label' => 'Post', 'pvalue' => "post_type:post"];

        $post_types = get_post_types($args);

        foreach ($post_types as $post_type) {
            $returnarr[] = ['label' => ucwords($post_type), 'pvalue' => "post_type:$post_type"];
        }

        $sql = "SELECT wt.term_id, CONCAT(wt.`name`, '-', wtt.taxonomy) AS term_name 
            FROM " . $wpdb->terms . " AS wt 
            LEFT JOIN " . $wpdb->term_taxonomy . " AS wtt ON (wt.`term_id` = wtt.`term_id`) 
            WHERE wtt.`taxonomy`!='supercontentcat' AND wtt.`taxonomy`!='post_format' AND wt.`name` LIKE '{$term}%'";

        $tax_results = $wpdb->get_results($sql);

        foreach ($tax_results as $taxonomy) {
            $returnarr[] = ['label' => $taxonomy->term_name, 'pvalue' => 'term:' . $taxonomy->term_id];
        }

        $sql = "SELECT wp.ID, CONCAT(wp.post_title, '-', wp.`post_type`) AS post_name 
            FROM " . $wpdb->posts . " AS wp 
            WHERE wp.`post_status` = 'publish' 
            AND wp.`post_type` NOT IN ('page', 'attachment', 'revision', 'nav_menu_item', 'superimage', 'supercontent', 'supertemplate', 'supercarousel') 
            AND wp.`post_title` LIKE '{$term}%'";

        $post_results = $wpdb->get_results($sql);

        foreach ($post_results as $post_result) {
            $returnarr[] = ['label' => $post_result->post_name, 'pvalue' => 'id:' . $post_result->ID];
        }

        wp_send_json($returnarr);
    }

    function check_youtube_api() {
        $apikey = SuperCarousel_Common::super_get_post('apikey');
        $playlisturl = SuperCarousel_Common::super_get_post('playlist');

        $playlistid = str_replace('https://www.youtube.com/playlist?list=', '', $playlisturl);

        $returnarr = ['status' => false];
        if (SuperCarousel_Slides::checkYouTubeAPI($apikey, $playlistid)) {
            $returnarr = ['status' => true];
        }
        wp_send_json($returnarr);
    }

    function check_flickr_api() {
        $apikey = SuperCarousel_Common::super_get_post('apikey');
        $flickrurl = SuperCarousel_Common::super_get_post('flickrurl');

        $returnarr = ['status' => false, 'message' => ''];

        $urltype = '';
        $userid = 0;
        $albumid = 0;
        $groupid = '';
        $albumpattern = "/https:\/\/www.flickr.com\/photos\/([a-zA-Z0-9\-\@]+)\/albums\/([0-9]+)/";
        $setalbumpattern = "/https:\/\/www.flickr.com\/photos\/([a-zA-Z0-9\-\@]+)\/sets\/([0-9]+)/";
        $grouppattern = "/https:\/\/www.flickr.com\/groups\/([0-9a-zA-Z\-\@]+)\//";
        if (preg_match($albumpattern, $flickrurl, $matches)) {
            $userid = urlencode($matches[1]);
            $albumid = urlencode($matches[2]);
            $urltype = 'album';
        } else if (preg_match($setalbumpattern, $flickrurl, $matches)) {
            $userid = urlencode($matches[1]);
            $albumid = urlencode($matches[2]);
            $urltype = 'album';
        } else if (preg_match($grouppattern, $flickrurl, $matches)) {

            $groupid = urlencode($matches[1]);
            $urltype = 'group';
        }

        if ($urltype == '') {
            $returnarr['message'] = __('Invalid Flickr URL', 'supercarousel');
        } else if (SuperCarousel_Slides::checkFlickrAPI($apikey)) {
            if ($urltype == 'album') {
                if (SuperCarousel_Slides::checkFlickrAlbumLookup($apikey, $flickrurl, $albumid)) {
                    $returnarr['message'] = '<span class="dashicons dashicons-thumbs-up"></span> ' . __('Awesome, looks good.', 'supercarousel');
                    $returnarr['status'] = true;
                } else {
                    $returnarr['message'] = __('Invalid User Id or Album', 'supercarousel');
                }
            } else {
                if (SuperCarousel_Slides::checkFlickrGroupLookup($apikey, $flickrurl)) {
                    $returnarr['message'] = '<span class="dashicons dashicons-thumbs-up"></span> ' . __('Awesome, looks good.', 'supercarousel');
                    $returnarr['status'] = true;
                } else {
                    $returnarr['message'] = __('Invalid Group Id', 'supercarousel');
                }
            }
        } else {
            $returnarr['message'] = __('Invalid API Key', 'supercarousel');
        }

        wp_send_json($returnarr);
    }

}
