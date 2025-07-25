<?php
    global $GOOGLEMAPS_PLUS_VC;
	
	// Function to Render Preloader Animation
	// --------------------------------------
	if (!function_exists('TS_GMVC_CreatePreloaderCSS')){
		function TS_GMVC_CreatePreloaderCSS($id, $class, $style, $enqueue) {
			$preloader 						= '';
			$style 							= intval($style);			
			if ($style > -1) {
				if ($enqueue == "true") {
					wp_enqueue_style('ts-extend-preloaders');
				}
				$spancount 					= 0;
				$spandatas					= array(
					0 => 0, 1 => 5, 2 => 4, 3 => 0, 4 => 5, 5 => 0, 6 => 4, 7 => 4, 8 => 0, 9 => 4,
					10 => 0, 11 => 2, 12 => 2, 13 => 1, 14 => 5, 15 => 3, 16 => 6, 17 => 6, 18 => 3, 19 => 0,
					20 => 4, 21 => 5, 22 => 0,
				);
				$spancount 					= (isset($spandatas[$style]) ? $spandatas[$style] : 0);
				$preloader .= '<div id="' . $id . '" class="' . $class . ' ts-preloader-animation-main ts-preloader-animation-' . $style . '">';
					for ($x = 1; $x <= $spancount; $x++) {
						$preloader .= '<span></span>';
					}
				$preloader .= '</div>';
			}
			return $preloader;
		}
	}

	// Function to get Listing of Posts and Pages
	// ------------------------------------------
    if (!function_exists('TS_GMVC_GetPostOptions')){
        function TS_GMVC_GetPostOptions($query_args) {
			//remove_all_filters('posts_orderby');
            $args = wp_parse_args($query_args, array(
                'post_type' 		=> 'post',
                'posts_per_page'	=> -1,
				'offset'			=> 0,
                'orderby' 			=> 'title',
                'order' 			=> 'ASC',
				'post_status'      	=> 'publish',
            ) );
			$post_options 			= array();
			$post_data				= get_post_type_object($args['post_type']);
			// Retrieve Post Data
            $posts 					= get_posts($args);
            if ($posts) {
                foreach ($posts as $post) {
                    $post_options[] = array(
                        'name' 		=> $post->post_title,
                        'value' 	=> $post->ID,
						'type'		=> $post_data->labels->singular_name,
						'link'		=> urlencode(get_permalink($post->ID)),
                    );
                }
            }
            //TS_GMVC_SortMultiArray($post_options, 'name');
            return $post_options;
        }
    }
	
    // Function to retrieve Current Post Type
    // --------------------------------------
    if (!function_exists('TS_GMVC_GetCurrentPostType')){
        function TS_GMVC_GetCurrentPostType() {
            global $post, $typenow, $current_screen; 
            if ($post && $post->post_type) {
                // We have a post so we can just get the post type from that
                return $post->post_type;		
            } else if ($typenow) {
                // Check the global $typenow
                return $typenow;
            } else if ($current_screen && $current_screen->post_type) {
                // Check the global $current_screen Object
                return $current_screen->post_type;	
            } else if (isset($_REQUEST['post_type'])) {
                // Check the Post Type QueryString
                return sanitize_key($_REQUEST['post_type']);
			} else if (empty($typenow) && !empty($_GET['post'])) {
				// Try to get via get_post(); Attempt A
				$post 		= get_post($_GET['post']);
				$typenow 	= $post->post_type;
				return $typenow;
			} else if (empty($typenow) && !empty($_POST['post_ID'])) {
				// Try to get via get_post(); Attempt B
				$post 		= get_post($_POST['post_ID']);
				$typenow 	= $post->post_type;
				return $typenow;
			} else if (function_exists('get_current_screen')) {
				// Try to get via get_current_screen()
				$current 	= get_current_screen();
				if (isset($current) && ($current != false) && ($current->post_type)) {
					return $current->post_type;
				} else {
					return null;
				}
			}			
            // We Do Not Know The Post Type!!!
            return null;
        }
    }
	
	// Function to Check if Currently Editing Page + Post
	// --------------------------------------------------
	if (!function_exists('TS_GMVC_IsEditPagePost')){
		function TS_GMVC_IsEditPagePost($new_edit = null){
			global $pagenow, $typenow;
			$frontend = TS_GMVC_CheckFrontEndEditor();
			if (function_exists('vc_is_inline')){
				$vc_is_inline = vc_is_inline();
				if ((vc_is_inline() == false) && (vc_is_inline() != '') && (vc_is_inline() != true) && (!is_admin())) {
					return false;
				} else if ((vc_is_inline() == true) && (vc_is_inline() != '') && (vc_is_inline() != true) && (!is_admin())) {
					return true;
				} else if (((vc_is_inline() == NULL) || (vc_is_inline() == '')) && (!is_admin())) {
					if ($frontend == true) {
						$vc_is_inline = true;
						return true;
					} else {
						$vc_is_inline = false;
						return false;
					}
				}
			} else {
				$vc_is_inline = false;
				if (!is_admin()) return false;
			}
			if (($frontend == true) && (!is_admin())) {
				return true;
			} else if ($new_edit == "edit") {
				return in_array($pagenow, array('post.php'));
			} else if ($new_edit == "new") {
				return in_array($pagenow, array('post-new.php'));
			} else if ($vc_is_inline == true) {
				return true;
			} else {
				return in_array($pagenow, array('post.php', 'post-new.php'));
			}
		}
	}
	
	// Function to Check for VC Frontend Editor
	// ----------------------------------------
	if (!function_exists('TS_GMVC_CheckFrontEndEditor')){
		function TS_GMVC_CheckFrontEndEditor() {
			$url 		= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			if ((strpos($url, "vc_editable=true") !== false) || (strpos($url, "vc_action=vc_inline") !== false)) {
				return true;
			} else {
				return false;
			}
		}
	}
    
	// Advanced Link Picker
	// --------------------
	if (!function_exists('TS_GMVC_Advancedlinks_GetLinkData')){
		function TS_GMVC_Advancedlinks_GetLinkData($link_string) {
			global $GOOGLEMAPS_PLUS_VC;
			$link_content						= (($link_string == '|') || ($link_string == '||') || ($link_string == '|||') || ($link_string == '||||') || ($link_string == '|||||') || ($link_string == '||||||')) ? '' : $link_string;
			$link_content						= TS_GMVC_Advancedlinks_BuildLinkArray($link_content);
			if ($GOOGLEMAPS_PLUS_VC->TS_GMVC_ParameterLinkPicker['enabled'] == "false") {
				if (($link_content['url'] == "") && ($link_content['id'] != "")) {
					$link_content['url']		= get_permalink($link_id);					
				}
			} else {	
				$link_href						= $link_content['url'];
				$link_title						= $link_content['title'];
				$link_target					= $link_content['target'];
				$link_source					= $link_content['source'];
				$link_id						= $link_content['id'];
				$link_name						= $link_content['name'];
				$link_rel						= $link_content['rel'];
				if (($link_source == "page") && ($link_id != '')) {
					$link_content['url']		= get_permalink($link_id);
				} else if (($link_source == "post") && ($link_id != '')) {
					$link_content['url']		= get_permalink($link_id);
				} else if (($link_source == "custom") && ($link_id != '')) {
					$link_content['url']		= get_permalink($link_id);
				}
			}
			if ((preg_match("@^[a-zA-Z0-9%+-_]*$@", $link_content['url'])) || (urlencode($link_content['url']) == str_replace(array('%', '+'), array('%25', '%2B'), $link_content['url']))) {
			//if ((preg_match("@^[a-zA-Z0-9%+-_]*$@", $link_content['url'])) || (urlencode($link_content['url']) == str_replace(['%', '+'], ['%25', '%2B'], $link_content['url']))) {
				$link_content['url']			= urldecode($link_content['url']);
			}
			unset($link_content['source']);
			unset($link_content['id']);
			unset($link_content['name']);
			return $link_content;
		}
	}	
	if (!function_exists('TS_GMVC_Advancedlinks_BuildLinkArray')){
		function TS_GMVC_Advancedlinks_BuildLinkArray($value) {
			global $GOOGLEMAPS_PLUS_VC;
			// Parse string like "title:Hello world|weekday:Monday" to array('title' => 'Hello World', 'weekday' => 'Monday')
			return TS_GMVC_Advancedlinks_ParseMultiAttribute($value, array('url' => '', 'title' => '', 'target' => '', 'rel' => '', 'source' => '', 'id' => '', 'name' => ''));
		}
	}
	if (!function_exists('TS_GMVC_Advancedlinks_ParseMultiAttribute')){
		function TS_GMVC_Advancedlinks_ParseMultiAttribute($value, $default = array()) {
			$result             	= $default;
			$params_pairs       	= explode('|', $value);
			if (!empty($params_pairs)) {
				foreach($params_pairs as $pair) {
					$param      	= preg_split('/\:/', $pair);
					if (!empty($param[0]) && isset($param[1])) {
						$result[$param[0]] = trim(rawurldecode($param[1]));
					}
				}
			}
			return $result;
		}
	}
	
	// Functions to Sort Multidimensional Array
	// ----------------------------------------
    if (!function_exists('TS_GMVC_SortMultiArray')){
        function TS_GMVC_SortMultiArray(&$array, $key) {
            foreach($array as &$value) {
                $value['__________'] = $value[$key];
            }
            /* Note, if your functions are inside of a class, use: 
                usort($array, array("My_Class", 'TS_VCSC_SortByDummyKey'));
            */
            usort($array, 'TS_GMVC_SortByDummyKey');
            foreach($array as &$value) {   // removes the dummy key from your array
                unset($value['__________']);
            }
            return $array;
        }
    }
    if (!function_exists('TS_GMVC_SortByDummyKey')){
        function TS_GMVC_SortByDummyKey($a, $b) {
            if($a['__________'] == $b['__________']) return 0;
            if($a['__________'] < $b['__________']) return -1;
            return 1;
        }
    }
?>