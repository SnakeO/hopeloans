<table class="form-table sfs-table">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Insert a text message to show on the handle (optional).", "smart-footer-system"); ?>" for=""><?php echo __("Text", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text" name="sfs[open-text]" type="text" value="<?php echo (isset($sfsFooterSettings['open-text'])) ? $sfsFooterSettings['open-text'] : '' ?>">
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose an icon between various library (optional).", "smart-footer-system"); ?>" for="sfs-footer-type-select">
					<?php echo __("Icon", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<input class="regular-text" type="hidden" id="sfs-open-icon" name="sfs[open-icon]" value="<?php if( isset( $sfsFooterSettings['open-icon'] ) ) { echo esc_attr( $sfsFooterSettings['open-icon'] ); } ?>"/>
				<div id="preview_sfs-open-icon" data-target="#sfs-open-icon" class="button icon-picker <?php if( isset( $sfsFooterSettings['open-icon'] ) ) { $v=explode('|',$sfsFooterSettings['open-icon']); echo $v[0].' '.$v[1]; } ?>"></div>
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Set the background color of the handle.", "smart-footer-system"); ?>" for=""><?php echo __("Background color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[bg-open-icon-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['bg-open-icon-color'])) ? $sfsFooterSettings['bg-open-icon-color'] : '' ?>">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define the icon color of the handle.", "smart-footer-system"); ?>" for=""><?php echo __("Icon color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[open-icon-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['open-icon-color'])) ? $sfsFooterSettings['open-icon-color'] : '' ?>">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose a color for your text.", "smart-footer-system"); ?>" for=""><?php echo __("Text color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[open-text-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['open-text-color'])) ? $sfsFooterSettings['open-text-color'] : '' ?>">
			</td>
		</tr>			
	</tbody>
</table>