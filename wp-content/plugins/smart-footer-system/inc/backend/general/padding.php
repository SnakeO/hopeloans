<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set a vertical padding of the footer content.", "smart-footer-system"); ?>"  for=""><?php echo __("Vertical Content padding", 'smart-footer-system') ?></label>
			</th>
			<td>
				<table class="form-table sfs-table sfs-table-full sfs-table-in">
					<thead>
						<th>Desktop</th>
						<th>Tablet</th>
						<th>Mobile</th>
					</thead>
					<tbody>
						<td><input name="sfs[content-vertical-padding-desktop]" type="text" class="regular-text" value="<?php echo (isset($sfsFooterSettings["content-vertical-padding-desktop"])) ? $sfsFooterSettings["content-vertical-padding-desktop"] : '' ?>"></td>
						<td><input name="sfs[content-vertical-padding-tablet]" type="text" class="regular-text" value="<?php echo (isset($sfsFooterSettings["content-vertical-padding-tablet"])) ? $sfsFooterSettings["content-vertical-padding-tablet"] : '' ?>"></td>
						<td><input name="sfs[content-vertical-padding-mobile]" type="text" class="regular-text" value="<?php echo (isset($sfsFooterSettings["content-vertical-padding-mobile"])) ? $sfsFooterSettings["content-vertical-padding-mobile"] : '' ?>"></td>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set a horizontal padding of the footer content.", "smart-footer-system"); ?>" for=""><?php echo __("Horizontal Content padding", 'smart-footer-system') ?></label>
			</th>
			<td>
				<table class="form-table sfs-table sfs-table-full sfs-table-in">
					<thead>
						<th>Desktop</th>
						<th>Tablet</th>
						<th>Mobile</th>
					</thead>
					<tbody>
						<td><input name="sfs[content-horizontal-padding-desktop]" type="text" class="regular-text" value="<?php echo (isset($sfsFooterSettings["content-horizontal-padding-desktop"])) ? $sfsFooterSettings["content-horizontal-padding-desktop"] : '' ?>"></td>
						<td><input name="sfs[content-horizontal-padding-tablet]" type="text" class="regular-text" value="<?php echo (isset($sfsFooterSettings["content-horizontal-padding-tablet"])) ? $sfsFooterSettings["content-horizontal-padding-tablet"] : '' ?>"></td>
						<td><input name="sfs[content-horizontal-padding-mobile]" type="text" class="regular-text" value="<?php echo (isset($sfsFooterSettings["content-horizontal-padding-mobile"])) ? $sfsFooterSettings["content-horizontal-padding-mobile"] : '' ?>"></td>
					</tbody>
				</table>
			</td>
		</tr>		
	</tbody>
</table>