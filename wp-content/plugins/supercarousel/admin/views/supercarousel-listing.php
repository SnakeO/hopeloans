<?php
$paged = max(1, (isset($_GET['paged']) ? (int) $_GET['paged'] : 0));
$args = array('post_type' => $superposttype, 'paged' => $paged);
$loop = new WP_Query($args);
if (count($loop->posts)) {
    ?>
    <table class="superlisting">
        <thead>
            <tr>
                <th class="su_id">#<?php _e('ID', 'supercarousel'); ?></th>
                <th><?php _e('Name', 'supercarousel'); ?></th>
                <?php
                if ($superposttype == 'supercarousel') {
                    ?>
                    <th class="su_shortcode"><?php _e('Short Code', 'supercarousel'); ?></th>
                    <?php
                } else if ($superposttype == 'supercontent') {
                    ?>
                    <th class="su_shortcode"><?php _e('Categories', 'supercarousel'); ?></th>
                    <?php
                }
                ?>
                <th class="su_action"><?php _e('Manage', 'supercarousel'); ?></th>
                <th class="su_action"><?php _e('Delete', 'supercarousel'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($loop->posts as $row) {
                $editurl = "admin.php?page={$superpage}&act=edit&id=" . $row->ID;
                ?>
                <tr>
                    <td><?php echo $row->ID; ?></td>
                    <td class="su_name">
                        <a href="<?php echo $editurl; ?>"><?php echo $row->post_title; ?></a>
                    </td>
                    <?php
                    if ($superposttype == 'supercarousel') {
                        ?>
                        <td class="su_shortcode">
                            <input type="text" class="supercarousel_shortcode_ip" readonly="" value="[supercarousel slug='<?php echo $row->post_name; ?>']" onclick="this.select();" onfocus="this.select();" />
                        </td>
                        <?php
                    } else if ($superposttype == 'supercontent') {
                        ?>
                        <td>
                            <?php
                            echo SuperCarousel_Common::get_super_content_categories($row->ID);
                            ?>
                        </td>
                        <?php
                    }
                    ?>
                    <td class="su_action"><a href="<?php echo $editurl; ?>"><span class="dashicons dashicons-edit"></span></a></td>
                    <td class="su_action"><a href="javascript:void(0);" onclick="SupercarouselCommon.delete_supercarousel('<?php echo $row->ID; ?>');"><span class="dashicons dashicons-dismiss"></span></a></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div class="su_paging">
        <?php
        $args = array(
            'base' => '%_%',
            'format' => '?paged=%#%',
            'total' => $loop->max_num_pages,
            'current' => $paged,
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => __('<span class="dashicons dashicons-arrow-left-alt2"></span>'),
            'next_text' => __('<span class="dashicons dashicons-arrow-right-alt2"></span>'),
            'type' => 'plain',
            'add_args' => false,
            'add_fragment' => '',
            'before_page_number' => '',
            'after_page_number' => ''
        );
        echo paginate_links($args);
        ?>
    </div>
    <?php
} else {
    ?>
    <h1 class="centered">No Records Found</h1>
    <?php
}
?>