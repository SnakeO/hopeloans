<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define an icon to show on your handle footer in order to open your footer content.", "smart-footer-system"); ?>" for=""><?php echo __("Open Icon", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text" type="hidden" id="sfs-accordion-open-icon" name="sfs[accordion][open-icon]" value="<?php if( isset( $sfsFooterSettings['accordion']['open-icon'] ) ) { echo esc_attr( $sfsFooterSettings['accordion']['open-icon'] ); } ?>"/>
				<div id="preview_sfs-accordion-open-icon" data-target="#sfs-accordion-open-icon" class="button icon-picker <?php if( isset( $sfsFooterSettings['accordion']['open-icon'] ) ) { $v=explode('|',$sfsFooterSettings['accordion']['open-icon']); echo $v[0].' '.$v[1]; } ?>"></div>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define an icon to show on your handle footer in order to close your footer content.", "smart-footer-system"); ?>" for=""><?php echo __("Close Icon", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text" type="hidden" id="sfs-accordion-close-icon" name="sfs[accordion][close-icon]" value="<?php if( isset( $sfsFooterSettings['accordion']['close-icon'] ) ) { echo esc_attr( $sfsFooterSettings['accordion']['close-icon'] ); } ?>"/>
				<div id="preview_sfs-accordion-close-icon" data-target="#sfs-accordion-close-icon" class="button icon-picker <?php if( isset( $sfsFooterSettings['accordion']['close-icon'] ) ) { $v=explode('|',$sfsFooterSettings['accordion']['close-icon']); echo $v[0].' '.$v[1]; } ?>"></div>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set a color for your icon.", "smart-footer-system"); ?>" for=""><?php echo __("Icon Color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[accordion][icon-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['accordion']['icon-color'])) ? $sfsFooterSettings['accordion']['icon-color'] : '' ?>">
			</td>
		</tr>
	</tbody>
</table>