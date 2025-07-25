<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
			<label data-hint="<?php echo __("You can load an image to set as background image of the banner box.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image"><?php echo __("Image", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div style="<?php echo (isset($currentSfsBannerSettings['background-image']) && $currentSfsBannerSettings['background-image'] !='') ? 'background-image: url('.$currentSfsBannerSettings['background-image'].')' : '' ?>" class="sfs-footer-banner-background-image-wrapper sfs-element-image <?php echo (isset($currentSfsBannerSettings['background-image']) && $currentSfsBannerSettings['background-image'] !='' ) ? 'w-image' : '' ?>">
					<i class="dashicons dashicons-format-image"></i>
					<input id="sfs-footer-banner-background-image" name="sfs[banner][<?php echo $res ?>][background-image]" value="<?php echo (isset($currentSfsBannerSettings['background-image'])) ? $currentSfsBannerSettings['background-image'] : '' ?>" type="hidden">					
				</div>
			</td>
		</tr>

		<tr>
			<th>
			<label data-hint="<?php echo __("Choose what size to give the image.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image-size"><?php echo __("Image size", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][background-image-size]" id="sfs-footer-banner-background-image-size"">
					<option <?php echo (isset($currentSfsBannerSettings["background-image-size"]) && $currentSfsBannerSettings["background-image-size"]=='auto') ? 'selected' : '' ?>  value="auto">auto</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-size"]) && $currentSfsBannerSettings["background-image-size"]=='cover') ? 'selected' : '' ?>  value="cover">cover</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-size"]) && $currentSfsBannerSettings["background-image-size"]=='contain') ? 'selected' : '' ?>  value="contain">contain</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-size"]) && $currentSfsBannerSettings["background-image-size"]=='strech') ? 'selected' : '' ?>  value="strech">strech</option>
				</select>
			</td>
		</tr>

		<tr>
			<th>
			<label data-hint="<?php echo __("Set the position of the background image.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image-position"><?php echo __("Image position", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][background-image-position]" id="sfs-footer-banner-background-image-position"">
					<option <?php echo (isset($currentSfsBannerSettings["background-image-position"]) && $currentSfsBannerSettings["background-image-position"]=='left top') ? 'selected' : '' ?> value="left top">left top</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-position"]) && $currentSfsBannerSettings["background-image-position"]=='left center') ? 'selected' : '' ?> value="left center">left center</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-position"]) && $currentSfsBannerSettings["background-image-position"]=='left bottom') ? 'selected' : '' ?> value="left bottom">left bottom</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-position"]) && $currentSfsBannerSettings["background-image-position"]=='right top') ? 'selected' : '' ?> value="right top">right top</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-position"]) && $currentSfsBannerSettings["background-image-position"]=='right center') ? 'selected' : '' ?> value="right center">right center</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-position"]) && $currentSfsBannerSettings["background-image-position"]=='right bottom') ? 'selected' : '' ?> value="right bottom">right bottom</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-position"]) && $currentSfsBannerSettings["background-image-position"]=='center top') ? 'selected' : '' ?> value="center top">center top</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-position"]) && $currentSfsBannerSettings["background-image-position"]=='center center') ? 'selected' : '' ?> value="center center">center center</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-position"]) && $currentSfsBannerSettings["background-image-position"]=='center bottom') ? 'selected' : '' ?> value="center bottom">center bottom</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
			<label data-hint="<?php echo __("If your image is too small you can use the repeat option to replicate it.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image-repeat"><?php echo __("Image repeat", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][background-image-repeat]" id="sfs-footer-banner-background-image-repeat"">
					<option <?php echo (isset($currentSfsBannerSettings["background-image-repeat"]) && $currentSfsBannerSettings["background-image-repeat"]=='no-repeat') ? 'selected' : '' ?> value="no-repeat">no-repeat</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-repeat"]) && $currentSfsBannerSettings["background-image-repeat"]=='repeat') ? 'selected' : '' ?> value="repeat">repeat</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-repeat"]) && $currentSfsBannerSettings["background-image-repeat"]=='repeat-x') ? 'selected' : '' ?> value="repeat-x">repeat-x</option>
					<option <?php echo (isset($currentSfsBannerSettings["background-image-repeat"]) && $currentSfsBannerSettings["background-image-repeat"]=='repeat-y') ? 'selected' : '' ?> value="repeat-y">repeat-y</option>
				</select>
			</td>
		</tr>

		<tr>
			<th>
			<label data-hint="<?php echo __("Define a background color if you don’t need of an image.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-color"><?php echo __("Color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-background-color" name="sfs[banner][<?php echo $res ?>][background-color]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["background-color"]) && $currentSfsBannerSettings["background-color"] !='') ? $currentSfsBannerSettings["background-color"] : '' ?>" type="text">
			</td>
		</tr>

		<tr>
			<th>
			<label data-hint="<?php echo __("Set a hover color of the banner box.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-color-hover"><?php echo __("Hover color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-background-color-hover" name="sfs[banner][<?php echo $res ?>][background-color-hover]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["background-color-hover"]) && $currentSfsBannerSettings["background-color-hover"] !='') ? $currentSfsBannerSettings["background-color-hover"] : '' ?>" type="text">
			</td>
		</tr>

		<tr>
			<th>
			<label data-hint="<?php echo __("Define an overlay color.", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("Overlay color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-overlay-color" name="sfs[banner][<?php echo $res ?>][overlay-color]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["overlay-color"]) && $currentSfsBannerSettings["overlay-color"] !='') ? $currentSfsBannerSettings["overlay-color"] : '' ?>" type="text">
			</td>
		</tr>		
	</tbody>
</table>