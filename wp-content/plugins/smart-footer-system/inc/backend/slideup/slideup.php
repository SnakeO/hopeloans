<nav>
	<ul>
		<li>
			<a data-target="slideup-general" href="javascript:;"><?php echo __("Settings", "smart-footer-system") ?></a>
		</li>
		<li>
			<a data-target="slideup-style" href="javascript:;"><?php echo __("Handle Style", "smart-footer-system") ?></a>
		</li>
	</ul>
</nav>
<div data-target="slideup-general" class="sfs-footer-sub" id="sfs-footer-general-settings">
	<?php include_once(SFS_PATH.'inc/backend/slideup/general.php'); ?>
</div>
<div data-target="slideup-style" class="sfs-footer-sub" id="sfs-footer-general-settings">
	<div class="table-tabs">
		<a data-tabtarget="bottom-style" href="javascript:;"><?php echo __("Style", "smart-footer-system") ?></a>
		<a data-tabtarget="bottom-open" href="javascript:;"><?php echo __("Open", "smart-footer-system") ?></a>
		<a data-tabtarget="bottom-close" href="javascript:;"><?php echo __("Close", "smart-footer-system") ?></a>
		<a data-tabtarget="bottom-font" href="javascript:;"><?php echo __("Font", "smart-footer-system") ?></a>
	</div>
	<div class="tab-targets">
		<div class="tab-target" data-tabtarget="bottom-style">
		<?php include_once(SFS_PATH.'inc/backend/slideup/style.php'); ?>
		</div>
		<div class="tab-target" data-tabtarget="bottom-open">
		<?php include_once(SFS_PATH.'inc/backend/slideup/open.php'); ?>
		</div>
		<div class="tab-target" data-tabtarget="bottom-close">
		<?php include_once(SFS_PATH.'inc/backend/slideup/close.php'); ?>
		</div>
		<div class="tab-target" data-tabtarget="bottom-font">
		<?php include_once(SFS_PATH.'inc/backend/slideup/font.php'); ?>
		</div>
	</div>
</div>