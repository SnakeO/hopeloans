<?php

/**
 * Adds Supertweet_Widget widget.
 */
class Supertweet_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    //, 'Access Token' => 'access_token', 'Access Token Secret' => 'access_token_secret'
    private $widgetFields = array('Title' => 'title', 'Number of Tweets' => 'total_tweets', 'Pause Time (In Milliseconds)' => 'pause_time', 'Twitter Screen Name' => 'screen_name', 'Consumer Key' => 'consumer_key', 'Secret Key' => 'secret_key');

    function __construct() {
        parent::__construct('supertweet_widget', // Base ID
                'Super Twitter Widget', // Name
                array('description' => 'A Supercarousel Twitter Widget',) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        foreach ($this->widgetFields as $lab => $v) {
            if (isset($instance[$v])) {
                $$v = $instance[$v];
            } else {
                $$v = '';
            }
        }

        $is_https = isset($instance['is_https']) ? (int) $instance['is_https'] : 0;

        if ($pause_time == '') {
            $pause_time = '2000';
        }

        $tweets = $this->getTweets($instance);
        if (isset($tweets->errors)) {
            echo $args['before_widget'];
            if (!empty($title)) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            echo isset($tweets->errors[0]->message) ? $tweets->errors[0]->message : '';
            echo $args['after_widget'];
            return;
        }
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        $rand = rand(111111, 999999);
        ?>
        <script type="text/javascript" language="javascript">
            jQuery(document).ready(function () {
                var opt = {};
                opt.desktopVisible = '1';
                opt.laptopVisible = '1';
                opt.mobileVisible = '1';
                opt.tabletVisible = '1';
                opt.auto = true;
                opt.circular = true;
                opt.pauseTime = '<?php echo $pause_time; ?>';
                opt.autoHeight = true;
                opt.swipe = false;
                opt.onload = function ($$) {
                    $$.find('>div').each(function () {
                        jQuery(this).find('span:first').html(jQuery.feedify(jQuery(this).find('span:first').html()));
                    });
                }
                if (jQuery("#supercarousel<?php echo $rand; ?>").find(">div").length == 0) {
                    jQuery("#supercrsl<?php echo $rand; ?>").hide();
                    return;
                }
                var scarousel = jQuery("#supercarousel<?php echo $rand; ?>").supercarousel(opt);
            });
        </script>
        <div id="supercrsl<?php echo $rand; ?>" class="supercrsl">
            <div class="supercarousel supertwitter" id="supercarousel<?php echo $rand; ?>">
                <?php
                foreach ($tweets as $row) {
                    ?>
                    <div>
                        <?php
                        if ($is_https == 1) {
                            if (isset($row->user->profile_image_url_https) and $row->user->profile_image_url_https != '') {
                                ?>
                                <img src="<?php echo $row->user->profile_image_url_https; ?>" />
                                <?php
                            }
                        } else {
                            if (isset($row->user->profile_image_url) and $row->user->profile_image_url != '') {
                                ?>
                                <img src="<?php echo $row->user->profile_image_url; ?>" />
                                <?php
                            }
                        }
                        ?><br />
                        <a href="<?php echo $row->user->url; ?>">
                            @<?php echo $row->user->screen_name; ?>
                        </a>
                        <br />
                        <span><?php echo $row->text; ?></span>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="clear"></div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    function getTweets($instance = array()) {
        foreach ($this->widgetFields as $lab => $v) {
            if (isset($instance[$v])) {
                $$v = $instance[$v];
            } else {
                $$v = '';
            }
        }

        if ($total_tweets == '') {
            $total_tweets = 5;
        }

        return $this->returnTweets($consumer_key, $secret_key, $screen_name, $total_tweets);
    }

    function returnTweets($consumer_key, $consumer_secret, $screen_name, $total_tweets) {
        $oauth_access_token = NULL;
        $oauth_access_token_secret = NULL;

        $twitter_timeline = "user_timeline";

        $request = array(
            'screen_name' => $screen_name,
            'count' => $total_tweets
        );

        $oauth = array(
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $oauth_access_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );

        $oauth = array_merge($oauth, $request);

        $base_info = $this->buildBaseString("https://api.twitter.com/1.1/statuses/$twitter_timeline.json", 'GET', $oauth);
        $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;

        $header = array($this->buildAuthorizationHeader($oauth), 'Expect:');
        $options = array(CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => "https://api.twitter.com/1.1/statuses/$twitter_timeline.json?" . http_build_query($request),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false);

        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        curl_close($feed);

        return json_decode($json);
    }

    function buildBaseString($baseURI, $method, $params) {
        $r = array();
        ksort($params);
        foreach ($params as $key => $value) {
            $r[] = "$key=" . rawurlencode($value);
        }
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    }

    function buildAuthorizationHeader($oauth) {
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach ($oauth as $key => $value)
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        $r .= implode(', ', $values);
        return $r;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        echo '<br /> <b>You need to enter authentication details.</b>';
        foreach ($this->widgetFields as $lab => $v) {
            if (isset($instance[$v])) {
                $$v = $instance[$v];
            } else {
                $$v = '';
            }
            ?>
            <p>
                <label for="<?php echo $this->get_field_id($v); ?>"><?php echo $lab; ?>:</label> 
                <input class="widefat" id="<?php echo $this->get_field_id($v); ?>" name="<?php echo $this->get_field_name($v); ?>" type="text" value="<?php echo isset($instance[$v]) ? esc_attr($instance[$v]) : ''; ?>">
            </p>
            <?php
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('is_https'); ?>">Use HTTPS:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id('is_https'); ?>" name="<?php echo $this->get_field_name('is_https'); ?>" type="checkbox"<?php echo (isset($instance['is_https']) and $instance['is_https'] == '1') ? ' checked="checked"' : ''; ?> value="1" />
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();

        foreach ($this->widgetFields as $lab => $v) {
            $instance[$v] = (!empty($new_instance[$v]) ) ? strip_tags($new_instance[$v]) : '';
        }

        $instance['is_https'] = isset($new_instance['is_https']) ? (int) $new_instance['is_https'] : 0;

        return $instance;
    }

}

// class Foo_Widget
// register Supertweet_Widget widget
function register_supeer_tweet_widget() {
    register_widget('Supertweet_Widget');
}

add_action('widgets_init', 'register_supeer_tweet_widget');
?>