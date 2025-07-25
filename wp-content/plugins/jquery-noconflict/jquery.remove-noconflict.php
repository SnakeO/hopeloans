<?php
/*
Plugin Name:  jQuery Remove noConflict
Description:  Wordpress has jQuery.noConflict() on by default. Remove it.
Version:      0.1
Author:       Jake Chapa
*/

class JQueryRemoveNoConflict
{
	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_script'), 1);
		add_action('admin_enqueue_scripts', array($this, 'wp_enqueue_script'), 1);
		
		add_action('admin_head', array($this, 'admin_head'), 1);
	}

	function wp_enqueue_script()
	{
		wp_enqueue_script('jquery.remove-noconflict', plugins_url('/jquery.remove-noconflict.js', __FILE__), array('jquery'), '1.0');
	}

	function admin_head()
	{
		?>

			<script type="text/javascript">
				window.$ = $ = jQuery;
			</script>

		<?php
	}
}

new JQueryRemoveNoConflict();

?>