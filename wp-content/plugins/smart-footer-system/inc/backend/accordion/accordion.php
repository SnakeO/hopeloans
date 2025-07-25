<nav>
	<ul>
		<li>
			<a data-target="accordion-general" href="javascript:;"><?php echo __("Settings", "smart-footer-system") ?></a>
		</li>
	</ul>
</nav>
<div data-target="accordion-general" class="sfs-footer-sub" id="sfs-footer-general-settings">
	<div class="table-tabs">
		<a data-tabtarget="accordion-type" href="javascript:;"><?php echo __("Type", "smart-footer-system") ?></a>
		<a data-tabtarget="accordion-icon" href="javascript:;"><?php echo __("Icon", "smart-footer-system") ?></a>
		<a data-tabtarget="accordion-text" href="javascript:;"><?php echo __("Text", "smart-footer-system") ?></a>		
		<a data-tabtarget="accordion-font" href="javascript:;"><?php echo __("Font", "smart-footer-system") ?></a>
	</div>
	<div class="tab-targets">
		<div class="tab-target" data-tabtarget="accordion-type">
		<?php include_once(SFS_PATH.'inc/backend/accordion/type.php'); ?>
		</div>
		<div class="tab-target" data-tabtarget="accordion-icon">
		<?php include_once(SFS_PATH.'inc/backend/accordion/icon.php'); ?>
		</div>
		<div class="tab-target" data-tabtarget="accordion-text">
		<?php include_once(SFS_PATH.'inc/backend/accordion/text.php'); ?>
		</div>		
		<div class="tab-target" data-tabtarget="accordion-font">
		<?php include_once(SFS_PATH.'inc/backend/accordion/font.php'); ?>
		</div>
	</div>	
</div>