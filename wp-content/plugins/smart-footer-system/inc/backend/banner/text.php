<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
			<label data-hint="<?php echo __("Set a Title text for your banner footer (optional).", "smart-footer-system"); ?>" for="sfs-footer-banner-title"><?php echo __("Title", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input style="width:500px;" id="sfs-footer-banner-title" name="sfs[banner][<?php echo $res ?>][title]" value="<?php echo (isset($currentSfsBannerSettings["title"]) && $currentSfsBannerSettings["title"] !='') ? $currentSfsBannerSettings["title"] : '' ?>" type="text">
			</td>
		</tr>
		<tr>
			<th>
			<label data-hint="<?php echo __("Set a Subtitle text for your banner footer (optional).", "smart-footer-system"); ?>" for="sfs-footer-banner-subtitle"><?php echo __("Subtitle", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input style="width:500px;" id="sfs-footer-banner-subtitle" name="sfs[banner][<?php echo $res ?>][subtitle]" value="<?php echo (isset($currentSfsBannerSettings["subtitle"]) && $currentSfsBannerSettings["subtitle"] !='') ? $currentSfsBannerSettings["subtitle"] : '' ?>" type="text">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a color for Title and Subtitle (optional).", "smart-footer-system"); ?>" for="sfs-footer-banner-font-color"><?php echo __("Color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-font-color" name="sfs[banner][<?php echo $res ?>][font-color]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["font-color"]) && $currentSfsBannerSettings["font-color"] !='') ? $currentSfsBannerSettings["font-color"] : '' ?>" type="text">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set a hover color for Title and Subtitle (optional).", "smart-footer-system"); ?>" for="sfs-footer-banner-font-color-hover"><?php echo __("Hover color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-font-color-hover" name="sfs[banner][<?php echo $res ?>][font-color-hover]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["font-color-hover"]) && $currentSfsBannerSettings["font-color-hover"] !='') ? $currentSfsBannerSettings["font-color-hover"] : '' ?>" type="text">
			</td>
		</tr>
	</tbody>
</table>