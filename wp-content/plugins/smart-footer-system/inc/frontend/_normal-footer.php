<style>
	<?php if(isset($sfsPostFooter["footer"]['normal-sticky']) && $sfsPostFooter["footer"]['normal-sticky'] ): ?>
	#sfs-footer-wrapper {
		position: fixed;
		width: 100%;
		left: 0px;
		bottom: 0px;
		min-width: 100%;
		max-width: 100%;
		z-index: 9999;
	}
	<?php if(!isset($sfsPostFooter["footer"]['normal-sticky-mobile']) || !$sfsPostFooter["footer"]['normal-sticky-mobile']): ?>
	@media only screen and (max-width: 768px) {
		#sfs-footer-wrapper {
			position: static;
			width: 100%;
			left: 0px;
			bottom: 0px;
			min-width: 100%;
			max-width: 100%;
			z-index: 1;
		}
	}
	<?php endif; ?>
	<?php endif; ?>
	<?php if(isset($sfsPostFooter["footer"]['normal-shadow-sticky']) && $sfsPostFooter["footer"]['normal-shadow-sticky'] ): ?>	
	#sfs-footer-wrapper,
	#mk_page_footer {
		box-shadow: -3px 4px 20px 0px #2a2a2a;
		z-index: 9999;
	}
	<?php endif; ?>
</style>