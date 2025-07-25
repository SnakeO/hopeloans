<table class="form-table sfs-table">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Insert a text message to show on the handle (optional).", "smart-footer-system"); ?>" for=""><?php echo __("Text", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text" name="sfs[close-text]" type="text" value="<?php echo (isset($sfsFooterSettings['close-text'])) ? $sfsFooterSettings['close-text'] : '' ?>">
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose an icon between various library (optional).", "smart-footer-system"); ?>" for="sfs-footer-type-select">
					<?php echo __("Icon", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<input class="regular-text" type="hidden" id="sfs-close-icon" name="sfs[close-icon]" value="<?php if( isset( $sfsFooterSettings['close-icon'] ) ) { echo esc_attr( $sfsFooterSettings['close-icon'] ); } ?>"/>
				<div id="preview_sfs-close-icon" data-target="#sfs-close-icon" class="button icon-picker <?php if( isset( $sfsFooterSettings['close-icon'] ) ) { $v=explode('|',$sfsFooterSettings['close-icon']); echo $v[0].' '.$v[1]; } ?>"></div>
			</td>
		</tr>			
		<tr>
			<th>
				<label data-hint="<?php echo __("Set the background color of the handle.", "smart-footer-system"); ?>" for=""><?php echo __("Background color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[bg-close-icon-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['bg-close-icon-color'])) ? $sfsFooterSettings['bg-close-icon-color'] : '' ?>">
			</td>
		</tr>	
		<tr>
			<th>
				<label data-hint="<?php echo __("Define the icon color of the handle.", "smart-footer-system"); ?>" for=""><?php echo __("Icon color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[close-icon-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['close-icon-color'])) ? $sfsFooterSettings['close-icon-color'] : '' ?>">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose a color for your text.", "smart-footer-system"); ?>" for=""><?php echo __("Text color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[close-text-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['close-text-color'])) ? $sfsFooterSettings['close-text-color'] : '' ?>">
			</td>
		</tr>				
	</tbody>
</table>