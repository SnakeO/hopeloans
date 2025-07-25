<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define if you want to open and close your footer with click or mouse hover effect.", "smart-footer-system"); ?>" for=""><?php echo __("Trigger on", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[open-on]" id="">
					<option <?php echo (isset($sfsFooterSettings['open-on']) && $sfsFooterSettings['open-on'] == 'click') ? 'selected' : '' ?> value="click"><?php echo __("Click", 'smart-footer-system') ?></option>				
					<option <?php echo (isset($sfsFooterSettings['open-on']) && $sfsFooterSettings['open-on'] == 'mouseover') ? 'selected' : '' ?> value="mouseover"><?php echo __("Mouse Hover", 'smart-footer-system') ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose if you want a normal or full height footer version.", "smart-footer-system"); ?>" for="sfs-footer-height-select"><?php echo __("Footer height", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[footer-height]" id="sfs-footer-height-select">
					<option <?php echo (isset($sfsFooterSettings['footer-height']) && $sfsFooterSettings['footer-height'] == 'normal') ? 'selected' : '' ?> value="normal"><?php echo __("Normal", 'smart-footer-system') ?></option>					
					<option <?php echo (isset($sfsFooterSettings['footer-height']) && $sfsFooterSettings['footer-height'] == 'full-height') ? 'selected' : '' ?> value="full-height"><?php echo __("Full height", 'smart-footer-system') ?></option>				
				</select>
			</td>
		</tr>		
		<tr class="tr-child" id="sfs-vertical-aligment-tr">
			<th>
				<label data-hint="<?php echo __("Set a vertical alignment for the footer content.", "smart-footer-system"); ?>" for="sfs-footer-v-align-select"><?php echo __("Vertical Alignment", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[v-align]" id="sfs-footer-v-align-select">
					<option <?php echo (isset($sfsFooterSettings['v-align']) && $sfsFooterSettings['v-align'] == 'top') ? 'selected' : '' ?> value="top"><?php echo __("Top", 'smart-footer-system') ?></option>					
					<option <?php echo (isset($sfsFooterSettings['v-align']) && $sfsFooterSettings['v-align'] == 'center') ? 'selected' : '' ?> value="center"><?php echo __("Center", 'smart-footer-system') ?></option>
					<option <?php echo (isset($sfsFooterSettings['v-align']) && $sfsFooterSettings['v-align'] == 'bottom') ? 'selected' : '' ?> value="bottom"><?php echo __("Bottom", 'smart-footer-system') ?></option>
				</select>
			</td>
		</tr>			
		<tr>
			<th>
				<label data-hint="<?php echo __("Define if you want a bottom border color under your handle.", "smart-footer-system"); ?>" for=""><?php echo __("Divider color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[divider-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['divider-color'])) ? $sfsFooterSettings['divider-color'] : '' ?>">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set the height of the bottom divider.", "smart-footer-system"); ?>" for=""><?php echo __("Divider height", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input style="width:80px" class="regular-text" name="sfs[divider-height]" type="number" value="<?php echo (isset($sfsFooterSettings['divider-height'])) ? $sfsFooterSettings['divider-height'] : 0 ?>"> px
			</td>
		</tr>	
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose what kind of animation you want to give to the handle.", "smart-footer-system"); ?>" for="sfs-animation-select">
					<?php echo __("Animation", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<select name="sfs[animation]" id="sfs-animation-select">
					<?php
					$animations = [
					"fade" 		=> __("Fade", 'smart-footer-system'),
					"scale" 	=> __("Scale", 'smart-footer-system'),
					"rotate" 	=> __("Rotate", 'smart-footer-system'),
					"slide" 	=> __("Slide", 'smart-footer-system'),
					"flip" 		=> __("Flip", 'smart-footer-system'),
					];
					foreach($animations as $key => $label):
						?>
					<option <?php echo (isset($sfsFooterSettings['animation']) && $sfsFooterSettings['animation'] == $key) ? 'selected' : '' ?> value="<?php echo $key ?>"><?php echo $label ?></option>	
				<?php endforeach; ?>		
			</select>
		</td>
	</tr>			
	<tr>
		<th>
			<label data-hint="<?php echo __("Define the speed of the animation.", "smart-footer-system"); ?>" for="sfs-open-speed-select">
				<?php echo __("Animation Speed", "smart-footer-system") ?>
			</label>
		</th>
		<td>
			<select name="sfs[open-speed]" id="sfs-open-speed-select">
				<?php
				$openSpeeds = [
				"no-animation" 	=> __("No Animation", 'smart-footer-system'),
				"very-slow" 	=> __("Very Slow", 'smart-footer-system'),
				"slow" 			=> __("Slow", 'smart-footer-system'),
				"medium"		=> __("Medium", 'smart-footer-system'),
				"fast"			=> __("Fast", 'smart-footer-system'),
				"very-fast"		=> __("Very fast", 'smart-footer-system'),
				];
				foreach($openSpeeds as $key => $label):
					?>
				<option <?php echo (isset($sfsFooterSettings['open-speed']) && $sfsFooterSettings['open-speed'] == $key) ? 'selected' : '' ?> value="<?php echo $key ?>"><?php echo $label ?></option>	
			<?php endforeach; ?>		
		</select>
	</td>
</tr>	
<tr>
	<th>
		<label data-hint="<?php echo __("If you switch on this option the handle footer will appear from bottom in the end of the page.", "smart-footer-system"); ?>" for="sfs-open-on-bottom-footer-check"><?php echo __("Auto open on end of page scroll", 'smart-footer-system') ?></label>
	</th>
	<td>
		<input <?php echo ( isset($sfsFooterSettings['open-on-bottom']) && $sfsFooterSettings['open-on-bottom']) ? 'checked': '' ?> id="sfs-open-on-bottom-footer-check" name="sfs[open-on-bottom]" type="checkbox" class="regular-text">
	</td>
</tr>			
</tbody>
</table>