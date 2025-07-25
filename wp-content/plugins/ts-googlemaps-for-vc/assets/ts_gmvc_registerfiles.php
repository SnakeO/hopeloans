<?php
    global $GOOGLEMAPS_PLUS_VC;
    $url                                                                        = $GOOGLEMAPS_PLUS_VC->TS_GMVC_PluginPath;
    $ts_vcsc_extend_settings_keyGoogleMapAPI	                                = get_option('ts_vcsc_extend_settings_keyGoogleMapAPI',	'');

    // Internal Files
    // --------------
    // Front-End Files
    wp_register_style('ts-googlemapsvc-front',						            $url . 'css/ts-googlemapsvc-front.min.css', null, GOOGLEMAPS_VCVERSION, 'all');
    wp_register_script('ts-googlemapsvc-front',						            $url . 'js/ts-googlemapsvc-front.min.js', array('jquery'), GOOGLEMAPS_VCVERSION, true);
    // General Settings Files
    wp_register_style('ts-googlemapsvc-settings',                              	$url . 'css/ts-googlemapsvc-settings.min.css', null, GOOGLEMAPS_VCVERSION, 'all');
    wp_register_script('ts-googlemapsvc-settings', 								$url . 'js/ts-googlemapsvc-settings.min.js', array('jquery'), GOOGLEMAPS_VCVERSION, true);
    // Elements Files (VC Editor)
    wp_register_script('ts-googlemapsvc-parameters',                            $url . 'js/ts-googlemapsvc-parameters.min.js', array('jquery'), GOOGLEMAPS_VCVERSION, true);
    wp_register_style('ts-googlemapsvc-parameters',                             $url . 'css/ts-googlemapsvc-parameters.min.css', null, GOOGLEMAPS_VCVERSION, 'all');
    // Composer Files
    wp_register_style('ts-googlemapsvc-composer',                               $url . 'css/ts-googlemapsvc-composer.min.css', null, GOOGLEMAPS_VCVERSION, 'all');
    // Admin Files
    wp_register_style('ts-googlemapsvc-admin',                                  $url . 'css/ts-googlemapsvc-admin.min.css', null, GOOGLEMAPS_VCVERSION, 'all');
    // Buttons Files
    wp_register_style('ts-googlemapsvc-buttons',                                $url . 'css/ts-googlemapsvc-buttons.min.css', null, GOOGLEMAPS_VCVERSION, 'all');
    // Map Marker Image Font
    wp_register_style('ts-font-mapmarker', 		                                $url . 'css/ts-font-mapmarker.min.css', null, false, 'all');
    
    // 3rd Party Files
    // ---------------
    // Google Maps API
    if ($ts_vcsc_extend_settings_keyGoogleMapAPI != "") {
        wp_register_script('ts-extend-mapapi-none',								'https://maps.google.com/maps/api/js?key=' . $ts_vcsc_extend_settings_keyGoogleMapAPI, false, false, false);
        wp_register_script('ts-extend-mapapi-library',							'https://maps.google.com/maps/api/js?key=' . $ts_vcsc_extend_settings_keyGoogleMapAPI . '&libraries=places,geometry', false, false, false);
    } else {
        wp_register_script('ts-extend-mapapi-none',								'https://maps.google.com/maps/api/js', false, false, false);
        wp_register_script('ts-extend-mapapi-library',							'https://maps.google.com/maps/api/js?libraries=places,geometry', false, false, false);
    }
    // Custom Google Map Scripts  
    wp_register_style('ts-extend-googlemapsplus',                 				$url . 'css/jquery.vcsc.gomapplus.min.css', null, false, 'all');
    wp_register_script('ts-extend-googlemapsplus', 								$url . 'js/jquery.vcsc.gomapplus.min.js', array('jquery'), false, true);
    wp_register_script('ts-extend-markerclusterer', 							$url . 'js/jquery.vcsc.markerclusterer.min.js', array('jquery','ts-extend-googlemapsplus'), false, true);    
    // Modernizr
    wp_register_script('ts-extend-modernizr',                					$url . 'js/jquery.vcsc.modernizr.min.js', array('jquery'), false, false);
    // Tooltipster Tooltips
    wp_register_style('ts-extend-tooltipster',                 					$url . 'css/jquery.vcsc.tooltipster.min.css', null, false, 'all');
    wp_register_script('ts-extend-tooltipster',									$url . 'js/jquery.vcsc.tooltipster.min.js', array('jquery'), false, true);			
    // Sumo Select
    wp_register_style('ts-extend-sumo', 				        				$url . 'css/jquery.vcsc.sumoselect.min.css', null, false, 'all');
    wp_register_script('ts-extend-sumo', 										$url . 'js/jquery.vcsc.sumoselect.min.js', array('jquery'), false, true);
    // Preloaders
    wp_register_style('ts-extend-preloaders', 				        			$url . 'css/jquery.vcsc.preloaders.min.css', null, false, 'all');
    
    
    // Back-End Files
    // --------------
    // NoUiSlider
    wp_register_style('ts-extend-nouislider',									$url . 'css/jquery.vcsc.nouislider.min.css', null, false, 'all');
    wp_register_script('ts-extend-nouislider',									$url . 'js/jquery.vcsc.nouislider.min.js', array('jquery'), false, true);
    // SweetAlert Popup
    wp_register_style('ts-extend-sweetalert', 				        			$url . 'css/jquery.vcsc.sweetalert.min.css', null, false, 'all');
    wp_register_script('ts-extend-sweetalert',                            		$url . 'js/jquery.vcsc.sweetalert.min.js', array('jquery'), false, true);
    // jQuery Easing
    wp_register_script('jquery-easing', 										$url . 'js/jquery.vcsc.easing.min.js', array('jquery'), false, true);
    // Validation Engine
    wp_register_script('validation-engine', 									$url . 'js/jquery.vcsc.validationengine.min.js', array('jquery'), false, true);
    wp_register_style('validation-engine',										$url . 'css/jquery.vcsc.validationengine.min.css', null, false, 'all');
    wp_register_script('validation-engine-en', 									$url . 'js/jquery.vcsc.validationengine.en.min.js', array('jquery'), false, true);
    // Font Icon Picker
    wp_register_style('ts-extend-iconpicker',					                $url . 'css/jquery.vcsc.fonticonpicker.min.css', null, false, 'all');
    wp_register_script('ts-extend-iconpicker',					                $url . 'js/jquery.vcsc.fonticonpicker.min.js', array('jquery'), false, true);
?>