<?php
    global $GOOGLEMAPS_PLUS_VC;    

	// Check for Visual Composer and Minimum Version
	// ---------------------------------------------
	add_action('admin_init',				'TS_GMVC_Init_Addon');	
    function TS_GMVC_Init_Addon() {
        $required_vc 	= '4.5.9';
        if (defined('WPB_VC_VERSION')){
            if (version_compare($required_vc, WPB_VC_VERSION, '>')) {
                add_action('admin_notices', 'TS_GMVC_Admin_Notice_Version');
            }
        } else {
            add_action('admin_notices', 	'TS_GMVC_Admin_Notice_Activation');
        }
    }
    function TS_GMVC_Admin_Notice_Version() {
        echo '<div class="ts-googlemaps-forvc-admin-notice notice notice-error is-dismissible"><p>The <strong>Google Maps PLUS for Visual Composer</strong> add-on requires <strong>Visual Composer</strong> version 4.6.0 or greater.</p></div>';	
    }
    function TS_GMVC_Admin_Notice_Activation() {
        echo '<div class="ts-googlemaps-forvc-admin-notice notice notice-error is-dismissible"><p>The <strong>Google Maps PLUS for Visual Composer</strong> add-on requires the <strong>Visual Composer</strong> Plugin installed and activated.</p></div>';
    }
    function TS_GMVC_Admin_Notice_Network() {
        echo '<div class="ts-googlemaps-forvc-admin-notice notice notice-warning is-dismissible"><p>The <strong>Google Maps PLUS for Visual Composer</strong> add-on can not be activated network-wide but only on individual sub-sites.</p></div>';
    }
    
    
	// Callback Function for Plugin Activation / Deactivation / Uninstall
	// ------------------------------------------------------------------
    function TS_GMVC_Callback_Activation() {
        // Language Settings: Google Maps PLUS
        $TS_VCSC_Google_MapPLUS_Language_Defaults_Init = array(
        'ListenersStart'                			=> 'Start Listeners',
        'ListenersStop'                 			=> 'Stop Listeners',
        'MobileShow'                    			=> 'Show Google Map',
        'MobileHide'                    			=> 'Hide Google Map',
        'StyleDefault'                  			=> 'Google Standard',
        'StyleLabel'                    			=> 'Change Map Style',
        'FilterAll'                     			=> 'All Groups',
        'FilterLabel'                   			=> 'Filter by Groups',
        'SelectLabel'                   			=> 'Zoom to Location',
        'ControlsOSM'                   			=> 'Open Street',
        'ControlsHome'                  			=> 'Home',
        'ControlsBounds'                			=> 'Fit All',
        'ControlsBike'                  			=> 'Bicycle Trails',
        'ControlsTraffic'               			=> 'Traffic',
        'ControlsTransit'               			=> 'Transit',
        'TrafficMiles'                  			=> 'Miles per Hour',
        'TrafficKilometer'              			=> 'Kilometers per Hour',
        'TrafficNone'                   			=> 'No Data Available',
        'SearchButton'                  			=> 'Find New Location',
        'SearchHolder'                  			=> 'Enter address to search for ...',
        'SearchGoogle'                  			=> 'View on Google Maps',
        'SearchDirections'              			=> 'Get Directions',
        'SearchGroup'                   			=> 'Map Search',
        'OtherLink'                     			=> 'Learn More!',
        'PlaceholderMarker'             			=> 'Select Location',
        'ListingsButton'                			=> 'Search Locations',
        'ListingsSearch'                			=> 'Enter location to search for ...',
		'SumoConfirm'			        			=> 'Confirm',
		'SumoCancel'			        			=> 'Cancel',
		'SumoSelected'			        			=> 'Selected',
		'SumoAllSelected'		        			=> 'All Selected!',
		'SumoPlaceholder'		        			=> 'Select Here',
		'SumoSearchLocations'		    			=> 'Search Locations',
		'SumoSearchGroups'		        			=> 'Search Groups',
		'SumoSearchStyles'		        			=> 'Search Styles',
        );
        add_option('ts_vcsc_extend_settings_translationsGoogleMapPLUS', 		$TS_VCSC_Google_MapPLUS_Language_Defaults_Init);
		add_option('ts_vcsc_extend_settings_translationsDomain', 				1);
    }
    function TS_GMVC_Callback_Deactivation() {
        
    }
    function TS_GMVC_Callback_Uninstall() {
        if ((in_array('ts-visual-composer-extend/ts-visual-composer-extend.php', apply_filters('active_plugins', get_option('active_plugins')))) || (class_exists('VISUAL_COMPOSER_EXTENSIONS'))) {
            // Keep Language Setting for Composium
        } else {
            delete_option('ts_vcsc_extend_settings_translationsGoogleMapPLUS');
			delete_option('ts_vcsc_extend_settings_translationsDomain');
        }
    }
    
    
    // Function to run if new Blog created on MutliSite
    // ------------------------------------------------	
    add_action('wpmu_new_blog', 			'TS_GMVC_On_New_BlogSite', 10, 6);
    function TS_GMVC_On_New_BlogSite($blog_id, $user_id, $domain, $path, $site_id, $meta) {
        global $wpdb;
        if (function_exists('is_multisite') && is_multisite()) {
            if (is_plugin_active_for_network('ts-googlemaps-for-vc/ts-googlemaps-for-vc.php')) {
                $old_blog = $wpdb->blogid;
                switch_to_blog($blog_id);
                TS_GMVC_Callback_Activation();
                switch_to_blog($old_blog);
            }
        }
    }
?>