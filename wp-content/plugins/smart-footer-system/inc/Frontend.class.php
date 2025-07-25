<?php
/**
* Smart Footer System - Frontend Class
*/
class SfsFrontend {
	/**
	 * Initialize class
	 * @return null
	 */
	public static function init() {
		if(is_admin()) return;
		self::scripts();		
		self::process();
		add_action("init", function(){
			self::process();
		});
	}
	/**
	 * Register style and scripts for the footer
	 * @return null
	 */
	public static function scripts(){
		if(is_admin()) return;
		add_action( 'wp_enqueue_scripts', function(){
			wp_enqueue_style('smart-footer-system', SFS_URL.'dist/css/sfs.frontend.css');
			wp_enqueue_script('smart-footer-system', SFS_URL.'dist/js/sfs.frontend.js', ['jquery'], true);
			wp_enqueue_style( 'dashicons' );
			$font2 = SFS_URL . 'vendor/icon-picker/fonts/font-awesome/css/font-awesome.css';
			wp_enqueue_style( 'font-awesome', $font2,'','');
			$font3 = SFS_URL . 'vendor/icon-picker/fonts/genericons/genericons.css';
			wp_enqueue_style( 'genericons', $font3, '', '');  
			wp_enqueue_script("wpb_composer_front_js");
			wp_enqueue_style("js_composer_front");
			wp_enqueue_script("js_composer_front");
		});
	}
	/**
	 * Add / Hide footer in the wp_footer or theme action and append to head a style with hidden selectors
	 * @return null
	 */
	public static function process() {
		if(is_admin()) return;
		$current_hook = 'wp_footer';
		if(has_action('sf_main_container_end')){
			$current_hook = 'sf_main_container_end';
		}
		add_action($current_hook, function(){
			$sfsCurrentFooter = SfsPostType::getPostFooter();
			$sfsSettings 	  = SfsSettings::get();
			ob_start();
			include_once(SFS_PATH.'inc/frontend/footer.php');
			echo ob_get_clean();
		},-1);
	}
	/**
	 * Get footer classes
	 * @param  array $footer Current footer
	 * @return string
	 */
	public static function getFooterClasses($sfsPostFooter) {
		$classes = [];
		$classes[] = $sfsPostFooter["footer"]['type'];
		if($sfsPostFooter['footer']['type'] != 'bottom'){
			return implode(" ", $classes);
		}
		if(isset($sfsPostFooter["footer"]['footer-width'])){
			$classes[] = $sfsPostFooter["footer"]['footer-width'];
		}
		if(isset($sfsPostFooter["footer"]['footer-height'])){
			$classes[] = $sfsPostFooter["footer"]['footer-height'];
		}
		if(isset($sfsPostFooter["footer"]['open-speed'])){
			$classes[] = 'speed-'.$sfsPostFooter["footer"]['open-speed'];
		}
		if(isset($sfsPostFooter["footer"]['animation'])){
			$classes[] = 'animation-'.$sfsPostFooter["footer"]['animation'];
		}	
		if(isset($sfsPostFooter["footer"]['shadow'])){
			$classes[] = 'w-shadow';
		}
		if(isset($sfsPostFooter["footer"]['transparency'])){
			$classes[] = 'w-transparency';
		}	
		if(isset($sfsPostFooter["footer"]['open-on-bottom'])){
			$classes[] = 'open-on-bottom';
		}
		if(in_array('full-height', $classes) && isset($sfsPostFooter["footer"]['v-align'])){
			$classes[] = 'v-'.$sfsPostFooter["footer"]['v-align'];
		}		
		if( (isset($sfsPostFooter["footer"]['open-text']) && $sfsPostFooter['footer']['open-text'] != '') ||  (isset($sfsPostFooter["footer"]['close-text']) && $sfsPostFooter['footer']['close-text'] != '') ){
			$classes[] = 'w-text';
		}		
		return implode(" ", $classes);
	}

	/**
	 * Get footer style
	 * @param  array $footer Current footer
	 * @return string
	 */
	public static function getFooterStyle($sfsPostFooter){
		$style = [];
		if($sfsPostFooter['footer']['type'] != 'bottom') {
			return '';
		}
		if(isset($sfsPostFooter['footer']['divider-height'])) {
			$style[] = 'padding-top: 0px';
		}
		return implode("; ", $style);
	}
	/**
	 * Get footer data attributes
	 * @param  array $footer Current footer
	 * @return string
	 */
	public static function getFooterData($sfsPostFooter){
		$data = [];
		$data[] = 'data-type="'.$sfsPostFooter['footer']['type'].'"';
		if(isset($sfsPostFooter['footer']['content-border-size'])) {
			$data[] = 'data-border="'.$sfsPostFooter['footer']['content-border-size'].'"';
		}
		
		if($sfsPostFooter['footer']['type'] == 'normal' && isset($sfsPostFooter['footer']['normal-sticky']) && $sfsPostFooter['footer']['normal-sticky']) {
			$data[] = 'data-normal-sticky="true"';
		}
		if($sfsPostFooter['footer']['type'] == 'normal' && isset($sfsPostFooter['footer']['normal-sticky-mobile']) && $sfsPostFooter['footer']['normal-sticky-mobile']) {
			$data[] = 'data-normal-sticky-mobile="true"';
		}		
		if($sfsPostFooter['footer']['type'] == 'keyring') {
			$data[] = 'data-animation-type="'.$sfsPostFooter['footer']['animation-type'].'"';
			$data[] = 'data-animation-position="'.$sfsPostFooter['footer']['animation-position'].'"';
			return implode(" ", $data);
		}
		if($sfsPostFooter['footer']['type'] == 'accordion') {
			$data[] = 'data-accordion-type="'.$sfsPostFooter['footer']['accordion']['type'].'"';
			return implode(" ", $data);
		}		
		if($sfsPostFooter['footer']['type'] != 'bottom') {
			return implode(" ", $data);
		}
		if(isset($sfsPostFooter["footer"]['open-on'])) {
			$data[] = 'data-on="'.$sfsPostFooter["footer"]['open-on'].'"';
		}
		if(isset($sfsPostFooter["footer"]['open-speed'])) {
			$data[] = 'data-speed="'.$sfsPostFooter["footer"]['open-speed'].'"';
		}		
		if(isset($sfsPostFooter["footer"]['open-speed'])) {
			$data[] = 'data-speed="'.$sfsPostFooter["footer"]['open-speed'].'"';
		}				
		return implode(" ", $data);
	}
	/**
	 * Get footer head classes
	 * @param  array $footer Current footer
	 * @return string
	 */
	public static function getFooterHeadClasses($sfsPostFooter){
		$classes = [];
		if(isset($sfsPostFooter["footer"]['icon-shape'])){
			$classes[] = $sfsPostFooter["footer"]['icon-shape'];
		}
		if(isset($sfsPostFooter["footer"]['icon-position'])){
			$classes[] = 'icon-'.$sfsPostFooter["footer"]['icon-position'];
		}
		return implode(" ", $classes);
	}
	/**
	 * Get footer head style
	 * @param  array $footer Current footer
	 * @return string
	 */
	public static function getFooterHeadStyle($sfsPostFooter){
		$style = [];

		if(isset($sfsPostFooter['footer']['divider-height'])) {
			$style[] = 'border-bottom: '.($sfsPostFooter['footer']['divider-height'])."px solid ".$sfsPostFooter['footer']['divider-color'];
		}	
		return implode("; ", $style);
	}
	/**
	 * Get footer icon classes
	 * @param  array $footer Current footer
	 * @param  string $tag icon tag
	 * @param  string $type icon type
	 * @return string
	 */
	public static function getFooterIconClasses($sfsPostFooter, $tag, $type) {
		$classes = [];
		if($tag == 'div'){
			$classes[] = $type.'-icon';
			$alignClass = 'text-right';
			if(isset($sfsPostFooter['footer']['icon-text-position'])) {
				$alignClass = $sfsPostFooter['footer']['icon-text-position'];
			}
			$classes[] = 'icon-'.$alignClass;
		}
		if($tag == 'i'){
			if(isset($sfsPostFooter['footer'][$type.'-icon'])){
				$classes[] = str_replace("|", " ", $sfsPostFooter['footer'][$type.'-icon']);
			}
		}
		return implode(" ", $classes);
	}	

	/**
	 * Get footer icon style
	 * @param  array $footer Current footer
	 * @param  array $tag icon tag 
	 * @param  array $type icon type
	 * @return string
	 */
	public static function getFooterIconStyle($sfsPostFooter, $tag, $type){
		$style = [];
		if($tag == 'div') {
			if(isset($sfsPostFooter['footer']['bg-icon-color'])) {
				$style[] = 'background: '.$sfsPostFooter['footer']['bg-icon-color'];
			}
			if(isset($sfsPostFooter['footer']['vertical-padding']) && $sfsPostFooter['footer']['footer-width'] == 'full-width' && $sfsPostFooter['footer']['vertical-padding'] != '0x') {
				$multiply = (int)str_replace("x", "", $sfsPostFooter['footer']['vertical-padding']);
				$verticalPadding = $multiply * 10;
				$style[] = 'padding-top: '.$verticalPadding."px";
				$style[] = 'padding-bottom: '.$verticalPadding."px";
				//$style[] = 'margin-top: -'.(($verticalPadding*2))."px";
			}				
		}
		if($tag == 'i' || $tag == 'span') {
			if(isset($sfsPostFooter['footer']['icon-color'])) {
				$style[] = 'color: '.$sfsPostFooter['footer']['icon-color'];
			}
		}
		return implode("; ", $style);
	}
	/**
	 * Get footer icon text
	 * @param  array $footer Current footer
	 * @param  array $type icon type
	 * @return null
	 */
	public static function getFooterIconText($sfsPostFooter, $type){
		if(isset($sfsPostFooter['footer'][$type.'-text']) && $sfsPostFooter['footer'][$type.'-text'] != ''):
			?>
		<span style="<?php echo self::getFooterIconStyle($sfsPostFooter, 'span', $type) ?>"><?php echo $sfsPostFooter['footer'][$type.'-text']; ?></span>
		<?php
		endif;
	}
	/**
	 * Get footer content style
	 * @param  array $footer Current footer
	 * @return string
	 */
	public static function getFooterContentStyle($sfsPostFooter){
		$style = [];		
		return implode("; ", $style);
	}

	/**
	 * Get accordion footer icon classes
	 * @param  array $footer Current footer
	 * @param  string $tag icon tag
	 * @param  string $type icon type
	 * @return string
	 */
	public static function getAccordionFooterIconClasses($sfsPostFooter, $tag, $type) {
		$classes = [];
		if($tag == 'i'){
			$classes[] = 'handle-icon';
			$classes[] = 'handle-icon-'.$type;
			if(isset($sfsPostFooter['footer']["accordion"][$type.'-icon'])){
				$classes[] = str_replace("|", " ", $sfsPostFooter['footer']["accordion"][$type.'-icon']);
			}
		}
		return implode(" ", $classes);
	}
	/**
	 * Get accordion footer icon styles
	 * @param  array $footer Current footer
	 * @param  string $tag icon tag
	 * @param  string $type icon type
	 * @return string
	 */
	public static function getAccordionFooterIconStyles($sfsPostFooter, $tag, $type) {
		$style = [];
		if($tag == 'i'){
			if(isset($sfsPostFooter['footer']["accordion"]['icon-color'])){
				$style[] = 'color: '.$sfsPostFooter['footer']["accordion"]['icon-color'];
			}
		}
		return implode("; ", $style);
	}		
	/**
	 * Get footer content paddings in px or percents.
	 * @param  array $sfsPostFooter Current Footer
	 * @return array paddings
	 */
	public static function getFooterContentPaddings($sfsPostFooter) {
		$resolutions = ["desktop", "tablet", "mobile"];
		foreach($resolutions as $res) {
			$paddings[$res]["horizontal"] = "15px";
			$paddings[$res]["vertical"] = "0px";
			if(isset($sfsPostFooter["footer"]["content-horizontal-padding-".$res])){
				$currentHPadding = $sfsPostFooter["footer"]["content-horizontal-padding-".$res];
				if(strpos($currentHPadding, '%')) {
					$currentHPadding = (int) str_replace('%', '', $currentHPadding );
					$paddings[$res]["horizontal"] = (0.015+$currentHPadding).'%';
				}
				else {
					$currentHPadding = (int) str_replace('px', '', $currentHPadding );
					$paddings[$res]["horizontal"] = (15+$currentHPadding).'px';
				}
			}
			if(isset($sfsPostFooter["footer"]["content-vertical-padding-".$res])){
				$currentVPadding = $sfsPostFooter["footer"]["content-vertical-padding-".$res];
				if(strpos($currentVPadding, '%')) {
					$currentVPadding = (int) str_replace('%', '', $currentVPadding );
					$paddings[$res]["vertical"] = $currentVPadding.'%';
				}
				else {
					$currentVPadding = (int) str_replace('px', '', $currentVPadding );
					$paddings[$res]["vertical"] = $currentVPadding.'px';
				}
			}
		}
		return $paddings;
	}

	public static function themeFixes($html){
		$currentTheme = wp_get_theme()->template;
		if($currentTheme == 'enfold') {
			$html = str_replace([
				'main_color',
				'container_wrap',
				"class='container'",
				'</div></div></div><!-- close content main div --></div></div>'
				], "", $html);

			$html = preg_replace("/\<div id=\'after_section(.*)\'/i", "</div></div></div></div></div><div id='after_section$1'", $html);
			for($i=2; $i<=100;$i++) {
				$html = str_replace("<div id='av_section_$i'", "</div></div></div></div></div><div id='av_section_$i'", $html);
			}
			$html .= '</div></div></div></div>';
			$html .= "
			<style>
					#sfs-footer-wrapper .content {
				border: none!important;
				padding: 0px!important;
				min-height: 0px!important;
			}
			#sfs-footer-wrapper .sfs-footer-content > div {
			padding: 0px!important;
		}
	}
</style>
";
}
return $html;
}

}