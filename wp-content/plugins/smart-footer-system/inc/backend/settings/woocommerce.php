<table class="form-table sfs-table sfs-table-full">
	<tbody>				
		<tr>
			<th>
				<?php echo __("Shop Page Footer", 'smart-footer-system') ?>
			</th>
			<td>
				<select name="sfs[footers][shop]">
					<option <?php echo (!isset($sfsSettings["footers"]["shop"]) || !$sfsSettings["footers"]["shop"]) ? 'selected' : '' ?> value="false"><?php echo __("Theme footer", 'smart-footer-system') ?></option>
					<?php foreach($sfsFooters as $sfsFooter): ?>
						<option <?php echo (isset($sfsSettings["footers"]["shop"]) && $sfsSettings["footers"]["shop"] == $sfsFooter->ID) ? 'selected' : '' ?> value="<?php echo $sfsFooter->ID ?>"><?php echo $sfsFooter->post_title ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>	
		<tr>
			<th>
				<?php echo __("My Account Page Footer", 'smart-footer-system') ?>
			</th>
			<td>
				<select name="sfs[footers][account]">
					<option <?php echo (!isset($sfsSettings["footers"]["account"]) || !$sfsSettings["footers"]["account"]) ? 'selected' : '' ?> value="false"><?php echo __("Theme footer", 'smart-footer-system') ?></option>
					<?php foreach($sfsFooters as $sfsFooter): ?>
						<option <?php echo (isset($sfsSettings["footers"]["account"]) && $sfsSettings["footers"]["account"] == $sfsFooter->ID) ? 'selected' : '' ?> value="<?php echo $sfsFooter->ID ?>"><?php echo $sfsFooter->post_title ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>								
		<tr>
			<th>
				<?php echo __("Cart Page Footer", 'smart-footer-system') ?>
			</th>
			<td>
				<select name="sfs[footers][cart]">
					<option <?php echo (!isset($sfsSettings["footers"]["cart"]) || !$sfsSettings["footers"]["cart"]) ? 'selected' : '' ?> value="false"><?php echo __("Theme footer", 'smart-footer-system') ?></option>
					<?php foreach($sfsFooters as $sfsFooter): ?>
						<option <?php echo (isset($sfsSettings["footers"]["cart"]) && $sfsSettings["footers"]["cart"] == $sfsFooter->ID) ? 'selected' : '' ?> value="<?php echo $sfsFooter->ID ?>"><?php echo $sfsFooter->post_title ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<?php echo __("Checkout Page Footer", 'smart-footer-system') ?>
			</th>
			<td>
				<select name="sfs[footers][checkout]">
					<option <?php echo (!isset($sfsSettings["footers"]["checkout"]) || !$sfsSettings["footers"]["checkout"]) ? 'selected' : '' ?> value="false"><?php echo __("Theme footer", 'smart-footer-system') ?></option>
					<?php foreach($sfsFooters as $sfsFooter): ?>
						<option <?php echo (isset($sfsSettings["footers"]["checkout"]) && $sfsSettings["footers"]["checkout"] == $sfsFooter->ID) ? 'selected' : '' ?> value="<?php echo $sfsFooter->ID ?>"><?php echo $sfsFooter->post_title ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>		
		<tr>
			<th>
				<?php echo __("Single Products Footer", 'smart-footer-system') ?>
			</th>
			<td>
				<select name="sfs[footers][product]">
					<option <?php echo (!isset($sfsSettings["footers"]["product"]) || !$sfsSettings["footers"]["product"]) ? 'selected' : '' ?> value="false"><?php echo __("Theme footer", 'smart-footer-system') ?></option>
					<?php foreach($sfsFooters as $sfsFooter): ?>
						<option <?php echo (isset($sfsSettings["footers"]["product"]) && $sfsSettings["footers"]["product"] == $sfsFooter->ID) ? 'selected' : '' ?> value="<?php echo $sfsFooter->ID ?>"><?php echo $sfsFooter->post_title ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<?php echo __("Archive Products Footer", 'smart-footer-system') ?>
			</th>
			<td>
				<select name="sfs[footers][archive_product]">
					<option <?php echo (!isset($sfsSettings["footers"]["archive_product"]) || !$sfsSettings["footers"]["archive_product"]) ? 'selected' : '' ?> value="false"><?php echo __("Theme footer", 'smart-footer-system') ?></option>
					<?php foreach($sfsFooters as $sfsFooter): ?>
						<option <?php echo (isset($sfsSettings["footers"]["archive_product"]) && $sfsSettings["footers"]["archive_product"] == $sfsFooter->ID) ? 'selected' : '' ?> value="<?php echo $sfsFooter->ID ?>"><?php echo $sfsFooter->post_title ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>									
	</tbody>
</table>