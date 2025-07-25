<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_WYSIWYG')) {
        class TS_Parameter_WYSIWYG {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('wysiwyg_base64', array(&$this, 'wysiwyg_base64_setting_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('wysiwyg_base64', array(&$this, 'wysiwyg_base64_setting_field'));
				}
            }        
            function wysiwyg_base64_setting_field($settings, $value){
                $param_name     	= isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           	= isset($settings['type']) ? $settings['type'] : '';
				$minimal			= isset($settings['minimal']) ? $settings['minimal'] : 'false';
				$scope				= isset($settings['scope']) ? $settings['scope'] : array();
				// Editor Settings
				$use_tabs			= isset($scope['tabs']) ? $scope['tabs'] : "true";
				$use_menubar		= isset($scope['menubar']) ? $scope['menubar'] : "true";
				$use_media			= isset($scope['media']) ? $scope['media'] : "true";
				$use_link			= isset($scope['link']) ? $scope['link'] : "true";
				$use_lists			= isset($scope['lists']) ? $scope['lists'] : "true";
				$use_blockquote		= isset($scope['blockquote']) ? $scope['blockquote'] : "true";
				$use_textcolor		= isset($scope['textcolor']) ? $scope['textcolor'] : "true";
				$use_background		= isset($scope['background']) ? $scope['background'] : "true";
				$use_height			= isset($scope['height']) ? $scope['height'] : 250;
				$use_rootblock		= isset($scope['rootblock']) ? $scope['rootblock'] : "p";
				// Minimal Usage Override
				if ($minimal == "true") {
					$use_menubar 	= "false";
					$use_media 		= "false";
					$use_link		= "false";
					$use_blockquote	= "false";
					$use_lists		= "false";
					$use_background	= "false";
					$use_height		= 150;
				}
				// Other Variables
				$randomizer			= rand(100000, 99999999);
                $output 			= '';
				// Final Parameter Output
				$output .= '<div id="ts-wysiwyg-base64-container-' . $randomizer . '" class="ts-wysiwyg-base64-container" data-use-tabs="' . $use_tabs . '" data-use-height="' . ($use_height - 60) . '" data-use-menubar="' . $use_menubar . '" data-use-media="' . $use_media . '" data-use-link="' . $use_link . '" data-use-blockquote="' . $use_blockquote . '" data-use-lists="' . $use_lists . '" data-use-textcolor="' . $use_textcolor . '" data-use-background="' . $use_background . '" data-use-rootblock="' . $use_rootblock . '" data-url-home="' . get_home_url() . '" data-url-site="' . get_site_url() . '">';
					if ($use_tabs == "true") {
						$output .= '<div id="ts-wysiwyg-base64-tabs-' . $randomizer . '" class="ts-wysiwyg-base64-tabs">';
							$output .= '<a id="ts-wysiwyg-base64-html-' . $randomizer . '" class="ts-wysiwyg-base64-html active">HTML</a>';
							$output .= '<a id="ts-wysiwyg-base64-visual-' . $randomizer . '" class="ts-wysiwyg-base64-visual">Visual</a>';
							$output .= '<div style="clear: both;"></div>';
						$output .= '</div>';
					}
					$output .= '<textarea id="ts-wysiwyg-base64-editor-' . $randomizer . '" name="' . $param_name . '" class="ts-wysiwyg-base64-editor wpb_vc_param_value ' . $param_name . ' ' . $type . '" style="height: ' . $use_height . 'px;">' . htmlentities(rawurldecode(base64_decode($value)), ENT_COMPAT, 'UTF-8') . '</textarea>';
				$output .= '</div>';
				return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_WYSIWYG')) {
        $TS_Parameter_WYSIWYG = new TS_Parameter_WYSIWYG();
    }
?>