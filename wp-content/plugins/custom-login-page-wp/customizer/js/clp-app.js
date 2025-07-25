/* Copyright (C) SeedProd LLC - All Rights Reserved
 * Written by John Turner <john@seedprod.com>, 2016
 */

jQuery(document).ready(function() {

    
    // Publish Button
    jQuery('#publish-btn').on('click',function(e){
        save_page();
    });


    // Background Color
    jQuery('.background_color_picker').colorpicker({ component: '.form-control, .add-on, .input-group-addon' }).on('changeColor.colorpicker', function(event){
      jQuery('#preview').contents().find('body').css('background-color',event.color.toHex());
    });

    // Background Image Picker
    jQuery("#image-picker").on("show.bs.modal", function(e) {
        p = page
        get_posts(p);
    });


    //Background Advanced Settings
    if (jQuery('#enable_background_adv_settings').is(':checked')) {
        jQuery("#background_adv_settings").show();
    }else{
        jQuery("#background_adv_settings").hide();
    }
    

    jQuery("#enable_background_adv_settings").change(function() {
    if(this.checked) {
        jQuery("#background_adv_settings").fadeIn();
    }else{
        jQuery("#background_adv_settings").hide();
    }
    });


    //Background Advanced Settings
    if (jQuery('#enable_background_overlay').is(':checked')) {
        jQuery("#background_overlay").parents('.form-group').show();
    }else{
        jQuery("#background_overlay").parents('.form-group').hide();
    }

    // Background Size
    jQuery('#background_size').change(function() {
        save_page(false);
        jQuery('#preview').contents().find('body').css('background-size',jQuery('#background_size').val());
    });

    jQuery('#background_repeat').change(function() {
        save_page(false);
        jQuery('#preview').contents().find('body').css('background-repeat',jQuery('#background_repeat').val());
    });

    jQuery('#background_position').change(function() {
        save_page(false);
        jQuery('#preview').contents().find('body').css('background-position',jQuery('#background_position').val());
    });

    jQuery('#background_attachment').change(function() {
        save_page(false);
        jQuery('#preview').contents().find('body').css('background-attachment',jQuery('#background_attachment').val());
    });



    // Element Color
    jQuery('.button_color_picker').colorpicker({ component: '.form-control, .add-on, .input-group-addon' }).on('changeColor.colorpicker', function(event){
      //if(jQuery('#container_flat').val() == '1'){
      jQuery('#preview').contents().find(' #clpio-social-profiles a,#clpio-login-desc a').css('color',"rgba("+event.color.toRGB().r+","+event.color.toRGB().g+","+event.color.toRGB().b+","+event.color.toRGB().a+")");
      jQuery('#preview').contents().find('.button-primary').css('background-color',"rgba("+event.color.toRGB().r+","+event.color.toRGB().g+","+event.color.toRGB().b+","+event.color.toRGB().a+")");
      //jQuery('#preview').contents().find('.button-primary').css('border-color',"rgba("+event.color.toRGB().r+","+event.color.toRGB().g+","+event.color.toRGB().b+","+event.color.toRGB().a+")");
      var dark_color1 = jQuery.Color(jQuery('#button_color').val()).lightness('-=0.1').toRgbaString();
      var dark_color3 = jQuery.Color(jQuery('#button_color').val()).lightness('-=0.2').toRgbaString();
      var light_color3 = jQuery.Color(jQuery('#button_color').val()).lightness('+=0.2').toRgbaString();
      jQuery('#preview').contents().find('.button-primary').css('border-color',dark_color1);
      jQuery('#preview').contents().find('.button-primary').css('box-shadow','0 1px 0 '+dark_color3);
      

      var lightness = jQuery.Color(jQuery('#button_color').val()).lightness();
      if(lightness >= 0.65){
        var color = '#000';
        jQuery('#preview').contents().find('.button-primary').css('color','#000');
        jQuery('#preview').contents().find('.button-primary').css('text-shadow','0 -1px 1px '+light_color3+',1px 0 1px '+light_color3+',0 1px 1px '+light_color3+',-1px 0 1px '+light_color3+'');
      }else{
        var color = '#fff';
        jQuery('#preview').contents().find('.button-primary').css('color','#fff');
        jQuery('#preview').contents().find('.button-primary').css('text-shadow','0 -1px 1px '+dark_color3+',1px 0 1px '+dark_color3+',0 1px 1px '+dark_color3+',-1px 0 1px '+dark_color3+'');
      }

      //}

    });
    
    jQuery('#button_color').on('blur',function(e){
            save_page(false);
	});

    
    // Form Input Background Color
    jQuery('.form_color_picker').colorpicker({ component: '.form-control, .add-on, .input-group-addon' }).on('changeColor.colorpicker', function(event){
      jQuery('#preview').contents().find('input').not("input[type='submit']").css('background-color',"rgba("+event.color.toRGB().r+","+event.color.toRGB().g+","+event.color.toRGB().b+","+event.color.toRGB().a+")");


      if(jQuery('#preview').contents().find('#tmp-form-style').length == 0){
        jQuery('#preview').contents().find('head').append("<style id='tmp-form-style' type='text/css'></style>");
      }
      

      var lightness = jQuery.Color(jQuery('#form_color').val()).lightness();
      if(lightness >= 0.65){
        var color = '#999';
        var textcolor = "#000";
      }else{
        var color = '#999';
        var textcolor = "#fff";
      }
      jQuery('#preview').contents().find('input').not("input[type='submit']").css('color',textcolor);

      jQuery('#preview').contents().find('#tmp-form-style').html('::-webkit-input-placeholder {color:'+color+' !important};:-moz-placeholder {color:'+color+' !important};::-moz-placeholder {color:'+color+' !important};:-ms-input-placeholder {color:'+color+' !important};');

    });


    // Custom CSS
    jQuery('#custom_css').on("input", function (e) { 
        jQuery('#preview').contents().find('#tmp-custom-css-style').remove();
        jQuery('#preview').contents().find('head').append("<style id='tmp-custom-css-style' type='text/css'></style>");
        jQuery('#preview').contents().find('#tmp-custom-css-style').html(jQuery('#custom_css').val());

    });
    

    // Fonts Stuff
    jQuery('#text_font').select2();


    jQuery('.text_color_picker').colorpicker({ component: '.form-control, .add-on, .input-group-addon' }).on('changeColor.colorpicker', function(event){

      jQuery('#preview').contents().find('#clpio-login-desc,.login label').css('color',"rgba("+event.color.toRGB().r+","+event.color.toRGB().g+","+event.color.toRGB().b+","+event.color.toRGB().a+")");
    });

    jQuery('.text_link_color_picker').colorpicker({ component: '.form-control, .add-on, .input-group-addon' }).on('changeColor.colorpicker', function(event){

      jQuery('#preview').contents().find(' .login #nav a, .login #backtoblog a').css('color',"rgba("+event.color.toRGB().r+","+event.color.toRGB().g+","+event.color.toRGB().b+","+event.color.toRGB().a+")");
    });



    jQuery('#text_line_height').on('input',function(e){
      jQuery('#preview').contents().find('body').css('line-height',jQuery('#text_line_height').val() + 'px');
    });
    
    if(jQuery('#publish_method').val() == 'download'){
        jQuery("#auth_code").parent().parent().hide();
        jQuery("#url").parent().show();
    }
    if(jQuery('#publish_method').val() == 'wordpress'){
        jQuery("#auth_code").parent().parent().show();
        jQuery("#url").parent().hide();
    }
    
    jQuery('#publish_method').change(function() {
        if(jQuery('#publish_method').val() == 'download'){
            jQuery("#auth_code").parent().parent().hide();
            jQuery("#url").parent().show();
        }
        if(jQuery('#publish_method').val() == 'wordpress'){
            jQuery("#auth_code").parent().parent().show();
            jQuery("#url").parent().hide();
        }
    });




}); // end doc ready



// Functions

// Dim iframe while changes are made.
jQuery(document)
.ajaxStart(function () {
    
})
.ajaxStop(function () {
    
});

jQuery('#preview').load(function(){
 // console.log('clear');
  clearTimeout(timeout);
  jQuery('#ajax-status').hide();
  jQuery('#preview').animate({
    opacity: "1"
}, 500); 
});


// Save Settings
function save_page(refresh){
    if(typeof refresh === 'undefined'){
        refresh = true;
    }
    // Clear any errors
    jQuery(".help-block").remove();
    jQuery(".form-group").removeClass('has-error');
    try{
    jQuery("#publish-btn").button('loading');
    }catch(err) {}

    // Submit data
    var dataString = jQuery( '#seed_cl_customizer' ).serialize();
    //console.log(dataString);

    if(dataString == ''){
        return 'false';
    }
    
    jQuery.ajax({
        type: "POST",
        url : save_url,
        data : dataString,
        beforeSend : function(data){
                if(refresh){
                    //console.log('timeout');
                    jQuery('#preview').css('opacity','0');
                    jQuery('#ajax-status').show();

                    
                    // timeout = setTimeout(function(){
                    //     location = ''
                    //   },10000);
                }
        },
        success : function(data){
            if(data == 'true'){
                try{
                jQuery("#publish-btn").button('reset');
                }catch(err) {}
                if(refresh){
                document.getElementById('preview').contentWindow.location.reload(true);
                }
                if(refresh == 'hard'){
                    location.refresh();
                }
                return true;
            }else{
                //console.log(jQuery.parseJSON(data));
                errors = '';
                jQuery.each( jQuery.parseJSON(data), function( key, value ) {
                  errors =  errors + "<li>"+value+"</li>";
                });
                toastr.options.timeOut = 15000;
                toastr.options.progressBar = true;
                toastr.error('Your settings could not be saved. Please make sure these fields are not empty. <ul style="list-style-type: circle;font-size:11px">'+errors+'</ul>');
            }
            

        },
        error: function(data){
            if(data.status == '403'){
                jQuery('#preview').css('opacity','1');
                jQuery('#ajax-status').hide();
                toastr.error('Your settings could not be saved. The WordFence Firewall is blocking the Save. Please set the Firewall to Learning Mode while building this page.');
            }else{
                toastr.error('Your settings could not be saved. Refresh the page and try again. Please contact Support if you continue to experience this issue.');
            }
            //alert('Your settings could not be saved. Please open a Support Ticket so we can identify the issue.');
            // var errors = data.responseJSON;
            // jQuery.each( errors, function( key, value ) {
            //     jQuery( "#"+key ).parent().append("<span class='help-block'>"+value+"</span>").addClass('has-error');
            // });
        }
    });
}

//Image Functions
jQuery( "#logo,#background_image" ).change(function() {
  update_image_preview(this);
});
function update_image_preview(el){
    var file = jQuery(el).val();
    jQuery(el).parent().find(".img-preview img").prop('src',file);
    jQuery(el).parent().find(".img-preview").show();
    var id = jQuery(el).attr('id');
    if(id == 'logo'){
        jQuery('#preview').contents().find('#clpio-logo').prop('src', file);
    }
    if(id == 'background_image'){
        jQuery('#preview').contents().find('body').css('background-image', 'url('+file+")");
        jQuery('#preview').contents().find('body').css('background-size',jQuery('#background_size').val());
    	jQuery('#preview').contents().find('body').css('background-repeat',jQuery('#background_repeat').val());
    	jQuery('#preview').contents().find('body').css('background-position',jQuery('#background_position').val());
    	jQuery('#preview').contents().find('body').css('background-attachment',jQuery('#background_attachment').val()); 
    }

    //console.log('trigger');
    save_page();
}

// Global //

jQuery(document).ready(function() {
    // Previews
    jQuery('#preview_desktop').on('click',function(e){
      jQuery("#preview-wrapper").removeClass('phone-wireframe');
      jQuery('#preview').contents().find('#tubular-container,#big-video-wrap').show();
      jQuery('#preview').animate({
        width: "100%",
        height: "100%",
        'padding-top': "0px"
    }, 500); 
    });

    jQuery('#preview_mobile').on('click',function(e){
      jQuery("#preview-wrapper").addClass('phone-wireframe');
      jQuery('#preview').contents().find('#tubular-container,#big-video-wrap').hide();
      jQuery('#preview').animate({
        width: "329px",
        height: "680px",
        'padding-top': "94px"
    }, 500); 
  });
  
   jQuery('#refresh_page').on('click',function(e){
      jQuery("#preview").attr('src',preview_url)
  });

	// Tooltips
	jQuery('[data-toggle="tooltip"]').tooltip();


	// Image Preview Delete
	jQuery('.img-preview .fa').click(function() {
	    jQuery(this).prev().prop('src',blank_gif);
	    jQuery(this).parent().parent().find("input:text,input:hidden").val('');
	    jQuery(this).parent().fadeOut();
	    save_page();
	});

	// Save Page Events
	jQuery('#recaptcha_site_key,#url,#publish_method,#headline_color,#headline_line_height,#text_color,#text_link_color,#text_size,#text_line_height,#container_color,#form_color,.note-editable,#background_color,#background_overlay,#footer_credit_text, #footer_credit_link, #footer_affiliate_link, #headline, #description, #privacy_policy_link_text,#thankyou_msg,#tweet_text,#seo_title, #seo_description, #ga_analytics,#txt_subscribe_button,#txt_email_field,#txt_name_field,#txt_already_subscribed_msg,#txt_invalid_email_msg,#txt_invalid_name_msg,#txt_stats_referral_stats,#txt_stats_referral_url,#txt_stats_referral_clicks,#txt_stats_referral_subscribers').on('blur',function(e){
	    save_page(false);
	});


	jQuery('#recaptcha_secret_key,#typekit_id,#header_scripts,#footer_scripts,#conversion_scripts,#custom_css,input[id^="social_profiles"],#bg_video_url,#progress_bar_start_date,#progress_bar_end_date,#countdown_date,#countdown_format,#txt_countdown_days,#txt_countdown_day,#txt_countdown_hours,#txt_countdown_hour,#txt_countdown_minutes, #txt_countdown_minute,#txt_countdown_days,#txt_countdown_day,#countdown_timezone').on('blur',function(e){
	    save_page();
	});

	jQuery("#enable_reflink,#credit_type,#enable_fitvid,#enable_retinajs,#enable_recaptcha,#enable_wp_head_footer,#bg_video_audio, #bg_video_loop,#display_name,#bg_slideshow_slide_transition,#progressbar_effect,#container_flat").change(function() {
	    save_page();
	});

	jQuery("#enable_fraud_detection,#enable_background_overlay,#countdown_launch,#require_name,#container_radius_slider,#progressbar_percentage_slider,#publish_method").change(function() {
	    save_page(false);
	});


    //Show hide adv fields
    jQuery("#show_hide_adv_fields").change(function() {
    if(this.checked){
        jQuery(".adv").fadeOut();
    }else{
        jQuery(".adv").fadeIn();
    }

});




}); // end doc ready

// switchery
var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
// Success color: #10CFBD
elems.forEach(function(html) {
  var switchery = new Switchery(html, {color: '#0085BA', size: 'small'});
});


        


// Text Font

    function set_text_font_extras(el){
        if(jQuery(el).val().indexOf(',') == -1){
             font_name = jQuery(el).val().replace(/\+/g, " ").replace(/\'/g, "");
             //console.log(font_name);
             font = google_fonts[font_name];
             jQuery('#text_weight, #text_subset').parent().fadeIn();
            //console.log(font);


            // load weights and style
            jQuery('#text_weight').find('option').remove();
            //jQuery('#text_weight').append('<option value="">Default</option>');
            //onsole.log(font);
            jQuery.each(font.variants,function(key, value) 
            {
                jQuery('#text_weight').append('<option value=' + value.id + '>' + value.name + '</option>');
            });

            
            if(text_weight != ''){
                jQuery('#text_weight').val(text_weight);
            }else{
                if(jQuery("#text_weight option[value='400']").length > 0){
                jQuery('#text_weight').val('400'); 
                }
            }
                

            // Load variants
            jQuery('#text_subset').find('option').remove();
            jQuery('#text_subset').append('<option value="">Default</option>');
            jQuery.each(font.subsets,function(key, value) 
            {
                jQuery('#text_subset').append('<option value=' + value.id + '>' + value.name + '</option>');
            });

            if(text_subset != ''){
                jQuery('#text_subset').val(text_subset);  
            }else{
                jQuery('#text_subset').val('');  
            }

        }else{
            // Load default weights
            jQuery('#text_weight').find('option').remove();
            jQuery('#text_weight').append('<option value="400">Normal 400</option');
            jQuery('#text_weight').append('<option value="700">Bold 700</option');
            jQuery('#text_weight').append('<option value="400italic">Normal 400 Italic</option');
            jQuery('#text_weight').append('<option value="700italic">Bold 700 Italic</option');
            jQuery('#text_weight').val('400');

            jQuery('#text_subset').parent().fadeOut();
        }
    }

    jQuery(function () {
    set_text_font_extras(jQuery('#text_font'));
    // jQuery('#text_weight').val('400');
    // jQuery('#text_subset').val('');
    });

    jQuery('#text_font').on("change", function (e) { 
        el =jQuery('#text_font');

        set_text_font_extras(el);

        // Show Preview
        if(jQuery(el).val().indexOf(',') === -1){
        jQuery('#preview').contents().find('.gf-text').remove();
        url = 'https://fonts.googleapis.com/css?family='+jQuery(el).val().replace(/\'/g, "").replace(/\s/g, "+")+':'+jQuery('#text_weight').val()+'&subset='+jQuery('#text_subset').val();
        jQuery('#preview').contents().find('head').append('<link class="gf-text" rel="stylesheet" href="'+url+'" type="text/css" />');
        }


        // Body Font
        jQuery('#preview').contents().find('body, p,.login form').css('font-family',jQuery(el).val());

        // Placeholder Update
        jQuery('#preview').contents().find('tmp-placeholder-style').remove();
        jQuery('#preview').contents().find('head').append("<style id='tmp-placeholder-style' type='text/css'> .placeholder::-webkit-input-placeholder {font-family:"+jQuery('#text_font').val()+";font-weight:"+jQuery('#text_weight').val().replace(/[a-zA-Z]/g, "")+";font-style:"+jQuery('#text_weight').val().replace(/[0-9]/g, "")+";} </style>");
        jQuery('#preview').contents().find('input').addClass('placeholder');

        jQuery('#preview').contents().find('body, p,.login form').css('font-weight',parseInt(jQuery('#text_weight').val()));

        style = jQuery('#text_weight').val().replace(/[0-9]/g, '');
        if(style != ""){
            jQuery('#preview').contents().find('body, p,.login form').css('font-style',style);
        }else{
            jQuery('#preview').contents().find('body, p,.login form').css('font-style','normal');
        }



        //Save
        save_page(false);
        
    });

    jQuery('#text_weight').on("change", function (e) { 
        el =jQuery('#text_font');
        if(jQuery(el).val().indexOf(',') === -1){
        jQuery(".gf-text").remove();
        url = 'https://fonts.googleapis.com/css?family='+jQuery(el).val().replace(/\'/g, "").replace(/\s/g, "+")+':'+jQuery('#text_weight').val()+'&subset='+jQuery('#text_subset').val();
        jQuery('#preview').contents().find('head').append('<link class="gf-text" rel="stylesheet" href="'+url+'" type="text/css" />');
        }

        jQuery('#preview').contents().find('body, p,.login form').css('font-weight',parseInt(jQuery('#text_weight').val()));
        style = jQuery('#text_weight').val().replace(/[0-9]/g, '');
        if(style == ""){
            style = 'normal'
        }
        jQuery('#preview').contents().find('body, p,.login form').css('font-style',style);
        
        // Placeholder Update
        jQuery('#preview').contents().find('tmp-placeholder-style').remove();
        jQuery('#preview').contents().find('head').append("<style id='tmp-placeholder-style' type='text/css'> .placeholder::-webkit-input-placeholder {font-family:"+jQuery('#text_font').val()+";font-weight:"+jQuery('#text_weight').val().replace(/[a-zA-Z]/g, "")+";font-style:"+style+";} </style>");
        jQuery('#preview').contents().find('input').addClass('placeholder');



        //Save
        save_page(false);
    });

    jQuery('#text_subset').on("change", function (e) { 
        el =jQuery('#text_font');
        if(jQuery(el).val().indexOf(',') === -1){
        jQuery(".gf-text").remove();
        url = 'https://fonts.googleapis.com/css?family='+jQuery(el).val().replace(/\'/g, "").replace(/\s/g, "+")+':'+jQuery('#text_weight').val()+'&subset='+jQuery('#text_subset').val();
        jQuery('#preview').contents().find('head').append('<link class="gf-text" rel="stylesheet" href="'+url+'" type="text/css" />');
        }
    //Save
        save_page(false);
    });

jQuery(document).ready(function() {

      jQuery("#text_size_slider").noUiSlider({
            start: text_size,
            connect: "lower",
            step: 1,
            range: {
                'min': 10,
                'max': 100
            },
            format: wNumb({
                decimals: 0
            })
        });

        jQuery("#text_size_slider").Link('lower').to('-inline-<div class="tooltip fade top in" style="top: -33px;left: -7px;opacity: 0.7;"></div>', function(value) {
            // The tooltip HTML is 'this', so additional
            // markup can be inserted here.
            jQuery(this).html(
                '<div class="tooltip-inner">' +
                '<span>' + value + 'px</span>' +
                '</div>'
            );
            jQuery('#text_size').val(value);
            jQuery('#preview').contents().find('body, p, .login label,.login form,.wp-core-ui .button, .wp-core-ui .button-primary, .wp-core-ui .button-secondary,.login form .forgetmenot label,a').css('font-size',value + 'px');
            jQuery('#preview').contents().find('.wp-core-ui .button.button-large, .wp-core-ui .button-group.button-large .button').css('height',((value*2)+2) + 'px');

        });

           jQuery("#text_line_height_slider").noUiSlider({
            start: text_line_height,
            connect: "lower",
            step: 0.01,
            range: {
                'min': 0.5,
                'max': 2
            }
        });


            

        jQuery("#text_line_height_slider").Link('lower').to('-inline-<div class="tooltip fade top in" style="top: -33px;left: -7px;opacity: 0.7;"></div>', function(value) {
            // The tooltip HTML is 'this', so additional
            // markup can be inserted here.
            jQuery(this).html(
                '<div class="tooltip-inner">' +
                '<span>' + value + 'em</span>' +
                '</div>'
            );
            jQuery('#text_line_height').val(value);
            jQuery('#preview').contents().find('body, p, .login label,.login form,.wp-core-ui .button, .wp-core-ui .button-primary, .wp-core-ui .button-secondary,.login form .forgetmenot label,a').css('line-height',value + 'em');

        });

         });














