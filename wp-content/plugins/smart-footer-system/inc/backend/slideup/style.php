<table class="form-table sfs-table">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("You can define if your prefer to have a normal handle or a full width handle.", "smart-footer-system"); ?>" for="sfs-footer-width-select"><?php echo __("Width", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[footer-width]" id="sfs-footer-width-select">
					<option <?php echo (isset($sfsFooterSettings['footer-width']) && $sfsFooterSettings['footer-width'] == 'normal') ? 'selected' : '' ?> value="normal"><?php echo __("Normal", 'smart-footer-system') ?></option>					
					<option <?php echo (isset($sfsFooterSettings['footer-width']) && $sfsFooterSettings['footer-width'] == 'full-width') ? 'selected' : '' ?> value="full-width"><?php echo __("Full width", 'smart-footer-system') ?></option>				
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define the position of your handle footer on the page.", "smart-footer-system"); ?>" for=""><?php echo __("Position", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[icon-position]" id="sfs-footer-icon-position-select">
					<option <?php echo (isset($sfsFooterSettings['icon-position']) && $sfsFooterSettings['icon-position'] == 'left') ? 'selected' : '' ?> value="left"><?php echo __("Left", 'smart-footer-system') ?></option>
					<option <?php echo (isset($sfsFooterSettings['icon-position']) && $sfsFooterSettings['icon-position'] == 'center') ? 'selected' : '' ?> value="center"><?php echo __("Center", 'smart-footer-system') ?></option>
					<option <?php echo (isset($sfsFooterSettings['icon-position']) && $sfsFooterSettings['icon-position'] == 'right') ? 'selected' : '' ?> value="right"><?php echo __("Right", 'smart-footer-system') ?></option>
				</select>
			</td>
		</tr>			
		<tr>
			<th>
				<label data-hint="<?php echo __("If you select a normal handle you could give a different shape to the handle as moon, circle etc.", "smart-footer-system"); ?>" for="sfs-footer-icon-shape-select">
					<?php echo __("Shape", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<select name="sfs[icon-shape]" id="sfs-footer-icon-shape-select">
					<option data-hide-on="" <?php echo (isset($sfsFooterSettings['icon-shape']) && $sfsFooterSettings['icon-shape'] == 'squared') ? 'selected' : '' ?> value="squared"><?php echo __("Squared", 'smart-footer-system') ?></option>
					<option data-hide-on="full-width" <?php echo (isset($sfsFooterSettings['icon-shape']) && $sfsFooterSettings['icon-shape'] == 'rounded') ? 'selected' : '' ?> value="rounded"><?php echo __("Rounded", 'smart-footer-system') ?></option>
					<option data-hide-on="full-width" <?php echo (isset($sfsFooterSettings['icon-shape']) && $sfsFooterSettings['icon-shape'] == 'circle') ? 'selected' : '' ?> value="circle"><?php echo __("Circle", 'smart-footer-system') ?></option>
					<option data-hide-on="full-width" <?php echo (isset($sfsFooterSettings['icon-shape']) && $sfsFooterSettings['icon-shape'] == 'half-moon') ? 'selected' : '' ?> value="half-moon"><?php echo __("Moon", 'smart-footer-system') ?></option>					
				</select>
			</td>
		</tr>		
		<tr id="sfs-footer-vertical-padding-tr">
			<th>
				<label data-hint="<?php echo __("Set a vertical padding of the handle.", "smart-footer-system"); ?>" for="sfs-footer-icon-shape-select">
					<?php echo __("Vertical Padding", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<select name="sfs[vertical-padding]" id="sfs-footer-vertical-padding-select">
					<option <?php echo (isset($sfsFooterSettings['vertical-padding']) && $sfsFooterSettings['vertical-padding'] == '0x') ? 'selected' : '' ?> value="0x">none</option>
					<option <?php echo (isset($sfsFooterSettings['vertical-padding']) && $sfsFooterSettings['vertical-padding'] == '1x') ? 'selected' : '' ?> value="1x">small</option>
					<option <?php echo (isset($sfsFooterSettings['vertical-padding']) && $sfsFooterSettings['vertical-padding'] == '2x') ? 'selected' : '' ?> value="2x">large</option>
				</select>
			</td>
		</tr>	
		<tr>
			<th>
				<label data-hint="<?php echo __("Define text alignment of your handle.", "smart-footer-system"); ?>" for=""><?php echo __("Icon/Text aligment", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[icon-text-position]" id="sfs-footer-icon-shape-select">
					<option <?php echo (isset($sfsFooterSettings['icon-text-position']) && $sfsFooterSettings['icon-text-position'] == 'text-right') ? 'selected' : '' ?> value="text-right"><?php echo __("Icon left / Text right", 'smart-footer-system') ?></option>		
					<option <?php echo (isset($sfsFooterSettings['icon-text-position']) && $sfsFooterSettings['icon-text-position'] == 'text-left') ? 'selected' : '' ?> value="text-left"><?php echo __("Text left / Icon right", 'smart-footer-system') ?></option>	
				</select>
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose if you prefer to set a transparency to the handle", "smart-footer-system"); ?>" for="sfs-trasparency-footer-check"><?php echo __("Transparency", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input data-target="sfs-bottom-transparency-alpha-tr" <?php echo ( isset($sfsFooterSettings['transparency']) && $sfsFooterSettings['transparency']) ? 'checked': '' ?> id="sfs-transparency-footer-check" name="sfs[transparency]" type="checkbox" class="regular-text">
			</td>
		</tr>
		<tr id="sfs-bottom-transparency-alpha-tr" class="tr-child">
			<th>
				<label data-hint="<?php echo __("Set an alpha to the handle from 0 (hide) to 1 (visible), by default if active is 0.5.", "smart-footer-system"); ?>" for="sfs-trasparency-alpha"><?php echo __("Alpha", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input min="0" max="1" step="0.1" value="<?php echo ( isset($sfsFooterSettings['transparency-alpha'])) ? $sfsFooterSettings['transparency-alpha'] : '0.5' ?>"  type="range">
					<input type="text" name="sfs[transparency-alpha]" value="<?php echo ( isset($sfsFooterSettings['transparency-alpha'])) ? $sfsFooterSettings['transparency-alpha'] : '0.5' ?>" class="sfs-element-text">
				</div>
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Set it if you want a shadow on the top of the handle.", "smart-footer-system"); ?>" for="sfs-shadow-footer-check"><?php echo __("Shadow", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input <?php echo ( isset($sfsFooterSettings['shadow']) && $sfsFooterSettings['shadow']) ? 'checked': '' ?> id="sfs-shadow-footer-check" name="sfs[shadow]" type="checkbox" class="regular-text">
			</td>
		</tr>		
	</tbody>	
</table>