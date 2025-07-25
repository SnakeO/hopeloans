<nav>
	<ul>
		<li>
			<a data-target="settings-general" href="javascript:;"><?php echo __("General", "smart-footer-system") ?></a>
		</li>
		<li>
			<a data-target="settings-home" href="javascript:;"><?php echo __("Homepage / Blog", "smart-footer-system") ?></a>
		</li>
		<li>
			<a data-target="settings-single" href="javascript:;"><?php echo __("Single", "smart-footer-system") ?></a>
		</li>		
		<li>
			<a data-target="settings-archive" href="javascript:;"><?php echo __("Archive", "smart-footer-system") ?></a>
		</li>	
		<?php if ( class_exists( 'WooCommerce' ) ): ?>		
		<li>
			<a data-target="settings-woocommerce" href="javascript:;"><?php echo __("WooCommerce", "smart-footer-system") ?></a>
		</li>				
		<?php endif; ?>
		<li>
			<a data-target="settings-import-export" href="javascript:;"><?php echo __("Import / Export Footers", "smart-footer-system") ?></a>
		</li>
		<li>
			<a data-target="settings-support" href="javascript:;"><?php echo __("Support", "smart-footer-system") ?></a>
		</li>		
	</ul>
</nav>
<div data-target="settings-general" class="sfs-footer-sub" id="sfs-footer-settings-general">
	<?php include_once(SFS_PATH.'inc/backend/settings/general.php'); ?>
</div>
<div data-target="settings-home" class="sfs-footer-sub" id="sfs-footer-settings-home">
	<?php include_once(SFS_PATH.'inc/backend/settings/home.php'); ?>
</div>
<div data-target="settings-single" class="sfs-footer-sub" id="sfs-footer-settings-single">
	<?php include_once(SFS_PATH.'inc/backend/settings/single.php'); ?>
</div>	
<div data-target="settings-archive" class="sfs-footer-sub" id="sfs-footer-settings-archive">
	<?php include_once(SFS_PATH.'inc/backend/settings/archive.php'); ?>
</div>	
<div data-target="settings-woocommerce" class="sfs-footer-sub" id="sfs-footer-settings-woocommerce">
	<?php include_once(SFS_PATH.'inc/backend/settings/woocommerce.php'); ?>
</div>	
<div data-target="settings-import-export" class="sfs-footer-sub" id="sfs-footer-settings-import-export">
	<?php include_once(SFS_PATH.'inc/backend/settings/import-export.php'); ?>
</div>	
<div data-target="settings-support" class="sfs-footer-sub" id="sfs-footer-settings-support">
	<?php include_once(SFS_PATH.'inc/backend/settings/support.php'); ?>
</div>	