<?php
//supershow($carouselData['options']);
extract($carouselData['options']);
$effectclass = '';
if ($effect == 'focus') {
    $effectclass = ' focuscarousel';
}
if ($randomize == '1') {
    shuffle($carouselData['slides']);
}
?>
<div class="supercrsl supercarousel<?php echo $carouselid; ?> <?php echo $wrapper_class; ?>" data-carouseloptions="<?php echo esc_attr(json_encode($carouselData['options'])); ?>">
    <div class="supercarousel<?php echo $effectclass; ?>">
        <?php
        foreach ($carouselData['slides'] as $html) {
            ?>
            <div>
                <?php echo do_shortcode($html); ?>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="clear"></div>
    <?php
    if ($nextPrev == '1') {
        ?>
        <a class="superprev super_<?php echo $arrowStyle; ?>" href="#"><span>prev</span></a>
        <a class="supernext super_<?php echo $arrowStyle; ?>" href="#"><span>next</span></a>
        <?php
    }
    ?>
    <div class="pagination"></div>
</div>