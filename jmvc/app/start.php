<?php

// do not delete
require_once ABSPATH . 'jmvc/system/boot.php';
// do not delete

// increment this to force the assets (css/js) to not cache
define('JMVC_ASSETS_VER', '1.2');

/**
 * Handles high-level global stuff for our app.
 */
class App
{
	function __construct()
	{
		// template data
   		T::init();

		$this->globalScripts();
		$this->setupShortcodes();
		$this->setupActions();
		$this->setupFilters();
		$this->loadPlugins();
		$this->addOptionsPage();
		$this->allowShortcodesInVCAdditionalClasses();
		$this->interpretVCShortcodesInWPAdmin();
		$this->allowMetaSlugsInJSONQuery();
		$this->forceVCAddonsIntoTemplateEditor();	
		$this->hackVCRolesSettings();
		$this->modifyLoginPage();

		// fire up our class if we are on any campaign page (to allow it to do internal bookkeeping)
		global $post;
		if( $post->post_type == 'campaign' ) {
			$campaign = HopeCampaign::get($post->ID);
		}

		/*
		if( $_GET['doit'] ) 
		{
			$posts = get_posts(array(
				'post_type' 		=> 'campaign',
				'posts_per_page'	=> -1,
				'post_status'		=> 'any'
			));

			foreach($posts as $post) {
				 HopeCampaign::get($post->ID);
			}
		}
		*/
		
	}

	function globalScripts()
	{
		add_action('wp_enqueue_scripts', function()
		{
			// theme specific
			wp_enqueue_script( "hope-loans", HOPE_THEME . '/js/hope-loans.js', ['jquery.remove-noconflict'], JMVC_ASSETS_VER );

			// load in all files inside jmvc/assets/js/autoload/*.js
			// Since all JS files are loaded in, each JS file needs to do some sort of checking
			// to be sure it's needed on that page.
			foreach( glob(JMVC . '/assets/js/autoload/*.js') as $i => $js_filepath ) 
			{
				$filename = basename($js_filepath);
				$src = site_url("/jmvc/assets/js/autoload/$filename");
				wp_enqueue_script( "jmvc_js_$i", $src, ['jquery.remove-noconflict'], JMVC_ASSETS_VER );
			}
		});
	}

	function setupActions()
	{
		HopeCampaign::setupActions();
	}

	function setupFilters()
	{
		HopeCampaign::setupFilters();
		Story::setupFilters();

		// add logged in status to the body class
		add_filter( 'body_class', function($classes)
		{
			$classes[] = is_user_logged_in() ? 'logged-in' : 'logged-out';
			return $classes;
		}, 10, 1);
	}

	function setupShortcodes()
	{
		HopeCampaign::makeShortcodes();
		Story::makeShortcodes();

		// generic acf shortcodes
		add_shortcode('acf', function($attrs)
		{
			$attrs = shortcode_atts(array(
				'post_id' 	=> null,	
				'field'		=> null
			), $attrs);

			global $post;
			$post_id = $attrs['post_id'] ?: $post->ID;

			return get_field($attrs['field'], $post_id);
		});

		// [number_format]1000000[/number_format] => 1,000,000
		add_shortcode('number_format', function($attrs, $content)
		{
			$attrs = shortcode_atts(array(
				'decimals' 		=> 0,	// # of decimals to display
				'is_shortcode'	=> 0,	// do we interpret our "content" as a shortcode?
			), $attrs);

			if( $attrs['is_shortcode'] ) {
				$content = do_shortcode($content);
			}

			return number_format($content, $attrs['decimals']);
		});

		// get the permalink of a post
		add_shortcode('post-url', function($attrs)
		{
			$attrs = shortcode_atts(array(
				'post_id' 	=> null,	
				'field'		=> null,
				'no_http'	=> false 	// this is good when used inside the URL attribute of a VC [button]
			), $attrs);

			global $post;
			$post_id = $attrs['post_id'] ?: $post->ID;

			$permalink = get_permalink($post_id);

			if( $attrs['no_http'] ) {
				$permalink = str_replace('http://', '', $permalink);
			}
			
			return $permalink;
		});

		// post meta
		add_shortcode('meta', function($attrs)
		{
			$attrs = shortcode_atts(array(
				'post_id' 	=> null,	
				'field'		=> null
			), $attrs);

			global $post;
			$post_id = $attrs['post_id'] ?: $post->ID;
			get_post_meta($post_id, $attrs['field'], true);
			
			return $permalink;
		});
	}

	// Plugins modify chunks of behavior. We organize them in the plugins directory because
	// we don't want to throw all the behavior in this top-level "App" class
	function loadPlugins()
	{
		new ModifyCharitable();
		new ModifyWooProductLoop();
	}

	function allowShortcodesInVCAdditionalClasses()
	{
		// add shortcode support for the custom css classes in visual composer
		add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, function($classes, $base, $atts)
		{
			return do_shortcode($classes);
		}, 10, 3);
	}

	// add an options page for general/global options
	function addOptionsPage()
	{
		if( !function_exists('acf_add_options_page') )  {
			return;
		}

		acf_add_options_page(array(
			'page_title' 	=> 'Global Options',
			'menu_slug'		=> 'global-options',
			'position'		=> 5,
			'icon_url'		=> 'dashicons-admin-site'
		));
	}

	// there is some admin-ajax.php functionality that calls out to VC shortcodes. Since
	// VC shortcodes are never called from the admin side, these return text only. To fix,
	// we tell the admin to interpret VC shortcodes 
	function interpretVCShortcodesInWPAdmin()
	{
		if ( is_admin() ) {
			add_action('init', function() {
		  		WPBMap::addAllMappedShortcodes();
			});
		}
	}

	function forceVCAddonsIntoTemplateEditor()
	{
		// take a look at wp-content/mu_plugins/force-vc-addons-into-template-editor.php
	}

	function allowMetaSlugsInJSONQuery()
	{
		add_filter( 'json_query_vars', function($valid_vars) 
		{
			$valid_vars = array_merge( $valid_vars, array( 'meta_key', 'meta_value' ) );
			return $valid_vars;
		});
	}

	// for some weird reason, the VC options get "turned off". This is a band-aid to force the options back on.
	function hackVCRolesSettings()
	{
		if(!is_admin()) {
			return;
		}

		require_once(ABSPATH . 'wp-admin/includes/user.php');
		require_once vc_path_dir( 'SETTINGS_DIR', 'class-vc-roles.php' );
		$settings = array (
			'administrator' => '{\\"post_types\\":{\\"_state\\":\\"custom\\",\\"post\\":\\"1\\",\\"page\\":\\"1\\",\\"frm_display\\":\\"0\\",\\"campaign\\":\\"0\\",\\"product\\":\\"0\\",\\"sfs-footer\\":\\"1\\",\\"story\\":\\"0\\"},\\"backend_editor\\":{\\"_state\\":\\"1\\",\\"disabled_ce_editor\\":\\"1\\"},\\"frontend_editor\\":{\\"_state\\":\\"1\\"},\\"post_settings\\":{\\"_state\\":\\"1\\"},\\"settings\\":{\\"_state\\":\\"1\\"},\\"templates\\":{\\"_state\\":\\"1\\"},\\"shortcodes\\":{\\"_state\\":\\"1\\"},\\"grid_builder\\":{\\"_state\\":\\"1\\"},\\"presets\\":{\\"_state\\":\\"1\\"},\\"dragndrop\\":{\\"_state\\":\\"1\\"}}',
			'editor' => '{\\"post_types\\":{\\"_state\\":\\"custom\\",\\"post\\":\\"0\\",\\"page\\":\\"0\\",\\"frm_display\\":\\"0\\",\\"campaign\\":\\"0\\",\\"product\\":\\"0\\",\\"sfs-footer\\":\\"1\\",\\"story\\":\\"0\\"},\\"backend_editor\\":{\\"_state\\":\\"1\\",\\"disabled_ce_editor\\":\\"0\\"},\\"frontend_editor\\":{\\"_state\\":\\"1\\"},\\"post_settings\\":{\\"_state\\":\\"1\\"},\\"templates\\":{\\"_state\\":\\"1\\"},\\"shortcodes\\":{\\"_state\\":\\"1\\"},\\"grid_builder\\":{\\"_state\\":\\"1\\"},\\"presets\\":{\\"_state\\":\\"1\\"},\\"dragndrop\\":{\\"_state\\":\\"1\\"}}',
			'author' => '{\\"post_types\\":{\\"_state\\":\\"custom\\",\\"post\\":\\"0\\",\\"page\\":\\"0\\",\\"frm_display\\":\\"0\\",\\"campaign\\":\\"0\\",\\"product\\":\\"0\\",\\"sfs-footer\\":\\"1\\",\\"story\\":\\"0\\"},\\"backend_editor\\":{\\"_state\\":\\"1\\",\\"disabled_ce_editor\\":\\"0\\"},\\"frontend_editor\\":{\\"_state\\":\\"1\\"},\\"post_settings\\":{\\"_state\\":\\"1\\"},\\"templates\\":{\\"_state\\":\\"1\\"},\\"shortcodes\\":{\\"_state\\":\\"1\\"},\\"grid_builder\\":{\\"_state\\":\\"1\\"},\\"presets\\":{\\"_state\\":\\"1\\"},\\"dragndrop\\":{\\"_state\\":\\"1\\"}}',
			'contributor' => '{\\"post_types\\":{\\"_state\\":\\"custom\\",\\"post\\":\\"0\\",\\"page\\":\\"0\\",\\"frm_display\\":\\"0\\",\\"campaign\\":\\"0\\",\\"product\\":\\"0\\",\\"sfs-footer\\":\\"1\\",\\"story\\":\\"0\\"},\\"backend_editor\\":{\\"_state\\":\\"1\\",\\"disabled_ce_editor\\":\\"0\\"},\\"frontend_editor\\":{\\"_state\\":\\"1\\"},\\"post_settings\\":{\\"_state\\":\\"1\\"},\\"templates\\":{\\"_state\\":\\"1\\"},\\"shortcodes\\":{\\"_state\\":\\"1\\"},\\"grid_builder\\":{\\"_state\\":\\"1\\"},\\"presets\\":{\\"_state\\":\\"1\\"},\\"dragndrop\\":{\\"_state\\":\\"1\\"}}',
			'shop_manager' => '{\\"post_types\\":{\\"_state\\":\\"custom\\",\\"post\\":\\"0\\",\\"page\\":\\"0\\",\\"frm_display\\":\\"0\\",\\"campaign\\":\\"0\\",\\"product\\":\\"0\\",\\"sfs-footer\\":\\"1\\",\\"story\\":\\"0\\"},\\"backend_editor\\":{\\"_state\\":\\"1\\",\\"disabled_ce_editor\\":\\"0\\"},\\"frontend_editor\\":{\\"_state\\":\\"1\\"},\\"post_settings\\":{\\"_state\\":\\"1\\"},\\"templates\\":{\\"_state\\":\\"1\\"},\\"shortcodes\\":{\\"_state\\":\\"1\\"},\\"grid_builder\\":{\\"_state\\":\\"1\\"},\\"presets\\":{\\"_state\\":\\"1\\"},\\"dragndrop\\":{\\"_state\\":\\"1\\"}}',
			'campaign_manager' => '{\\"post_types\\":{\\"_state\\":\\"custom\\",\\"post\\":\\"0\\",\\"page\\":\\"0\\",\\"frm_display\\":\\"0\\",\\"campaign\\":\\"0\\",\\"product\\":\\"0\\",\\"sfs-footer\\":\\"1\\",\\"story\\":\\"0\\"},\\"backend_editor\\":{\\"_state\\":\\"1\\",\\"disabled_ce_editor\\":\\"0\\"},\\"frontend_editor\\":{\\"_state\\":\\"1\\"},\\"post_settings\\":{\\"_state\\":\\"1\\"},\\"templates\\":{\\"_state\\":\\"1\\"},\\"shortcodes\\":{\\"_state\\":\\"1\\"},\\"grid_builder\\":{\\"_state\\":\\"1\\"},\\"presets\\":{\\"_state\\":\\"1\\"},\\"dragndrop\\":{\\"_state\\":\\"1\\"}}',
		);

		$vc_roles = new Vc_Roles();
		$data = $vc_roles->save( $settings );
	}

	function modifyLoginPage()
	{
		// change logo anhor from wordpress.org > our own URL
		add_action('login_footer', function()
		{
			?>
			<script type="text/javascript">
				
				jQuery(function($) {
					$("#login > h1 > a").attr('href', '/');
				});
				
			</script>
			<?php
		}, 1, 100);
	}
}

new App();

