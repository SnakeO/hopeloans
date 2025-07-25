
<!-- css -->
<link rel="stylesheet" href="<?php echo SEED_CL_PLUGIN_URL ?>customizer/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo SEED_CL_PLUGIN_URL ?>customizer/css/font-awesome.min.css">

<!-- Plugins -->
<link href="<?php echo SEED_CL_PLUGIN_URL ?>customizer/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="<?php echo SEED_CL_PLUGIN_URL ?>customizer/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="<?php echo SEED_CL_PLUGIN_URL ?>customizer/css/jquery.nouislider.css" rel="stylesheet">
<link href="<?php echo SEED_CL_PLUGIN_URL ?>customizer/css/switchery.min.css" rel="stylesheet">
<link href="<?php echo SEED_CL_PLUGIN_URL ?>customizer/css/select2.min.css" rel="stylesheet">
<link href="<?php echo SEED_CL_PLUGIN_URL ?>customizer/css/fontawesome-iconpicker.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo SEED_CL_PLUGIN_URL ?>customizer/css/toastr.min.css">
 
<!-- Editor css -->
<link href="<?php echo SEED_CL_PLUGIN_URL ?>customizer/css/editor-style.css" rel="stylesheet">

<div id="seed-cl-customizer-wrapper">

<!-- BEGIN SIDEBAR -->
<div id="seed-cl-sidebar" data-pages="sidebar">
   
<!-- Right Side Of Navbar -->
<div id="preview-actions">
<a id="seed-back" href="<?php echo admin_url(); ?>options-general.php?page=seed_cl">&#8592; Back to Settings</a>

 Custom Login Page by <img style="width:100px;margin-bottom:8px;vertical-align: middle;" src="<?php echo SEED_CL_PLUGIN_URL ?>admin/seedprod-logo-black.png"> <br>

<div style="margin-top:10px">
<button id="publish-btn" class="button-primary" data-step="4" data-loading-text="Saving..."><i class="fa fa-save"></i> <?php _e('Save','custom-login-page-wp'); ?></button>
    <a id="refresh_page"  class="button-secondary"><i class="fa fa-refresh"></i> <?php _e('Refresh','custom-login-page-wp'); ?></a>
    <a id="preview_desktop" class="button-secondary"><i class="fa fa-desktop"></i> <?php _e('Desktop','custom-login-page-wp'); ?></a>
    <a id="preview_mobile"  class="button-secondary"><i class="fa fa-mobile-phone"></i> <?php _e('Mobile','custom-login-page-wp'); ?></a>
</div>
<p style="margin-top:18px;background:#fff"><a style="color:#FF5722;" href="https://www.seedprod.com/wordpress-custom-login-page/?utm_source=custom-login-page-wp-plugin&utm_medium=banner&utm_campaign=custom-login-page-wp-link-in-plugin" target="_blank"><i class="fa fa-star"></i> Check out the Pro Version for More Customizations</a></p>

    

                            


</div>

<!-- BEGIN SIDEBAR MENU -->
<div class="clp-sidebar-menu">
<div class="sidebar">
<form id="seed_cl_customizer">
<input type="hidden" id="disabled_fields" name="disabled_fields" value="<?php echo ( empty($settings->disabled_fields) ) ? '' : $settings->disabled_fields  ?>">
<input type="hidden" id="first_run" name="first_run" value="">
<input type="hidden" id="page_id" name="page_id" value="<?php echo $page_id; ?>">

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


    <a name="header-content-settings"></a>
    <div class="panel-heading">
        <h3 class="panel-title"> <i class="fa fa-file-text-o"></i><?php _e('Logo Settings','custom-login-page-wp'); ?></h3>
    </div>
        <div class="panel-body">

        <div class="form-group">
            <label class="control-label"><?php _e('Logo','custom-login-page-wp'); ?></label>
            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?php _e('Upload a logo or teaser image. Width should be less than 320px','custom-login-page-wp'); ?>"></i>
            <input id="logo_height" name="logo_height" type="hidden" value="<?php echo  $settings->logo_height ?>">
            <input id="logo_width" name="logo_width" type="hidden" value="<?php echo  $settings->logo_width ?>">
            <input id="logo" class="form-control input-sm" name="logo" type="text" value="<?php echo  $settings->logo ?>">
            <input id='logo_upload_image_button' class='button-primary upload-button' type='button' value='<?php _e( 'Choose Image', 'custom-login-page-wp' ) ?>' /><br>
                <?php if(!empty($settings->logo)): ?>
                <div class="img-preview">
                    <img id="logo-preview" src="<?php echo  $settings->logo ?>">
                    <?php else: ?>
                    <div class="img-preview" style="display:none;">
                        <img id="logo-preview" src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/img/blank.gif" >
                    <?php endif; ?>
                    <i class="fa fa-close"></i>
                </div>
        </div>
     
      <div class="form-group" style="display:none;">
            <label class="control-label" ><?php _e('Description','custom-login-page-wp') ?></label>
            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?php _e('Tell the visitor what to expect from your site. Also supports WordPress shortcodes and video embeds. Most shortcodes require that you enable "Enable 3rd Party Plugins" which can be found under the advanced tab.','custom-login-page-wp') ?>"></i>
            <?php
            $content   = $settings->rich_description;
            $editor_id = 'rich_description';
            $args      = array(
                 'textarea_name' => "rich_description",
            ); 
            
            wp_editor( $content, $editor_id, $args ); 
            ?>
        </div> 
        </div>
    
     
        
   
     
   
                    <a name="header-background-settings"></a>
                    <div class="panel-heading">
                        <h3  class="panel-title"><i class="fa fa-picture-o"></i><?php _e('Background Settings','custom-login-page-wp') ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label"><?php _e('Background Color','custom-login-page-wp') ?></label>
                            <div class="input-group background_color_picker">
                                <input id="background_color" class="form-control input-sm" data-format="hex" name="background_color" type="text" value="<?php echo $settings->background_color ?>">  
                                <span class="input-group-addon"><i></i></span>  
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label"><?php _e('Background Image','custom-login-page-wp') ?></label> 
                            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?php _e('Tip: Make sure to select the full size image when inserting.','custom-login-page-wp') ?>"></i>
                            <br>
                            <!-- <button type="button" class="stock-image button-primary" data-toggle="modal" data-target="#image-picker"><?php _e('Select Stock Image','custom-login-page-wp') ?></button> 
                            or -->
                            <input id="background_image" class="form-control input-sm" name="background_image" type="hidden" value="<?php echo  $settings->background_image ?>">
                            <input id='background_image_upload_image_button' class='button-primary upload-button' type='button' value='<?php _e( 'Choose Image', 'custom-login-page-wp' ) ?>' /><br>
                                <?php if(!empty($settings->background_image)): ?>
                                <div class="img-preview">
                                    <img id="background_image-preview" src="<?php echo  $settings->background_image ?>">
                                    <?php else: ?>
                                    <div class="img-preview" style="display:none;">
                                        <img id="background_image-preview" src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/img/blank.gif" >
                                    <?php endif; ?>
                                    <i class="fa fa-close"></i>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="control-label"><?php _e('Background Advanced Settings','custom-login-page-wp') ?></label>
                                <input id="enable_background_adv_settings" class="switchery" name="enable_background_adv_settings" type="checkbox" value="1" <?php echo (isset($settings->enable_background_adv_settings)) ? 'checked' : '' ?>>       
                            </div>
                            <div id="background_adv_settings">
                                <div class="form-group">
                                    <label class="control-label"><?php _e('Background Size','custom-login-page-wp') ?></label>
                                    <?php seed_cl_select('background_size',array('auto'=>'Auto','cover'=>'Cover','contain'=>'Contain'),$settings->background_size); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php _e('Background Repeat','custom-login-page-wp') ?></label>
                                    <?php seed_cl_select('background_repeat',array('repeat'=>'Repeat','repeat-x'=>'Repeat-X','repeat-y'=>'Repeat-Y', 'no-repeat'=>'No-Repeat'),$settings->background_repeat); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php _e('Background Position','custom-login-page-wp') ?></label>
                                    <?php seed_cl_select('background_position',array('left top'=>'Left Top','left center'=>'Left Center','left bottom'=>'Left Bottom', 'right top' => 'Right Top', 'right center' => 'Right Center', 'right bottom' => 'Right Bottom', 'center top' => 'Center Top', 'center center' => 'Center Center', 'center bottom' => 'Center Bottom'),$settings->background_position); ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php _e('Background Attachment','custom-login-page-wp') ?></label>
                                    <?php seed_cl_select('background_attachment',array('scroll'=>'Scroll','fixed'=>'Fixed'),$settings->background_attachment); ?>
                                </div>
                            </div>
                          
                        </div>

                        <a name="header-elements-settings"></a>
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-paint-brush"></i><?php _e('Colors','custom-login-page-wp') ?></h3>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="control-label"><?php _e('Button Color','custom-login-page-wp') ?></label>
                                <div class="input-group button_color_picker">
                                    <input id="button_color" class="form-control input-sm" name="button_color" type="text" value="<?php echo $settings->button_color ?>">
                                    <span class="input-group-addon"><i></i></span>  
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label"><?php _e('From Text Color','custom-login-page-wp') ?></label>
                                <div class="input-group text_color_picker">
                                    <input id="text_color" class="form-control input-sm" name="text_color" type="text" value="<?php echo $settings->text_color ?>"> 
                                    <span class="input-group-addon"><i></i></span>  
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="control-label"><?php _e('Below Form Link Color','custom-login-page-wp') ?></label>
                                <div class="input-group text_link_color_picker">
                                    <input id="text_link_color" class="form-control input-sm" name="text_link_color" type="text" value="<?php echo $settings->text_link_color ?>"> 
                                    <span class="input-group-addon"><i></i></span>  
                                </div>
                            </div>
                     
                     


                 
                  
                        </div>
                        <a name="header-typography-settings"></a>
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-font"></i><?php _e('Typography','custom-login-page-wp') ?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label"><?php _e('Text Font','custom-login-page-wp') ?></label>
                                <?php seed_cl_select('text_font',$font_families,$settings->text_font); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php _e('Text Weight & Style','custom-login-page-wp') ?></label>
                                <?php seed_cl_select("text_weight",array('400'=>'Normal 400','Bold 700'=>'Bold','400 italic'=>'Normal 400 Italic', '700italic' => 'Bold 700 Italic'),$settings->text_weight); ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php _e('Text Subset','custom-login-page-wp') ?></label>
                                <?php seed_cl_select("text_subset",array(''=>'Default'),$settings->text_subset); ?>
                            </div>
                        
                            <div class="form-group">
                                <label class="control-label"><?php _e('Text Size','custom-login-page-wp') ?></label>
                                <input id="text_size" name="text_size" type="hidden" value="<?php echo ( empty($settings->text_size) ) || $settings->text_size == 'false' ? '16' : $settings->text_size ?>">
                                <div class="bg-master m-b-10 m-t-40" id="text_size_slider"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php _e('Text Line Height','custom-login-page-wp') ?></label>
                                <input id="text_line_height" name="text_line_height" type="hidden" value="<?php echo ( empty($settings->text_line_height) || $settings->text_line_height == 'false' ) ? '1.5' : $settings->text_line_height ?>">
                                <div class="bg-master m-b-10 m-t-40" id="text_line_height_slider"></div>
                            </div>
     
                           </div>
                        <a name="header-custom-css-settings"></a>
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-css3"></i>CSS</h3>
                        </div>
                        <div class="panel-body">       
                            <div class="form-group">
                                <label class="control-label"><?php _e('Custom CSS','custom-login-page-wp') ?></label>
                                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?php _e('Need to tweak the styles? Add your custom CSS here.','custom-login-page-wp') ?>"></i>
                    
                                <textarea id="theme_css" class="form-control input-sm" name="theme_css" cols="50" rows="10" style="display:none"><?php  echo ( empty($settings->theme_css) ) ? '' : $settings->theme_css ?></textarea> 
                                <textarea id="theme_scripts" class="form-control input-sm" name="theme_scripts" cols="50" rows="10" style="display:none"><?php echo ( empty($settings->theme_scripts) ) ? '' : $settings->theme_scripts ?></textarea> 
                                <textarea id="custom_css" class="form-control input-sm" name="custom_css" cols="50" rows="10"><?php echo $settings->custom_css ?></textarea>        
                            </div>
                           
                        </div>
                
     
               
            </div>
            </form>

        </div>
        <!-- /.sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->

<!-- START PAGE-CONTAINER -->
<div class="page-container">
    <!-- START PAGE HEADER WRAPPER -->
    <!-- END PAGE HEADER WRAPPER -->
    <!-- START PAGE CONTENT WRAPPER -->
    <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
            <!-- START CONTAINER FLUID -->
            <div class="container-fluid container-fixed-lg">
                <div id="ajax-status"><img src="<?php echo admin_url() ?>/images/spinner.gif"></div>
                <!-- BEGIN PlACE PAGE CONTENT HERE -->
                <div id="preview-wrapper" class="main" data-step="3" data-intro="All your changes will show up in the Preview window as you make them.">
                    <iframe id="preview" src="<?php echo home_url('/','relative').'wp-login.php?seed_cl_preview='. $page_id?>" ></iframe>  
                </div>
                <!-- END PLACE PAGE CONTENT HERE -->
            </div>
            <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTAINER -->


<!-- JS -->

<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/bootstrap.min.js" ></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/moment.min.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/jquery.nouislider.min.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/jquery.liblink.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/switchery.min.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/wNumb.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/select2.min.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/fontawesome-iconpicker.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/jquery.fitvids.min.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/jquery.color.min.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/clp-app.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/imagesloaded.pkgd.min.js"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>customizer/js/toastr.min.js" type="text/javascript"></script>
<script src="<?php echo SEED_CL_PLUGIN_URL ?>admin/field-types/js/upload.js"></script>

<!-- App JS -->
<script>

var blank_gif = '<?php echo SEED_CL_PLUGIN_URL ?>customizer/img/blank.gif';
var page_id = '<?php echo $page_id; ?>';
var refresh = true;
var timeout;
var page = '1';
var preview_url = '<?php echo home_url('/','relative'); ?>wp-login.php?seed_cl_preview=<?php echo $page_id; ?>';
var path = '<?php echo admin_url(); ?>';
var text_size = <?php echo ( empty($settings->text_size) || $settings->text_size == 'false' ) ? '16' : $settings->text_size ?>;
var text_line_height = <?php echo ( empty($settings->text_line_height) || $settings->text_line_height == 'false' ) ? '1.5' : $settings->text_line_height ?>;
var text_weight = '<?php echo $settings->text_weight ?>';
var text_subset = '<?php echo $settings->text_subset ?>';
<?php $save_page_ajax_url = html_entity_decode(wp_nonce_url('admin-ajax.php?action=seed_cl_save_page','seed_cl_save_page')); ?>
var save_url = "<?php echo $save_page_ajax_url; ?>";
var google_fonts = [];

</script>

<script type="text/template" id="social_profiles_template">
<div class="field-group">
    <div class="btn-group" >
        <button id="bicon_{?}" data-selected="graduation-cap" type="button" class="icp icp-dd btn btn-default btn-sm dropdown-toggle iconpicker-component" data-toggle="dropdown">
            Icon  <i class="fa fa-fw"></i>
            <span class="caret"></span>
        </button>
        <div class="dropdown-menu"></div>
    </div>
                               
    <div class="input-group">
    <div class="input-group-addon"><i class="fa fa-bars"></i></div>
    <input type="text" name="social_profiles[{?}][url]" value=""  id="social_profiles_{?}" class="form-control input-sm" placeholder="<?php _e('Enter Url','custom-login-page-wp') ?>" />
    <input type="hidden" name="social_profiles[{?}][icon]" value="" id="icon_{?}"  class="form-control input-sm"/>
    <div class="input-group-addon slide-delete"><i class="fa fa-close delete"></i></div>

    </div>
</div>
</script>



</div>


