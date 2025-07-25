<?php
/**
 * Render Pages
 */


class SEED_CL{

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;


	function __construct(){
                $ts = seed_cl_get_settings();
                if(!empty($ts) && is_array($ts)){
    			     extract($ts);
                }else{
                    return false;
                }


                // Actions & Filters if the landing page is active or being previewed
                if(((!empty($status) && $status === '1') || (isset($_GET['seed_cl_preview'])))){
                    add_action( 'login_enqueue_scripts', array(&$this,'add_scripts') );
                	add_action('login_head', array(&$this,'custom_login_head'),PHP_INT_MAX);
                    add_action('login_footer', array(&$this,'custom_login_footer'));
                }
    }

    /**
     * Return an instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    function add_scripts(){
        wp_enqueue_script('jquery');
    }



    function custom_login_head(){

        // Get Settings
        $settings = get_option('seed_cl_customizer_settings');
        $settings = json_decode(json_encode($settings), FALSE);
        //var_dump($settings);
        wp_enqueue_script('jquery');
        require_once(SEED_CL_PLUGIN_PATH.'lib/seed_cl_lessc.inc.php');


        ?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

        <script src="<?php echo SEED_CL_PLUGIN_URL ?>lib/modernizr-custom.js"></script>
        <style>

        html{
            height:100%;
            <?php if(!empty($settings->background_image)): ?>
                    background: <?php echo $settings->background_color; ?> url(<?php echo $settings->background_image; ?>) <?php echo $settings->background_repeat; ?> <?php echo $settings->background_position; ?> <?php echo $settings->background_attachment; ?>;
                    <?php if(!empty($settings->background_size)): ?>
                        -webkit-background-size: <?php echo $settings->background_size; ?>;
                        -moz-background-size: <?php echo $settings->background_size; ?>;
                        -o-background-size: <?php echo $settings->background_size; ?>;
                        background-size: <?php echo $settings->background_size; ?>;
                    <?php endif; ?>
            <?php else: ?>
                background: <?php echo $settings->background_color; ?>;
            <?php endif; ?>
        }

        body{
            background:transparent;
        }

        body,p, .login form{
             font-family: <?php echo $settings->text_font; ?>;
             font-weight: <?php echo preg_replace('/[a-zA-Z]/', '', $settings->text_weight); ?>;
             font-style: <?php echo preg_replace('/[0-9]/', '', $settings->text_weight); ?>;
             font-size: <?php echo $settings->text_size; ?>px;
             line-height: <?php echo $settings->text_line_height; ?>em;
        }



        body, p, .login label,.login form,.wp-core-ui .button, .wp-core-ui .button-primary, .wp-core-ui .button-secondary,.login form .forgetmenot label,a{
            font-size: <?php echo $settings->text_size; ?>px;
        }

        #nav a, #backtoblog a{
         font-size: <?php echo $settings->text_size - 1; ?>px;
        }

        .wp-core-ui .button.button-large, .wp-core-ui .button-group.button-large .button{
            height:<?php echo ($settings->text_size*2)+2; ?>px;
        }

        <?php 
        $ratio = $settings->logo_width /  $settings->logo_height;
        $targetWidth = $targetHeight = min(320, max($settings->logo_width, $settings->logo_height));
        if ($ratio < 1) {
            $targetWidth = $targetHeight * $ratio;
        } else {
            $targetHeight = $targetWidth / $ratio;
        }
        // var_dump($targetHeight);
        // die();



        if(!empty($settings->logo)){ 
        ?>

        .login h1 a{
            background-image: url(<?php echo $settings->logo; ?>);
            background-size: <?php echo $targetWidth; ?>px <?php echo $targetHeight;; ?>px;
            height: <?php echo $targetHeight; ?>px;
            width: <?php echo $targetWidth; ?>px;

        }
        <?php } ?>


        #clpio-page{
            min-height: 100%;
        }



        #clpio-login-desc,.login label{
            color: <?php echo $settings->text_color; ?>;
        }

        #clpio-social-profiles a, #clpio-login-desc a, #login_error a{
            color: <?php echo $settings->button_color; ?>;
        }


        <?php
        $css = "
        @buttonColor: {$settings->button_color};
        @primaryColor: #fff;
        @dark_color1: darken(@primaryColor, 10%);
        @dark_color3: darken(@primaryColor, 20%);
        @light_color3: lighten(@primaryColor, 10%);
        .lightordark (@c) when (lightness(@c) >= 65%) {
            color: black;

        }
        .lightordark (@c) when (lightness(@c) < 65%) {
            color: white;

        }

        .login form .input, .login input[type='text'], .login form input[type='checkbox']{
            background-color: @primaryColor;
            .lightordark (@primaryColor);
        }

        input[type='text']:focus, input[type='password']:focus, input[type='color']:focus, input[type='date']:focus, input[type='datetime']:focus, input[type='datetime-local']:focus, input[type='email']:focus, input[type='month']:focus, input[type='number']:focus, input[type='password']:focus, input[type='search']:focus, input[type='tel']:focus, input[type='text']:focus, input[type='time']:focus, input[type='url']:focus, input[type='week']:focus, input[type='checkbox']:focus, input[type='radio']:focus, select:focus, textarea:focus{
            border-color: @buttonColor;
            -webkit-box-shadow: 0 0 2px @buttonColor;
            box-shadow: 0 0 2px @buttonColor;
        }



        ";
        try {

            $less = new seed_cl_lessc();
            $style = $less->parse($css);
            echo $style;
        } catch (Exception $e) {
            echo $e;
        }
        ?>

        .login .message, .login #login_error{
            border-left: 4px solid <?php echo $settings->button_color; ?>;
        }

        <?php
        $css = "
        @primaryColor: {$settings->button_color};
        @dark_color1: darken(@primaryColor, 10%);
        @dark_color3: darken(@primaryColor, 20%);
        @light_color3: lighten(@primaryColor, 10%);

        .lightordark (@c) when (lightness(@c) >= 65%) {
            color: black;
            text-shadow: 0 -1px 0 @light_color3;
        }
        .lightordark (@c) when (lightness(@c) < 65%) {
            color: white;
            text-shadow: 0 -1px 0 @dark_color3;
        }

        .wp-core-ui .button, .wp-core-ui .button-secondary .button-primary{
            background-color: @primaryColor;
            border-color: @dark_color1;
            box-shadow: 0 1px 0  @dark_color3;
            .lightordark (@primaryColor);
        }
        .wp-core-ui .button:hover, .wp-core-ui .button-primary:hover{
            background-color: @dark_color1;
            border-color: @dark_color1;
            box-shadow: 0 1px 0  @dark_color3;
            .lightordark (@primaryColor);
        }

        #login_error a:hover{
            color: @dark_color1;
        }




        ";
        try {

            $less = new seed_cl_lessc();
            $style = $less->parse($css);
            echo $style;
        } catch (Exception $e) {
            echo $e;
        }
        ?>

        .login #nav a, .login #backtoblog a, .login #nav a:hover, .login #backtoblog a:hover{
            color: <?php echo $settings->text_link_color; ?>;
        }

        <?php if(!empty($settings->custom_css)){
            echo $settings->custom_css;
        }
        ?>

        </style>
        <?php 

     
    }


    function custom_login_footer(){
        // Get Settings
        $settings = get_option('seed_cl_customizer_settings');
        $settings = json_decode(json_encode($settings), FALSE);
     
    ?>
 


        <?php
        if(isset($_GET['seed_cl_preview'])){
        ?>
        <script>
        jQuery("#loginform").attr('action',jQuery("#loginform").attr('action')+'?seed_cl_preview=1');
        jQuery("#lostpasswordform").attr('action',jQuery("#lostpasswordform").attr('action')+'&seed_cl_preview=1');
        jQuery(".login-action-login #nav a").attr('href',jQuery(".login-action-login #nav a").attr('href')+'&seed_cl_preview=1');
        jQuery(".login-action-lostpassword #nav a").attr('href',jQuery(".login-action-lostpassword #nav a").attr('href')+'?seed_cl_preview=1');
        jQuery("#user_login").val('');
        </script>
        <?php
        }
        ?>



    <?php
    }

}

