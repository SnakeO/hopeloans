<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a border size", "smart-footer-system"); ?>" for=""><?php echo __("Border size", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="0" max="500" value="<?php echo (isset($sfsFooterSettings["content-border-size"])) ? $sfsFooterSettings["content-border-size"] : '0' ?>">
					<input value="<?php echo (isset($sfsFooterSettings["content-border-size"])) ? $sfsFooterSettings["content-border-size"] : '0' ?>" type="text" name="sfs[content-border-size]">
					px
				</div>
			</td>
		</tr>	
		<tr>
			<th>
				<label data-hint="<?php echo __("You can also set type for your border", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("Border Type", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[content-border-type]" id="sfs-footer-banner-background-image-size">
					<option <?php echo (!isset($sfsFooterSettings["content-border-type"]) || $sfsFooterSettings["content-border-type"] == 'solid') ?> value="solid">solid</option>				
					<option <?php echo (isset($sfsFooterSettings["content-border-type"]) && $sfsFooterSettings["content-border-type"] == 'dotted') ?> value="dotted">dotted</option>
					<option <?php echo (isset($sfsFooterSettings["content-border-type"]) && $sfsFooterSettings["content-border-type"] == 'dashed') ?> value="dashed">dashed</option>
					<option <?php echo (isset($sfsFooterSettings["content-border-type"]) && $sfsFooterSettings["content-border-type"] == 'double') ?> value="double">double</option>
					<option <?php echo (isset($sfsFooterSettings["content-border-type"]) && $sfsFooterSettings["content-border-type"] == 'groove') ?> value="groove">groove</option>
					<option <?php echo (isset($sfsFooterSettings["content-border-type"]) && $sfsFooterSettings["content-border-type"] == 'ridge') ?> value="ridge">ridge</option>
					<option <?php echo (isset($sfsFooterSettings["content-border-type"]) && $sfsFooterSettings["content-border-type"] == 'inset') ?> value="inset">inset</option>
					<option <?php echo (isset($sfsFooterSettings["content-border-type"]) && $sfsFooterSettings["content-border-type"] == 'outset') ?> value="outset">outset</option>
				</select>
			</td>
		</tr>	
		<tr>
			<th>
				<label data-hint="<?php echo __("You can also set a color for border", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("Border Color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-overlay-color" name="sfs[content-border-color]" class="sfs-color-picker" value="<?php echo (isset($sfsFooterSettings["content-border-color"]) && $sfsFooterSettings["content-border-color"] !='') ? $sfsFooterSettings["content-border-color"] : '' ?>" type="text">
			</td>
		</tr>
	</tbody>
</table>