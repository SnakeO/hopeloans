<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("With this option you can select two different ways to show your accordion footer", "smart-footer-system"); ?>" for=""><?php echo __("Accordion type", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[accordion][type]" id="">
					<option <?php echo (isset($sfsFooterSettings["accordion"]["type"]) && $sfsFooterSettings["accordion"]["type"] == 'normal') ? 'selected' : '' ?> value="normal"><?php echo __("Normal", 'smart-footer-system') ?></option>
					<option <?php echo (isset($sfsFooterSettings["accordion"]["type"]) && $sfsFooterSettings["accordion"]["type"] == 'half-moon') ? 'selected' : '' ?> value="half-moon"><?php echo __("Half moon", 'smart-footer-system') ?></option>
				</select>
			</td>
		</tr>
	</tbody>
</table>