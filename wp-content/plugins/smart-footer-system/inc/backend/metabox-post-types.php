<div id="sfs-footer-metabox">
	<table class="form-table sfs-table sfs-table-full">
		<tbody>
			<tr>
				<th>
					<label data-hint="<?php echo __("Switch on if you want to display a different footer to this particular page", "smart-footer-system"); ?>" for="sfs-hide-footer-check">
						<?php echo __("Override default Smart Footer System Footer", "smart-footer-system") ?>
					</label>
				</th>
				<td>
					<input <?php echo ( $sfsPostFooter['override']) ? 'checked': '' ?> id="sfs-hide-footer-check" name="sfs[override]" type="checkbox" class="regular-text">
				</td>
			</tr>				
			<tr class="sfs-tr-hide-footer">
				<th>
					<label data-hint="<?php echo __("Define the new footer that you want to display", "smart-footer-system"); ?>" for="">
						<?php echo __("New Footer", 'smart-footer-system') ?>
					</label>
					
				</th>
				<td>
					<select name="sfs[footer]">
						<?php foreach($sfsFooters as $sfsFooter): ?>
							<option <?php echo ($sfsPostFooter["id"] == $sfsFooter->ID) ? 'selected' : '' ?> value="<?php echo $sfsFooter->ID ?>"><?php echo $sfsFooter->post_title ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th>
					<label data-hint="<?php echo __("Disable Smart Footer System only to this particular page", "smart-footer-system"); ?>" for="sfs-disable-footer-check">
						<?php echo __("Disable Smart Footer System", "smart-footer-system") ?>
					</label>
				</th>
				<td>
					<input <?php echo ( $sfsPostFooter['disable']) ? 'checked': '' ?> id="sfs-disable-footer-check" name="sfs[disable]" type="checkbox" class="regular-text">
				</td>			
			</tr>
		</tbody>
	</table>
</div>