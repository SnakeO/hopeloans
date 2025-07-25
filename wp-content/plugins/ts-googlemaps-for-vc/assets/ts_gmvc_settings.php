<?php
	global $GOOGLEMAPS_PLUS_VC;
	if ((isset($_POST['Submit'])) && ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "false")) {
		//var_dump($_POST);
		if (trim ($_POST['ts_vcsc_extend_settings_true']) == 1) {
			
			echo '<div id="ts_vcsc_extend_settings_save" style="position: relative; margin: 20px auto 20px auto; width: 128px; height: 128px;">';
				echo TS_GMVC_CreatePreloaderCSS("ts-settings-panel-loader", "", 4, "false");
			echo '</div>';
			
			if ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "false") {
				// Language Settings
				$TS_VCSC_Google_MapPLUS_Language = array (
					'ListenersStart'                => trim ($_POST['ts_vcsc_extend_settings_languageTextListenersStart']),
					'ListenersStop'                 => trim ($_POST['ts_vcsc_extend_settings_languageTextListenersStop']),
					'MobileShow'                    => trim ($_POST['ts_vcsc_extend_settings_languageTextMobileShow']),
					'MobileHide'                    => trim ($_POST['ts_vcsc_extend_settings_languageTextMobileHide']),
					'StyleDefault'                  => trim ($_POST['ts_vcsc_extend_settings_languageTextStyleDefault']),
					'StyleLabel'                    => trim ($_POST['ts_vcsc_extend_settings_languageTextStyleLabel']),
					'FilterAll'                     => trim ($_POST['ts_vcsc_extend_settings_languageTextFilterAll']),
					'FilterLabel'                   => trim ($_POST['ts_vcsc_extend_settings_languageTextFilterLabel']),
					'SelectLabel'                   => trim ($_POST['ts_vcsc_extend_settings_languageTextSelectLabel']),
					'ControlsOSM'                   => trim ($_POST['ts_vcsc_extend_settings_languageTextControlsOSM']),
					'ControlsHome'                  => trim ($_POST['ts_vcsc_extend_settings_languageTextControlsHome']),
					'ControlsBounds'                => trim ($_POST['ts_vcsc_extend_settings_languageTextControlsBounds']),
					'ControlsBike'                  => trim ($_POST['ts_vcsc_extend_settings_languageTextControlsBike']),
					'ControlsTraffic'               => trim ($_POST['ts_vcsc_extend_settings_languageTextControlsTraffic']),
					'ControlsTransit'               => trim ($_POST['ts_vcsc_extend_settings_languageTextControlsTransit']),
					'TrafficMiles'                  => trim ($_POST['ts_vcsc_extend_settings_languageTextTrafficMiles']),
					'TrafficKilometer'              => trim ($_POST['ts_vcsc_extend_settings_languageTextTrafficKilometer']),
					'TrafficNone'                   => trim ($_POST['ts_vcsc_extend_settings_languageTextTrafficNone']),
					'SearchButton'                  => trim ($_POST['ts_vcsc_extend_settings_languageTextSearchButton']),
					'SearchHolder'                  => trim ($_POST['ts_vcsc_extend_settings_languageTextSearchHolder']),
					'SearchGoogle'                  => trim ($_POST['ts_vcsc_extend_settings_languageTextSearchGoogle']),				
					'SearchGroup'                  	=> trim ($_POST['ts_vcsc_extend_settings_languageTextSearchGroup']),				
					'SearchDirections'              => trim ($_POST['ts_vcsc_extend_settings_languageTextSearchDirections']),
					'OtherLink'              		=> trim ($_POST['ts_vcsc_extend_settings_languageTextOtherLink']),
					'PlaceholderMarker'				=> trim ($_POST['ts_vcsc_extend_settings_languageTextPlaceholderMarker']),
					'ListingsButton'                => trim ($_POST['ts_vcsc_extend_settings_languageTextListingsButton']),
					'ListingsSearch'                => trim ($_POST['ts_vcsc_extend_settings_languageTextListingsSearch']),
					'SumoConfirm'			        => trim ($_POST['ts_vcsc_extend_settings_languageTextSumoConfirm']),
					'SumoCancel'			        => trim ($_POST['ts_vcsc_extend_settings_languageTextSumoCancel']),
					'SumoSelected'			        => trim ($_POST['ts_vcsc_extend_settings_languageTextSumoSelected']),
					'SumoAllSelected'		        => trim ($_POST['ts_vcsc_extend_settings_languageTextSumoAllSelected']),
					'SumoPlaceholder'		        => trim ($_POST['ts_vcsc_extend_settings_languageTextSumoPlaceholder']),
					'SumoSearchLocations'		    => trim ($_POST['ts_vcsc_extend_settings_languageTextSumoSearchLocations']),
					'SumoSearchGroups'		        => trim ($_POST['ts_vcsc_extend_settings_languageTextSumoSearchGroups']),
					'SumoSearchStyles'		        => trim ($_POST['ts_vcsc_extend_settings_languageTextSumoSearchStyles']),
				);
				update_option('ts_vcsc_extend_settings_translationsGoogleMapPLUS', 		$TS_VCSC_Google_MapPLUS_Language);
				
				// Advanced Link Picker
				$TS_VCSC_Link_Picker = array(
					'enabled'						=> intval(((isset($_POST['ts_vcsc_extend_settings_linkerEnabled']))						?	$_POST['ts_vcsc_extend_settings_linkerEnabled']						: 0)),
					'global'						=> 1,
					'offset'						=> intval(((isset($_POST['ts_vcsc_extend_settings_linkerOffset'])) 						?	$_POST['ts_vcsc_extend_settings_linkerOffset'] 						: 25)),
					'posts'							=> intval(((isset($_POST['ts_vcsc_extend_settings_linkerPosts']))						?	$_POST['ts_vcsc_extend_settings_linkerPosts']						: 0)),
					'custom'						=> intval(((isset($_POST['ts_vcsc_extend_settings_linkerCustom']))						?	$_POST['ts_vcsc_extend_settings_linkerCustom']						: 0)),
					'orderby'						=> ((isset($_POST['ts_vcsc_extend_settings_linkerOrderby'])) 							?	$_POST['ts_vcsc_extend_settings_linkerOrderby'] 					: 'title'),
					'order'							=> ((isset($_POST['ts_vcsc_extend_settings_linkerOrder'])) 								?	$_POST['ts_vcsc_extend_settings_linkerOrder'] 						: 'ASC'),
				);
				update_option('ts_vcsc_extend_settings_parameterLinkpicker',			$TS_VCSC_Link_Picker);
				
				// Google Maps API Key
				update_option('ts_vcsc_extend_settings_keyGoogleMapAPI',				trim ($_POST['ts_vcsc_extend_settings_externalAPIGoogleMaps']));
				
				// Load Translation File
				update_option('ts_vcsc_extend_settings_translationsDomain',				intval(((isset($_POST['ts_vcsc_extend_settings_translationsDomain'])) ?	$_POST['ts_vcsc_extend_settings_translationsDomain'] : 0)));
				
				// Extendend Container Nesting
				update_option('ts_vcsc_extend_settings_allowExtendedNesting', 			intval(((isset($_POST['ts_vcsc_extend_settings_allowExtendedNesting'])) ?	$_POST['ts_vcsc_extend_settings_allowExtendedNesting'] : 0)));
			}
			
			echo '<script>';
				echo 'window.location="' . $_SERVER['REQUEST_URI'] . '";';
			echo '</script>';
			//Header('Location: '.$_SERVER['REQUEST_URI']);
			Exit();
		}
	} else {
		if ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "false") {
			// Language Settings
			$TS_VCSC_Google_MapPLUS_Language				= get_option('ts_vcsc_extend_settings_translationsGoogleMapPLUS',	$GOOGLEMAPS_PLUS_VC->TS_GMVC_Google_MapPLUS_Language_Defaults);

			// Advanced Link Selector
			$ts_vcsc_extend_settings_linkerEnabled			= ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ParameterLinkPicker['enabled'] == "true" ? 1 : 0);
			$ts_vcsc_extend_settings_linkerGlobal			= ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ParameterLinkPicker['global'] == "true" ? 1 : 0);
			$ts_vcsc_extend_settings_linkerOffset			= $GOOGLEMAPS_PLUS_VC->TS_GMVC_ParameterLinkPicker['offset'];
			$ts_vcsc_extend_settings_linkerPosts			= ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ParameterLinkPicker['posts'] == "true" ? 1 : 0);
			$ts_vcsc_extend_settings_linkerCustom			= ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ParameterLinkPicker['custom'] == "true" ? 1 : 0);
			$ts_vcsc_extend_settings_linkerOrderby			= $GOOGLEMAPS_PLUS_VC->TS_GMVC_ParameterLinkPicker['orderby'];
			$ts_vcsc_extend_settings_linkerOrder			= $GOOGLEMAPS_PLUS_VC->TS_GMVC_ParameterLinkPicker['order'];
			
			// Google Maps API Key
			$ts_vcsc_extend_settings_keyGoogleMapAPI		= get_option('ts_vcsc_extend_settings_keyGoogleMapAPI',	'');
			
			// Translation File
			$ts_vcsc_extend_settings_translationsDomain		= get_option('ts_vcsc_extend_settings_translationsDomain',	1);
		
			// Extendend Container Nesting
			$ts_vcsc_extend_settings_allowExtendedNesting	= get_option('ts_vcsc_extend_settings_allowExtendedNesting', 0);
			
			// Basic Form Validation
			if (get_option('ts_vcsc_extend_settings_updated') == 1) {
				echo "\n";
				echo "<script type='text/javascript'>" . "\n";
					echo "var SettingsSaved = true;" . "\n";
				echo "</script>" . "\n";
			} else {
				echo "\n";
				echo "<script type='text/javascript'>" . "\n";
					echo "var SettingsSaved = false;" . "\n";
				echo "</script>" . "\n";
			}
			update_option('ts_vcsc_extend_settings_updated',	0);
		}
	}
?>

<div id="ts_vcsc_extend_errors" style="display: none;">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-hammer ts-vcsc-section-title-icon"></i><span class="ts-vcsc-section-title-header"></span></div>
		<div class="ts-vcsc-section-content"></div>
	</div>
</div>
<form id="ts_vcsc_extend_settings" data-type="settings" class="ts_vcsc_extend_global_settings" name="ts_vcsc_extend_settings" style="margin-top: 25px; width: 100%;" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<span id="gallery_settings_true" style="display: none !important; margin-bottom: 20px;">
		<input type="text" style="width: 20%;" id="ts_vcsc_extend_settings_true" name="ts_vcsc_extend_settings_true" value="0" size="100">
		<input type="text" style="width: 20%;" id="ts_vcsc_extend_settings_count" name="ts_vcsc_extend_settings_count" value="0" size="100">
	</span>
	<div class="wrapper ts-vcsc-settings-group-container">		
		<div class="ts-vcsc-settings-group-header">
			<div class="display_header">
				<h2><span class="dashicons dashicons-admin-generic"></span>Google Maps PLUS for Visual Composer v<?php echo TS_GMVC_GetPluginVersion(); ?> ... Options Panel</h2>
			</div>
			<div class="clear"></div>
		</div>
		<div class="ts-vcsc-settings-group-topbar ts-vcsc-settings-group-buttonbar">
			<a href="javascript:void(0);" class="ts-vcsc-settings-group-toggle">Expand</a>
			<div class="ts-vcsc-settings-group-actionbar">
				<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder ts-advanced-link-tooltip-right ts-advanced-link-tooltip-bottom">
					<span class="ts-advanced-link-tooltip-content"><?php _e("Click here to save your plugin settings.", "ts_visual_composer_extend"); ?></span>
					<button type="submit" name="Submit" id="ts_vcsc_extend_settings_submit_1" class="ts-advanced-link-button-main ts-advanced-link-button-blue ts-advanced-link-button-save" <?php echo ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "true" ? 'disabled="disabled"' : ''); ?> style="margin: 0;">
						<?php echo __("Save Settings", "ts_visual_composer_extend"); ?>
					</button>
				</div>				
			</div>
			<div class="clear"></div>
		</div>		
		<div id="v-nav" class="ts-vcsc-settings-group-tabs">
			<ul id="v-nav-main" data-type="settings">
				<li id="link-ts-settings-logo" class="first" style="border-bottom: 1px solid #DDD; height: 76px;">
					<img style="width: 210px; height: auto; margin: 0 auto;" src="<?php echo TS_GMVC_GetResourceURL('images/logos/tekanewa_scripts.png'); ?>">
				</li>
				<li id="link-ts-settings-general" 		data-tab="ts-settings-general" 			data-order="1"		data-name="General Settings"		class="link-data current"><i class="dashicons-admin-generic"></i>General Settings<span id="errorTab1" class="errorMarker"></span></li>
				<?php
					if ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "false") {
						echo '<li id="link-ts-settings-language" 		data-tab="ts-settings-language" 		data-order="2"		data-name="Language Settings"		class="link-data"><i class="dashicons-translation"></i>Language Settings<span id="errorTab2" class="errorMarker"></span></li>';
					}
					if (function_exists('file_get_contents')) {
						echo '<li id="link-ts-settings-changelog" 		data-tab="ts-settings-changelog" 		data-order="16"		data-name="Changelog"				class="link-data"><i class="dashicons-media-text"></i>Changelog<span id="errorTab16" class="errorMarker"></span></li>';
					}
				?>
			</ul>
		</div>
		<div class="ts-vcsc-settings-group-main">
			<?php
				if (function_exists('file_get_contents')) {
					include('ts_gmvc_general.php');
					if ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "false") {
						include('ts_gmvc_language.php');
					}
					include('ts_gmvc_changelog.php');
				}
			?>
        </div>
		<div class="ts-vcsc-settings-group-bottombar ts-vcsc-settings-group-buttonbar" style="">
			<div class="ts-vcsc-settings-group-actionbar">
				<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder ts-advanced-link-tooltip-right">
					<span class="ts-advanced-link-tooltip-content"><?php _e("Click here to save your plugin settings.", "ts_visual_composer_extend"); ?></span>
					<button type="submit" name="Submit" id="ts_vcsc_extend_settings_submit_2" class="ts-advanced-link-button-main ts-advanced-link-button-blue ts-advanced-link-button-save" <?php echo ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "true" ? 'disabled="disabled"' : ''); ?> style="margin: 0;">
						<?php echo __("Save Settings", "ts_visual_composer_extend"); ?>
					</button>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</form>