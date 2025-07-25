<table class="form-table sfs-table">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Optionally set a custom text on the left of the icon.", "smart-footer-system"); ?>" for=""><?php echo __("Left text", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text" name="sfs[accordion][left-text]" type="text" value="<?php echo (isset($sfsFooterSettings['accordion']['left-text'])) ? $sfsFooterSettings['accordion']['left-text'] : '' ?>">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Optionally set a custom text on the right of the icon.", "smart-footer-system"); ?>" for=""><?php echo __("Right text", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text" name="sfs[accordion][right-text]" type="text" value="<?php echo (isset($sfsFooterSettings['accordion']['right-text'])) ? $sfsFooterSettings['accordion']['right-text'] : '' ?>">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set a color for your text.", "smart-footer-system"); ?>" for=""><?php echo __("Color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[accordion][text-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['accordion']['text-color'])) ? $sfsFooterSettings['accordion']['text-color'] : '' ?>">
			</td>
		</tr>		
	</tbody>
</table>