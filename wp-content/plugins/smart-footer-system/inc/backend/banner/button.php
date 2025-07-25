<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Insert a text for your button.", "smart-footer-system"); ?>" for="sfs-footer-banner-button-text"><?php echo __("Text button", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input style="width:500px;" id="sfs-footer-banner-button-text" name="sfs[banner][<?php echo $res ?>][button-text]" value="<?php echo (isset($currentSfsBannerSettings["button-text"]) && $currentSfsBannerSettings["button-text"] !='') ? $currentSfsBannerSettings["button-text"] : '' ?>" type="text">
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose an icon to open the banner box (optional).", "smart-footer-system"); ?>" for="sfs-footer-banner-open-icon">
					<?php echo __("Open icon", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<input class="regular-text" type="hidden" id="sfs-footer-banner-open-icon-<?php echo $res ?>" name="sfs[banner][<?php echo $res ?>][open-icon]" value="<?php if( isset( $currentSfsBannerSettings['open-icon'] ) ) { echo esc_attr( $currentSfsBannerSettings['open-icon'] ); } ?>"/>
				<div id="preview_sfs-footer-banner-open-icon" data-target="#sfs-footer-banner-open-icon-<?php echo $res ?>" class="button icon-picker <?php if( isset( $currentSfsBannerSettings['open-icon'] ) ) { $v=explode('|',$currentSfsBannerSettings['open-icon']); echo $v[0].' '.$v[1]; } ?>"></div>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose an icon to close the banner box (optional).", "smart-footer-system"); ?>" for="sfs-footer-banner-open-icon">
					<?php echo __("Close icon", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<input class="regular-text" type="hidden" id="sfs-footer-banner-close-icon-<?php echo $res ?>" name="sfs[banner][<?php echo $res ?>][close-icon]" value="<?php if( isset( $currentSfsBannerSettings['close-icon'] ) ) { echo esc_attr( $currentSfsBannerSettings['close-icon'] ); } ?>"/>
				<div id="preview_sfs-footer-banner-close-icon" data-target="#sfs-footer-banner-close-icon-<?php echo $res ?>" class="button icon-picker <?php if( isset( $currentSfsBannerSettings['close-icon'] ) ) { $v=explode('|',$currentSfsBannerSettings['close-icon']); echo $v[0].' '.$v[1]; } ?>"></div>
			</td>
		</tr>
		<tr>
			<th>
			<label data-hint="<?php echo __("Define a background color (optional).", "smart-footer-system"); ?>" for="sfs-footer-banner-button-background-color"><?php echo __("Background color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-button-background-color" name="sfs[banner][<?php echo $res ?>][button-background-color]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["button-background-color"]) && $currentSfsBannerSettings["button-background-color"] !='') ? $currentSfsBannerSettings["button-background-color"] : '' ?>" type="text">
			</td>
		</tr>
		<tr>
			<th>
			<label data-hint="<?php echo __("Set a different color for the hover color.", "smart-footer-system"); ?>" for="sfs-footer-banner-button-background-color-hover"><?php echo __("Background hover color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-button-background-color-hover" name="sfs[banner][<?php echo $res ?>][button-background-color-hover]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["button-background-color-hover"]) && $currentSfsBannerSettings["button-background-color-hover"] !='') ? $currentSfsBannerSettings["button-background-color-hover"] : '' ?>" type="text">
			</td>
		</tr>	

		<tr>
			<th>
			<label data-hint="<?php echo __("Set a border color.", "smart-footer-system"); ?>" for="sfs-footer-banner-button-border-color"><?php echo __("Border color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-button-border-color" name="sfs[banner][<?php echo $res ?>][button-border-color]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["button-border-color"]) && $currentSfsBannerSettings["button-border-color"] !='') ? $currentSfsBannerSettings["button-border-color"] : '' ?>" type="text">
			</td>
		</tr>

		<tr>
			<th>
			<label data-hint="<?php echo __("Define an hover color of the button border.", "smart-footer-system"); ?>" for="sfs-footer-banner-button-border-color-hover"><?php echo __("Border hover color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-button-border-color-hover" name="sfs[banner][<?php echo $res ?>][button-border-color-hover]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["button-border-color-hover"]) && $currentSfsBannerSettings["button-border-color-hover"] !='') ? $currentSfsBannerSettings["button-border-color-hover"] : '' ?>" type="text">
			</td>
		</tr>

		<tr>
			<th>
			<label data-hint="<?php echo __("Set a color for the text.", "smart-footer-system"); ?>" for="sfs-footer-banner-button-font-color"><?php echo __("Text color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-button-font-color" name="sfs[banner][<?php echo $res ?>][button-font-color]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["button-font-color"]) && $currentSfsBannerSettings["button-font-color"] !='') ? $currentSfsBannerSettings["button-font-color"] : '' ?>" type="text">
			</td>
		</tr>

		<tr>
			<th>
			<label data-hint="<?php echo __("Choose an hover color for the text.", "smart-footer-system"); ?>" for="sfs-footer-banner-button-font-color-hover"><?php echo __("Text hover color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-button-font-color-hover" name="sfs[banner][<?php echo $res ?>][button-font-color-hover]" class="sfs-color-picker" value="<?php echo (isset($currentSfsBannerSettings["button-font-color-hover"]) && $currentSfsBannerSettings["button-font-color-hover"] !='') ? $currentSfsBannerSettings["button-font-color-hover"] : '' ?>" type="text">
			</td>
		</tr>
		<tr>
			<th>
			<label data-hint="<?php echo __("Define the size of the button.", "smart-footer-system"); ?>" for="sfs-footer-banner-button-size"><?php echo __("Size", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][button-size]" id="sfs-footer-banner-button-size">
					<option <?php echo (isset($currentSfsBannerSettings["button-size"]) && $currentSfsBannerSettings["button-size"]=='small') ? 'selected' : '' ?> value="small">small</option>
					<option <?php echo (isset($currentSfsBannerSettings["button-size"]) && $currentSfsBannerSettings["button-size"]=='medium') ? 'selected' : '' ?> value="medium">medium</option>
					<option <?php echo (isset($currentSfsBannerSettings["button-size"]) && $currentSfsBannerSettings["button-size"]=='large') ? 'selected' : '' ?> value="large">large</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
			<label data-hint="<?php echo __("Choose the button shape.", "smart-footer-system"); ?>" for="sfs-footer-banner-button-shape"><?php echo __("Shape", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][button-shape]" id="sfs-footer-banner-button-shape">
					<option <?php echo (isset($currentSfsBannerSettings["button-shape"]) && $currentSfsBannerSettings["button-shape"]=='squared') ? 'selected' : '' ?> value="squared">squared</option>
					<option <?php echo (isset($currentSfsBannerSettings["button-shape"]) && $currentSfsBannerSettings["button-shape"]=='rounded') ? 'selected' : '' ?> value="rounded">rounded</option>
				</select>
			</td>
		</tr>		
	</tbody>
</table>