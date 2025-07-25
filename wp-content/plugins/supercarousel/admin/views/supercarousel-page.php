<input type="hidden" id="superpage" value="<?php echo $superpage; ?>" />
<div class="wrap supercarousel_wrapper">
    <div class="top_title">
        <div class="surow">
            <div class="sucol-8">
                <h3 class="pageheading"><?php echo (SuperCarousel_Common::is_supercarousel_edit()) ? __('Edit', 'supercarousel') . ' ' : ''; ?><?php echo $superheading; ?></h3>
            </div>
            <div class="sucol-4 textright">
                <a class="superbluebtn" href="admin.php?page=<?php echo $superpage; ?>&act=add"><?php _e('Add New', 'supercarousel'); ?></a>
                <?php
                if (SuperCarousel_Common::is_supercarousel_add() or SuperCarousel_Common::is_supercarousel_edit()) {
                    ?>
                    <a class="superredbtn" href="admin.php?page=<?php echo $superpage; ?>"><?php _e('&lt;&lt; Back to Listing', 'supercarousel'); ?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    if (SuperCarousel_Common::is_supercarousel_listing()) {
        include(SUPER_CAROUSEL_PATH . 'admin/views/supercarousel-listing.php');
    } else if (SuperCarousel_Common::is_supercarousel_add() or SuperCarousel_Common::is_supercarousel_edit()) {
        include(SUPER_CAROUSEL_PATH . 'admin/views/' . $superpage . '-addedit.php');
    }
    ?>
</div>
<div class="clear"></div>