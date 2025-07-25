<?php
/**
 * seed_cl Admin
 *
 * @package WordPress
 * @subpackage seed_cl
 * @since 0.1.0
 */


class SEED_CL_ADMIN
{
    public $plugin_version = SEED_CL_VERSION;
    public $plugin_name = SEED_CL_PLUGIN_NAME;

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

   /**
     * Slug of the plugin screen.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_screen_hook_suffix = null;
    protected $plugin_screen_customizer_hook_suffix = null;

    /**
     * Load Hooks
     */
    function __construct( )
    {

        if ( is_admin() && ( !defined( 'DOING_AJAX' ) ) ){
            add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts'  ) );
            add_action( 'admin_enqueue_scripts', array( &$this, 'deregister_scripts' ), PHP_INT_MAX );
            add_action( 'admin_menu', array( &$this, 'create_menus'  ) );
            
            // Render Options
            add_action( 'admin_init', array( &$this, 'reset_defaults' ) );
            add_action( 'admin_init', array( &$this, 'create_settings' ) );
            // Add link to options on the plugin page
            add_filter( 'plugin_action_links', array( &$this, 'plugin_action_links' ), 10, 2 );
            
        }
        
        if (defined( 'DOING_AJAX' )){
            // Save Page Ajqx
            add_action( 'wp_ajax_seed_cl_save_page', array(&$this,'save_page'));

        }

    }
    

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    function deregister_scripts(){
        if(isset($_GET['page']) && $_GET['page'] == 'seed_cl_customizer'){
            if(isset($_GET['seed_cl_debug'])){
            // only ones we need are: common|utils|wp-auth-check|media-upload|seed_cl-customizer-js
            $d = array();
            if(!empty($_GET['d'])){
                $d = explode("|",$_GET['d']); 
            }
            global $wp_scripts;
             foreach( $wp_scripts->queue as $handle ) :
                echo $handle . '|';
                if(!empty($d)){
                if(!in_array($handle,$d)){
                    wp_dequeue_script( $handle );
                    wp_deregister_script( $handle );
                }
                }
            endforeach;
            }
        //die();
        }
       
    }
    
    
    
    /**
     * Reset the settings page. Reset works per settings id.
     *
     */
    function save_page( )
    {
        if(check_ajax_referer('seed_cl_save_page')){


            // Vars 
            $r = false;
            $page_id = $_REQUEST['page_id'];
        
            //$url = $_REQUEST['url'];
            $settings = stripslashes_deep($_REQUEST);
            $settings_arr = $settings;

            //$settings = base64_encode(serialize($settings));



            // Make sure these fields are not empty

            $error_message_map = array(
                'check_mic' => ''
            );

            $validated = true;
            $error_message = array();

            $v_fields = array(
                'check_mic');
            foreach($v_fields as $v){

                if(empty($settings_arr[$v])){
                    //$validated = false;
                    if(!empty($error_message_map[$v])){
                    $error_message[] = $error_message_map[$v];
                    }
                }
            }

            if($validated){
                
                // Save Settings
                update_option('seed_cl_customizer_settings',$settings);
                $r = true;
            }
            
            
            if($r !== false){
                echo 'true';
            }else{
                echo json_encode($error_message);
            }
            exit();
        }
    }
    
    



    /**
     * Reset the settings page. Reset works per settings id.
     *
     */
    function reset_defaults( )
    {
        if ( isset( $_POST[ 'seed_cl_reset' ] ) ) {
            $option_page = $_POST[ 'option_page' ];
            check_admin_referer( $option_page . '-options' );
            require_once(SEED_CL_PLUGIN_PATH.'inc/default-settings.php');

            $_POST[ $_POST[ 'option_page' ] ] = $seed_cl_settings_deafults[$_POST[ 'option_page' ]];
            add_settings_error( 'general', 'seed_cl-settings-reset', __( "Settings reset." ), 'updated' );
        }
    }

    /**
     * Properly enqueue styles and scripts for our theme options page.
     *
     * This function is attached to the admin_enqueue_scripts action hook.
     *
     * @since  0.1.0
     * @param string $hook_suffix The name of the current page we are on.
     */
    function admin_enqueue_scripts( $hook_suffix )
    {
        $pages = array(
            'settings_page_seed_cl'
        );

        wp_enqueue_script( 'jquery' );
        if ( in_array($hook_suffix,$pages) ){
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'wp-lists' );
            wp_enqueue_script( 'seed_cl-framework-js', SEED_CL_PLUGIN_URL . 'admin/settings-scripts.js', array( 'jquery' ), $this->plugin_version );
            wp_enqueue_script( 'theme-preview' );
            wp_enqueue_style( 'thickbox' );
            wp_enqueue_style( 'media-upload' );
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_style( 'seed_cl-framework-css', SEED_CL_PLUGIN_URL . 'admin/settings-style.css', false, $this->plugin_version );
            wp_enqueue_style( 'font-awesome', SEED_CL_PLUGIN_URL .'customizer/css/font-awesome.min.css', false, $this->plugin_version );
            wp_enqueue_script( 'seed-cl-backend-script', plugins_url('admin/backend-scripts.js',dirname(__FILE__)), array( 'jquery' ),SEED_CL_VERSION, true );  
			$data = array( 
                'delete_confirm' => __( 'Are you sure you want to DELETE all pages?' , 'custom-login-page-wp'),
            );
			wp_localize_script( 'seed-cl-backend-script', 'seed_cl_msgs', $data );
        }
        
        if($hook_suffix == $this->plugin_screen_customizer_hook_suffix){
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'seed_cl-customizer-js', SEED_CL_PLUGIN_URL . 'customizer/customizer-scripts.js', array( 'jquery' ), $this->plugin_version );
            wp_enqueue_style( 'thickbox' );
            wp_enqueue_style( 'media-upload' );
            wp_enqueue_style( 'seed_cl-customizer-css', SEED_CL_PLUGIN_URL . 'customizer/customizer-style.css', false, $this->plugin_version );
        }
    }

    /**
     * Creates WordPress Menu pages from an array in the config file.
     *
     * This function is attached to the admin_menu action hook.
     *
     * @since 0.1.0
     */
    function create_menus( )
    {

    $this->plugin_screen_hook_suffix = add_options_page(
            __( "Login Page", 'custom-login-page-wp' ),
            __( "Login Page", 'custom-login-page-wp' ),
            'manage_options',
            'seed_cl',
            array( &$this , 'option_page' )
            );
            
    $this->plugin_screen_customizer_hook_suffix = add_submenu_page(
            NULL,
            __( "Customizer", 'custom-login-page-wp' ),
            __( "Customizer", 'custom-login-page-wp' ),
            'manage_options',
            'seed_cl_customizer',
            array( &$this , 'customizer' )
            );
            
    
    
    $this->plugin_screen_importer_hook_suffix = add_submenu_page(
            NULL,
            __( "Import", 'custom-login-page-wp' ),
            __( "Import", 'custom-login-page-wp' ),
            'manage_options',
            'seed_cl_import',
            array( &$this , 'import_page' )
            );
    
    }

 


    /**
     * Display settings link on plugin page
     */
    function plugin_action_links( $links, $file )
    {
        $plugin_file = SEED_CL_SLUG;

        if ( $file == $plugin_file ) {
            $settings_link = '<a href="options-general.php?page=seed_cl">Settings</a>';
            array_unshift( $links, $settings_link );
        }
        return $links;
    }


    /**
     * Allow Tabs on the Settings Page
     *
     */
    function plugin_options_tabs( )
    {
        $menu_slug   = null;
        $page        = $_REQUEST[ 'page' ];
        $uses_tabs   = false;
        $current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : false;

        //Check if this config uses tabs
        foreach ( seed_cl_get_options() as $v ) {
            if ( $v[ 'type' ] == 'tab' ) {
                $uses_tabs = true;
                break;
            }
        }

        // If uses tabs then generate the tabs
        if ( $uses_tabs ) {
            echo '<h2 class="nav-tab-wrapper" style="padding-left:20px">';
            $c = 1;
            foreach ( seed_cl_get_options() as $v ) {
                    if ( isset( $v[ 'menu_slug' ] ) ) {
                        $menu_slug = $v[ 'menu_slug' ];
                    }
                    if ( $menu_slug == $page && $v[ 'type' ] == 'tab' ) {
                        $active = '';
                        if ( $current_tab ) {
                            $active = $current_tab == $v[ 'id' ] ? 'nav-tab-active' : '';
                        } elseif ( $c == 1 ) {
                            $active = 'nav-tab-active';
                        }

                        if(empty($v[ 'icon' ])){
                            $v[ 'icon' ] = '';
                        }

                        echo '<a class="nav-tab ' . $active . '" href="?page=' . $menu_slug . '&tab=' . $v[ 'id' ] . '"><i class="'.$v[ 'icon' ].'"></i> ' . $v[ 'label' ] . '</a>';
                        $c++;
                    }
            }

             echo '<a class="nav-tab seed_csp4-support" style="background-color: #444;color: #fff" href="https://www.seedprod.com/wordpress-custom-login-page/?utm_source=custom-login-page-wp-plugin&utm_medium=banner&utm_campaign=custom-login-page-wp-link-in-plugin" target="_blank"><i class="fa fa-star"></i> '.__('Upgrade to Pro for more Professional Features','coming-soon').'</a>';
            
            echo '</h2>';

        }
    }

    /**
     * Get the layout for the page. classic|2-col
     *
     */
    function get_page_layout( )
    {
        $layout = '2-col';
        foreach ( seed_cl_get_options() as $v ) {
            switch ( $v[ 'type' ] ) {
                case 'menu';
                    $page = $_REQUEST[ 'page' ];
                    if ( $page == $v[ 'menu_slug' ] ) {
                        if ( isset( $v[ 'layout' ] ) ) {
                            $layout = $v[ 'layout' ];
                        }
                    }
                    break;
            }
        }
        return $layout;
    }
    
    
    function customizer( ){
    //var_dump($_GET['seed_cl_customize']);

        

    // Page auth make sure user can perform this action
    
    // Page Info
    $page_id = 1;
    if(isset($_GET['seed_cl_customize'])){
        $page_id = $_GET['seed_cl_customize'];
    }
    
    


    $fonts['Standard Fonts'] = array(
        "'Open Sans', sans-serif"                              => "Open Sans",
        "Helvetica, Arial, sans-serif"                         => "Helvetica, Arial, sans-serif",
        "'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif",
        "'Bookman Old Style', serif"                           => "'Bookman Old Style', serif",
        "'Comic Sans MS', cursive"                             => "'Comic Sans MS', cursive",
        "Courier, monospace"                                   => "Courier, monospace",
        "Garamond, serif"                                      => "Garamond, serif",
        "Georgia, serif"                                       => "Georgia, serif",
        "Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
        "'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace",
        "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
        "'MS Sans Serif', Geneva, sans-serif"                  => "'MS Sans Serif', Geneva, sans-serif",
        "'MS Serif', 'New York', sans-serif"                   => "'MS Serif', 'New York', sans-serif",
        "'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
        "Tahoma,Geneva, sans-serif"                            => "Tahoma, Geneva, sans-serif",
        "'Times New Roman', Times,serif"                       => "'Times New Roman', Times, serif",
        "'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif",
        "Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif",
    );


    $font_families = $fonts;

    
    
    
    // Get Page 
    $settings = get_option('seed_cl_customizer_settings');  
    $settings = json_decode(json_encode($settings), FALSE);


     // die();
        if($settings !== false){
            ?>

            <div id="seed-cl-customizer">
              <?php require_once(SEED_CL_PLUGIN_PATH.'customizer/customizer.php'); ?>
            </div>
            <?php
        }else{
            ?>
            Settings could not be loaded. Please contact support.
            <?php
        }
    }

    /**
     * Render the option pages.
     *
     * @since 0.1.0
     */
    function option_page( )
    {

        $menu_slug = null;
        $page   = $_REQUEST[ 'page' ];
        $layout = $this->get_page_layout();
        ?>
        <div class="wrap seed_cl columns-2">

           
            <?php include(SEED_CL_PLUGIN_PATH.'admin/header.php') ?>
            <?php $this->plugin_options_tabs(); ?>
            <?php if ( $layout == '2-col' ): ?>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-1">
                    <div id="post-body-content" >
            <?php endif; ?>
                    <?php if(!empty($_GET['tab']))
                            do_action( 'seed_cl_render_page', array('tab'=>$_GET['tab']));
                    ?>
                    <?php if(!empty($_GET['tab']) && $_GET['tab'] == 'seed_cl_build' ) { 
                    //$token = '6a6c0899-0139-4a25-806e-a780d863a5af';
                    ?>
                        <iframe src="test<?php echo $token ?>" width="100%"  height="500px"></iframe>
                    <?php }else{ ?>
                    
                    
                    <form action="options.php" method="post">

                    <!-- <input name="submit" type="submit" value="<?php _e( 'Save All Changes', 'custom-login-page-wp' ); ?>" class="button-primary"/> -->
                    <?php if(!empty($_GET['tab']) && $_GET['tab'] != 'seed_cl_tab_3') { ?>
                    <!-- <input id="reset" name="reset" type="submit" value="<?php _e( 'Reset Settings', 'custom-login-page-wp' ); ?>" class="button-secondary"/>     -->
                    <?php } ?>

                            <?php
                            $show_submit = false;
                            foreach ( seed_cl_get_options() as $v ) {
                                if ( isset( $v[ 'menu_slug' ] ) ) {
                                    $menu_slug = $v[ 'menu_slug' ];
                                }
                                    if ( $menu_slug == $page ) {
                                        switch ( $v[ 'type' ] ) {
                                            case 'menu';
                                                break;
                                            case 'tab';
                                                $tab = $v;
                                                if ( empty( $default_tab ) )
                                                    $default_tab = $v[ 'id' ];
                                                break;
                                            case 'setting':
                                                $current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $default_tab;
                                                if ( $current_tab == $tab[ 'id' ] ) {
                                                    settings_fields( $v[ 'id' ] );
                                                    $show_submit = true;
                                                }

                                                break;
                                            case 'section':
                                                $current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $default_tab;
                                                if ( $current_tab == $tab[ 'id' ] or $current_tab === false ) {
                                                    if ( $layout == '2-col' ) {
                                                        echo '<div id="'.$v[ 'id' ].'" class="postbox seedprod-postbox">';
                                                        $icon = $v[ 'icon' ];
                                                        $this->do_settings_sections( $v[ 'id' ],$show_submit,$icon );
                                                        echo '</div>';
                                                    } else {
                                                        do_settings_sections( $v[ 'id' ] );
                                                    }

                                                }
                                                break;

                                        }

                                }
                            }
                        ?>
                    <?php if($show_submit): ?>
                    <p>
                    <!-- <input name="submit" type="submit" value="<?php _e( 'Save All Changes', 'custom-login-page-wp' ); ?>" class="button-primary"/> -->
                    <!-- <input id="reset" name="reset" type="submit" value="<?php _e( 'Reset Settings', 'custom-login-page-wp' ); ?>" class="button-secondary"/> -->
                    </p>
                    <?php endif; ?>
                    </form>
                    <?php } ?>
                    <?php //if ( $layout == '2-col' ): ?>
                     <?php if ( 1 == 0 ): ?>
                    </div> <!-- #post-body-content -->

                    <div id="postbox-container-1" class="postbox-container">
                        <div id="side-sortables" class="meta-box-sortables ui-sortable">

                            <div class="postbox rss-postbox" style="background-color: #fcf8e3">
									<div class="handlediv" title="Click to toggle"><br /></div>
									<form action="https://www.getdrip.com/forms/2650489/submissions" method="post" target="_blank" data-drip-embedded-form="2650489">
	  <h3 class="hndle" data-drip-attribute="headline"><span>How to launch a site that&#x27;s successful on Day One</span></h3>
						<div class="inside">


							<p data-drip-attribute="description">There&#x27;s nothing more disappointing than launching a new site and not get enough visitors to support it. Find out how to build an audience before you launch in this free 5-part course.</p>
							<div>
								<label for="fields[email]">Email Address</label><br />
								<input class="regular-text" style="width:100%" type="email" name="fields[email]" value="<?php echo get_option( 'admin_email' ); ?>" />
							</div>

							<div style="margin-top:10px">
								<label for="fields[first_name]">First Name</label><br />
								<input class="regular-text" style="width:100%" type="text" name="fields[first_name]" value="" />
							</div>

						<div style="margin-top:10px">
							<input type="submit" name="submit" value="Subscribe Now" style="background-color:red; border-color:firebrick;" data-drip-attribute="sign-up-button" class="button-primary" />
						</div>


										<!-- <div class="rss-widget">
											<?php
											wp_widget_rss_output(array(
												'url' => 'http://seedprod.com/feed/',
												'title' => 'SeedProd Blog',
												'items' => 3,
												'show_summary' => 0,
												'show_author' => 0,
												'show_date' => 1,
												));
												?>
												<ul>
													<li>&raquo; <a href="http://seedprod.com/subscribe/"><?php _e('Subscribe by Email', 'ultimate-coming-soon-page') ?></a></li>
												</ul>
											</div> -->
										</div>
									</form>


									</div>
                            <!-- <a href="http://www.seedprod.com/plugins/wordpress-coming-soon-pro-plugin/?utm_source=plugin&utm_medium=banner&utm_campaign=coming-soon-pro-in-plugin-banner" target="_blank"><img src="http://static.seedprod.com/ads/coming-soon-pro-sidebar.png" /></a>
                            <br><br> -->
                            <div class="postbox support-postbox" style="background-color:#d9edf7">
                                <div class="handlediv" title="Click to toggle"><br /></div>
                                <h3 class="hndle"><span><?php _e('Plugin Support', 'custom-login-page-wp') ?></span></h3>
                                <div class="inside">
                                    <div class="support-widget">
                                        <p>
                                            <?php _e('Got a Question, Idea, Problem or Praise?') ?>
                                        </p>
                                        <ul>
                                            <li>&raquo; <a href="https://wordpress.org/support/plugin/coming-soon" target="_blank"><?php _e('Support Request', 'custom-login-page-wp') ?></a></li>
                                            <li>&raquo; <a href="http://support.seedprod.com/article/83-how-to-clear-wp-super-caches-cache" target="_blank"><?php _e('Common Caching Issues Resolutions', 'custom-login-page-wp') ?></a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                           
                                <div class="postbox like-postbox" style="background-color:#d9edf7">
                                    <div class="handlediv" title="Click to toggle"><br /></div>
                                    <h3 class="hndle"><span><?php _e('Show Some Love', 'custom-login-page-wp') ?></span></h3>
                                    <div class="inside">
                                        <div class="like-widget">
                                            <p><?php _e('Like this plugin? Show your support by:', 'custom-login-page-wp')?></p>
                                            <ul>
                                                <li>&raquo; <a target="_blank" href="http://www.seedprod.com/features/?utm_source=coming-soon-plugin&utm_medium=banner&utm_campaign=coming-soon-link-in-plugin"><?php _e('Buy It', 'custom-login-page-wp') ?></a></li>

                                                <li>&raquo; <a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/coming-soon?rate=5#postform"><?php _e('Rate It', 'custom-login-page-wp') ?></a></li>
                                                <li>&raquo; <a target="_blank" href="<?php echo "http://twitter.com/share?url=https%3A%2F%2Fwordpress.org%2Fplugins%2Fultimate-coming-soon-page%2F&text=Check out this awesome %23WordPress Plugin I'm using, Coming Soon Page and Maintenance Mode by SeedProd"; ?>"><?php _e('Tweet It', 'custom-login-page-wp') ?></a></li>

                                                <li>&raquo; <a href="https://www.seedprod.com/submit-site/"><?php _e('Submit your site to the Showcase', 'custom-login-page-wp') ?></a></li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            


                                <div class="postbox rss-postbox" style="background-color:#d9edf7">
    											<div class="handlediv" title="Click to toggle"><br /></div>
    											<h3 class="hndle"><span><?php _e('SeedProd Blog', 'ultimate-coming-soon-page') ?></span></h3>
    											<div class="inside">

    												<div class="rss-widget">
    													<?php
    													wp_widget_rss_output(array(
    													'url' => 'http://feeds.feedburner.com/seedprod/',
    													'title' => 'SeedProd Blog',
    													'items' => 3,
    													'show_summary' => 0,
    													'show_author' => 0,
    													'show_date' => 1,
    												));
    												?>
    												<ul>
    													<br>
    												<li>&raquo; <a href="https://www.getdrip.com/forms/9414625/submissions/new"><?php _e('Subscribe by Email', 'ultimate-coming-soon-page') ?></a></li>
    											</ul>
    										</div>
    									</div>
    								</div>

                        </div>
                    </div>
                </div> <!-- #post-body -->


            </div> <!-- #poststuff -->
            <?php endif; ?>
        </div> <!-- .wrap -->

        <!-- JS login to confirm setting resets. -->
        <script>
            jQuery(document).ready(function($) {
                $('#reset').click(function(e){
                    if(!confirm('<?php _e( 'This tabs settings be deleted and reset to the defaults. Are you sure you want to reset?', 'custom-login-page-wp' ); ?>')){
                        e.preventDefault();
                    }
                });
                if(jQuery(".include_exclude_options:checked").val() == '2'){
                    jQuery("#include_url_pattern").parents('tr').show();
                }else{
                    jQuery("#include_url_pattern").parents('tr').hide();
                }

                if(jQuery(".include_exclude_options:checked").val() == '3'){
                    jQuery("#exclude_url_pattern").parents('tr').show();
                }else{
                    jQuery("#exclude_url_pattern").parents('tr').hide();
                }

                jQuery(".include_exclude_options").click(function() {
                    var val = jQuery(this).val();
                    if(val == '2'){
                        jQuery("#include_url_pattern").parents('tr').fadeIn();
                    }else{
                        jQuery("#include_url_pattern").parents('tr').hide();
                    }

                    if(val == '3'){
                        jQuery("#exclude_url_pattern").parents('tr').fadeIn();
                    }else{
                        jQuery("#exclude_url_pattern").parents('tr').hide();
                    } 
                });
            });
        </script>
        <?php
    }

    /**
     * Create the settings options, sections and fields via the WordPress Settings API
     *
     * This function is attached to the admin_init action hook.
     *
     * @since 0.1.0
     */
    function create_settings( )
    {
        foreach ( seed_cl_get_options() as $k => $v ) {

            switch ( $v[ 'type' ] ) {
                case 'menu':
                    $menu_slug = $v[ 'menu_slug' ];

                    break;
                case 'setting':
                    if ( empty( $v[ 'validate_function' ] ) ) {
                        $v[ 'validate_function' ] = array(
                             &$this,
                            'validate_machine'
                        );
                    }
                    register_setting( $v[ 'id' ], $v[ 'id' ], $v[ 'validate_function' ] );
                    $setting_id = $v[ 'id' ];
                    break;
                case 'section':
                    if ( empty( $v[ 'desc_callback' ] ) ) {
                        $v[ 'desc_callback' ] = array(
                             &$this,
                            '__return_empty_string'
                        );
                    } else {
                        $v[ 'desc_callback' ] = $v[ 'desc_callback' ];
                    }
                    add_settings_section( $v[ 'id' ], $v[ 'label' ], $v[ 'desc_callback' ], $v[ 'id' ] );
                    $section_id = $v[ 'id' ];
                    break;
                case 'tab':
                    break;
                default:
                    if ( empty( $v[ 'callback' ] ) ) {
                        $v[ 'callback' ] = array(
                             &$this,
                            'field_machine'
                        );
                    }

                    add_settings_field( $v[ 'id' ], $v[ 'label' ], $v[ 'callback' ], $section_id, $section_id, array(
                         'id' => $v[ 'id' ],
                        'desc' => ( isset( $v[ 'desc' ] ) ? $v[ 'desc' ] : '' ),
                        'setting_id' => $setting_id,
                        'class' => ( isset( $v[ 'class' ] ) ? $v[ 'class' ] : '' ),
                        'type' => $v[ 'type' ],
                        'default_value' => ( isset( $v[ 'default_value' ] ) ? $v[ 'default_value' ] : '' ),
                        'option_values' => ( isset( $v[ 'option_values' ] ) ? $v[ 'option_values' ] : '' )
                    ) );

            }
        }
    }

    /**
     * Create a field based on the field type passed in.
     *
     * @since 0.1.0
     */
    function field_machine( $args )
    {
        extract( $args ); //$id, $desc, $setting_id, $class, $type, $default_value, $option_values

        // Load defaults
        $defaults = array( );
        foreach ( seed_cl_get_options() as $k ) {
            switch ( $k[ 'type' ] ) {
                case 'setting':
                case 'section':
                case 'tab':
                    break;
                default:
                    if ( isset( $k[ 'default_value' ] ) ) {
                        $defaults[ $k[ 'id' ] ] = $k[ 'default_value' ];
                    }
            }
        }
        $options = get_option( $setting_id );

        $options = wp_parse_args( $options, $defaults );

        $path = SEED_CL_PLUGIN_PATH . 'admin/field-types/' . $type . '.php';
        if ( file_exists( $path ) ) {
            // Show Field
            include( $path );
            // Show description
            if ( !empty( $desc ) ) {
                echo "<small class='description'>{$desc}</small>";
            }
        }

    }

    /**
     * Validates user input before we save it via the Options API. If error add_setting_error
     *
     * @since 0.1.0
     * @param array $input Contains all the values submitted to the POST.
     * @return array $input Contains sanitized values.
     * @todo Figure out best way to validate values.
     */
    function validate_machine( $input )
    {
        if(!isset($_POST['option_page'])){
           return $input; 
        }
        $option_page = $_POST['option_page'];
        foreach ( seed_cl_get_options() as $k ) {
            switch ( $k[ 'type' ] ) {
                case 'menu':
                case 'setting':
                    if(isset($k['id']))
                        $setting_id = $k['id'];
                case 'section':
                case 'tab';
                    break;
                default:
                    if ( !empty( $k[ 'validate' ] ) && $setting_id == $option_page ) {
                        $validation_rules = explode( ',', $k[ 'validate' ] );

                        foreach ( $validation_rules as $v ) {
                            $path = SEED_CL_PLUGIN_PATH . 'admin/validations/' . $v . '.php';
                            if ( file_exists( $path ) ) {
                                // Defaults Values
                                $is_valid  = true;
                                $error_msg = '';

                                // Test Validation
                                include( $path );

                                // Is it valid?
                                if ( $is_valid === false ) {
                                    add_settings_error( $k[ 'id' ], 'seedprod_error', $error_msg, 'error' );
                                    // Unset invalids
                                    unset( $input[ $k[ 'id' ] ] );
                                }

                            }
                        } //end foreach

                    }
            }
        }

        return $input;
    }

    /**
     * Dummy function to be called by all sections from the Settings API. Define a custom function in the config.
     *
     * @since 0.1.0
     * @return string Empty
     */
    function __return_empty_string( )
    {
        echo '';
    }


    /**
     * SeedProd version of WP's do_settings_sections
     *
     * @since 0.1.0
     */
    function do_settings_sections( $page, $show_submit, $icon )
    {
        global $wp_settings_sections, $wp_settings_fields;

        if ( !isset( $wp_settings_sections ) || !isset( $wp_settings_sections[ $page ] ) )
            return;

        foreach ( (array) $wp_settings_sections[ $page ] as $section ) {
            echo "<h3 class='hndle'><i class='{$icon}'></i> {$section['title']}</h3>\n";
            echo '<div class="inside">';
            call_user_func( $section[ 'callback' ], $section );
            if ( !isset( $wp_settings_fields ) || !isset( $wp_settings_fields[ $page ] ) || !isset( $wp_settings_fields[ $page ][ $section[ 'id' ] ] ) )
                continue;
            echo '<table class="form-table">';
            $this->do_settings_fields( $page, $section[ 'id' ] );
            echo '</table>';
            if($show_submit): ?>
                <p>
                <input name="submit" type="submit" value="<?php _e( 'Save All Changes', 'custom-login-page-wp' ); ?>" class="button-primary"/>
                </p>
            <?php endif;
            echo '</div>';
        }
    }

    function do_settings_fields($page, $section) {
          global $wp_settings_fields;

          if ( !isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section]) )
              return;

          foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
              echo '<tr valign="top">';
              if ( !empty($field['args']['label_for']) )
                  echo '<th scope="row"><label for="' . $field['args']['label_for'] . '">' . $field['title'] . '</label></th>';
              else
                  echo '<th scope="row"><strong>' . $field['title'] . '</strong><!--<br>'.$field['args']['desc'].'--></th>';
              echo '<td>';
              call_user_func($field['callback'], $field['args']);
              echo '</td>';
              echo '</tr>';
          }
      }
 
}