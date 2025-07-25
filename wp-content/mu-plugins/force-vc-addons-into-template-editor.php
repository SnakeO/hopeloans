<?php
/*
Plugin Name:  Force VC Addons into Toolset Template Editor
Description:  Visual Composer Addons don't know to load in their files in the Toolset Types Template Editor screens. So we help them understand that's what they need to do.
Version:      0.1
Author:       Jake Chapa
*/

class ForceVCAddonsIntoTemplateEditor
{
	public function __construct()
	{
		$this->setupForTSGoogleMapsPlugin();
	}

	function setupForTSGoogleMapsPlugin()
	{
		// are we in the Toolset Types Template Editor?
		if( @$_GET['page'] != 'ct-editor' ) {
			return false;
		}

		/* 
		global $vc_is_inline;
		$vc_is_inline = true;
		*/

		// create/hijack this function from the 'ts-googlemaps-for-vc' plugin
		function TS_GMVC_IsEditPagePost($new_edit = null)
		{
			return true;
		}
	}
}

new ForceVCAddonsIntoTemplateEditor();

?>