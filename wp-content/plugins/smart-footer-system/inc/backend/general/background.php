<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("You can define a background image selecting by media.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image"><?php echo __("Bakground Content Image", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div style="<?php echo (isset($sfsFooterSettings['content-background-image']) && $sfsFooterSettings['content-background-image'] !='') ? 'background-image: url('.$sfsFooterSettings['content-background-image'].')' : '' ?>" class="sfs-element-image <?php echo (isset($sfsFooterSettings['content-background-image']) && $sfsFooterSettings['content-background-image'] !='' ) ? 'w-image' : '' ?>">
					<i class="dashicons dashicons-format-image"></i>
					<input id="sfs-footer-banner-background-image" name="sfs[content-background-image]" value="<?php echo (isset($sfsFooterSettings['content-background-image'])) ? $sfsFooterSettings['content-background-image'] : '' ?>" type="hidden">					
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<label data-hint="<?php echo __("Choose the size of your image.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image-size"><?php echo __("Bakground Content Image Size", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[content-background-image-size]" id="sfs-footer-banner-background-image-size"">
					<option <?php echo (isset($sfsFooterSettings["content-background-image-size"]) && $sfsFooterSettings["content-background-image-size"]=='auto') ? 'selected' : '' ?>  value="auto">auto</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-size"]) && $sfsFooterSettings["content-background-image-size"]=='cover') ? 'selected' : '' ?>  value="cover">cover</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-size"]) && $sfsFooterSettings["content-background-image-size"]=='contain') ? 'selected' : '' ?>  value="contain">contain</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-size"]) && $sfsFooterSettings["content-background-image-size"]=='strech') ? 'selected' : '' ?>  value="strech">strech</option>
				</select>
			</td>
		</tr>

		<tr>
			<th>
				<label data-hint="<?php echo __("Set the position for your image.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image-position"><?php echo __("Background Content Image Position", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[content-background-image-position]" id="sfs-footer-banner-background-image-position"">
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='left top') ? 'selected' : '' ?> value="left top">left top</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='left center') ? 'selected' : '' ?> value="left center">left center</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='left bottom') ? 'selected' : '' ?> value="left bottom">left bottom</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='right top') ? 'selected' : '' ?> value="right top">right top</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='right center') ? 'selected' : '' ?> value="right center">right center</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='right bottom') ? 'selected' : '' ?> value="right bottom">right bottom</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='center top') ? 'selected' : '' ?> value="center top">center top</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='center center') ? 'selected' : '' ?> value="center center">center center</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='center bottom') ? 'selected' : '' ?> value="center bottom">center bottom</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("If your image is too small you can use the repeat option to replicate it.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image-repeat"><?php echo __("Background Content Image Repeat", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[content-background-image-repeat]" id="sfs-footer-banner-background-image-repeat"">
					<option <?php echo (isset($sfsFooterSettings["content-background-image-repeat"]) && $sfsFooterSettings["content-background-image-repeat"]=='no-repeat') ? 'selected' : '' ?> value="no-repeat">no-repeat</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-repeat"]) && $sfsFooterSettings["content-background-image-repeat"]=='repeat') ? 'selected' : '' ?> value="repeat">repeat</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-repeat"]) && $sfsFooterSettings["content-background-image-repeat"]=='repeat-x') ? 'selected' : '' ?> value="repeat-x">repeat-x</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-repeat"]) && $sfsFooterSettings["content-background-image-repeat"]=='repeat-y') ? 'selected' : '' ?> value="repeat-y">repeat-y</option>
				</select>
			</td>
		</tr>

		<tr>
			<th>
				<label data-hint="<?php echo __("Use this option to set a custom background color of the main content. Default value is transparent.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-color"><?php echo __("Background Content Color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-background-color" name="sfs[content-background-color]" class="sfs-color-picker" value="<?php echo (isset($sfsFooterSettings["content-background-color"]) && $sfsFooterSettings["content-background-color"] !='') ? $sfsFooterSettings["content-background-color"] : '' ?>" type="text">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("You can also set a custom overlay color from this option.", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("Background Content Overlay Color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-overlay-color" name="sfs[content-overlay-color]" class="sfs-color-picker" value="<?php echo (isset($sfsFooterSettings["content-overlay-color"]) && $sfsFooterSettings["content-overlay-color"] !='') ? $sfsFooterSettings["content-overlay-color"] : '' ?>" type="text">
			</td>
		</tr>	
	</tbody>
</table>