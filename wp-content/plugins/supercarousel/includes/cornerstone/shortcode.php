<?php
/**
 * Shortcode handler
 */
$class = "cs_supercarousel " . $class;
?>
<div <?php cs_atts(array('id' => $id, 'class' => $class, 'style' => $style), true); ?>>
    <?php echo do_shortcode("[supercarousel slug='{$supercarousel_slug}']"); ?>
</div>
