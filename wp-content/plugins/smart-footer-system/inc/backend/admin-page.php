<?php 
$sfsSettings  = SfsSettings::get();
$sfsFooters   = SfsPostType::get();
$sfsPostTypes = SfsPostType::getAllPostTypes();
?>
<div id="sfs-footer-metabox">
	<form method="post">
		<section class="sfs-footer-section" id="sfs-footer-general-settings-content">
			<header>
				<h3><?php echo __("Smart Footer System", 'smart-footer-system').'<small style="font-size: 14px; margin-left: 5px; margin-top: 5px;"> v'.SFS_VERSION.'</small>' ?></h3>
				<button type="submit" name="submit" id="submit" value="<?php echo __("Save Changes", "smart-footer-system") ?>"><?php echo __("Save Changes", "smart-footer-system") ?></button>
			</header>
			<div class="sfs-footer-settings">
				<?php
				include_once(SFS_PATH.'inc/backend/settings/settings.php');
				?>	
			</div>
		</section>	
		<?php wp_nonce_field( 'sfs-save-settings'); ?>	
	</form>
</div>