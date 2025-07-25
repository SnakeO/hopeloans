<?php 
$animationsTypes = [
	'skewXY',
	'skewX',
	'skewY',
	'rotateXY',
	'rotateX',
	'rotateY',
	'scaleXY',
	'scaleX',
	'scaleY',	
];
$animationsPositions = [
	'top left',
	'top center',
	'top right',
	'center left',
	'center center',
	'center right',
	'bottom left',
	'bottom center',
	'bottom right'
];
?>
<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set a type of animation in order to show different styles.", "smart-footer-system"); ?>" for=""><?php echo __("Animation type", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[animation-type]" id="">
					<?php foreach($animationsTypes as $animationsType) :?>
					<option <?php echo (isset($sfsFooterSettings['animation-type']) && $sfsFooterSettings['animation-type'] == $animationsType) ? 'selected' : '' ?> value="<?php echo $animationsType ?>"><?php echo $animationsType ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>	
		<tr>
			<th>
				<label data-hint="<?php echo __("Define the position to change with other types.", "smart-footer-system"); ?>" for=""><?php echo __("Animation position", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[animation-position]" id="">
					<?php foreach($animationsPositions as $animationPosition) :?>
					<option <?php echo (isset($sfsFooterSettings['animation-position']) && $sfsFooterSettings['animation-position'] == $animationPosition) ? 'selected' : '' ?> value="<?php echo $animationPosition ?>"><?php echo $animationPosition ?></option>
					<?php endforeach; ?>													
				</select>
			</td>
		</tr>				
	</tbody>
</table>