<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("If you want to hide your footer on desktop switch on this option.", "smart-footer-system"); ?>" for="sfs-banner-hide-on-desktop"><?php echo __("Hide on desktop", "smart-footer-system") ?></label>
			</th>
			<td>
				<input <?php echo (isset($sfsFooterSettings['hide-on-desktop']) && $sfsFooterSettings['hide-on-desktop'] == 1) ? 'checked' : '' ?> data-type="auto-check" name="sfs[hide-on-desktop]" type="checkbox" value="1">
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("If you want to hide your footer on tablet switch on this option.", "smart-footer-system"); ?>" for="sfs-banner-hide-on-tablet"><?php echo __("Hide on tablet", "smart-footer-system") ?></label>
			</th>
			<td>
				<input <?php echo (isset($sfsFooterSettings['hide-on-tablet']) && $sfsFooterSettings['hide-on-tablet'] == 1) ? 'checked' : '' ?> data-type="auto-check" name="sfs[hide-on-tablet]" type="checkbox" value="1">
			</td>
		</tr>			
		<tr>
			<th>
				<label data-hint="<?php echo __("If you want to hide your footer on mobile switch on this option.", "smart-footer-system"); ?>" for="sfs-banner-hide-on-mobile"><?php echo __("Hide on mobile", "smart-footer-system") ?></label>
			</th>
			<td>
				<input <?php echo (isset($sfsFooterSettings['hide-on-mobile']) && $sfsFooterSettings['hide-on-mobile'] == 1) ? 'checked' : '' ?> data-type="auto-check" name="sfs[hide-on-mobile]" type="checkbox" value="1">
			</td>
		</tr>		
	</tbody>
</table>