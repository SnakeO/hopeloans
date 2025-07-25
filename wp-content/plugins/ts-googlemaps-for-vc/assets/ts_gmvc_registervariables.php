<?php
    global $GOOGLEMAPS_PLUS_VC;
    
    // Setting Parameters
    // ------------------
    $this->TS_GMVC_ComposerParameters = array(
        "Advanced Link Parameter"                   			=> array("file" => "advancedlinks"),
        "Advanced Setting Parameter"                			=> array("file" => "advancedsetting"),
        "Google Fonts Parameter"                    			=> array("file" => "googlefonts"),
        "Hidden Input Parameter"                    			=> array("file" => "hiddeninput"),
        "Live Preview Parameter"                  				=> array("file" => "livepreview"),
        "Map Marker Parameter"                      			=> array("file" => "markerpanel"),
		"Icon Picker Parameter"                      			=> array("file" => "iconspanel"),
        "Messenger Parameter"                       			=> array("file" => "messenger"),
        "NoUiSlider Parameter"                      			=> array("file" => "nouislider"),
        "Separator Parameter"            		    			=> array("file" => "separator"),
        "Switch Parameter"                          			=> array("file" => "switch"),
        "Tag Input Parameter"                       			=> array("file" => "tageditor"),
		"WYSIWYG Editor Parameter"                       		=> array("file" => "wysiwyg"),
    );
	
    // Preloader Selection
    $this->TS_GMVC_Preloader_Styles = array(
        "Preloader #0"				                            => "0",        
        "Preloader #1"			                                => "1",
        "Preloader #2"			                                => "2",
        "Preloader #3"			                                => "3",
        "Preloader #4"                                          => "4",
        "Preloader #5"                                          => "5",
        "Preloader #6"                                          => "6",
        "Preloader #7"                                          => "7",
        "Preloader #8"                                          => "8",
        "Preloader #9"                                          => "9",
        "Preloader #10"                                         => "10",
        "Preloader #11"                                         => "11",
        "Preloader #12"                                         => "12",
        "Preloader #13"                                         => "13",
        "Preloader #14"                                         => "14",
        "Preloader #15"                                         => "15",
        "Preloader #16"                                         => "16",
        "Preloader #17"                                         => "17",
        "Preloader #18"                                         => "18",
        "Preloader #19"                                         => "19",
        "Preloader #20"                                         => "20",
        "Preloader #21"                                         => "21",
		"Preloader #22"                                         => "22",
        __("No Preloader", "ts_visual_composer_extend")			=> "-1",
    );
    
    // Default Text Strings for TS Google Maps PLUS
    // --------------------------------------------
    $this->TS_GMVC_Google_MapPLUS_Language_Defaults = array(
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
    
    // Default Advanced Link Picker
    // ----------------------------
    $this->TS_GMVC_Advanced_Linkpicker_Defaults = array(
        'enabled'                       		    => 0, // true/false
        'global'                        		    => 1,
        'offset'                        		    => 25,
        'posts'                         		    => 1, // true/false
        'custom'                        		    => 0, // true/false
        'orderby'                       		    => 'title',
        'order'                         		    => 'ASC',
    );				
    $TS_GMVC_Advanced_Linkpicker_Settings		    = get_option('ts_vcsc_extend_settings_parameterLinkpicker', '');
    if (($TS_GMVC_Advanced_Linkpicker_Settings == false) || (empty($TS_GMVC_Advanced_Linkpicker_Settings))) {
        $TS_GMVC_Advanced_Linkpicker_Settings	    = array();
    }
    $this->TS_GMVC_ParameterLinkPicker = array(
        'enabled'								    => (((array_key_exists('enabled', $TS_GMVC_Advanced_Linkpicker_Settings))   ? $TS_GMVC_Advanced_Linkpicker_Settings['enabled']      : $this->TS_GMVC_Advanced_Linkpicker_Defaults['enabled'])       == 1 ? "true" : "false"),
        'global'								    => (((array_key_exists('global', $TS_GMVC_Advanced_Linkpicker_Settings))    ? $TS_GMVC_Advanced_Linkpicker_Settings['global']       : $this->TS_GMVC_Advanced_Linkpicker_Defaults['global'])        == 1 ? "true" : "false"),
        'offset'								    => ((array_key_exists('offset', $TS_GMVC_Advanced_Linkpicker_Settings))     ? $TS_GMVC_Advanced_Linkpicker_Settings['offset']       : $this->TS_GMVC_Advanced_Linkpicker_Defaults['offset']),
        'posts'									    => (((array_key_exists('posts', $TS_GMVC_Advanced_Linkpicker_Settings))     ? $TS_GMVC_Advanced_Linkpicker_Settings['posts']        : $this->TS_GMVC_Advanced_Linkpicker_Defaults['posts'])         == 1 ? "true" : "false"),
        'custom'								    => (((array_key_exists('custom', $TS_GMVC_Advanced_Linkpicker_Settings))    ? $TS_GMVC_Advanced_Linkpicker_Settings['custom']       : $this->TS_GMVC_Advanced_Linkpicker_Defaults['custom'])        == 1 ? "true" : "false"),
        'orderby'								    => ((array_key_exists('orderby', $TS_GMVC_Advanced_Linkpicker_Settings))    ? $TS_GMVC_Advanced_Linkpicker_Settings['orderby']      : $this->TS_GMVC_Advanced_Linkpicker_Defaults['orderby']),
        'order'									    => ((array_key_exists('order', $TS_GMVC_Advanced_Linkpicker_Settings))      ? $TS_GMVC_Advanced_Linkpicker_Settings['order']        : $this->TS_GMVC_Advanced_Linkpicker_Defaults['order']),
    );
    unset($TS_GMVC_Advanced_Linkpicker_Settings);
	
    // Extendend Container Nesting
    if (get_option('ts_vcsc_extend_settings_allowExtendedNesting', 0) == 1) {
		$this->TS_GMVC_UseExtendedNesting 			= "true";
	} else {
		$this->TS_GMVC_UseExtendedNesting 			= "false";
	}
	
	// TinyMCE Editor / Textarea Input
	$this->TS_GMVC_EditorBase64TinyMCE				= "true";
?>