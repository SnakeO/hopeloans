<nav>
	<ul>
		<li>
			<a data-target="general-settings-general" href="javascript:;"><?php echo __("General", "smart-footer-system") ?></a>
		</li>
		<li>
			<a data-target="general-settings-advanced" href="javascript:;"><?php echo __("Advanced", "smart-footer-system") ?></a>
		</li>
	</ul>
</nav>
<div data-target="general-settings-general" class="sfs-footer-sub" id="sfs-footer-general-settings">
	
	<div class="table-tabs">
		<a data-tabtarget="general-general-background" href="javascript:;"><?php echo __("Background", "smart-footer-system") ?></a>
		<a data-tabtarget="general-general-border" href="javascript:;"><?php echo __("Border", "smart-footer-system") ?></a>		
		<a data-tabtarget="general-general-padding" href="javascript:;"><?php echo __("Padding", "smart-footer-system") ?></a>
		<a data-tabtarget="general-general-display" href="javascript:;"><?php echo __("Display", "smart-footer-system") ?></a>
	</div>
	<div class="tab-targets">
		<div data-tabtarget="general-general-background" id="sfs-banner-general-settings">
			<?php include(SFS_PATH.'inc/backend/general/background.php'); ?>
		</div>
		<div data-tabtarget="general-general-border" id="sfs-banner-general-settings">
			<?php include(SFS_PATH.'inc/backend/general/border.php'); ?>
		</div>
		<div data-tabtarget="general-general-padding" id="sfs-banner-general-settings">
			<?php include(SFS_PATH.'inc/backend/general/padding.php'); ?>
		</div>
		<div data-tabtarget="general-general-display" id="sfs-banner-general-settings">
			<?php include(SFS_PATH.'inc/backend/general/display.php'); ?>
		</div>
	</div>
</div>
<div data-target="general-settings-advanced" class="sfs-footer-sub" id="sfs-footer-general-advanced">
	<?php
	include_once(SFS_PATH.'inc/backend/general/advanced.php');
	?>
</div>