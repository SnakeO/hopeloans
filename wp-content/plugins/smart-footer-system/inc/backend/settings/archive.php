<table class="form-table sfs-table sfs-table-full">
	<tbody>		
		<?php foreach($sfsPostTypes as $key => $sfsPostType): if($key == 'product') continue; ?>
			<tr>
				<th>
				<label data-hint="<?php echo __("Set footer for archive ", "smart-footer-system"); ?>		<?php echo $sfsPostType->label ?>">
					<?php echo __("Archive", 'smart-footer-system') ?>
					<?php echo $sfsPostType->label ?>
					<?php echo __("Footer", 'smart-footer-system') ?>
					</label>
				</th>
				<td>
					<select name="sfs[footers][archive_<?php echo $key ?>]">
						<option <?php echo (!isset($sfsSettings["footers"]['archive_'.$key]) || !$sfsSettings["footers"]['archive_'.$key]) ? 'selected' : '' ?> value="false"><?php echo __("Theme footer", 'smart-footer-system') ?></option>
						<?php foreach($sfsFooters as $sfsFooter): ?>
							<option <?php echo (isset($sfsSettings["footers"]['archive_'.$key]) && $sfsSettings["footers"]['archive_'.$key] == $sfsFooter->ID) ? 'selected' : '' ?> value="<?php echo $sfsFooter->ID ?>"><?php echo $sfsFooter->post_title ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>