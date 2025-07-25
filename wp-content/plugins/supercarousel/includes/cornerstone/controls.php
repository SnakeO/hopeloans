<?php

/**
 * Element Controls
 */
$args = array('post_type' => 'supercarousel', 'posts_per_page' => -1);
$loop = new WP_Query($args);

$supercarouseloptions = [['value'=>'', 'label'=>'Select']];

foreach ($loop->posts as $row) {
    $supercarouseloptions[] = ['value' => $row->post_name, 'label' => $row->post_title];
}

return array(
    'supercarousel_slug' => array(
        'type' => 'select',
        'ui' => array(
            'title' => __('Super Carousel', 'supercarousel'),
            'tooltip' => __('Select Super Carousel', 'supercarousel'),
        ),
        'options' => array(
            'choices' => $supercarouseloptions
        )
    ),
);
