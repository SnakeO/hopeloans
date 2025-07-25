<?php
	global $GOOGLEMAPS_PLUS_VC;	
	if (TS_GMVC_VersionCompare($GOOGLEMAPS_PLUS_VC->TS_GMVC_VisualComposer_Version, '4.5.0') >= 0) {
		$visual_composer_link					= 'admin.php?page=vc-general';
	} else {
		$visual_composer_link					= 'options-general.php?page=vc_settings';
	}
?>
<div id="ts-settings-general" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-info"></i>General Information</div>
		<div class="ts-vcsc-section-content">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				In order to use this plugin, you MUST have the Visual Composer Plugin installed; either as a normal plugin or as part of your theme. If Visual Composer is part of your theme, please ensure that it has not been modified;
				some theme developers heavily modify Visual Composer in order to allow for certain theme functions. Unfortunately, some of these modification prevent this extension pack from working correctly.
			</div>
			<div style="margin-top: 20px; margin-bottom: 20px;">
				<h4>Google Maps PLUS for Visual Composer</h4>
				<?php
					if ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "false") {
						echo '<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify;">If you are using the "User Groups Access Rules" provided by Visual Composer itself, you MUST enable the new elements in the <a href="' . $visual_composer_link . '" target="_parent">settings</a> for the actual Visual Composer Plugin.</div>';
					}			
				?>
				<div style="margin-top: 20px;">
					<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder">
						<span class="ts-advanced-link-tooltip-content"><?php echo __("Click here to purchase a license for the plugin.", "ts_visual_composer_extend"); ?></span>
						<a href="https://codecanyon.net/item/google-maps-plus-for-visual-composer/13510102" target="_blank" class="ts-advanced-link-button-main ts-advanced-link-button-orange ts-advanced-link-button-purchase">
							<?php echo __("Buy Plugin", "ts_visual_composer_extend"); ?>
						</a>
					</div>
					<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder">
						<span class="ts-advanced-link-tooltip-content"><?php echo __("Click here to view the documentation for the plugin.", "ts_visual_composer_extend"); ?></span>
						<a href="http://www.googlemapsvc.krautcoding.com/documentation/" target="_blank" class="ts-advanced-link-button-main ts-advanced-link-button-purple ts-advanced-link-button-manual">
							<?php echo __("Documentation", "ts_visual_composer_extend"); ?>
						</a>
					</div>
					<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder">
						<span class="ts-advanced-link-tooltip-content"><?php echo __("Click here to go to the official support forum for the plugin.", "ts_visual_composer_extend"); ?></span>
						<a href="http://helpdesk.krautcoding.com/forums/forum/wordpress-plugins/google-maps-plus-for-visual-composer/" target="_blank" class="ts-advanced-link-button-main ts-advanced-link-button-red ts-advanced-link-button-support">
							<?php echo __("Support Forum", "ts_visual_composer_extend"); ?>
						</a>
					</div>
					<div class="ts-advanced-link-button-wrapper ts-advanced-link-tooltip-holder">
						<span class="ts-advanced-link-tooltip-content"><?php echo __("Click here to go to the public knowledge base for the plugin.", "ts_visual_composer_extend"); ?></span>
						<a href="http://helpdesk.krautcoding.com/category/google-maps-plus-for-visual-composer/" target="_blank" class="ts-advanced-link-button-main ts-advanced-link-button-green ts-advanced-link-button-knowledge">
							<?php echo __("Knowledge Base", "ts_visual_composer_extend"); ?>
						</a>
					</div>
				</div>
			</div>
			<?php
				if ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "true") {
					echo '<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify;">';
						echo 'You already have the "<strong>Composium - Visual Composer Extensions Addon</strong>" plugin installed and activated, which also includes the Google maps elements this plugin would otherwise provide for. In order to avoid duplications and potential
						conflicts, this plugin will NOT be loading its element version and/or associated files. Instead, you should be using the mirror elements in "Composium - Visual Composer Extensions". If the map elements are
						not available in "Composium - Visual Composer Extensions Addon", you might have to manually enable them in the plugin settings for "Composium - Visual Composer Extensions Addon" first.';
					echo '</div>';
				}
			?>
		</div>		
	</div>
	<?php if ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ComposiumStandard == "false") { ?>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-admin-network"></i>General Plugin Settings</div>
			<div class="ts-vcsc-section-content">
				<h4>Google Maps API Key:</h4>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					The usage of Google Maps is free for non-commercial users. Since 01/2012, commercial users have a current usage limit of 25.000 free requests a day – with additional usage cost of 0.5$/1000 requests.
					In order to comply with the Google Maps terms of services, commercial users have to register for a free API key. This API key can also be used by non-commercial users in order to monitor their Google Maps
					API usage. You can create your API key in the <a href="https://developers.google.com/" target="_blank">Google Developers Console</a>.
				</div>	
				<label class="Uniform" style="display: inline-block;" for="ts_vcsc_extend_settings_externalAPIGoogleMaps">Google Maps API Key:</label>
				<input class="ts_vcsc_extend_settings_externalAPIGoogleMaps" data-error="API Key - Google Maps" data-order="1" type="text" style="width: 50%;" id="ts_vcsc_extend_settings_externalAPIGoogleMaps" name="ts_vcsc_extend_settings_externalAPIGoogleMaps" value="<?php echo $ts_vcsc_extend_settings_keyGoogleMapAPI; ?>" size="100">	
			</div>
		</div>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-translation"></i>Visual Composer Translation File</div>
			<div class="ts-vcsc-section-content slideFade" style="display: none;">
				<h3>Load Plugin Language File:</h3>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					The default language for this plugin is English, but translation files for some other languages are included (for the element settings panels in Visual Composer only). If another language then English is detected,
					the plugin will load the language file for the detected language (if available). If you rather stick with English, you can disable the language file here.
				</div>
				<div style="margin-top: 20px; margin-bottom: 20px;">
					<div class="ts-switch-button ts-codestar-field-switcher" data-value="<?php echo $ts_vcsc_extend_settings_translationsDomain; ?>">
						<div class="ts-codestar-fieldset">
							<label class="ts-codestar-label">
								<input id="ts_vcsc_extend_settings_translationsDomain" data-order="1" value="<?php echo $ts_vcsc_extend_settings_translationsDomain; ?>" class="ts-codestar-checkbox ts_vcsc_extend_settings_translationsDomain" name="ts_vcsc_extend_settings_translationsDomain" type="checkbox" <?php echo ($ts_vcsc_extend_settings_translationsDomain == 1 ? 'checked="checked"' : ''); ?>> 
								<em data-on="Yes" data-off="No"></em>
								<span></span>
							</label>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_translationsDomain">Use Translation File</label>
				</div>
			</div>
		</div>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-tools"></i>Element Setting Panel Controls</div>
			<div class="ts-vcsc-section-content slideFade" style="display: none;">
				<div style="margin-top: 10px; margin-bottom: 10px;">
					<div style="font-weight: bold; font-size: 14px; margin: 0;">Allow Extended Container Elements Nesting:</div>
					<p style="font-size: 12px;">Define if the plugin should allow the usage of its container elements beyond the officially supported two levels of nested shortcodes:</p>
					<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify;">
						Officially, Visual Composer does NOT support the usage of container elements within other elements that would create more than 2 sub-levels of nested elements. That means, that you can't use container elements
						within inner (child) rows or other elements such as tabs or accordions. You have the option to "unlock" the container element ("TS Google Maps PLUS") within this plugin to be used in nested levels beyond the supported 2 levels, but
						be advised that neither Visual Composer itself or this addon can guaranty that those container elements will behave and render correctly. <strong>Use this option carefully and at your own risk!</strong></strong>
					</div>
					<div style="margin-top: 20px; margin-bottom: 20px;">
						<div class="ts-switch-button ts-codestar-field-switcher" data-value="<?php echo $ts_vcsc_extend_settings_allowExtendedNesting; ?>">
							<div class="ts-codestar-fieldset">
								<label class="ts-codestar-label">
									<input id="ts_vcsc_extend_settings_allowExtendedNesting" data-order="1" value="<?php echo $ts_vcsc_extend_settings_allowExtendedNesting; ?>" class="ts-codestar-checkbox ts_vcsc_extend_settings_allowExtendedNesting" name="ts_vcsc_extend_settings_allowExtendedNesting" type="checkbox" <?php echo ($ts_vcsc_extend_settings_allowExtendedNesting == 1 ? 'checked="checked"' : ''); ?>> 
									<em data-on="Yes" data-off="No"></em>
									<span></span>
								</label>
							</div>
						</div>
						<label class="labelToggleBox" for="ts_vcsc_extend_settings_allowExtendedNesting">Allow Extended Container Elements Nesting</label>
					</div>
				</div>
				<div style="margin-top: 20px; margin-bottom: 10px;">
					<h3>Advanced Link Selector:</h3>
					<p style="font-size: 12px;">Define if the plugin should provide you with an advanced link selector, based on page/post ID, instead of the standard one that is provided by Visual Composer:</p>				
					<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
						By default, this plugin will use the standard link selector that is part of Visual Composer, which is usually sufficient and faster. But if for some reason, you are frequently changing page/post names and/or slugs, which would
						also change the permalink to that page or post, rendering the link created by the standard link selector invalid, we provide our advanced link selector as an alternative. Instead of using the last known permalink directly,
						the advanced link selector will use the numeric page/post ID as basis. That will allow links created with the advanced link picker to always be current, as long as you don't change the numeric page/post ID number.
					</div>			
					<div style="margin-top: 20px; margin-bottom: 20px;">
						<div class="ts-switch-button ts-codestar-field-switcher" data-value="<?php echo $ts_vcsc_extend_settings_linkerEnabled; ?>">
							<div class="ts-codestar-fieldset">
								<label class="ts-codestar-label">
									<input id="ts_vcsc_extend_settings_linkerEnabled" data-order="1" value="<?php echo $ts_vcsc_extend_settings_linkerEnabled; ?>" class="ts-codestar-checkbox ts_vcsc_extend_settings_linkerEnabled" name="ts_vcsc_extend_settings_linkerEnabled" type="checkbox" <?php echo ($ts_vcsc_extend_settings_linkerEnabled == 1 ? 'checked="checked"' : ''); ?>> 
									<em data-on="Yes" data-off="No"></em>
									<span></span>
								</label>
							</div>
						</div>
						<label class="labelToggleBox" for="ts_vcsc_extend_settings_linkerEnabled">Use Advanced Link Selector</label>
					</div>					
				</div>
				<div id="ts_vcsc_extend_settings_linker_true" style="margin-top: 20px; margin-bottom: 10px; margin-left: 25px; <?php echo ($ts_vcsc_extend_settings_linkerEnabled == 0 ? 'display: none;' : 'display: block;'); ?>">
					<div style="margin-top: 0px; margin-bottom: 10px;">
						<h4>Show Standard Posts:</h4>
						<p style="font-size: 12px;">Define if the link selector should also show a listing of all standard WordPress posts, aside from pages:</p>		
						<div style="margin-top: 20px; margin-bottom: 20px;">
							<div class="ts-switch-button ts-codestar-field-switcher" data-value="<?php echo $ts_vcsc_extend_settings_linkerPosts; ?>">
								<div class="ts-codestar-fieldset">
									<label class="ts-codestar-label">
										<input id="ts_vcsc_extend_settings_linkerPosts" data-order="1" value="<?php echo $ts_vcsc_extend_settings_linkerPosts; ?>" class="ts-codestar-checkbox ts_vcsc_extend_settings_linkerPosts" name="ts_vcsc_extend_settings_linkerPosts" type="checkbox" <?php echo ($ts_vcsc_extend_settings_linkerPosts == 1 ? 'checked="checked"' : ''); ?>> 
										<em data-on="Yes" data-off="No"></em>
										<span></span>
									</label>
								</div>
							</div>
							<label class="labelToggleBox" for="ts_vcsc_extend_settings_linkerPosts">Show Standard Posts Listing</label>
						</div>		
					</div>				
					<div style="margin-top: 0px; margin-bottom: 10px;">
						<h4>Show Custom Posts:</h4>
						<p style="font-size: 12px;">Define if the link selector should also show a listing of custom WordPress posts, aside from pages (custom posts must be registered as public, queryable and searchable):</p>
						<div style="margin-top: 20px; margin-bottom: 20px;">
							<div class="ts-switch-button ts-codestar-field-switcher" data-value="<?php echo $ts_vcsc_extend_settings_linkerCustom; ?>">
								<div class="ts-codestar-fieldset">
									<label class="ts-codestar-label">
										<input id="ts_vcsc_extend_settings_linkerCustom" data-order="1" value="<?php echo $ts_vcsc_extend_settings_linkerCustom; ?>" class="ts-codestar-checkbox ts_vcsc_extend_settings_linkerCustom" name="ts_vcsc_extend_settings_linkerCustom" type="checkbox" <?php echo ($ts_vcsc_extend_settings_linkerCustom == 1 ? 'checked="checked"' : ''); ?>> 
										<em data-on="Yes" data-off="No"></em>
										<span></span>
									</label>
								</div>
							</div>
							<label class="labelToggleBox" for="ts_vcsc_extend_settings_linkerCustom">Show Custom Posts Listing</label>
						</div>		
					</div>				
					<div style="margin-top: 20px; margin-bottom: 10px;" class="clearFixMe">
						<h4>LazyLoad Offset:</h4>
						<p style="font-size: 12px;">Define the lazyload offset (interval) at which more pages/posts should be added to the link selector once you scroll to the end of the current list:</p>
						<div class="ts-nouislider-input-slider-wrapper clearFixMe ts-settings-parameter-gradient-grey ts-nouislider-input-slider-pips" style="height: 100px; max-width: 600px; float: left;">
							<div class="ts-nouislider-input-slider">
								<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px; background: #f5f5f5; color: #666666;" name="ts_vcsc_extend_settings_linkerOffset" id="ts_vcsc_extend_settings_linkerOffset" class="ts-nouislider-serial nouislider-input-selector nouislider-input-composer ts_vcsc_extend_settings_linkerOffset" type="text" min="10" max="120" step="1" value="<?php echo $ts_vcsc_extend_settings_linkerOffset; ?>"/>
								<span style="float: left; margin-right: 20px; margin-top: 10px; min-width: 10px;" class="unit">Links</span>
								<span class="ts-nouislider-input-down dashicons-arrow-left" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 5px; cursor: pointer; margin: 0;"></span>
								<div id="ts_vcsc_extend_settings_linkerOffset_slider" class="ts-nouislider-input ts-nouislider-input-element" data-pips="true" data-tooltip="false" data-value="<?php echo $ts_vcsc_extend_settings_linkerOffset; ?>" data-min="10" data-max="120" data-decimals="0" data-step="1" data-unit="x" style="width: 320px; float: left; margin-top: 10px;"></div>
								<span class="ts-nouislider-input-up dashicons-arrow-right" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 5px; cursor: pointer; margin: 0 20px 0 0;"></span>
							</div>
						</div>
					</div>
					<div style="margin-top: 20px; margin-bottom: 10px;">
						<h4>Order By Criteria</h4>
						<p>Please define which criteria should be used to order the pages or post in the link selector:</p>
						<label for="ts_vcsc_extend_settings_linkerOrderby" class="ts_vcsc_extend_settings_defaultLightbox">Page/Post Order By Criteria:</label>
						<select id="ts_vcsc_extend_settings_linkerOrderby" name="ts_vcsc_extend_settings_linkerOrderby" style="width: 250px; margin-left: 20px;">
							<option value="title" <?php echo selected('title', $ts_vcsc_extend_settings_linkerOrderby); ?>>Page/Post Title</option>
							<option value="date" <?php echo selected('date', $ts_vcsc_extend_settings_linkerOrderby); ?>>Page/Post Publish Date</option>
							<option value="modified" <?php echo selected('modified', $ts_vcsc_extend_settings_linkerOrderby); ?>>Page/Post Modify Date</option>
							<option value="id" <?php echo selected('id', $ts_vcsc_extend_settings_linkerOrderby); ?>>Page/Post ID</option>
							<option value="author" <?php echo selected('author', $ts_vcsc_extend_settings_linkerOrderby); ?>>Page/Post Author</option>
						</select>
					</div>
					<div style="margin-top: 20px; margin-bottom: 10px;">
						<h4>Order Direction</h4>
						<p>Please define which direction should be used to order the pages or post in the link selector:</p>
						<label for="ts_vcsc_extend_settings_linkerOrder" class="ts_vcsc_extend_settings_defaultLightbox">Page/Post Order Direction:</label>
						<select id="ts_vcsc_extend_settings_linkerOrder" name="ts_vcsc_extend_settings_linkerOrder" style="width: 250px; margin-left: 20px;">
							<option value="ASC" <?php echo selected('ASC', $ts_vcsc_extend_settings_linkerOrder); ?>>Ascending</option>
							<option value="DESC" <?php echo selected('DESC', $ts_vcsc_extend_settings_linkerOrder); ?>>Descending</option>
						</select>
					</div>
				</div>
			</div>		
		</div>
	<?php } ?>
</div>