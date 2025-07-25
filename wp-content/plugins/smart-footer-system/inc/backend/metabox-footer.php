<section class="sfs-footer-section" id="sfs-footer-general-settings-content">
	<header>
		<h3><span class="dashicons dashicons-menu"></span><span><?php echo __("Settings", 'smart-footer-system') ?></span></h3>
	</header>
	<div class="sfs-footer-settings">
	<?php
	include_once(SFS_PATH.'inc/backend/general/general.php');
	?>	
	</div>
</section>

<section class="sfs-footer-section" id="sfs-footer-settings-content">
	<header>
		<h3><span class="dashicons dashicons-image-flip-vertical"></span><span><?php echo __("Footer Type", 'smart-footer-system') ?></span></h3>
		<select name="sfs[type]" id="sfs-footer-type-select">	
			<option <?php echo (!isset($sfsFooterSettings['type']) || $sfsFooterSettings['type'] == 'normal') ? 'selected' : '' ?> value="normal"><?php echo __("Normal", 'smart-footer-system') ?></option>
			<option <?php echo (isset($sfsFooterSettings['type']) && $sfsFooterSettings['type'] == 'reveal') ? 'selected' : '' ?> value="reveal"><?php echo __("Reveal", 'smart-footer-system') ?></option>			
			<option <?php echo (isset($sfsFooterSettings['type']) && $sfsFooterSettings['type'] == 'bottom') ? 'selected' : '' ?> value="bottom"><?php echo __("Slide Up", 'smart-footer-system') ?></option>	
			<option <?php echo (isset($sfsFooterSettings['type']) && $sfsFooterSettings['type'] == 'banner') ? 'selected' : '' ?> value="banner"><?php echo __("Banner", 'smart-footer-system') ?></option>

			<option <?php echo (isset($sfsFooterSettings['type']) && $sfsFooterSettings['type'] == 'keyring') ? 'selected' : '' ?> value="keyring"><?php echo __("Css3 Animations", 'smart-footer-system') ?></option>			
			<option <?php echo (isset($sfsFooterSettings['type']) && $sfsFooterSettings['type'] == 'accordion') ? 'selected' : '' ?> value="accordion"><?php echo __("Accordion", 'smart-footer-system') ?></option>			
		</select>		
	</header>
	<div class="sfs-footer-settings" id="sfs-footer-settings-general">
	<?php 
	include_once(SFS_PATH.'inc/backend/general/general-footer.php');
	?>
	</div>
	<div class="sfs-footer-settings" id="sfs-footer-settings-normal">
	<?php 
	include_once(SFS_PATH.'inc/backend/normal/normal.php');
	?>		
	</div>
	<div class="sfs-footer-settings" id="sfs-footer-settings-reveal">
	<?php 
	include_once(SFS_PATH.'inc/backend/reveal/reveal.php');
	?>
	</div>
	<div class="sfs-footer-settings" id="sfs-footer-settings-bottom">
	<?php 
	include_once(SFS_PATH.'inc/backend/slideup/slideup.php');
	?>			
	</div>
	<div class="sfs-footer-settings" id="sfs-footer-settings-banner">
	<?php 
	include_once(SFS_PATH.'inc/backend/banner/banner.php');
	?>			
	</div>
	<div class="sfs-footer-settings" id="sfs-footer-settings-keyring">
	<?php 
	include_once(SFS_PATH.'inc/backend/keyring/keyring.php');
	?>			
	</div>	
	<div class="sfs-footer-settings" id="sfs-footer-settings-accordion">
	<?php 
	include_once(SFS_PATH.'inc/backend/accordion/accordion.php');
	?>			
	</div>		
</section>
<div style="text-align: right; padding: 50px">
	<a target="_blank" style="margin-right: 20px;padding: 10px; height: auto; min-width:200px; text-align: center" class="button button-default" href="<?php echo get_admin_url().'post-new.php?post_type=sfs-footer' ?>"><?php echo __("Create new footer", "smart-footer-system") ?></a>
	<button style="padding: 10px; height: auto; min-width:200px; text-align: center" type="button" onclick='jQuery("input#publish").trigger("click")' class="button button-primary"><?php echo __("Save footer", "smart-footer-system") ?></button>
</div>