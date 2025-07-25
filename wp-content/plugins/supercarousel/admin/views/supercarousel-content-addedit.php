<?php
$post_id = $id = (int) SuperCarousel_Common::super_get_get('id');
$act = SuperCarousel_Common::super_get_get('act');

$super_title = '';
$super_content = '';
$super_excerpt = '';
$content_menu_order = 0;
if ($id > 0 and $act == 'edit') {
    $content_post = get_post($id);
    $super_title = $content_post->post_title;
    $super_content = $content_post->post_content;
    $super_excerpt = $content_post->post_excerpt;
    $content_menu_order = $content_post->menu_order;
}
?>
<form name="supercarouselform" id="supercarouselform" method="post" onsubmit="return SupercarouselCommon.supercarousel_save(this);">
    <input type="hidden" name="action" value="supercarouseladmin" />
    <input type="hidden" name="superaction" value="save_supercontent" />
    <input type="hidden" name="page" value="supercontent" />
    <input type="hidden" name="act" value="<?php echo $act; ?>" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <div class="surow">
        <div class="sucol-9">
            <div class="supercarouseladdedit superform">
                <div class="carousel_title">
                    <?php
                    echo SuperCarousel_Common::generate_super_textbox('super_title', $super_title, ' required="" placeholder="' . __('Content Title', 'supercarousel') . '"');
                    ?>
                </div>
                <br />
                <div class="sc_box supernomargin">
                    <h4 class="sc_box_heading"><?php _e('Super Content', 'supercarousel'); ?></h4>
                    <div class="sc_box_content">
                        <?php
                        wp_editor($super_content, 'super_content', ['editor_height' => '200']);
                        ?>
                    </div>
                </div>
                <br />
                <div class="sc_box supernomargin">
                    <h4 class="sc_box_heading"><?php _e('Excerpt', 'supercarousel'); ?></h4>
                    <div class="sc_box_content">
                        <textarea class="supercarousel_excerpt_textarea" rows="3" name="super_excerpt"><?php echo $super_excerpt; ?></textarea>
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
                    <span class="super_icon_acc supercategories"></span>
                    <?php _e('Attributes', 'supercarousel'); ?>
                </h2>
                <div class="susettingboxcontent supercontent_categories supersettingfields" style="display: block;">
                    <div class="surow">
                        <div class="sucol-6">
                            <label>Menu Order</label>
                            <input type="text" value="<?php echo $content_menu_order; ?>" name="content_menu_order" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="susettingbox">
                <h2>
                    <span class="super_icon_acc supercategories"></span>
                    <?php _e('Categories', 'supercarousel'); ?>
                </h2>
                <div class="susettingboxcontent supercontent_categories supersettingfields" style="display: block;">
                    <div class="surow">
                        <div class="sucol-12">
                            <div class="supercontent_category_loader"></div>
                            <div class="supertaxonomy" id="supercontentcategory"><?php include('supercontent-category.php'); ?></div>
                        </div>
                    </div>
                    <div class="surow">
                        <div class="sucol-12">
                            <input type="text" placeholder="<?php echo _e('Category Name Here', 'supercarousel'); ?>" class="noentersubmit" data-entercallback="SupercarouselContent.save_supercontent_category();" id="supercontent_category_name" />
                            <input type="hidden" id="supercontent_category_id" value="0" />
                            <input type="hidden" id="supercontent_category_act" value="add" />
                            <input type="hidden" id="supercontent_post_id" value="<?php echo $id; ?>" />
                            <div class="right-text">
                                <button type="button" class="superbluebtn small" id="btn_category_add" onclick="SupercarouselContent.save_supercontent_category();"><?php _e('Add', 'supercarousel'); ?></button>
                                <button type="button" style="display: none;" id="btn_category_reset" class="superredbtn small" onclick="SupercarouselContent.reset_supercontent_category();"><?php _e('Cancel', 'supercarousel'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>