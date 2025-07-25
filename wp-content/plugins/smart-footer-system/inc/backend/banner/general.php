<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("From this option you can set a vertical padding inside the banner box.", "smart-footer-system"); ?>" for="sfs-footer-banner-v-padding"><?php echo __("Vertical padding", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][v-padding]" id="sfs-footer-banner-v-padding">
					<option <?php echo (isset($currentSfsBannerSettings["v-padding"]) && $currentSfsBannerSettings["v-padding"]=='1x') ? 'selected' : '' ?> value="1x">1x</option>
					<option <?php echo (isset($currentSfsBannerSettings["v-padding"]) && $currentSfsBannerSettings["v-padding"]=='2x') ? 'selected' : '' ?> value="2x">2x</option>
					<option <?php echo (isset($currentSfsBannerSettings["v-padding"]) && $currentSfsBannerSettings["v-padding"]=='3x') ? 'selected' : '' ?> value="3x">3x</option>
					<option <?php echo (isset($currentSfsBannerSettings["v-padding"]) && $currentSfsBannerSettings["v-padding"]=='4x') ? 'selected' : '' ?> value="4x">4x</option>
					<option <?php echo (isset($currentSfsBannerSettings["v-padding"]) && $currentSfsBannerSettings["v-padding"]=='5x') ? 'selected' : '' ?> value="5x">5x</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Feel free to set a horizontal padding to the banner box.", "smart-footer-system"); ?>" for="sfs-footer-banner-h-padding"><?php echo __("Horizontal padding", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][h-padding]" id="sfs-footer-banner-h-padding">
					<option <?php echo (isset($currentSfsBannerSettings["h-padding"]) && $currentSfsBannerSettings["h-padding"]=='1x') ? 'selected' : '' ?> value="1x">1x</option>
					<option <?php echo (isset($currentSfsBannerSettings["h-padding"]) && $currentSfsBannerSettings["h-padding"]=='2x') ? 'selected' : '' ?> value="2x">2x</option>
					<option <?php echo (isset($currentSfsBannerSettings["h-padding"]) && $currentSfsBannerSettings["h-padding"]=='3x') ? 'selected' : '' ?> value="3x">3x</option>
					<option <?php echo (isset($currentSfsBannerSettings["h-padding"]) && $currentSfsBannerSettings["h-padding"]=='4x') ? 'selected' : '' ?> value="4x">4x</option>
					<option <?php echo (isset($currentSfsBannerSettings["h-padding"]) && $currentSfsBannerSettings["h-padding"]=='5x') ? 'selected' : '' ?> value="5x">5x</option>
				</select>
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("With this select you can choose a different content alignment of the title, description and button.", "smart-footer-system"); ?>" for="sfs-footer-banner-content-aligment"><?php echo __("Content alignment", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][content-aligment]" id="sfs-footer-banner-content-aligment">
					<option <?php echo (isset($currentSfsBannerSettings["content-aligment"]) && $currentSfsBannerSettings["content-aligment"]=='left') ? 'selected' : '' ?> value="left">left</option>
					<option <?php echo (isset($currentSfsBannerSettings["content-aligment"]) && $currentSfsBannerSettings["content-aligment"]=='center') ? 'selected' : '' ?> value="center">center</option>
					<option <?php echo (isset($currentSfsBannerSettings["content-aligment"]) && $currentSfsBannerSettings["content-aligment"]=='right') ? 'selected' : '' ?> value="right">right</option>
					<option <?php echo (isset($currentSfsBannerSettings["content-aligment"]) && $currentSfsBannerSettings["content-aligment"]=='justify-right') ? 'selected' : '' ?> value="justify-right">text left / button right</option>						
					<option <?php echo (isset($currentSfsBannerSettings["content-aligment"]) && $currentSfsBannerSettings["content-aligment"]=='justify-left') ? 'selected' : '' ?> value="justify-left">button left / text right</option>				
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set an animation speed opening of the footer.", "smart-footer-system"); ?>" for="sfs-open-speed-select">
					<?php echo __("Animation Speed", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][open-speed]" id="sfs-open-speed-select">
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
					<option <?php echo (isset($currentSfsBannerSettings['open-speed']) && $currentSfsBannerSettings['open-speed'] == $key) ? 'selected' : '' ?> value="<?php echo $key ?>"><?php echo $label ?></option>	
				<?php endforeach; ?>		
			</select>
		</td>
	</tr>
	<tr>
		<th>
			<label data-hint="<?php echo __("Switch on this option if you want to auto show the banner after x seconds.", "smart-footer-system"); ?>" for="sfs-banner-auto-open"><?php echo __("Auto show", 'smart-footer-system'); ?></label>
		</th>
		<td>
			<input <?php echo (isset($currentSfsBannerSettings['auto-show']) && $currentSfsBannerSettings['auto-show'] == 1) ? 'checked' : '' ?> data-type="auto-check" data-target="sfs-banner-auto-show-tr-<?php echo $res ?>" name="sfs[banner][<?php echo $res ?>][auto-show]" type="checkbox" value="1">
		</td>
	</tr>
	<tr class="tr-child"  id="sfs-banner-auto-show-tr-<?php echo $res ?>">
		<th>
			<label data-hint="<?php echo __("Set time in seconds", "smart-footer-system"); ?>" for="sfs-auto-show-input"><?php echo __("Auto show after (seconds)", "smart-footer-system") ?></label>
		</th>
		<td>
			<input name="sfs[banner][<?php echo $res ?>][auto-show-seconds]" type="number" step="0.100" min="0" max="100" value="<?php echo (isset($currentSfsBannerSettings["auto-show-seconds"])) ? $currentSfsBannerSettings["auto-show-seconds"] : '' ?>">
		</td>
	</tr>
	<tr>
		<th>
			<label data-hint="<?php echo __("Switch on this option if you want to auto hide the banner after x seconds.", "smart-footer-system"); ?>" for="sfs-banner-auto-hide"><?php echo __("Auto hide", 'smart-footer-system'); ?></label>
		</th>
		<td>
			<input <?php echo (isset($currentSfsBannerSettings['auto-hide']) && $currentSfsBannerSettings['auto-hide'] == 1) ? 'checked' : '' ?> data-type="auto-check"  data-target="sfs-banner-auto-hide-tr-<?php echo $res ?>" name="sfs[banner][<?php echo $res ?>][auto-hide]" type="checkbox" value="1">
		</td>
	</tr>			
	<tr class="tr-child"  id="sfs-banner-auto-hide-tr-<?php echo $res ?>">
		<th>
			<label data-hint="<?php echo __("Set time in seconds", "smart-footer-system"); ?>" for="sfs-auto-hide-input"><?php echo __("Auto hide after (seconds)", "smart-footer-system") ?></label>
		</th>
		<td>
			<input name="sfs[banner][<?php echo $res ?>][auto-hide-seconds]" type="number" step="0.100" min="0" max="100" value="<?php echo (isset($currentSfsBannerSettings["auto-hide-seconds"])) ? $currentSfsBannerSettings["auto-hide-seconds"] : '' ?>">
		</td>
	</tr>	
	<tr>
		<th>
			<label data-hint="<?php echo __("Select this option if you want that the banner box appear on the end scroll of the page.", "smart-footer-system"); ?>" for="sfs-banner-open-on-bottom"><?php echo __("Open on end scroll", "smart-footer-system") ?></label>
		</th>
		<td>
			<input <?php echo (isset($currentSfsBannerSettings['open-on-bottom']) && $currentSfsBannerSettings['open-on-bottom'] == 1) ? 'checked' : '' ?> data-type="auto-check" name="sfs[banner][<?php echo $res ?>][open-on-bottom]" type="checkbox" value="1">
		</td>
	</tr>	
</tbody>
</table>