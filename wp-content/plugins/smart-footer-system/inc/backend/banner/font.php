<h4 class="subsection-title"><?php echo __("Title font", 'smart-footer-system') ?></h4>
<table class="form-table sfs-table">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-style.", "smart-footer-system"); ?>" for=""><?php echo __("Font style", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][title-font-style]" id="">
					<option <?php echo (isset($currentSfsBannerSettings["title-font-style"]) && $currentSfsBannerSettings["title-font-style"] == 'normal') ? 'selected' : '' ?> value="normal">normal</option>
					<option <?php echo (isset($currentSfsBannerSettings["title-font-style"]) && $currentSfsBannerSettings["title-font-style"] == 'italic') ? 'selected' : '' ?> value="italic">italic</option>
					<option <?php echo (isset($currentSfsBannerSettings["title-font-style"]) && $currentSfsBannerSettings["title-font-style"] == 'oblique') ? 'selected' : '' ?> value="oblique">oblique</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-weight.", "smart-footer-system"); ?>" for=""><?php echo __("Font weight", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][title-font-weight]" id="">
					<option <?php echo (isset($currentSfsBannerSettings["title-font-weight"]) && $currentSfsBannerSettings["title-font-weight"] == 'normal') ? 'selected' : '' ?> value="normal">normal</option>
					<option <?php echo (isset($currentSfsBannerSettings["title-font-weight"]) && $currentSfsBannerSettings["title-font-weight"] == 'bold') ? 'selected' : '' ?> value="bold">bold</option>
					<option <?php echo (isset($currentSfsBannerSettings["title-font-weight"]) && $currentSfsBannerSettings["title-font-weight"] == 'bolder') ? 'selected' : '' ?> value="bolder">bolder</option>
					<option <?php echo (isset($currentSfsBannerSettings["title-font-weight"]) && $currentSfsBannerSettings["title-font-weight"] == 'lighter') ? 'selected' : '' ?> value="lighter">lighter</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-size.", "smart-footer-system"); ?>" for=""><?php echo __("Font size", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="12" max="100" value="<?php echo (isset($currentSfsBannerSettings["title-font-size"])) ? $currentSfsBannerSettings["title-font-size"] : '12' ?>">
					<input value="<?php echo (isset($currentSfsBannerSettings["title-font-size"])) ? $currentSfsBannerSettings["title-font-size"] : '12' ?>" type="text" name="sfs[banner][<?php echo $res ?>][title-font-size]">
					px
				</div>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a line-height.", "smart-footer-system"); ?>" for=""><?php echo __("Line height", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="1" max="100" value="<?php echo (isset($currentSfsBannerSettings["title-line-height"])) ? $currentSfsBannerSettings["title-line-height"] : '1' ?>">
					<input value="<?php echo (isset($currentSfsBannerSettings["title-line-height"])) ? $currentSfsBannerSettings["title-line-height"] : '12' ?>" type="text" name="sfs[banner][<?php echo $res ?>][title-line-height]">
					px
				</div>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a margin bottom", "smart-footer-system"); ?>" for=""><?php echo __("Margin bottom", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="1" max="500" value="<?php echo (isset($currentSfsBannerSettings["title-margin-bottom"])) ? $currentSfsBannerSettings["title-margin-bottom"] : '1' ?>">
					<input value="<?php echo (isset($currentSfsBannerSettings["title-margin-bottom"])) ? $currentSfsBannerSettings["title-margin-bottom"] : '12' ?>" type="text" name="sfs[banner][<?php echo $res ?>][title-margin-bottom]">
					px
				</div>
			</td>
		</tr>		
	</tbody>
</table>
<h4 class="subsection-title"><?php echo __("Subtitle font", 'smart-footer-system') ?></h4>
<table class="form-table sfs-table">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-style.", "smart-footer-system"); ?>" for=""><?php echo __("Font style", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][subtitle-font-style]" id="">
					<option <?php echo (isset($currentSfsBannerSettings["subtitle-font-style"]) && $currentSfsBannerSettings["subtitle-font-style"] == 'normal') ? 'selected' : '' ?> value="normal">normal</option>
					<option <?php echo (isset($currentSfsBannerSettings["subtitle-font-style"]) && $currentSfsBannerSettings["subtitle-font-style"] == 'italic') ? 'selected' : '' ?> value="italic">italic</option>
					<option <?php echo (isset($currentSfsBannerSettings["subtitle-font-style"]) && $currentSfsBannerSettings["subtitle-font-style"] == 'oblique') ? 'selected' : '' ?> value="oblique">oblique</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-weight.", "smart-footer-system"); ?>" for=""><?php echo __("Font weight", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][subtitle-font-weight]" id="">
					<option <?php echo (isset($currentSfsBannerSettings["subtitle-font-weight"]) && $currentSfsBannerSettings["subtitle-font-weight"] == 'normal') ? 'selected' : '' ?> value="normal">normal</option>
					<option <?php echo (isset($currentSfsBannerSettings["subtitle-font-weight"]) && $currentSfsBannerSettings["subtitle-font-weight"] == 'bold') ? 'selected' : '' ?> value="bold">bold</option>
					<option <?php echo (isset($currentSfsBannerSettings["subtitle-font-weight"]) && $currentSfsBannerSettings["subtitle-font-weight"] == 'bolder') ? 'selected' : '' ?> value="bolder">bolder</option>
					<option <?php echo (isset($currentSfsBannerSettings["subtitle-font-weight"]) && $currentSfsBannerSettings["subtitle-font-weight"] == 'lighter') ? 'selected' : '' ?> value="lighter">lighter</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-size.", "smart-footer-system"); ?>" for=""><?php echo __("Font size", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="12" max="100" value="<?php echo (isset($currentSfsBannerSettings["subtitle-font-size"])) ? $currentSfsBannerSettings["subtitle-font-size"] : '12' ?>">
					<input value="<?php echo (isset($currentSfsBannerSettings["subtitle-font-size"])) ? $currentSfsBannerSettings["subtitle-font-size"] : '12' ?>" type="text" name="sfs[banner][<?php echo $res ?>][subtitle-font-size]">
					px
				</div>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a line-height.", "smart-footer-system"); ?>" for=""><?php echo __("Line height", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="1" max="100" value="<?php echo (isset($currentSfsBannerSettings["subtitle-line-height"])) ? $currentSfsBannerSettings["subtitle-line-height"] : '1' ?>">
					<input value="<?php echo (isset($currentSfsBannerSettings["subtitle-line-height"])) ? $currentSfsBannerSettings["subtitle-line-height"] : '12' ?>" type="text" name="sfs[banner][<?php echo $res ?>][subtitle-line-height]">
					px
				</div>
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a margin bottom", "smart-footer-system"); ?>" for=""><?php echo __("Margin bottom", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="1" max="500" value="<?php echo (isset($currentSfsBannerSettings["subtitle-margin-bottom"])) ? $currentSfsBannerSettings["subtitle-margin-bottom"] : '1' ?>">
					<input value="<?php echo (isset($currentSfsBannerSettings["subtitle-margin-bottom"])) ? $currentSfsBannerSettings["subtitle-margin-bottom"] : '12' ?>" type="text" name="sfs[banner][<?php echo $res ?>][subtitle-margin-bottom]">
					px
				</div>
			</td>
		</tr>
	</tbody>
</table>
<h4 class="subsection-title"><?php echo __("Button font", 'smart-footer-system') ?></h4>
<table class="form-table sfs-table">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-style.", "smart-footer-system"); ?>" for=""><?php echo __("Font style", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][button-font-style]" id="">
					<option <?php echo (isset($currentSfsBannerSettings["button-font-style"]) && $currentSfsBannerSettings["button-font-style"] == 'normal') ? 'selected' : '' ?> value="normal">normal</option>
					<option <?php echo (isset($currentSfsBannerSettings["button-font-style"]) && $currentSfsBannerSettings["button-font-style"] == 'italic') ? 'selected' : '' ?> value="italic">italic</option>
					<option <?php echo (isset($currentSfsBannerSettings["button-font-style"]) && $currentSfsBannerSettings["button-font-style"] == 'oblique') ? 'selected' : '' ?> value="oblique">oblique</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-weight.", "smart-footer-system"); ?>" for=""><?php echo __("Font weight", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[banner][<?php echo $res ?>][button-font-weight]" id="">
					<option <?php echo (isset($currentSfsBannerSettings["button-font-weight"]) && $currentSfsBannerSettings["button-font-weight"] == 'normal') ? 'selected' : '' ?> value="normal">normal</option>
					<option <?php echo (isset($currentSfsBannerSettings["button-font-weight"]) && $currentSfsBannerSettings["button-font-weight"] == 'bold') ? 'selected' : '' ?> value="bold">bold</option>
					<option <?php echo (isset($currentSfsBannerSettings["button-font-weight"]) && $currentSfsBannerSettings["button-font-weight"] == 'bolder') ? 'selected' : '' ?> value="bolder">bolder</option>
					<option <?php echo (isset($currentSfsBannerSettings["button-font-weight"]) && $currentSfsBannerSettings["button-font-weight"] == 'lighter') ? 'selected' : '' ?> value="lighter">lighter</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a font-size.", "smart-footer-system"); ?>" for=""><?php echo __("Font size", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="12" max="100" value="<?php echo (isset($currentSfsBannerSettings["button-font-size"])) ? $currentSfsBannerSettings["button-font-size"] : '12' ?>">
					<input value="<?php echo (isset($currentSfsBannerSettings["button-font-size"])) ? $currentSfsBannerSettings["button-font-size"] : '12' ?>" type="text" name="sfs[banner][<?php echo $res ?>][button-font-size]">
					px
				</div>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define a line-height.", "smart-footer-system"); ?>" for=""><?php echo __("Line height", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="sfs-element-range">
					<input type="range" step="1" min="1" max="100" value="<?php echo (isset($currentSfsBannerSettings["button-line-height"])) ? $currentSfsBannerSettings["button-line-height"] : '1' ?>">
					<input value="<?php echo (isset($currentSfsBannerSettings["button-line-height"])) ? $currentSfsBannerSettings["button-line-height"] : '12' ?>" type="text" name="sfs[banner][<?php echo $res ?>][button-line-height]">
					px
				</div>
			</td>
		</tr>		
	</tbody>
</table>