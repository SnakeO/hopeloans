<?php
	if (!defined('WP_UNINSTALL_PLUGIN')) {
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
	}	
	
	if (!is_user_logged_in()) {
		wp_die('You must be logged in to run this script.');
	}
	
	if (!current_user_can('install_plugins')) {
		wp_die('You do not have permission to run this script.');
	}

	if (function_exists('is_multisite') && is_multisite()) {
		if ($network_wide) {
			global $wpdb;
			global $GOOGLEMAPS_PLUS_VC;
			$old_blog 	= $wpdb->blogid;
			$blogids 	= $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				if ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "false") {
					delete_option('ts_vcsc_extend_settings_translationsGoogleMapPLUS');
				}
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	if ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "false") {
		delete_option('ts_vcsc_extend_settings_translationsGoogleMapPLUS');
	}
?>