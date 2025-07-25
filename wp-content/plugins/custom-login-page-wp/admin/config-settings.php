<?php
/**
 * Config
 *
 * @package WordPress
 * @subpackage seed_cl
 * @since 0.1.0
 */

/**
 * Config Settings
 */
function seed_cl_get_options(){

    /**
     * Create new menus
     */

    $seed_cl_options[ ] = array(
        "type" => "menu",
        "menu_type" => "add_options_page",
        "page_name" => __( "Login Page", 'custom-login-page-wp' ),
        "menu_slug" => "seed_cl",
        "layout" => "2-col"
    );

    /**
     * Settings Tab
     */
    $seed_cl_options[ ] = array(
        "type" => "tab",
        "id" => "seed_cl_setting",
        "label" => __( "Login Page Settings", 'custom-login-page-wp' ),
        "icon" => 'fa fa-sign-in',
    );

    $seed_cl_options[ ] = array(
        "type" => "setting",
        "id" => "seed_cl_settings_content",
    );

    $seed_cl_options[ ] = array(
        "type" => "section",
        "id" => "seed_cl_section_general",
        "label" => __( "General Settings", 'custom-login-page-wp' ),
        "icon" => 'fa fa-cogs',
    );

    $seed_cl_options[ ] = array(
        "type" => "custom_status",
        "id" => "status",
        "label" => __( "Status", 'custom-login-page-wp' ),
        "option_values" => array(
            '0' => __( 'Disabled', 'custom-login-page-wp' ),
            '1' => __( 'Enable Custom Login Page', 'custom-login-page-wp' ),
        ),
        "desc" => __( "<span class='highlight'>Use the settings above to turn the custom login page on and off. Click the button below to customize the login page.</span>", 'custom-login-page-wp' ),
        "default_value" => "0"
    );
    
    $seed_cl_options[ ] = array(
        "type" => "custom_editpage",
        "id" => "edit_page",
        "label" => __( "", 'custom-login-page-wp' ),

    );





    




    return $seed_cl_options;

}
