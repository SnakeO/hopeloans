<?php

class SuperCarousel_Slides {

    public $slides = [];
    public $template = '';
    public $carouselId = 0;
    public $superdata, $post_image_sizes = [], $type, $isExpertMode = false;
    public $templatevalues = [
        'Image' => [
            'customkey' => 'customkey',
            'imageid' => 'id',
            'title' => 'caption',
            'altimage' => 'caption',
            'caption' => 'caption',
            'titleimage' => 'caption',
            'lightboxurl' => 'lightbox',
            'linkurl' => 'link',
            'target' => 'newwindow',
        ],
        'Content' => [
            'customkey' => 'customkey',
            'contentid' => 'ID',
            'title' => 'post_title',
            'content' => 'post_content',
            'excerpt' => 'post_excerpt',
            'categories' => 'categories',
        ],
        'Post' => [
            'customkey' => 'customkey',
            'id' => 'ID',
            'altimage' => 'post_title',
            'titleimage' => 'post_title',
            'title' => 'post_title',
            'content' => 'post_content',
            'categories' => 'categories',
            'tags' => 'tags',
            'taxonomies' => 'taxonomies',
            'excerpt' => 'post_excerpt',
            'author' => 'post_author',
            'slug' => 'post_name',
            'postauthor' => 'postauthor',
            'date' => 'post_date',
            'postmeta' => 'postmeta',
            'lightboxurl' => 'lightbox',
            'linkurl' => 'link',
            'permalink' => 'link'
        ],
        'YouTube' => [
            'customkey' => 'customkey',
            'id' => 'videoId',
            'videoid' => 'videoId',
            'channelid' => 'channelId',
            'altimage' => 'title',
            'titleimage' => 'title',
            'title' => 'title',
            'content' => 'description',
            'description' => 'description',
            'lightboxurl' => 'image_maxres',
            'linkurl' => 'video_url',
            'videolink' => 'video_url',
            'image_default' => 'image_default',
            'image_thumbnails' => 'image_thumbnails',
            'image_mqdefault' => 'image_medium',
            'image_medium' => 'image_medium',
            'image_high' => 'image_high',
            'image_hqdefault' => 'image_high',
            'image_sddefault' => 'image_standard',
            'image_standard' => 'image_standard',
            'image_maxres' => 'image_maxres',
            'image_maxresdefault' => 'image_maxres',
            'image_full' => 'image_maxres',
        ],
        'Feeds' => [
            'customkey' => 'customkey',
            'altimage' => 'title',
            'titleimage' => 'title',
            'title' => 'title',
            'content' => 'description',
            'description' => 'description',
            'image' => 'image',
            'image_full' => 'image',
            'image_large' => 'image',
            'lightboxurl' => 'image',
            'linkurl' => 'link',
            'itemlink' => 'link',
            'optionalelement' => 'optionalelement'
        ],
        'Flickr' => [
            'customkey' => 'customkey',
            'altimage' => 'title',
            'titleimage' => 'title',
            'title' => 'title',
            'image_link' => 'image_large',
            'image_lightbox' => 'image_large',
            'image_full' => 'image_full',
            'image_large' => 'image_large',
            'image_medium' => 'image_medium',
            'image_small' => 'image_small',
            'linkurl' => 'image_large',
            'image' => 'image',
            'lightboxurl' => 'image',
        ]
    ];

    public function __construct($superdata = []) {
        $this->superdata = $superdata;
        $this->type = $this->superdata['type'];
        $this->post_image_sizes = get_intermediate_image_sizes();
        $this->post_image_sizes[] = 'full';
        $this->isExpertMode = isset($this->superdata['expertmode']) ? true : false;
    }

    public function get_slides_data() {
        $template_html = $this->get_template_html($this->superdata);
        //echo htmlentities($template_html);
        //supershow($this->superdata);
        $elements = $this->get_slide_data();

        foreach ($elements as $row) {
            $this->slides[] = $this->filter_variables($template_html, (array) $row);
        }
        //supershow($this->slides);
        return $this->slides;
    }

    function filter_variables($html, $row) {
        if (!isset($this->templatevalues[$this->type])) {
            return $html;
        }

        $slideTypeFilter = 'SuperCarousel';

        if (has_filter($slideTypeFilter)) {
            return apply_filters($slideTypeFilter, $this->carouselId, $this->type, $row);
        }

        $slideTypeFilterId = 'SuperCarousel_' . $this->carouselId;

        if (has_filter($slideTypeFilterId)) {
            return apply_filters($slideTypeFilterId, $this->type, $row);
        }

        $templateValues = $this->templatevalues[$this->type];
        //supershow($row);
        $parserObj = new SuperCarousel_Parser($row);
        $parserObj->keymaps = $templateValues;

        foreach ($templateValues as $temkey => $temval) {
            $keyFilterName = 'SuperCarousel_' . $this->type . '_' . $temkey;
            if (has_filter($keyFilterName)) {
                $keyval = isset($row[$temval]) ? $row[$temval] : '';
                $row[$temval] = apply_filters($keyFilterName, $row);
            }
            if (!(strpos($html, "{{$temkey}}") === false)) {
                if (method_exists($this, "get_{$temval}")) {
                    $html = call_user_func([$this, "get_{$temval}"], $html, $row, $temkey);
                } else {
                    if (!isset($row[$temval])) {
                        continue;
                    }
                    $html = str_replace("{{$temkey}}", $row[$temval], $html);
                }
            }
            $html = $parserObj->parseKey($temkey, $html);
        }

        if ($this->type == 'Image' and ! $this->isExpertMode) {
            $html = $this->overRideSuperImages($row, $html);
        }

        /* Filter all images */
        $html = $this->filter_images($html, $row);

        return $html;
    }

    function overRideSuperImages($row = [], $html = '') {
        $hrefpattern = '/href="([a-zA-Z0-9{}\(\)\.\/\:\-\_\~\+\#\,\%\;\=\s]+)"/';
        $clickpattern = '/onclick="([a-zA-Z0-9{}\(\)\'\.\/\:\-\_\~\+\#\,\%\;\=\s]+)"/';
        if ($row['link'] != '') {
            $html = preg_replace($hrefpattern, 'href="' . $row['link'] . '"', $html);
            $html = preg_replace($clickpattern, '', $html);
            if ($row['newwindow'] == '1') {
                $html = preg_replace('/target="([a-zA-Z\_{}\s]+)"/', 'target="_blank"', $html);
                $html = str_replace('target=""', 'target="_blank"', $html);
            } else {
                $html = preg_replace('/target="([a-zA-Z\_{}\s]+)"/', 'target="_self"', $html);
                $html = str_replace('target=""', 'target="_self"', $html);
            }
            $html = str_replace('superlight', '', $html);
        } else if ($row['lightbox'] != '') {
            $html = preg_replace($hrefpattern, 'href="' . $row['lightbox'] . '"', $html);
            $html = preg_replace($clickpattern, '', $html);
            $html = preg_replace('/target="([a-zA-Z\_{}]+)"/', '', $html);
            $html = str_replace('super_clickaction', 'super_clickaction superlight', $html);
            $html = str_replace('superbutton', 'superbutton superlight', $html);
            $html = str_replace('class=""', 'class="superlight"', $html);
            $html = str_replace('superlight superlight', 'superlight', $html);
        } else {
            $html = str_replace('{defaulthref}', 'javascript: void(0);', $html);
            $html = str_replace('{defaulttarget}', '_self', $html);
        }
        return $html;
    }

    /*
     * Dynamically Called
     */

    function get_link($html, $row, $temkey) {
        if ($this->type == 'Image') {
            if ($this->isExpertMode) {
                return str_replace("{{$temkey}}", $row['link'], $html);
            }
            return str_replace("{{$temkey}}", '{image_full}', $html);
        } else if ($this->type == 'Post') {
            if ($temkey == 'linkurl' || $temkey == 'permalink') {
                return str_replace("{{$temkey}}", get_permalink($row['ID']), $html);
            } else if ($temkey == 'lightbox') {
                return str_replace("{{$temkey}}", '{image_full}', $html);
            }
            return $html;
        } else if ($this->type == 'Feeds') {
            return str_replace("{{$temkey}}", $row['link'], $html);
        }
        return $html;
    }

    /*
     * Dynamically Called
     */

    function get_lightbox($html, $row, $temkey) {
        if ($this->isExpertMode and $this->type == 'Image') {
            $html = str_replace("{{$temkey}}", $row['lightbox'], $html);
            return $html;
        }
        return $this->get_link($html, $row, 'lightboxurl');
    }

    /*
     * Dynamically Called
     */

    function get_postmeta($html, $row, $temkey) {
        return '';
    }

    function filter_images($html, $row) {
        if ($this->type == 'Image') {
            $html = $this->filter_post_images($html, $row['id']);
        } else if ($this->type == 'Post') {
            $html = $this->filter_post_images($html, get_post_thumbnail_id($row['ID']));
        }
        return $html;
    }

    function filter_post_images($html, $id) {
        foreach ($this->post_image_sizes as $image_size) {
            $sizevar = "{image_{$image_size}}";
            if (!(strpos($html, $sizevar) === false)) {
                list($src) = wp_get_attachment_image_src($id, $image_size);
                if ($src == '') {
                    $src = apply_filters('SuperCarouselNoImage', SUPER_CAROUSEL_NO_IMAGE);
                }
                $html = str_replace($sizevar, $src, $html);
            }
        }
        return $html;
    }

    /*
     * Getting Data
     */

    function get_slide_data() {
        $type = $this->superdata['type'];
        if (method_exists($this, "get{$type}CarouselData")) {
            return call_user_func([$this, "get{$type}CarouselData"]);
        }
        return [];
    }

    public function getImageCarouselData() {
        $superimage = (int) $this->superdata['superimage'];
        if ($superimage == 0) {
            return [];
        }
        $imagedata = get_post_meta($superimage, 'superimages', true);
        $imagedata = SuperCarousel_Common::super_unserialize($imagedata);
        $imagedata = SuperCarousel_Common::get_mult_arr($imagedata);
        return $imagedata;
    }

    public function getContentCarouselData() {
        $supercontent = (int) $this->superdata['supercontent'];
        $limit = (int) $this->superdata['contentlimit'];

        $args = array(
            'posts_per_page' => $limit,
            'post_type' => 'supercontent',
            'tax_query' => array(
                array(
                    'taxonomy' => 'supercontentcat',
                    'field' => 'term_id',
                    'terms' => [$supercontent],
                )
            )
        );

        if (isset($this->superdata['contentpostorderby']) and isset($this->superdata['contentpostorder'])) {
            $args['orderby'] = $this->superdata['contentpostorderby'];
            $args['order'] = $this->superdata['contentpostorder'];
        }

        $supercontentdata = new WP_Query($args);

        foreach ($supercontentdata->posts as $k => $row) {
            $supercontentdata->posts[$k]->categories = SuperCarousel_Common::get_super_content_categories($row->ID);
        }
        return $supercontentdata->posts;
    }

    public function getPostCarouselData() {
        //supershow($this->superdata);
        $postfilters = isset($this->superdata['postfilter']) ? $this->superdata['postfilter'] : [];

        if (!count($postfilters)) {
            return [];
        }

        $post_types = [];
        $terms = [];
        $postids = [];

        foreach ($postfilters as $postfilter) {
            if (!(strpos($postfilter, ':') === false)) {
                $keyval = explode(':', $postfilter);
                if ($keyval[0] == 'post_type') {
                    $post_types[] = $keyval[1];
                } else if ($keyval[0] == 'term') {
                    $termdata = get_term_by('term_taxonomy_id', (int) $keyval[1]);
                    if (isset($termdata->taxonomy)) {
                        $terms[] = [
                            'taxonomy' => $termdata->taxonomy,
                            'field' => 'term_id',
                            'terms' => array((int) $keyval[1]),
                        ];
                    } else {
                        $termdata = get_term((int) $keyval[1]);
                        if (isset($termdata->taxonomy)) {
                            $terms[] = [
                                'taxonomy' => $termdata->taxonomy,
                                'field' => 'term_id',
                                'terms' => array((int) $keyval[1]),
                            ];
                        }
                    }
                } else if ($keyval[0] == 'id') {
                    $postids[] = (int) $keyval[1];
                }
            }
        }

        $args = [];
        if (count($post_types) == 0) {
            $args['post_type'] = 'any';
        } else {
            $args['post_type'] = $post_types;
        }

        if (count($terms)) {
            $args['tax_query'] = $terms;
        }

        if (count($postids)) {
            $args['post__in'] = $postids;
        }

        $args['orderby'] = $this->superdata['postorderby'];
        $args['order'] = $this->superdata['postorder'];

        $posts_per_page = (int) $this->superdata['postlimit'];
        if ($posts_per_page > 0) {
            $args['posts_per_page'] = $posts_per_page;
        }

        if (isset($this->superdata['postfeaturedimage']) and $this->superdata['postfeaturedimage'] == 'yes') {
            $args['meta_query'] = array(
                array(
                    'key' => '_thumbnail_id',
                    'compare' => 'EXISTS'
                ),
            );
        }

        $loop = new WP_Query($args);

        foreach ($loop->posts as $k => $row) {
            $loop->posts[$k]->taxonomies = SuperCarousel_Common::get_post_taxonomies($row->ID);
            $loop->posts[$k]->postauthor = get_the_author_meta('display_name', $row->post_author);
            $loop->posts[$k]->categories = SuperCarousel_Common::get_post_categories($row->ID);
            $loop->posts[$k]->tags = SuperCarousel_Common::get_post_tags($row->ID);
        }

        return $loop->posts;
    }

    public function getYouTubeCarouselData() {
        //supershow($this->superdata);
        $youtubeurl = $this->superdata['youtubeurl'];

        $playlistid = str_replace('https://www.youtube.com/playlist?list=', '', $youtubeurl);

        $youtubeapi = $this->superdata['youtubeapi'];
        $youtubelimit = (int) $this->superdata['youtubelimit'];

        $apiurl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults={$youtubelimit}&playlistId={$playlistid}&key={$youtubeapi}";

        $response = wp_remote_get($apiurl);

        $body = wp_remote_retrieve_body($response);
        $response_code = (int) wp_remote_retrieve_response_code($response);

        if ($response_code == 200) {
            $body = json_decode($body);
            $returnarr = [];
            foreach ($body->items as $row) {
                $temp = [];
                $temp['title'] = $row->snippet->title;
                $temp['description'] = $row->snippet->description;
                $temp['channelId'] = isset($row->snippet->channelId) ? $row->snippet->channelId : '';
                foreach ($row->snippet->thumbnails as $thumbnailkey => $tempthumbanil) {
                    $temp['image_' . $thumbnailkey] = $tempthumbanil->url;
                }
                if (!isset($temp['image_medium'])) {
                    $temp['image_medium'] = $temp['image_default'];
                }
                if (!isset($temp['image_high'])) {
                    $temp['image_high'] = $temp['image_medium'];
                }
                if (!isset($temp['image_standard'])) {
                    $temp['image_standard'] = $temp['image_high'];
                }
                if (!isset($temp['image_maxres'])) {
                    $temp['image_maxres'] = $temp['image_standard'];
                }
                /*
                  $temp['image_default'] = $row->snippet->thumbnails->default->url;
                  $temp['image_medium'] = $row->snippet->thumbnails->medium->url;
                  $temp['image_high'] = $row->snippet->thumbnails->high->url;
                  $temp['image_standard'] = $row->snippet->thumbnails->standard->url;
                  $temp['image_maxres'] = $row->snippet->thumbnails->maxres->url;
                 */
                $temp['channelTitle'] = $row->snippet->channelTitle;
                $temp['playlistId'] = $row->snippet->playlistId;
                $temp['videoId'] = $row->snippet->resourceId->videoId;
                $temp['video_url'] = "https://www.youtube.com/watch?v=" . $temp['videoId'] . "&list=" . $temp['playlistId'];
                $temp['etag'] = $row->etag;
                $returnarr[] = $temp;
            }
            return $returnarr;
        }

        return [];
    }

    public function getFeedsCarouselData() {
        //supershow($this->superdata);

        $feedurl = $this->superdata['feedurl'];
        $feedlimit = (int) $this->superdata['feedlimit'];
        $feedorder = $this->superdata['feedorder'];
        //$response = wp_remote_get($feedurl);

        $feedimage_tag = isset($this->superdata['feed_image_tag']) ? $this->superdata['feed_image_tag'] : '';

        $response = fetch_feed($feedurl);
        //supershow($response);
        $maxitems = $response->get_item_quantity($feedlimit);

        $rss_items = $response->get_items(0, $maxitems);

        $returnarr = [];

        foreach ($rss_items as $item) {
            $temp = [];
            $temp['title'] = $item->get_title();
            $temp['link'] = $item->get_permalink();
            $temp['description'] = strip_tags($item->get_description());
            $temp['copyright'] = $item->get_copyright();
            $temp['image'] = $this->getFeedImage($item, $feedimage_tag);
            if (is_array($temp['image'])) {
                $temp['image'] = $temp['image'][0];
            }
            $temp['author'] = $item->get_author();
            $temp['category'] = $item->get_category();
            $returnarr[] = $temp;
        }
        if ($feedorder == 'DESC') {
            $returnarr = array_reverse($returnarr);
        }
        //supershow($returnarr);
        return $returnarr;
    }

    public function getFlickrCarouselData() {
        //supershow($this->superdata);

        $flickrurl = $this->superdata['flickrurl'];
        $flickrapi = $this->superdata['flickrapi'];
        $flickrlimit = (int) $this->superdata['flickrlimit'];

        $urltype = '';
        $userid = 0;
        $albumid = 0;
        $groupid = '';
        $albumpattern = "/https:\/\/www.flickr.com\/photos\/([a-zA-Z0-9\@\-]+)\/(albums|sets)\/([0-9]+)/";
        $grouppattern = "/https:\/\/www.flickr.com\/groups\/([0-9a-zA-Z\@\-]+)\//";

        $returnarr = [];

        if (preg_match($albumpattern, $flickrurl, $matches)) {
            $userid = self::getFlickrAlbumUserId($flickrapi, $flickrurl);
            $albumid = urlencode($matches[3]);
            $url = "https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key={$flickrapi}&photoset_id={$albumid}&user_id={$userid}&per_page={$flickrlimit}&format=json&nojsoncallback=1";
            $response = wp_remote_get($url);
            $body = json_decode(wp_remote_retrieve_body($response), true);
            //supershow($body);
            if ($body['stat'] == 'ok') {
                foreach ($body['photoset']['photo'] as $row) {
                    $temp = [];
                    $temp['title'] = $row['title'];
                    $temp['image'] = $this->getFlickImageFromId($row, 'h');
                    $temp['image_full'] = $this->getFlickImageFromId($row, 'h');
                    $temp['image_large'] = $this->getFlickImageFromId($row, 'b');
                    $temp['image_medium'] = $this->getFlickImageFromId($row, 'z');
                    $temp['image_small'] = $this->getFlickImageFromId($row, 'n');
                    $returnarr[] = $temp;
                }
            }
        } else if (preg_match($grouppattern, $flickrurl, $matches)) {
            $groupid = self::getFlickrGroupId($flickrapi, $flickrurl);
            $url = "https://api.flickr.com/services/rest/?method=flickr.groups.pools.getPhotos&api_key={$flickrapi}&group_id={$groupid}&per_page={$flickrlimit}&format=json&nojsoncallback=1";
            $response = wp_remote_get($url);
            $body = json_decode(wp_remote_retrieve_body($response), true);
            if (isset($body['stat']) and $body['stat'] == 'ok') {
                foreach ($body['photos']['photo'] as $row) {
                    $temp = [];
                    $temp['title'] = $row['title'];
                    $temp['image'] = $this->getFlickImageFromId($row, 'h');
                    $temp['image_full'] = $this->getFlickImageFromId($row, 'h');
                    $temp['image_large'] = $this->getFlickImageFromId($row, 'b');
                    $temp['image_medium'] = $this->getFlickImageFromId($row, 'z');
                    $temp['image_small'] = $this->getFlickImageFromId($row, 'n');
                    $returnarr[] = $temp;
                }
            }
        }
        //supershow($returnarr);
        return $returnarr;
    }

    public function getFlickImageFromId($row = [], $size = 'h') {
        $secret = $row['secret'];
        $id = $row['id'];
        $server = $row['server'];
        $farm = $row['farm'];
        return "https://farm{$farm}.staticflickr.com/{$server}/{$id}_{$secret}_{$size}.jpg";
    }

    public function getFeedImage($item, $customTag = '') {

        if ($customTag != '' and $customTag != '0') {
            if ($return = $item->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, $customTag)) {
                return $item->sanitize($return[0]['data'], $item->registry->call('Misc', 'atom_10_construct_type', array($return[0]['attribs'])), $item->get_base($return[0]));
            } elseif ($return = $item->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, $customTag)) {
                return $item->sanitize($return[0]['data'], $item->registry->call('Misc', 'atom_03_construct_type', array($return[0]['attribs'])), $item->get_base($return[0]));
            } elseif ($return = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_10, $customTag)) {
                return $item->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_MAYBE_HTML, $item->get_base($return[0]));
            } elseif ($return = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_090, $customTag)) {
                return $item->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_MAYBE_HTML, $item->get_base($return[0]));
            } elseif ($return = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, $customTag)) {
                return $item->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_MAYBE_HTML, $item->get_base($return[0]));
            } elseif ($return = $item->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, $customTag)) {
                return $item->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
            } elseif ($return = $item->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, $customTag)) {
                return $item->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
            }
        }

        $enclosure = $item->get_enclosure();

        $image = isset($enclosure->link) ? $enclosure->link : '';

        if (isset($enclosure->thumbnails[0]) and $image == '') {
            $image = $enclosure->thumbnails[0];
        }

        if ($image != '') {
            return $image;
        }

        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', html_entity_decode($item->get_description()), $image);
        if (isset($image['src'])) {
            return $image['src'];
        }
        return '';
    }

    public static function checkYouTubeAPI($key = '', $playlistid = '') {
        $key = esc_sql($key);
        $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=1&playlistId={$playlistid}&key={$key}";
        $response = wp_remote_get($url);
        $body = wp_remote_retrieve_body($response);
        $response_code = wp_remote_retrieve_response_code($response);
        if (isset($body['errors']) or (int) $response_code != 200) {
            return false;
        }
        return true;
    }

    public static function checkFlickrAPI($key = '') {
        $key = esc_sql($key);
        $url = "https://api.flickr.com/services/rest/?method=flickr.test.echo&api_key={$key}&format=json&nojsoncallback=1";

        $response = wp_remote_get($url);
        $body = json_decode(wp_remote_retrieve_body($response), true);

        if ((isset($body['stat']) and $body['stat'] == 'ok')) {
            return true;
        }
        return false;
    }

    public static function checkFlickrAlbum($apikey, $userid, $albumid) {
        $url = "https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key={$apikey}&photoset_id={$albumid}&user_id={$userid}&per_page=1&format=json&nojsoncallback=1";
        $response = wp_remote_get($url);
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['stat']) and $body['stat'] == 'ok') {
            return true;
        }
        return false;
    }

    public static function checkFlickrAlbumLookup($apikey, $photourl, $albumid) {
        $url = "https://api.flickr.com/services/rest/?method=flickr.urls.lookupUser&api_key={$apikey}&url=" . urlencode($photourl) . "&format=json&nojsoncallback=1";
        $response = wp_remote_get($url);
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['stat']) and $body['stat'] == 'ok') {
            return true;
        }
        return false;
    }

    public static function getFlickrAlbumUserId($apikey, $photourl) {
        $url = "https://api.flickr.com/services/rest/?method=flickr.urls.lookupUser&api_key={$apikey}&url=" . urlencode($photourl) . "&format=json&nojsoncallback=1";
        $response = wp_remote_get($url);
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['stat']) and $body['stat'] == 'ok') {
            return $body['user']['id'];
        }
        return false;
    }

    public static function checkFlickrGroup($apikey, $groupid) {
        $url = "https://api.flickr.com/services/rest/?method=flickr.groups.pools.getPhotos&api_key={$apikey}&group_id={$groupid}&per_page=1&format=json&nojsoncallback=1";
        $response = wp_remote_get($url);
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['stat']) and $body['stat'] == 'ok') {
            return true;
        }
        return false;
    }

    public static function getFlickrGroupId($apikey, $groupurl) {
        $url = "https://api.flickr.com/services/rest/?method=flickr.urls.lookupGroup&api_key={$apikey}&url=" . urlencode($groupurl) . "&format=json&nojsoncallback=1";
        $response = wp_remote_get($url);
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['stat']) and $body['stat'] == 'ok') {
            return $body['group']['id'];
        }
        return '';
    }

    public static function checkFlickrGroupLookup($apikey, $groupurl) {
        $url = "https://api.flickr.com/services/rest/?method=flickr.urls.lookupGroup&api_key={$apikey}&url=" . urlencode($groupurl) . "&format=json&nojsoncallback=1";
        $response = wp_remote_get($url);
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($body['stat']) and $body['stat'] == 'ok') {
            return true;
        }
        return false;
    }

    public function get_template_html($data = []) {
        $is_expertmode = isset($data['expertmode']) ? true : false;
        $type = isset($data['type']) ? $data['type'] : '';
        $return_html = '';
        if ($is_expertmode) {
            if (isset($data['experthtml_' . $type])) {
                return stripslashes($data['experthtml_' . $type]);
            }
        } else {
            $template_data = isset($data['data']) ? $data['data'] : '';
            $template_arr = [];
            if ($template_data != '') {
                $template_arr = json_decode(stripslashes($template_data));
            }

            if (isset($template_arr->$type)) {
                //supershow($template_arr->$type->elements);
                if (isset($template_arr->$type->elements)) {
                    $superElementObj = new SuperCarousel_Elements($template_arr->$type->elements);
                    $superElementObj->type = $type;
                    $return_html = $superElementObj->getHtml();
                }
            }
        }
        return $return_html;
    }

}
