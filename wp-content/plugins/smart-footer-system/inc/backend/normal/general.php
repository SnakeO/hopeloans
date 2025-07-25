<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Activate if you want a fixed sticky footer", "smart-footer-system"); ?>" for=""><?php echo __("Sticky", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input data-target="sfs-normal-sticky-footer-mobile-check-tr" <?php echo ( isset($sfsFooterSettings['normal-sticky']) && $sfsFooterSettings['normal-sticky']) ? 'checked': '' ?> id="sfs-normal-sticky-footer-check" name="sfs[normal-sticky]" type="checkbox" class="regular-text">
			</td>
		</tr>
		<tr id="sfs-normal-sticky-footer-mobile-check-tr">
			<th>
				<label data-hint="<?php echo __("Activate if you want a sticky on mobile"); ?>" for=""><?php echo __("Mobile Sticky", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input <?php echo ( isset($sfsFooterSettings['normal-sticky-mobile']) && $sfsFooterSettings['normal-sticky-mobile']) ? 'checked': '' ?> id="sfs-normal-sticky-mobile-footer-check" name="sfs[normal-sticky-mobile]" type="checkbox" class="regular-text">
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Activate if you want a top shadow to your footer", "smart-footer-system"); ?>" for=""><?php echo __("Shadow", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input <?php echo ( isset($sfsFooterSettings['normal-shadow-sticky']) && $sfsFooterSettings['normal-shadow-sticky']) ? 'checked': '' ?> id="sfs-normal-shadow-sticky-footer-check" name="sfs[normal-shadow-sticky]" type="checkbox" class="regular-text">
			</td>
		</tr>		
	</tbody>
</table>