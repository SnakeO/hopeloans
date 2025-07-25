<style>
	#sfs-footer-wrapper.keyring {
		position: relative;
		<?php if($sfsPostFooter["footer"]["content-background-color"]): ?>
		background-color: <?php echo $sfsPostFooter["footer"]["content-background-color"] ?>;
		<?php endif; ?>		
		<?php if($sfsPostFooter["footer"]["content-background-image"]): ?>
		background-image: url(<?php echo $sfsPostFooter["footer"]["content-background-image"] ?>);
		<?php endif; ?>
		<?php if($sfsPostFooter["footer"]["content-background-image-position"]): ?>
		background-position: <?php echo $sfsPostFooter["footer"]["content-background-image-position"] ?>;
		<?php endif; ?>
		<?php if($sfsPostFooter["footer"]["content-background-image-size"]): ?>
		background-size: <?php echo $sfsPostFooter["footer"]["content-background-image-size"] ?>;
		<?php endif; ?>
		<?php if($sfsPostFooter["footer"]["content-background-image-repeat"]): ?>
		background-repeat: <?php echo $sfsPostFooter["footer"]["content-background-image-repeat"] ?>;
		<?php endif; ?>
	}
	#sfs-footer-wrapper.keyring::before {
		<?php if($sfsPostFooter["footer"]["content-overlay-color"]): ?>
		content: '';
		display: block;
		width: 100%;
		height: 100%;
		min-height: 100%;
		max-height: 100%;
		min-width: 100%;
		max-width: 100%;
		position: absolute;
		top: 0px;
		left:0px;
		background-color: <?php echo $sfsPostFooter["footer"]["content-overlay-color"] ?>;
		opacity: 0.5;
		<?php endif; ?>
	}
	<?php if(isset($sfsPostFooter["footer"]["animation-position"])): ?>
	#sfs-footer-wrapper.keyring .sfs-footer-content > div {
		-webkit-transform-origin: <?php echo $sfsPostFooter["footer"]["animation-position"] ?>;
		-moz-transform-origin: <?php echo $sfsPostFooter["footer"]["animation-position"] ?>;
		-ms-transform-origin: <?php echo $sfsPostFooter["footer"]["animation-position"] ?>;
		-o-transform-origin: <?php echo $sfsPostFooter["footer"]["animation-position"] ?>;
		transform-origin: <?php echo $sfsPostFooter["footer"]["animation-position"] ?>;
	}
	<?php endif; ?>
	@media only screen and ( max-width: 1024px ) {
		#sfs-footer-wrapper.keyring .sfs-footer-content > div {
			transform: none!important;
		}
	}
</style>