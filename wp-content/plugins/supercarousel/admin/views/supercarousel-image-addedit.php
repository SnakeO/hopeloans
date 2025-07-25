<?php
$id = (int) SuperCarousel_Common::super_get_get('id');
$act = SuperCarousel_Common::super_get_get('act');

$super_title = '';
$superimages = array('id' => array());
if ($id > 0 and $act == 'edit') {
    $super_title = get_the_title($id);
    $superimages_str = get_post_meta($id, 'superimages', true);
    if ($superimages_str != '') {
        $superimages = SuperCarousel_Common::super_unserialize($superimages_str);
    }
}

if (!count($superimages)) {
    $superimages = array('id' => array());
}
?>
<form name="supercarouselform" id="supercarouselform" method="post" onsubmit="return SupercarouselCommon.supercarousel_save(this);">
    <input type="hidden" name="action" value="supercarouseladmin" />
    <input type="hidden" name="superaction" value="save_superimage" />
    <input type="hidden" name="page" value="superimage" />
    <input type="hidden" name="act" value="<?php echo $act; ?>" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <div class="surow">
        <div class="sucol-9">
            <div class="supercarouseladdedit superform">
                <div class="carousel_title">
                    <?php
                    echo SuperCarousel_Common::generate_super_textbox('super_title', $super_title, ' required="" placeholder="' . __('Carousel Title', 'supercarousel') . '"');
                    ?>
                </div>
                <br />
                <div class="carouseladminwrapper">
                    <div class="surow">
                        <div class="sucol-6">
                            <button type="button" class="superbluebtn super_select_image" data-multiple="1" data-callback="SupercarouselImage.add_images_superimage"><span class="dashicons dashicons-format-gallery"></span> <?php _e('Add Images', 'supercarousel'); ?></button>
                        </div>
                        <div class="sucol-6 right-text">
                            <label class="superonoff small"><input id="superimageexpand_button" onclick="SupercarouselImage.superimage_toggle_expand(this)" type="checkbox" /><span class="icon"></span>&nbsp;<span>&nbsp;<?php _e('Expand', 'supercarousel'); ?></span></label>
                        </div>
                    </div>
                    <div class="supercarousel-images superthumbs">
                        <?php
                        foreach ($superimages['id'] as $i => $row) {
                            ?>
                            <div class="supercarousel-image">
                                <input type="hidden" name="superimage[id][]" value="<?php echo $superimages['id'][$i]; ?>" />
                                <a href="javascript: void(0);" onclick="SupercarouselImage.remove_super_image(this);" class="fr imagedetails expandimagedelete"><span class="dashicons dashicons-no-alt"></span></a>
                                <div class="superimgcaption">
                                    <div class="superimgwrap centered">
                                        <a href="javascript: void(0);" onclick="SupercarouselImage.remove_super_image(jQuery(this).parent().parent());" class="superthumbdelete"><span class="dashicons dashicons-no-alt"></span></a>
                                        <img class="superthumb" src="<?php echo wp_get_attachment_thumb_url($superimages['id'][$i]); ?>" />
                                        <a class="imagedetails superbluebtn small btnchangeimage super_select_image" data-multiple="0" data-callback="change_super_image"><span class="dashicons dashicons-format-image"></span> <?php _e('Change Image', 'supercarousel'); ?></a>
                                    </div>
                                    <div class="imagedetails">
                                        <textarea name="superimage[caption][]"><?php echo stripslashes($superimages['caption'][$i]); ?></textarea>
                                    </div>
                                </div>
                                <div class="imagedetails">
                                    <input type="text" name="superimage[lightbox][]" placeholder="<?php _e('Lightbox URL', 'supercarousel'); ?>" value="<?php echo stripslashes($superimages['lightbox'][$i]); ?>" />
                                    <input type="text" name="superimage[link][]" placeholder="<?php _e('Link URL', 'supercarousel'); ?>" value="<?php echo stripslashes($superimages['link'][$i]); ?>" />
                                    <input type="hidden" class="supertarget" name="superimage[newwindow][]" value="<?php echo $superimages['newwindow'][$i]; ?>" />
                                    <div class="superimgtarget">
                                        <label><?php _e('New Window', 'supercarousel'); ?>: </label>
                                        &nbsp;
                                        <label class="superonoff small"><input onclick="SupercarouselImage.super_change_target(this);" type="checkbox"<?php echo ($superimages['newwindow'][$i] == '1') ? ' checked="checked"' : ''; ?> /><span class="icon"></span></label>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <br class="clr" />
                </div>
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
        </div>
    </div>
</form>