<?php
function seed_cl_get_settings(){
    $settings = get_option('seed_cl_settings_content');
    if(empty($settings)){
    	require_once( SEED_CL_PLUGIN_PATH.'admin/default-settings.php' );
		add_option('seed_cl_settings_content',unserialize($seed_cl_settings_defaults['seed_cl_settings_content']));
    }
    return apply_filters( 'seed_cl_get_settings', $settings );;
}
