<?php
/*This file is part of hope-loans, visual-composer-starter child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

define('HOPE_THEME', get_stylesheet_directory_uri());

require_once(ABSPATH . '/jmvc/app/start.php');

/*
add_filter( 'wpv_filter_query', function($query_args, $view_settings, $view_id)
{
	return $query_args;

	print_r(array(
		'view_id'		=> $view_id,
		'query_args'	=> $query_args,
		'view_settings'	=> $view_settings
	));

}, 99, 3 );
*/

function hope_loans_enqueue_child_styles() 
{
	$parent_style = 'parent-style'; 
		wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css' );
		/*
		wp_enqueue_style( 
			'child-style', 
			get_stylesheet_directory_uri() . '/style.css',
			array( $parent_style ),
			wp_get_theme()->get('Version') );
		*/
}
add_action( 'wp_enqueue_scripts', 'hope_loans_enqueue_child_styles' );

add_action( 'after_setup_theme', function() 
{
    add_theme_support( 'woocommerce' );
});
