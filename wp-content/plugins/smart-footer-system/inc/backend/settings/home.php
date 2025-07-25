<table class="form-table sfs-table sfs-table-full">
	<tbody>				
		<tr>
			<th>
				<label data-hint="<?php echo __("Set footer for the homepage of your site.", "smart-footer-system"); ?>" for="">
					<?php echo __("Homepage Footer", 'smart-footer-system') ?>
				</label>
			</th>
			<td>
				<select name="sfs[footers][home]">
					<option <?php echo (!isset($sfsSettings["footers"]["home"]) || !$sfsSettings["footers"]["home"]) ? 'selected' : '' ?> value="false"><?php echo __("Theme footer", 'smart-footer-system') ?></option>
					<?php foreach($sfsFooters as $sfsFooter): ?>
						<option <?php echo (isset($sfsSettings["footers"]["home"]) && $sfsSettings["footers"]["home"] == $sfsFooter->ID) ? 'selected' : '' ?> value="<?php echo $sfsFooter->ID ?>"><?php echo $sfsFooter->post_title ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set footer for the blog page of your site.", "smart-footer-system"); ?>" for="">
					<?php echo __("Blog Footer", 'smart-footer-system') ?>
				</label>
			</th>
			<td>
				<select name="sfs[footers][blog]">
					<option <?php echo (!isset($sfsSettings["footers"]["blog"]) || !$sfsSettings["footers"]["blog"]) ? 'selected' : '' ?> value="false"><?php echo __("Theme footer", 'smart-footer-system') ?></option>
					<?php foreach($sfsFooters as $sfsFooter): ?>
						<option <?php echo (isset($sfsSettings["footers"]["blog"]) && $sfsSettings["footers"]["blog"] == $sfsFooter->ID) ? 'selected' : '' ?> value="<?php echo $sfsFooter->ID ?>"><?php echo $sfsFooter->post_title ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>			
	</tbody>
</table>