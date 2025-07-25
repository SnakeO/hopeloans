<nav>
	<ul>
		<li>
			<a data-target="banner-desktop" href="javascript:;"><?php echo __("Desktop", "smart-footer-system") ?></a>
		</li>
		<li>
			<a data-target="banner-mobile" href="javascript:;"><?php echo __("Mobile", "smart-footer-system") ?></a>
		</li>		
	</ul>
</nav>
<?php 
$sfsFooterBannerSettings = [];
if(isset($sfsFooterSettings) && isset($sfsFooterSettings["banner"])){
	$sfsFooterBannerSettings = $sfsFooterSettings['banner'];
}
foreach(array('desktop', 'mobile') as $res):
	$currentSfsBannerSettings = [];
	if(isset($sfsFooterBannerSettings[$res])){
		$currentSfsBannerSettings = $sfsFooterBannerSettings[$res];
	}	
?>
<div data-target="banner-<?php echo $res ?>" class="sfs-footer-sub sfs-footer-type-banner" id="sfs-banner-general-settings">
	<div class="table-tabs">
		<a data-tabtarget="banner-<?php echo $res ?>-settings" href="javascript:;"><?php echo __("Settings", "smart-footer-system") ?></a>
		<a data-tabtarget="banner-<?php echo $res ?>-background" href="javascript:;"><?php echo __("Background", "smart-footer-system") ?></a>
		<a data-tabtarget="banner-<?php echo $res ?>-text" href="javascript:;"><?php echo __("Text", "smart-footer-system") ?></a>		
		<a data-tabtarget="banner-<?php echo $res ?>-button" href="javascript:;"><?php echo __("Button", "smart-footer-system") ?></a>
		<a data-tabtarget="banner-<?php echo $res ?>-font" href="javascript:;"><?php echo __("Font", "smart-footer-system") ?></a>		
		<?php if($res == 'desktop'): ?>
			<button type="button" id="sfs-banner-copy-to-mobile-button" class="button button-default button-large"><span class="dashicons dashicons-admin-page"></span><?php echo __("Copy to mobile", 'smart-footer-system'); ?></button>
		<?php endif; ?>		
	</div>
	<div class="tab-targets">
		<div data-tabtarget="banner-<?php echo $res ?>-settings" id="sfs-banner-general-settings">
			<?php include(SFS_PATH.'inc/backend/banner/general.php'); ?>
		</div>
		<div data-tabtarget="banner-<?php echo $res ?>-background" id="sfs-banner-general-settings">
			<?php include(SFS_PATH.'inc/backend/banner/background.php'); ?>
		</div>
		<div data-tabtarget="banner-<?php echo $res ?>-text" id="sfs-banner-general-settings">
			<?php include(SFS_PATH.'inc/backend/banner/text.php'); ?>
		</div>			
		<div data-tabtarget="banner-<?php echo $res ?>-button" id="sfs-banner-general-settings">
			<?php include(SFS_PATH.'inc/backend/banner/button.php'); ?>
		</div>	
		<div data-tabtarget="banner-<?php echo $res ?>-font" id="sfs-banner-general-settings">
			<?php include(SFS_PATH.'inc/backend/banner/font.php'); ?>
		</div>	
	</div>
</div>
<?php endforeach; ?>