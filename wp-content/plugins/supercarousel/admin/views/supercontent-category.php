<?php
$term_ids = array();

if ($post_id > 0) {

    $post_terms = get_the_terms($post_id, 'supercontentcat');

    if ($post_terms) {
        foreach ($post_terms as $row) {
            $term_ids[] = $row->term_id;
        }
    }
}

$terms = get_terms(
        array(
            'taxonomy' => 'supercontentcat',
            'hide_empty' => false
        )
);
foreach ($terms as $row) {
    ?>
    <label>
        <input type="checkbox" name="super_content_terms[]" value="<?php echo $row->term_id; ?>"<?php echo in_array($row->term_id, $term_ids) ? ' checked="checked"' : ''; ?> /><input type="hidden" class="data" value="<?php echo esc_attr($row->name); ?>" /> <?php echo $row->name; ?> 
        <a href="javascript: void(0);" class="red fr" onclick="SupercarouselContent.delete_supercontent_category('<?php echo $row->term_id; ?>');"><span class="dashicons dashicons-no"></span></a>
        <a href="javascript: void(0);" class="fr" onclick="SupercarouselContent.edit_supercontent_category(this, '<?php echo $row->term_id; ?>');"><span class="dashicons dashicons-edit"></span></a> 
    </label>
    <?php
}
?>