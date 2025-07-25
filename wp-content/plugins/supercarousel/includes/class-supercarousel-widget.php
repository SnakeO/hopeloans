<?php

/**
 * Adds SuperCarousel widget.
 */
class Supercarousel_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    //, 'Access Token' => 'access_token', 'Access Token Secret' => 'access_token_secret'
    private $widgetFields = array('Title' => 'title', 'Text Before' => 'text_before', 'Carousel' => 'carousel_id', 'Text After' => 'text_after');

    function __construct() {
        parent::__construct('supercarousel_widget', // Base ID
                'Super Carousel Widget', // Name
                array('description' => 'A Supercarousel Widget',) // Args
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

        if ($carousel_id == '' or (int) $carousel_id <= 0) {
            echo 'Invalid Carousel';
            exit;
        }

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo $text_before;
        echo do_shortcode("[supercarousel id=$carousel_id]");
        echo $text_after;
        echo $args['after_widget'];
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
                <?php
                if ($v == 'carousel_id') {
                    $loop = new WP_Query(array('post_type' => 'supercarousel', 'posts_per_page' => -1));
                    ?>
                    <select id="<?php echo $this->get_field_id($v); ?>" name="<?php echo $this->get_field_name($v); ?>">
                        <?php
                        foreach ($loop->posts as $sc) {
                            ?>
                            <option value="<?php echo $sc->ID; ?>"<?php echo (isset($instance[$v]) and $instance[$v] == $sc->ID) ? ' selected="selected"' : ''; ?>><?php echo $sc->post_title; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php
                } else {
                    ?>
                    <input class="widefat" id="<?php echo $this->get_field_id($v); ?>" name="<?php echo $this->get_field_name($v); ?>" type="text" value="<?php echo isset($instance[$v]) ? esc_attr($instance[$v]) : ''; ?>">
                    <?php
                }
                ?>
            </p>
            <?php
        }
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

        return $instance;
    }

}

// register Supercarousel_Widget widget
function register_supeer_carousel_widget() {
    register_widget('Supercarousel_Widget');
}

add_action('widgets_init', 'register_supeer_carousel_widget');
?>