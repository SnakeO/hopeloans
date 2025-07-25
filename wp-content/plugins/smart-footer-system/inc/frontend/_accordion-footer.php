<style>
	#sfs-footer-wrapper.accordion::before,
	#sfs-footer-wrapper.accordion .sfs-footer-content > div {
		background-color: <?php echo $sfsPostFooter["footer"]["content-background-color"] ?>;
	}
	#sfs-footer-wrapper.accordion span {
		<?php if(isset($sfsPostFooter["footer"]['accordion']["text-color"])): ?>
		color: <?php echo $sfsPostFooter["footer"]['accordion']["text-color"] ?>;
		<?php endif; ?>
		<?php if(isset($sfsPostFooter["footer"]['accordion']["font-style"])): ?>
		font-style: <?php echo $sfsPostFooter["footer"]['accordion']["font-style"] ?>;
		<?php endif; ?>
		<?php if(isset($sfsPostFooter["footer"]['accordion']["font-size"])): ?>
		font-size: <?php echo $sfsPostFooter["footer"]['accordion']["font-size"] ?>px;
		<?php endif; ?>	
		<?php if(isset($sfsPostFooter["footer"]['accordion']["font-weight"])): ?>
		font-weight: <?php echo $sfsPostFooter["footer"]['accordion']["font-weight"] ?>;
		<?php endif; ?>		
		<?php if(isset($sfsPostFooter["footer"]['accordion']["line-height"])): ?>
		line-height: <?php echo $sfsPostFooter["footer"]['accordion']["line-height"] ?>px;
		<?php endif; ?>		
	}	
	<?php if( 
		(!isset($sfsPostFooter["footer"]['accordion']["left-text"]) || $sfsPostFooter["footer"]['accordion']["left-text"] == '') 
		&& (!isset($sfsPostFooter["footer"]['accordion']["right-text"]) || $sfsPostFooter["footer"]['accordion']["right-text"] == '') 
		): ?>
	#sfs-footer-wrapper.accordion .handle-wrapper {
		justify-content: center!important;
		-webkit-box-align: center!important;
		-webkit-box-pack: center!important;
	}
	<?php endif; ?>
</style>
<div class="handle-wrapper">
	<?php if(isset($sfsPostFooter["footer"]['accordion']["left-text"]) && $sfsPostFooter["footer"]['accordion']["left-text"] != ''): ?>
	<span><?php echo $sfsPostFooter["footer"]['accordion']["left-text"] ?></span>
	<?php endif; ?>
	<i style="<?php echo SfsFrontend::getAccordionFooterIconStyles($sfsPostFooter, 'i', 'open'); ?>" class="<?php echo SfsFrontend::getAccordionFooterIconClasses($sfsPostFooter, 'i', 'open'); ?>"></i>
	<i style="<?php echo SfsFrontend::getAccordionFooterIconStyles($sfsPostFooter, 'i', 'close'); ?>" class="<?php echo SfsFrontend::getAccordionFooterIconClasses($sfsPostFooter, 'i', 'close'); ?>"></i>
	<?php if(isset($sfsPostFooter["footer"]['accordion']["right-text"]) && $sfsPostFooter["footer"]['accordion']["right-text"] != ''): ?>
	<span><?php echo $sfsPostFooter["footer"]['accordion']["right-text"] ?></span>
	<?php endif; ?>
</div>