<table class="form-table sfs-table">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-style.", "smart-footer-system"); ?>" for=""><?php echo __("Font style", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[accordion][font-style]" id="">
					<option <?php echo (isset($sfsFooterSettings['accordion']['font-style']) && $sfsFooterSettings['accordion']['font-style'] == 'normal') ? 'selected' : '' ?> value="normal">normal</option>
					<option <?php echo (isset($sfsFooterSettings['accordion']['font-style']) && $sfsFooterSettings['accordion']['font-style'] == 'italic') ? 'selected' : '' ?> value="italic">italic</option>
					<option <?php echo (isset($sfsFooterSettings['accordion']['font-style']) && $sfsFooterSettings['accordion']['font-style'] == 'oblique') ? 'selected' : '' ?> value="oblique">oblique</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-weight.", "smart-footer-system"); ?>" for=""><?php echo __("Font weight", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[accordion][font-weight]" id="">
					<option <?php echo (isset($sfsFooterSettings['accordion']['font-weight']) && $sfsFooterSettings['accordion']['font-weight'] == 'normal') ? 'selected' : '' ?> value="normal">normal</option>
					<option <?php echo (isset($sfsFooterSettings['accordion']['font-weight']) && $sfsFooterSettings['accordion']['font-weight'] == 'bold') ? 'selected' : '' ?> value="bold">bold</option>
					<option <?php echo (isset($sfsFooterSettings['accordion']['font-weight']) && $sfsFooterSettings['accordion']['font-weight'] == 'bolder') ? 'selected' : '' ?> value="bolder">bolder</option>
					<option <?php echo (isset($sfsFooterSettings['accordion']['font-weight']) && $sfsFooterSettings['accordion']['font-weight'] == 'lighter') ? 'selected' : '' ?> value="lighter">lighter</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-size.", "smart-footer-system"); ?>" for=""><?php echo __("Font size", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="12" max="100" value="<?php echo (isset($sfsFooterSettings['accordion']['font-size'])) ? $sfsFooterSettings['accordion']['font-size'] : '12' ?>">
					<input type="text" name="sfs[accordion][font-size]" value="<?php echo (isset($sfsFooterSettings['accordion']['font-size'])) ? $sfsFooterSettings['accordion']['font-size'] : '12' ?>">
					px
				</div>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a line-height.", "smart-footer-system"); ?>" for=""><?php echo __("Line height", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="1" max="100" value="<?php echo (isset($sfsFooterSettings['accordion']['line-height'])) ? $sfsFooterSettings['accordion']['line-height'] : '12' ?>">
					<input type="text" name="sfs[accordion][line-height]" value="<?php echo (isset($sfsFooterSettings['accordion']['line-height'])) ? $sfsFooterSettings['accordion']['line-height'] : '12' ?>">
					px
				</div>
			</td>
		</tr>		
	</tbody>
</table>