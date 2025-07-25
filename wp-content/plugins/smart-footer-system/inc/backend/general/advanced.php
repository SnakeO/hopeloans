<table class="form-table sfs-table">
	<tbody>
		<tr>
			<td style="text-align: left;">
				<label data-hint="<?php echo __("If you want to personalize more your footer you can use this input to insert your custom css.", "smart-footer-system"); ?>" style="font-weight: 600; margin-bottom: 2px" for="sfs-custom-css">
					<?php echo __("Custom Css", "smart-footer-system") ?>
				</label>			
				<textarea class="sfs-element-text" name="sfs[custom-css]" style="width: 100%; height: 200px;"><?php echo (isset($sfsFooterSettings['custom-css'])) ? $sfsFooterSettings['custom-css'] : '' ?></textarea>
			</td>
		</tr>
	</tbody>
</table>