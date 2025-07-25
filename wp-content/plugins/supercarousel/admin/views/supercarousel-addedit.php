<?php
$id = (int) SuperCarousel_Common::super_get_get('id');
$act = SuperCarousel_Common::super_get_get('act');

$super_title = '';
$supertemplate = [];

if ($id > 0 and $act == 'edit') {
    $super_title = get_the_title($id);
    $supertemplate_str = get_post_meta($id, 'supertemplate', true);
    if ($supertemplate_str != '') {
        $supertemplate = SuperCarousel_Common::super_unserialize($supertemplate_str);
    }
}
//supershow($supertemplate);
if (!count($supertemplate)) {
    $supertemplate = [];
}
$supertemplate_data = SuperCarousel_Common::get_array_value($supertemplate, 'data', '');
//$supertemplate_data = stripslashes($supertemplate_data);
$regimage_sizes_arr = get_intermediate_image_sizes();
$regimage_sizes_arr[] = 'full';
$regimage_sizes = '';
foreach ($regimage_sizes_arr as $imgsize) {
    $regimage_sizes .= '<span>{image_' . $imgsize . '}</span>';
}
?>
<form name="supercarouselform" id="supercarouselform" method="post" onsubmit="return SupercarouselCommon.supercarousel_save(this);">
    <input type="hidden" name="action" value="supercarouseladmin" />
    <input type="hidden" name="superaction" value="save_supercarousel" />
    <input type="hidden" name="page" value="supercarousel" />
    <input type="hidden" name="act" value="<?php echo $act; ?>" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <textarea name="supertemplate[data]" style="display: none;" id="super_template_elements"><?php echo $supertemplate_data; ?></textarea>
    <div class="surow">
        <div class="sucol-9">
            <div class="supercarouseladdedit superform">
                <div class="carousel_title">
                    <?php
                    echo SuperCarousel_Common::generate_super_textbox('super_title', $super_title, ' required="" placeholder="' . __('Super Carousel Title', 'supercarousel') . '"');
                    ?>
                </div>
                <div class="supertemplatetabs">
                    <?php
                    $supertemplate_type = SuperCarousel_Common::get_array_value($supertemplate, 'type', 'Image');
                    ?>
                    <label class="superimage">
                        <input type="radio" name="supertemplate[type]" value="Image"<?php echo ($supertemplate_type == 'Image') ? ' checked=""' : ''; ?> /><span><span class="super_icon superimage"></span><?php _e('Image', 'supercarousel'); ?></span>
                    </label>
                    <label class="supercontent">
                        <input type="radio" name="supertemplate[type]" value="Content"<?php echo ($supertemplate_type == 'Content') ? ' checked=""' : ''; ?> /><span><span class="super_icon supercontent"></span><?php _e('Content', 'supercarousel'); ?></span>
                    </label>
                    <label class="superpost">
                        <input type="radio" name="supertemplate[type]" value="Post"<?php echo ($supertemplate_type == 'Post') ? ' checked=""' : ''; ?> /><span><span class="super_icon superpost"></span><?php _e('Post', 'supercarousel'); ?></span>
                    </label>
                    <label class="superyoutube">
                        <input type="radio" name="supertemplate[type]" value="YouTube"<?php echo ($supertemplate_type == 'YouTube') ? ' checked=""' : ''; ?> /><span><span class="super_icon superyoutube"></span><?php _e('YouTube', 'supercarousel'); ?></span>
                    </label>
                    <label class="superfeed">
                        <input type="radio" name="supertemplate[type]" value="Feeds"<?php echo ($supertemplate_type == 'Feeds') ? ' checked=""' : ''; ?> /><span><span class="super_icon superfeeds"></span><?php _e('Feeds', 'supercarousel'); ?></span>
                    </label>
                    <label class="superflickr">
                        <input type="radio" name="supertemplate[type]" value="Flickr"<?php echo ($supertemplate_type == 'Flickr') ? ' checked=""' : ''; ?> /><span><span class="super_icon superflickr"></span><?php _e('Flickr', 'supercarousel'); ?></span>
                    </label>
                </div>
                <div class="superexpertbutton">
                    <?php
                    $expertmode = SuperCarousel_Common::get_array_value($supertemplate, 'expertmode', 0);
                    ?>
                    <?php _e('Expert Mode', 'supercarousel'); ?> <label class="superonoff small"><input id="supertemplate_expertmode" onclick="supercarouselTemplate.supertemplate_mode(this)" value="1"<?php echo ($expertmode == '1') ? ' checked=""' : ''; ?> type="checkbox" name="supertemplate[expertmode]" /><span class="icon"></span>&nbsp;</label>
                </div>
                <div class="supersources">
                    <div class="superactive">
                        <div class="surow">
                            <div class="sucol-4">
                                <label><?php _e('Super Image:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-4">
                                <?php
                                $supertemplate_superimage = SuperCarousel_Common::get_array_value($supertemplate, 'superimage');
                                ?>
                                <select name="supertemplate[superimage]">
                                    <option value=""><?php _e('Select', 'supercarousel'); ?></option>
                                    <?php
                                    $super_images = get_posts(['post_type' => 'superimage', 'posts_per_page' => -1]);
                                    foreach ($super_images as $row) {
                                        ?>
                                        <option value="<?php echo $row->ID; ?>"<?php echo ($row->ID == $supertemplate_superimage) ? ' selected="selected"' : ''; ?>><?php echo $row->post_title; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Super Content -->
                    <div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Super Content:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-4">
                                <?php
                                $supertemplate_supercontent = SuperCarousel_Common::get_array_value($supertemplate, 'supercontent');
                                ?>
                                <select name="supertemplate[supercontent]">
                                    <option value=""><?php _e('Select', 'supercarousel'); ?></option>
                                    <?php
                                    $super_contents = get_terms(
                                            array(
                                                'taxonomy' => 'supercontentcat',
                                                'hide_empty' => true
                                            )
                                    );
                                    foreach ($super_contents as $row) {
                                        ?>
                                        <option value="<?php echo $row->term_id; ?>"<?php echo ($supertemplate_supercontent == $row->term_id) ? ' selected="selected"' : ''; ?>><?php echo $row->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Order By:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-4">
                                <?php
                                $orderbyarr = ['none', 'ID', 'author', 'title', 'name', 'date', 'modified', 'parent', 'rand', 'comment_count', 'menu_order'];
                                $contentpostorderby = SuperCarousel_Common::get_array_value($supertemplate, 'contentpostorderby', 'none');
                                ?>
                                <select name="supertemplate[contentpostorderby]">
                                    <?php
                                    foreach ($orderbyarr as $orderby) {
                                        ?>
                                        <option value="<?php echo $orderby; ?>"<?php echo ($contentpostorderby == $orderby) ? ' selected="selected"' : ''; ?>><?php echo $orderby; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="sucol-2">
                                <?php
                                $contentpostorder = SuperCarousel_Common::get_array_value($supertemplate, 'contentpostorder', 'ASC');
                                ?>
                                <select name="supertemplate[contentpostorder]">
                                    <option value="ASC"<?php echo ($contentpostorder == 'ASC') ? ' selected="selected"' : ''; ?>><?php _e('ASC', 'supercarousel'); ?></option>
                                    <option value="DESC"<?php echo ($contentpostorder == 'DESC') ? ' selected="selected"' : ''; ?>><?php _e('DESC', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Limit:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-4">
                                <?php
                                $contentlimit = (int) SuperCarousel_Common::get_array_value($supertemplate, 'contentlimit', 10);
                                ?>
                                <input name="supertemplate[contentlimit]" type="number" min="0" max="50" value="<?php echo $contentlimit; ?>" />
                            </div>
                        </div>
                    </div>
                    <!-- Post -->
                    <div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Filter By:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-6">
                                <input type="text" id="supertem_filter_keyword" placeholder="<?php _e('Enter any post type, taxonomy, tag or title', 'supercarousel'); ?>" />
                                <?php
                                $post_filters = SuperCarousel_Common::get_array_value($supertemplate, 'postfilter', []);
                                $post_filters_label = SuperCarousel_Common::get_array_value($supertemplate, 'postfilterlabel', []);
                                ?>
                                <div class="supertem_post_filters" id="supertem_post_filters">
                                    <?php
                                    foreach ($post_filters as $k => $pf) {
                                        ?>
                                        <div>
                                            <input type="hidden" name="supertemplate[postfilter][]" value="<?php echo $pf; ?>" />
                                            <input type="hidden" name="supertemplate[postfilterlabel][]" value="<?php echo $post_filters_label[$k]; ?>" />
                                            <div class="su_element_delete" onclick="supercarouselTemplate.removePostFilter(this);"><span class="dashicons dashicons-trash"></span></div>
                                            <span><?php echo $post_filters_label[$k]; ?></span>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Order By:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-4">
                                <?php
                                $orderbyarr = ['none', 'ID', 'author', 'title', 'name', 'date', 'modified', 'parent', 'rand', 'comment_count', 'menu_order'];
                                $postorderby = SuperCarousel_Common::get_array_value($supertemplate, 'postorderby', 'none');
                                ?>
                                <select name="supertemplate[postorderby]">
                                    <?php
                                    foreach ($orderbyarr as $orderby) {
                                        ?>
                                        <option value="<?php echo $orderby; ?>"<?php echo ($postorderby == $orderby) ? ' selected="selected"' : ''; ?>><?php echo $orderby; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="sucol-2">
                                <?php
                                $postorder = SuperCarousel_Common::get_array_value($supertemplate, 'postorder', 'ASC');
                                ?>
                                <select name="supertemplate[postorder]">
                                    <option value="ASC"<?php echo ($postorder == 'ASC') ? ' selected="selected"' : ''; ?>><?php _e('ASC', 'supercarousel'); ?></option>
                                    <option value="DESC"<?php echo ($postorder == 'DESC') ? ' selected="selected"' : ''; ?>><?php _e('DESC', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Posts with Featured Image:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-4">
                                <?php
                                $postfeaturedimage = SuperCarousel_Common::get_array_value($supertemplate, 'postfeaturedimage', 'no');
                                ?>
                                <select name="supertemplate[postfeaturedimage]">
                                    <option value="no"<?php echo ($postfeaturedimage == 'no') ? ' selected="selected"' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="yes"<?php echo ($postfeaturedimage == 'yes') ? ' selected="selected"' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Limit:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-6">
                                <?php
                                $postlimit = (int) SuperCarousel_Common::get_array_value($supertemplate, 'postlimit', 7);
                                ?>
                                <input name="supertemplate[postlimit]" type="number" min="0" max="50" value="<?php echo $postlimit; ?>" />
                            </div>
                        </div>
                    </div>
                    <!-- Youtube -->
                    <div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('YouTube Playlist URL:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-6">
                                <?php
                                $youtubeurl = SuperCarousel_Common::get_array_value($supertemplate, 'youtubeurl');
                                ?>
                                <input type="text" class="superyoutubeurl" name="supertemplate[youtubeurl]" value="<?php echo $youtubeurl; ?>" placeholder="https://www.youtube.com/playlist?list={<?php _e('playlistid', 'supercarousel'); ?>}" />
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('API Key:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-6">
                                <?php
                                $youtubeapi = SuperCarousel_Common::get_array_value($supertemplate, 'youtubeapi');
                                ?>
                                <input type="text" class="superyoutubeapi" name="supertemplate[youtubeapi]" value="<?php echo $youtubeapi; ?>" placeholder="<?php _e('API Key', 'supercarousel'); ?>" />
                                <br />
                                <a href="https://developers.google.com/youtube/registering_an_application" target="_blank"><?php _e('Where do I get the API Key?', 'supercarousel'); ?></a> 
                                | 
                                <a href="javascript: void(0);" onclick="supercarouselTemplate.checkYouTubeAPI();"><?php _e('Test API and URL', 'supercarousel'); ?></a>
                                <br />
                                <span class="supercarousel_youtube_status"></span>
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Limit:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-8">
                                <?php
                                $youtubelimit = SuperCarousel_Common::get_array_value($supertemplate, 'youtubelimit', 5);
                                ?>
                                <input type="number" name="supertemplate[youtubelimit]" min="0" max="50" value="<?php echo $youtubelimit; ?>" />
                            </div>
                        </div>
                    </div>
                    <!-- Feeds -->
                    <div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Feeds URL:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-6">
                                <?php
                                $feedurl = SuperCarousel_Common::get_array_value($supertemplate, 'feedurl');
                                ?>
                                <input type="text" name="supertemplate[feedurl]" value="<?php echo $feedurl; ?>" />
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Limit:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-1">
                                <?php
                                $feedlimit = (int) SuperCarousel_Common::get_array_value($supertemplate, 'feedlimit', 10);
                                ?>
                                <input type="number" name="supertemplate[feedlimit]" min="0" max="20" value="<?php echo $feedlimit ?>" />
                            </div>
                            <div class="sucol-2">
                                <?php
                                $feedorder = SuperCarousel_Common::get_array_value($supertemplate, 'feedorder');
                                ?>
                                <select name="supertemplate[feedorder]">
                                    <option value="ASC"<?php echo ($feedorder == 'ASC') ? ' selected=""' : ''; ?>><?php _e('ASC', 'supercarousel'); ?></option>
                                    <option value="DESC"<?php echo ($feedorder == 'DESC') ? ' selected=""' : ''; ?>><?php _e('DESC', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Custom Image Tag:', 'supercarousel'); ?></label>
                            </div>
                            <div class="sucol-3">
                                <?php
                                $feed_image_tag = SuperCarousel_Common::get_array_value($supertemplate, 'feed_image_tag');
                                ?>
                                <input type="text" name="supertemplate[feed_image_tag]" value="<?php echo $feed_image_tag; ?>" />
                            </div>
                        </div>
                    </div>
                    <!-- Flickr -->
                    <div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Flickr Album / Group URL:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-6">
                                <?php
                                $flickrurl = SuperCarousel_Common::get_array_value($supertemplate, 'flickrurl');
                                ?>
                                <input class="superflickrurl" type="text" name="supertemplate[flickrurl]" value="<?php echo $flickrurl; ?>" placeholder="https://www.flickr.com/photos/{<?php _e('userid', 'supercarousel'); ?>}/albums/{<?php _e('albumid', 'supercarousel'); ?>}" />
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('API Key:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-6">
                                <?php
                                $flickrapi = SuperCarousel_Common::get_array_value($supertemplate, 'flickrapi');
                                ?>
                                <input type="text" class="superflickrapi" name="supertemplate[flickrapi]" value="<?php echo $flickrapi; ?>" placeholder="<?php _e('API Key', 'supercarousel'); ?>" />
                                <br />
                                <a href="https://www.flickr.com/services/api/keys/" target="_blank"><?php _e('Where do I get the API Key?', 'supercarousel'); ?></a> 
                                | 
                                <a href="javascript: void(0);" onclick="supercarouselTemplate.checkFlickrAPI();"><?php _e('Test API and URL', 'supercarousel'); ?></a>
                                <br />
                                <span class="supercarousel_flickr_status"></span>
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-3">
                                <label><?php _e('Limit:', 'supercarousel'); ?> </label>
                            </div>
                            <div class="sucol-3">
                                <?php
                                $flickrlimit = (int) SuperCarousel_Common::get_array_value($supertemplate, 'flickrlimit', 10);
                                ?>
                                <input type="number" name="supertemplate[flickrlimit]" min="0" max="50" value="<?php echo $flickrlimit; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="super_visual_expertmodes">
                    <div class="su_visualmode">
                        <div class="surow">
                            <div class="sucol-6">
                                <div class="sc_box">
                                    <h4 class="sc_box_heading"><?php _e('Preview', 'supercarousel'); ?></h4>
                                    <div class="sc_box_content">
                                        <div class="supertemplate_defined">
                                            <div class="supertemplate_defined_loader"></div>
                                            <div class="surow">
                                                <div class="sucol-6">
                                                    <select id="sel_load_previewtem">
                                                        <option value=""><?php _e('Load Template', 'supercarousel'); ?></option>
                                                    </select>
                                                </div>
                                                <div class="sucol-6">
                                                    <input type="text" id="name_previewtem" placeholder="<?php _e('Template Name', 'supercarousel'); ?>" />
                                                </div>
                                            </div>
                                            <div class="surow supertemplate_defined_button">
                                                <div class="sucol-6">
                                                    <button type="button" id="btn_load_previewtem" style="display: none;" class="superbluebtn small"><?php _e('Load', 'supercarousel'); ?></button>
                                                    <button type="button" id="btn_save_previewtem" class="superbluebtn small"><?php _e('Save', 'supercarousel'); ?></button>
                                                </div>
                                                <div class="sucol-6 right-text">
                                                    <button type="button" id="btn_delete_previewtem" class="superredbtn small" disabled=""><?php _e('Delete', 'supercarousel'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="supertemplatepreview" class="supertemplatepreview">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sucol-6">
                                <div class="sc_box">
                                    <h4 class="sc_box_heading"><?php _e('Properties', 'supercarousel'); ?></h4>
                                    <div class="sc_box_content">
                                        <div class="su_accordion">
                                            <div class="su_accourion_panel su_accordion_active">
                                                <h4 class="su_accordion_heading suslideprop"><?php _e('Slide', 'supercarousel'); ?></h4>
                                                <div class="su_accordion_content">
                                                    <div id="suslideproperty"><?php _e('No Property', 'supercarousel'); ?></div>
                                                </div>
                                            </div>
                                            <div class="su_accourion_panel">
                                                <h4 class="su_accordion_heading suelementprop"><?php _e('Element', 'supercarousel'); ?> <span class="supropelementname"></span></h4>
                                                <div class="su_accordion_content">
                                                    <div id="suelementproperty"><?php _e('No Property', 'supercarousel'); ?></div>
                                                </div>
                                            </div>
                                            <div class="su_accourion_panel">
                                                <h4 class="su_accordion_heading suhoverelementprop"><?php _e('Element Hover', 'supercarousel'); ?> <span class="supropelementname"></span></h4>
                                                <div class="su_accordion_content">
                                                    <div id="suelementoverproperty"><?php _e('No Property', 'supercarousel'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sc_box">
                                    <h4 class="sc_box_heading"><?php _e('Elements', 'supercarousel'); ?></h4>
                                    <div class="sc_box_content">
                                        <div class="surow">
                                            <div class="sucol-5">
                                                <select size="2" ondblclick="supercarouselTemplate.addElement();" class="supertab_elements" id="supertab_elements"></select>
                                            </div>
                                            <div class="sucol-7">
                                                <div class="supertab_selected_elements" id="supertab_selected_elements">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="su_expertmode" style="display: none;">
                        <div class="surow">
                            <div class="sucol-6">
                                <div class="sc_box">
                                    <h4 class="sc_box_heading"><?php _e('HTML', 'supercarousel'); ?></h4>
                                    <div class="sc_box_content">
                                        <?php
                                        $experthtml_Image = SuperCarousel_Common::get_array_value($supertemplate, 'experthtml_Image', '');
                                        $experthtml_Content = SuperCarousel_Common::get_array_value($supertemplate, 'experthtml_Content', '');
                                        $experthtml_Post = SuperCarousel_Common::get_array_value($supertemplate, 'experthtml_Post', '');
                                        $experthtml_YouTube = SuperCarousel_Common::get_array_value($supertemplate, 'experthtml_YouTube', '');
                                        $experthtml_Feeds = SuperCarousel_Common::get_array_value($supertemplate, 'experthtml_Feeds', '');
                                        $experthtml_Flickr = SuperCarousel_Common::get_array_value($supertemplate, 'experthtml_Flickr', '');
                                        ?>
                                        <textarea id="super_htmlcode_Image" name="supertemplate[experthtml_Image]"><?php echo $experthtml_Image; ?></textarea>
                                        <textarea id="super_htmlcode_Content" name="supertemplate[experthtml_Content]"><?php echo $experthtml_Content; ?></textarea>
                                        <textarea id="super_htmlcode_Post" name="supertemplate[experthtml_Post]"><?php echo $experthtml_Post; ?></textarea>
                                        <textarea id="super_htmlcode_YouTube" name="supertemplate[experthtml_YouTube]"><?php echo $experthtml_YouTube; ?></textarea>
                                        <textarea id="super_htmlcode_Feeds" name="supertemplate[experthtml_Feeds]"><?php echo $experthtml_Feeds; ?></textarea>
                                        <textarea id="super_htmlcode_Flickr" name="supertemplate[experthtml_Flickr]"><?php echo $experthtml_Flickr; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="sucol-6">
                                <div class="sc_box">
                                    <h4 class="sc_box_heading"><?php _e('Global CSS', 'supercarousel'); ?></h4>
                                    <div class="sc_box_content">
                                        <?php
                                        $super_csscode_global = stripslashes(get_option('super_csscode_global'));
                                        ?>
                                        <textarea id="super_csscode_global" name="super_csscode_global"><?php echo $super_csscode_global; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                        <div class="surow">
                            <div class="sucol-12">
                                <label><?php _e('Variables', 'supercarousel'); ?></label>
                                <div id="su_template_var_Image" class="su_template_vars">
                                    <span>{imageid}</span>
                                    <?php echo $regimage_sizes; ?>
                                    <span>{title}</span>
                                    <span>{lightboxurl}</span>
                                    <span>{linkurl}</span>
                                    <span>{target}</span>
                                    <span>{caption}</span>
                                </div>
                                <div id="su_template_var_Content" class="su_template_vars">
                                    <span>{title}</span>
                                    <span>{content}</span>
                                    <span>{excerpt}</span>
                                    <span>{categories}</span>
                                </div>
                                <div id="su_template_var_Post" class="su_template_vars">
                                    <?php echo $regimage_sizes; ?>
                                    <span>{title}</span>
                                    <span>{content}</span>
                                    <span>{excerpt}</span>
                                    <span>{postauthor}</span>
                                    <span>{slug}</span>
                                    <span>{permalink}</span>
                                    <span>{date}</span>
                                    <span>{taxonomies}</span>
                                    <span>{categories}</span>
                                    <span>{tags}</span>
                                    <span>{postmeta|postmeta:METANAME}</span>
                                </div>
                                <div id="su_template_var_YouTube" class="su_template_vars">
                                    <span>{image_default}</span>
                                    <span>{image_thumbnails}</span>
                                    <span>{image_medium}</span>
                                    <span>{image_high}</span>
                                    <span>{image_standard}</span>
                                    <span>{image_full}</span>
                                    <span>{title}</span>
                                    <span>{description}</span>
                                    <span>{videoid}</span>
                                    <span>{videolink}</span>
                                    <span>{channelid}</span>
                                </div>
                                <div id="su_template_var_Feeds" class="su_template_vars">
                                    <span>{image}</span>
                                    <span>{title}</span>
                                    <span>{description}</span>
                                    <span>{itemlink}</span>
                                    <span>{optionalelement|category}</span>
                                    <span>{optionalelement|copyright}</span>
                                    <span>{optionalelement|author}</span>
                                </div>
                                <div id="su_template_var_Flickr" class="su_template_vars">
                                    <span>{image_small}</span>
                                    <span>{image_medium}</span>
                                    <span>{image_large}</span>
                                    <span>{image_full}</span>
                                    <span>{title}</span>
                                </div>
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-12">
                                <p class="supernotes">
                                    <?php _e('To use the fix height carousel, it must have one image tag with "super_image" class.eg. &lt;img src="{image_large}" class="super_image" /&gt;', 'supercarousel'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
        </div>
        <div class="sucol-3">
            <div class="super_save_box_position"></div>
            <div class="susettingbox supersettings_save_box">
                <h2>
                    <span class="super_icon_acc supersave"></span>
                    <?php _e('Save Changes', 'supercarousel'); ?>
                </h2>
                <div class="susettingboxcontent" id="supersaveactionbox">
                    <div class="surow supercarousel_shortcode_wrap">
                        <div class="sucol-12">
                            <?php
                            if ($id > 0) {
                                $slug = get_post_field('post_name', $id);
                                ?>
                                <input class="supercarousel_shortcode_ip" type="text" readonly="readonly" value="[supercarousel slug='<?php echo $slug; ?>']" onclick="this.select();" onfocus="this.select();" />
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-6">
                            <button type="button" onclick="SupercarouselCommon.delete_supercarousel('<?php echo $id; ?>');" class="superredbtn small"><span class="dashicons dashicons-trash"></span> <?php _e('Delete', 'supercarousel'); ?></button>
                        </div>
                        <div class="sucol-6 right-text">
                            <button type="submit" class="superbluebtn small"><span class="dashicons dashicons-thumbs-up"></span> <?php _e('Save', 'supercarousel'); ?></button>
                        </div>
                    </div>
                    <div class="su_status" style="display: none;"></div>
                </div>
            </div>
            <div class="susettingbox">
                <h2>
                    <span class="super_icon_acc superresponsive"></span>
                    <?php _e('Responsive', 'supercarousel'); ?>
                    <span class="susettingtoggle fr dashicons dashicons-minus"></span>
                </h2>
                <div class="susettingboxcontent superresponsive" id="superresponsivebox">
                    <div class="responsivegrid">
                        <div class="surow">
                            <div class="sucol-6 centered">
                                <div class="superrespcolinnerwrap">
                                    Desktop Large [Max]
                                    <div class="superresponsivehead">
                                        <span class="super_icon_responsive superdesktop"></span>
                                        <?php
                                        $respdesktop = SuperCarousel_Common::get_array_value($supertemplate, 'respdesktop', 'visible');
                                        ?>
                                        <select class="superresponsivesel" name="supertemplate[respdesktop]">
                                            <option value="visible"<?php echo ($respdesktop == 'visible') ? ' selected="selected"' : ''; ?>><?php _e('Visible', 'supercarousel'); ?></option>
                                            <option value="fixwidth"<?php echo ($respdesktop == 'fixwidth') ? ' selected="selected"' : ''; ?>><?php _e('Fix Width', 'supercarousel'); ?></option>
                                            <option value="fixheight"<?php echo ($respdesktop == 'fixheight') ? ' selected="selected"' : ''; ?>><?php _e('Fix Height', 'supercarousel'); ?></option>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="suresp_visible"<?php echo (!($respdesktop == 'visible')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $respdesktopvisible = (int) SuperCarousel_Common::get_array_value($supertemplate, 'respdesktopvisible', 4);
                                            ?>
                                            <input name="supertemplate[respdesktopvisible]" min="1" max="10" type="number" placeholder="<?php _e('Visible', 'supercarousel'); ?>" value="<?php echo $respdesktopvisible; ?>" />
                                        </div>
                                        <div class="suresp_width"<?php echo (!($respdesktop == 'fixwidth')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $respdesktopwidth = (int) SuperCarousel_Common::get_array_value($supertemplate, 'respdesktopwidth', 200);
                                            ?>
                                            <input name="supertemplate[respdesktopwidth]" type="text" placeholder="<?php _e('eg. 200px', 'supercarousel'); ?>" value="<?php echo $respdesktopwidth; ?>" /> px
                                        </div>
                                        <div class="suresp_height"<?php echo (!($respdesktop == 'fixheight')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $respdesktopheight = (int) SuperCarousel_Common::get_array_value($supertemplate, 'respdesktopheight', 200);
                                            ?>
                                            <input name="supertemplate[respdesktopheight]" type="text" placeholder="<?php _e('eg. 200px', 'supercarousel'); ?>" value="<?php echo $respdesktopheight; ?>" /> px
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sucol-6 centered">
                                <div class="superrespcolinnerwrap">
                                    Notebook [<1200px]
                                    <div class="superresponsivehead">
                                        <span class="super_icon_responsive superlaptop"></span>
                                        <?php
                                        $resplaptop = SuperCarousel_Common::get_array_value($supertemplate, 'resplaptop', 'visible');
                                        ?>
                                        <select class="superresponsivesel" name="supertemplate[resplaptop]">
                                            <option value="visible"<?php echo ($resplaptop == 'visible') ? ' selected="selected"' : ''; ?>><?php _e('Visible', 'supercarousel'); ?></option>
                                            <option value="fixwidth"<?php echo ($resplaptop == 'fixwidth') ? ' selected="selected"' : ''; ?>><?php _e('Fix Width', 'supercarousel'); ?></option>
                                            <option value="fixheight"<?php echo ($resplaptop == 'fixheight') ? ' selected="selected"' : ''; ?>><?php _e('Fix Height', 'supercarousel'); ?></option>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="suresp_visible"<?php echo (!($resplaptop == 'visible')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $resplaptopvisible = (int) SuperCarousel_Common::get_array_value($supertemplate, 'resplaptopvisible', 4);
                                            ?>
                                            <input name="supertemplate[resplaptopvisible]" min="1" max="10" type="number" placeholder="<?php _e('Visible', 'supercarousel'); ?>" value="<?php echo $resplaptopvisible; ?>" />
                                        </div>
                                        <div class="suresp_width"<?php echo (!($resplaptop == 'fixwidth')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $resplaptopwidth = (int) SuperCarousel_Common::get_array_value($supertemplate, 'resplaptopwidth', 200);
                                            ?>
                                            <input name="supertemplate[resplaptopwidth]" type="text" placeholder="<?php _e('eg. 200px', 'supercarousel'); ?>" value="<?php echo $resplaptopwidth; ?>" /> px
                                        </div>
                                        <div class="suresp_height"<?php echo (!($resplaptop == 'fixheight')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $resplaptopheight = (int) SuperCarousel_Common::get_array_value($supertemplate, 'resplaptopheight', 200);
                                            ?>
                                            <input name="supertemplate[resplaptopheight]" type="text" placeholder="<?php _e('eg. 200px', 'supercarousel'); ?>" value="<?php echo $resplaptopheight; ?>" /> px
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="surow">
                            <div class="sucol-6 centered">
                                <div class="superrespcolinnerwrap">
                                    Tablet [<992px]
                                    <div class="superresponsivehead">
                                        <span class="super_icon_responsive supertablet"></span>
                                        <?php
                                        $resptab = SuperCarousel_Common::get_array_value($supertemplate, 'resptab', 'visible');
                                        ?>
                                        <select class="superresponsivesel" name="supertemplate[resptab]">
                                            <option value="visible"<?php echo ($resptab == 'visible') ? ' selected="selected"' : ''; ?>><?php _e('Visible', 'supercarousel'); ?></option>
                                            <option value="fixwidth"<?php echo ($resptab == 'fixwidth') ? ' selected="selected"' : ''; ?>><?php _e('Fix Width', 'supercarousel'); ?></option>
                                            <option value="fixheight"<?php echo ($resptab == 'fixheight') ? ' selected="selected"' : ''; ?>><?php _e('Fix Height', 'supercarousel'); ?></option>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="suresp_visible"<?php echo (!($resptab == 'visible')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $resptabvisible = (int) SuperCarousel_Common::get_array_value($supertemplate, 'resptabvisible', 4);
                                            ?>
                                            <input name="supertemplate[resptabvisible]" min="1" max="10" type="number" placeholder="<?php _e('Visible', 'supercarousel'); ?>" value="<?php echo $resptabvisible; ?>" />
                                        </div>
                                        <div class="suresp_width"<?php echo (!($resptab == 'fixwidth')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $resptabwidth = SuperCarousel_Common::get_array_value($supertemplate, 'resptabwidth', 200);
                                            ?>
                                            <input name="supertemplate[resptabwidth]" type="text" placeholder="<?php _e('eg. 200px', 'supercarousel'); ?>" value="<?php echo $resptabwidth; ?>" /> px
                                        </div>
                                        <div class="suresp_height"<?php echo (!($resptab == 'fixheight')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $resptabheight = SuperCarousel_Common::get_array_value($supertemplate, 'resptabheight', 200);
                                            ?>
                                            <input name="supertemplate[resptabheight]" type="text" placeholder="<?php _e('eg. 200px', 'supercarousel'); ?>" value="<?php echo $resptabheight; ?>" /> px
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sucol-6 centered">
                                <div class="superrespcolinnerwrap">
                                    Mobile [<450px] 
                                    <div class="superresponsivehead">
                                        <span class="super_icon_responsive supermobile"></span>
                                        <?php
                                        $respmob = SuperCarousel_Common::get_array_value($supertemplate, 'respmob', 'visible');
                                        ?>
                                        <select class="superresponsivesel" name="supertemplate[respmob]">
                                            <option value="visible"<?php echo ($respmob == 'visible') ? ' selected=""' : ''; ?>><?php _e('Visible', 'supercarousel'); ?></option>
                                            <option value="fixwidth"<?php echo ($respmob == 'fixwidth') ? ' selected=""' : ''; ?>><?php _e('Fix Width', 'supercarousel'); ?></option>
                                            <option value="fixheight"<?php echo ($respmob == 'fixheight') ? ' selected=""' : ''; ?>><?php _e('Fix Height', 'supercarousel'); ?></option>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="suresp_visible"<?php echo (!($respmob == 'visible')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $respmobvisible = (int) SuperCarousel_Common::get_array_value($supertemplate, 'respmobvisible', 1);
                                            ?>
                                            <input name="supertemplate[respmobvisible]" min="1" max="10" type="number" placeholder="<?php _e('Visible', 'supercarousel'); ?>" value="<?php echo $respmobvisible; ?>" />
                                        </div>
                                        <div class="suresp_width"<?php echo (!($respmob == 'fixwidth')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $respmobwidth = SuperCarousel_Common::get_array_value($supertemplate, 'respmobwidth', 200);
                                            ?>
                                            <input name="supertemplate[respmobwidth]" type="text" placeholder="<?php _e('eg. 200px', 'supercarousel'); ?>" value="<?php echo $respmobwidth; ?>" /> px
                                        </div>
                                        <div class="suresp_height"<?php echo (!($respmob == 'fixheight')) ? ' style="display: none;"' : ''; ?>>
                                            <?php
                                            $respmobheight = SuperCarousel_Common::get_array_value($supertemplate, 'respmobheight', 200);
                                            ?>
                                            <input name="supertemplate[respmobheight]" type="text" placeholder="<?php _e('eg. 200px', 'supercarousel'); ?>" value="<?php echo $respmobheight; ?>" /> px
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="superrespcustom">
                        <?php
                        if ($id > 0) {
                            $customresponsives = SuperCarousel_Common::get_array_value($supertemplate, 'customrespby', []);
                            foreach ($customresponsives as $k => $customresponsive) {
                                ?>
                                <div class="responsivegrid">
                                    <div class="surow">
                                        <div class="sucol-6 centered">
                                            <div class="superrespcolinnerwrap">Min
                                                <div>
                                                    <?php
                                                    $customrespmin = SuperCarousel_Common::get_array_value($supertemplate, 'customrespmin', []);
                                                    ?>
                                                    <input name="supertemplate[customrespmin][]" value="<?php echo $customrespmin[$k]; ?>" type="text"> px
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sucol-6 centered">
                                            <div class="superrespcolinnerwrap">Max
                                                <div>
                                                    <?php
                                                    $customrespmax = SuperCarousel_Common::get_array_value($supertemplate, 'customrespmax', []);
                                                    ?>
                                                    <input name="supertemplate[customrespmax][]" value="<?php echo $customrespmax[$k]; ?>" type="text"> px
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="surow">
                                        <div class="sucol-12 centered">
                                            <div class="superrespcolinnerwrap">
                                                <div class="superresponsivehead">
                                                    <select class="superresponsivesel" name="supertemplate[customrespby][]">
                                                        <option value="visible"<?php echo ($customresponsive == 'visible') ? ' selected="selected"' : ''; ?>>Visible</option>
                                                        <option value="fixwidth"<?php echo ($customresponsive == 'fixwidth') ? ' selected="selected"' : ''; ?>>Fix Width</option>
                                                        <option value="fixheight"<?php echo ($customresponsive == 'fixheight') ? ' selected="selected"' : ''; ?>>Fix Height</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <div class="suresp_visible"<?php echo (!($customresponsive=='visible')) ? ' style="display: none;"' : ''; ?>>
                                                        <?php
                                                        $customrespvisible = SuperCarousel_Common::get_array_value($supertemplate, 'customrespvisible', []);
                                                        ?>
                                                        <input name="supertemplate[customrespvisible][]" min="1" max="10" placeholder="Visible" value="<?php echo $customrespvisible[$k]; ?>" type="number" />
                                                    </div>
                                                    <div class="suresp_width"<?php echo (!($customresponsive=='fixwidth')) ? ' style="display: none;"' : ''; ?>>
                                                        <?php
                                                        $customrespwidth = SuperCarousel_Common::get_array_value($supertemplate, 'customrespwidth', []);
                                                        ?>
                                                        <input name="supertemplate[customrespwidth][]" placeholder="Fix Width" value="<?php echo $customrespwidth[$k]; ?>" type="text" /> px
                                                    </div>
                                                    <div class="suresp_height"<?php echo (!($customresponsive=='fixheight')) ? ' style="display: none;"' : ''; ?>>
                                                        <?php
                                                        $customrespheight = SuperCarousel_Common::get_array_value($supertemplate, 'customrespheight', []);
                                                        ?>
                                                        <input name="supertemplate[customrespheight][]" placeholder="Fix Height" value="<?php echo $customrespheight[$k]; ?>" type="text" /> px
                                                    </div>
                                                </div>
                                                <a href="javascript: void(0);" class="superredbtn small" onclick="supercarouselTemplate.removeResponsive(this);">- Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="surow">
                        <div class="sucol-12 centered">
                            <a href="javascript: void(0);" class="superbluebtn small" onclick="supercarouselTemplate.addCustomResponsive();">+ <?php echo _e('Add Custom Option', 'supercarousel'); ?></a>
                            <p class="supernotes"><?php _e('There must be an image selected to use fix height carousel.', 'supercarousel'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            <div class="susettingbox">
                <h2>
                    <span class="super_icon_acc superanimation"></span>
                    <?php _e('Animation', 'supercarousel'); ?>
                    <span class="susettingtoggle fr dashicons dashicons-plus"></span>
                </h2>
                <div class="susettingboxcontent supersettingfields" id="superresponsivebox" style="display: none;">
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Direction', 'supercarousel'); ?>
                                </label>
                                <?php
                                $sudirection = SuperCarousel_Common::get_array_value($supertemplate, 'direction');
                                ?>
                                <select name="supertemplate[direction]">
                                    <option value="left"<?php echo ($sudirection == 'left') ? ' selected=""' : ''; ?>><?php _e('Left', 'supercarousel'); ?></option>
                                    <option value="right"<?php echo ($sudirection == 'right') ? ' selected=""' : ''; ?>><?php _e('Right', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Effect', 'supercarousel'); ?>
                                </label>
                                <?php
                                $sueffect = SuperCarousel_Common::get_array_value($supertemplate, 'effect');
                                ?>
                                <select name="supertemplate[effect]">
                                    <option value="slide"<?php echo ($sueffect == 'slide') ? ' selected=""' : ''; ?>><?php _e('Slide', 'supercarousel'); ?></option>
                                    <option value="focus"<?php echo ($sueffect == 'focus') ? ' selected=""' : ''; ?>><?php _e('Focus', 'supercarousel'); ?></option>
                                    <option value="fade"<?php echo ($sueffect == 'fade') ? ' selected=""' : ''; ?>><?php _e('Fade', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Easing', 'supercarousel'); ?>
                                </label>
                                <?php
                                $sueasing = SuperCarousel_Common::get_array_value($supertemplate, 'easing');
                                $easings = SuperCarousel_Common::get_easing_list();
                                ?>
                                <select name="supertemplate[easing]">
                                    <?php
                                    foreach ($easings as $easing) {
                                        ?>
                                        <option value="<?php echo $easing; ?>"<?php echo ($easing == $sueasing) ? ' selected=""' : ''; ?>><?php echo $easing; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Easing Time', 'supercarousel'); ?>
                                </label>
                                <?php
                                $sueasing_time = SuperCarousel_Common::get_array_value($supertemplate, 'easing_time', 400);
                                ?>
                                <input type="number" name="supertemplate[easing_time]" min="100" max="10000" value="<?php echo $sueasing_time; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Steps', 'supercarousel'); ?>
                                </label>
                                <?php
                                $steps = SuperCarousel_Common::get_array_value($supertemplate, 'steps', 1);
                                ?>
                                <input type="number" name="supertemplate[steps]" min="0" max="10" value="<?php echo $steps; ?>" />
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap"></div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-12 centered">
                            <div class="superrespcolinnerwrap">
                                <p class="supernotes"><strong><?php _e('Note:', 'supercarousel'); ?></strong> <?php _e('Easing Time is calculated in milliseconds, Step is the number of slides it will move in one go. <br />If you want full-width scroll, just put "0" in Step(s) box', 'supercarousel'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            <div class="susettingbox">
                <h2>
                    <span class="super_icon_acc superautomatic"></span>
                    <?php _e('Automatic', 'supercarousel'); ?>
                    <span class="susettingtoggle fr dashicons dashicons-plus"></span>
                </h2>
                <div class="susettingboxcontent supersettingfields" id="superresponsivebox" style="display: none;">
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Auto Play', 'supercarousel'); ?>
                                </label>
                                <?php
                                $suautoplay = SuperCarousel_Common::get_array_value($supertemplate, 'autoplay');
                                ?>
                                <select name="supertemplate[autoplay]">
                                    <option value="0"<?php echo ($suautoplay == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($suautoplay == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Pause Time', 'supercarousel'); ?>
                                </label>
                                <?php
                                $supause_time = SuperCarousel_Common::get_array_value($supertemplate, 'pause_time', 3000);
                                ?>
                                <input type="number" name="supertemplate[pause_time]" min="1000" max="20000" value="<?php echo $supause_time; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Pause Over', 'supercarousel'); ?>
                                </label>
                                <?php
                                $supause_over = SuperCarousel_Common::get_array_value($supertemplate, 'pause_over');
                                ?>
                                <select name="supertemplate[pause_over]">
                                    <option value="0"<?php echo ($supause_over == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($supause_over == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Auto Scroll', 'supercarousel'); ?>
                                </label>
                                <?php
                                $sucontinuous_scroll = SuperCarousel_Common::get_array_value($supertemplate, 'continuous_scroll');
                                ?>
                                <select name="supertemplate[continuous_scroll]">
                                    <option value="0"<?php echo ($sucontinuous_scroll == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($sucontinuous_scroll == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Scroll Speed', 'supercarousel'); ?>
                                </label>
                                <?php
                                $suscroll_speed = SuperCarousel_Common::get_array_value($supertemplate, 'scroll_speed', 1);
                                ?>
                                <input type="number" name="supertemplate[scroll_speed]" min="1" max="20" value="<?php echo $suscroll_speed; ?>" />
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Auto Height', 'supercarousel'); ?>
                                </label>
                                <?php
                                $suauto_height = SuperCarousel_Common::get_array_value($supertemplate, 'auto_height');
                                ?>
                                <select name="supertemplate[auto_height]">
                                    <option value="0"<?php echo ($suauto_height == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($suauto_height == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Randomize', 'supercarousel'); ?>
                                </label>
                                <?php
                                $surandomize = SuperCarousel_Common::get_array_value($supertemplate, 'randomize');
                                ?>
                                <select name="supertemplate[randomize]">
                                    <option value="0"<?php echo ($surandomize == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($surandomize == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Slide Gap', 'supercarousel'); ?>
                                </label>
                                <?php
                                $suslidegap = SuperCarousel_Common::get_array_value($supertemplate, 'slide_gap', 1);
                                ?>
                                <input type="number" name="supertemplate[slide_gap]" min="0" max="50" value="<?php echo $suslidegap; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Hidden Carousel', 'supercarousel'); ?>
                                </label>
                                <?php
                                $hidden_carousel = SuperCarousel_Common::get_array_value($supertemplate, 'hidden_carousel');
                                ?>
                                <select name="supertemplate[hidden_carousel]">
                                    <option value="0"<?php echo ($hidden_carousel == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($hidden_carousel == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap"></div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-12 centered">
                            <div class="superrespcolinnerwrap">
                                <p class="supernotes"><strong><?php _e('Note:', 'supercarousel'); ?></strong> <?php _e('Pause Time is calculated in miliseconds. Slide Gap is calculated in pixels.', 'supercarousel'); ?>
                                    <?php _e('Pause time must always greater than easing time.<br />Continuous Scroll overwrites autoplay settings.', 'supercarousel'); ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            <div class="susettingbox">
                <h2>
                    <span class="super_icon_acc supernavigation"></span>
                    <?php _e('Navigation', 'supercarousel'); ?>
                    <span class="susettingtoggle fr dashicons dashicons-plus"></span>
                </h2>
                <div class="susettingboxcontent supersettingfields" id="superresponsivebox" style="display: none;">
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Next / Prev', 'supercarousel'); ?>
                                </label>
                                <?php
                                $sunp = SuperCarousel_Common::get_array_value($supertemplate, 'next_prev');
                                ?>
                                <select name="supertemplate[next_prev]">
                                    <option value="0"<?php echo ($sunp == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($sunp == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Arrow Style', 'supercarousel'); ?>
                                </label>
                                <?php
                                $suarrow_style = SuperCarousel_Common::get_array_value($supertemplate, 'arrow_style');
                                ?>
                                <select name="supertemplate[arrow_style]" id="super_arrow_style" onchange="supercarouselTemplate.displayArrowStyle();">
                                    <?php
                                    for ($i = 1; $i <= 8; $i++) {
                                        ?>
                                        <option value="<?php echo "style$i-black"; ?>"<?php echo ($suarrow_style == "style$i-black") ? ' selected=""' : ''; ?>><?php echo "Style$i-Black"; ?></option>
                                        <option value="<?php echo "style$i-black-small"; ?>"<?php echo ($suarrow_style == "style$i-black-small") ? ' selected=""' : ''; ?>><?php echo "Style$i-Black"; ?> Small</option>
                                        <option value="<?php echo "style$i-white"; ?>"<?php echo ($suarrow_style == "style$i-white") ? ' selected=""' : ''; ?>><?php echo "Style$i-White"; ?></option>
                                        <option value="<?php echo "style$i-white-small"; ?>"<?php echo ($suarrow_style == "style$i-white-small") ? ' selected=""' : ''; ?>><?php echo "Style$i-White"; ?> Small</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-12">
                            <div class="superrespcolinnerwrap">
                                <div id="super_arrow_preview" class="preview_<?php echo $suarrow_style; ?>">
                                    <div class="preview_prev"></div>
                                    <div class="preview_next"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Arrow Outside', 'supercarousel'); ?>
                                </label>
                                <?php
                                $suarrowsout = SuperCarousel_Common::get_array_value($supertemplate, 'arrowsout');
                                ?>
                                <select name="supertemplate[arrowsout]">
                                    <option value="0"<?php echo ($suarrowsout == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($suarrowsout == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Circular', 'supercarousel'); ?>
                                </label>
                                <?php
                                $sucircular = SuperCarousel_Common::get_array_value($supertemplate, 'circular');
                                ?>
                                <select name="supertemplate[circular]">
                                    <option value="0"<?php echo ($sucircular == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($sucircular == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Mouse Wheel', 'supercarousel'); ?>
                                </label>
                                <?php
                                $sumousewheel = SuperCarousel_Common::get_array_value($supertemplate, 'mousewheel');
                                ?>
                                <select name="supertemplate[mousewheel]">
                                    <option value="0"<?php echo ($sumousewheel == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($sumousewheel == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Touch Swipe', 'supercarousel'); ?>
                                </label>
                                <?php
                                $sutouchswipe = SuperCarousel_Common::get_array_value($supertemplate, 'touchswipe');
                                ?>
                                <select name="supertemplate[touchswipe]">
                                    <option value="0"<?php echo ($sutouchswipe == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($sutouchswipe == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Keyboard', 'supercarousel'); ?>
                                </label>
                                <?php
                                $sukeyboard = SuperCarousel_Common::get_array_value($supertemplate, 'keyboard');
                                ?>
                                <select name="supertemplate[keyboard]">
                                    <option value="0"<?php echo ($sukeyboard == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($sukeyboard == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="sucol-6">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Pagination', 'supercarousel'); ?>
                                </label>
                                <?php
                                $supagination = SuperCarousel_Common::get_array_value($supertemplate, 'pagination');
                                ?>
                                <select name="supertemplate[pagination]">
                                    <option value="0"<?php echo ($supagination == '0') ? ' selected=""' : ''; ?>><?php _e('No', 'supercarousel'); ?></option>
                                    <option value="1"<?php echo ($supagination == '1') ? ' selected=""' : ''; ?>><?php _e('Yes', 'supercarousel'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-12 centered">
                            <div class="superrespcolinnerwrap">
                                <p class="supernotes"><strong><?php _e('Note:', 'supercarousel'); ?></strong> <?php _e('Keyboard enables next/prev/up/down arrow keys and numeric keys.', 'supercarousel'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            <div class="susettingbox">
                <h2>
                    <span class="super_icon_acc supermisc"></span>
                    <?php _e('Miscellaneous', 'supercarousel'); ?>
                    <span class="susettingtoggle fr dashicons dashicons-plus"></span>
                </h2>
                <div class="susettingboxcontent supersettingfields" id="supermiscbox" style="display: none;">
                    <div class="surow">
                        <div class="sucol-12">
                            <div class="superrespcolinnerwrap">
                                <label>
                                    <?php _e('Wrapper Class', 'supercarousel'); ?>
                                </label>
                                <?php
                                $wrapper_class = SuperCarousel_Common::get_array_value($supertemplate, 'wrapper_class');
                                ?>
                                <input type="text" name="supertemplate[wrapper_class]" value="<?php echo $wrapper_class; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>