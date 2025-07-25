# README

* **System dependencies**
	- [Composer](https://getcomposer.org)
	- PHP 7+

* **Configuration**
	- Frontend
		- Global breakpoints are defined in `THEME_DIR/scss/elements/breakpoints.scss`
	- Backend
		- JMVC is an MVC Framework. All the files can be found in `ROOT_DIR/jmvc/`. More on JMVC below.
				
* **Deployment instructions**
	- Work locally, save your work with `git push`, then `ssh` into staging/production and do a `git pull`
	- Database changes are always tricky with Wordpress. Most of the time DB changes are copied over manually.

* **Project Notes**
	- Though the app has SCSS files inside `THEME_DIR/scss/` directory, these are auto-compiled via a wordpress plugin -- so no need to compile manually.

* **JMVC Notes**
	- JMVC is loaded into the theme via the `functions.php` file.
	- Whenever new classes are added, `cd` into the `jmvc` directory and run `composer dump-autoload` to regenerate the composer autoload file
	- You will find javascript files inside `jvmc/assets/js`

* **Website Organization**
	- Hope Project / Hope Campaign
		- *Hope Projects* are generally referred to as *Hope Campaigns* in the backend.
		- Each *Hope Campaign* has a model found in `jmvc/models/HopeCampaign.php`
		- For the *Hope Campaign* Carousels, we use SuperCarousel. They look like this in the frontend:
			- ![SuperCarousel 1](https://wow-ss.s3.amazonaws.com/oFtECMw.png)
			- ![SuperCarousel 2](https://wow-ss.s3.amazonaws.com/9e5ELSS.png)
		- There are 4 carousels, one for each category, editable at [/wp-admin/admin.php?page=supercarousel](/wp-admin/admin.php?page=supercarousel)
			- ![SuperCarousel Admin](https://wow-ss.s3.amazonaws.com/BliGK1u.png)
		- SuperCarousel comes with a VisualComposer Widget:
			- ![SuperCarousel VC](https://wow-ss.s3.amazonaws.com/8OgHLLG.png)
		- For the *Hope Campaign* Grids, we use Toolset Views. They look like this in the frontend:
			- ![Toolset View](https://wow-ss.s3.amazonaws.com/bwY2ECT.png)
		- You can find them in the admin under "[Toolset -> Views](/wp-admin/admin.php?page=views)" :
			- ![Toolset View Admin](https://wow-ss.s3.amazonaws.com/5ve31QF.png)
	- Child Fundraisers
		- Look at `jmvc/libraries/plugins/ModifyCharitable.php` to see the functionality for creating & earmarking Child Fundraisers.
			- When a Child **Hope Project (aka Hope Campaign) Fundraiser** is created, the `post_parent` is set to the parent Hope Project.
			- When a Child **Hope Loan Fundraiser** is created, the `post_parent` is set to a special *Private* Hope Campaign identified by `HopeCampaign::$HOPELOAN_CAMPAIGN_ID` and named *"Parent Campaign for Hope Loans Fundraiser (DO NOT TRASH)"*
			- When a Child **Donation Fundraiser** is created, the `post_parent` is set to a special *Private* Hope Campaign identified by `HopeCampaign::$DONATION_CAMPAIGN_ID` and named *"Parent Campaign for Donation Fundraiser (DO NOT TRASH)"*. Additionally, the Hope Loan product which is earmarked is set through a variable called `earmark_identifier`
	- One-Time / Monthly Recurring Donations
		- These donations can be made through the form on the website that looks like this: ![One-Time/Monthly Recurring Donation](https://wow-ss.s3.amazonaws.com/VlJprPS.png)
		- This form is displayed using the shortcode: `[hope-campaign-standalone-donation-form]`
		- Payments are assigned to a special Hope Campaign called *"One-Time or Recurring Standalone Donation (DO NOT TRASH)"*

* **File Organization**
	- Stylesheets
		- The `style.css` file in the theme root directory is unused. Instead, we use the file inside `css/style.css`
		- ![CSS Structure](https://wow-ss.s3.amazonaws.com/XA3Qe0X.png)
			- Do not edit `css/style.css` directly
				- `css/style.css` file is generated from all files in `scss` directory.
				- Any direct edits to `css/style.css` will be overwritten.
		- All additions/edits should occur inside the `scss` directory:
			- ![SCSS Directory](https://wow-ss.s3.amazonaws.com/qDg0Q17.png)
			- To add a new file, simply create a new `.scss` file inside either `elements` or `pages`, then link to it from the `scss/style.scss` file:
			- ![Add to SCSS](https://wow-ss.s3.amazonaws.com/WEEg2pG.png)
		- No need to manually compile the SCSS files, the website auto-compiles with the [WP-SCSS plugin](https://wordpress.org/plugins/wp-scss/) whenever a change is detected in the `scss/` directory.
	- Theme
		- The theme used is a child theme @ `wp-content/themes/hope-loans`
			- We have overridden some templates from the `charitable` plugin. Look in the Theme directory inside the `charitable` folder for these.

* **Plugin Modifications**
	- We modified some core files of a plugin as a last resort. This was necessary because there were no useable hooks. The following are the modifications that were made, and they ***must be manually re-applied*** when updating these plugins:

#####1. `charitable-ambassadors` plugin:

			
~~~php
/*
	What: 	Modified the `get_posts` call to include both "published" and "private" posts.
	Why: 	We use special "private" Charity fundraisers for "Hope Loan" and "Donation" Fundraisers.
	Where: 	/charitable-ambassadors/includes/admin/views/metaboxes/campaign-parent.php:14
	See: 	https://wow-ss.s3.amazonaws.com/IxmkLDr.png
*/

// Old Code
$campaigns = get_posts( array(
	'post_type' => Charitable::CAMPAIGN_POST_TYPE,
	'post_status' => 'publish',
	'posts_per_page' => -1
) );

// New Code
$campaigns = get_posts( array(
	'post_type' => Charitable::CAMPAIGN_POST_TYPE,
	'post_status' => 'publish,private',
	'posts_per_page' => -1
) );
~~~

#####2. `ts-googlemaps-for-vc` plugin:
~~~php
/*
	What: 	Added a 3rd string parameter ("gmaps_plus_single") to the shortcode_atts() function call.	
	Why:  	So that we can setup a filter to inject the Hope Campaign address for the Google Map Marker.
	Where: 	/ts-googlemaps-for-vc/assets/ts_gmvc_googlemap.php:1379
			function TS_VCSC_GoogleMapsPlus_Single()
	See: 	https://wow-ss.s3.amazonaws.com/qb5RVnu.png
	Used At:  jmvc/models/HopeCampaign::setupFilters() -> 
				in the "shortcode_atts_gmaps_plus_single" filter
*/

// Old Code
extract( shortcode_atts( array(
	/* long list of parameters here */
), $atts ));

// New Code
extract( shortcode_atts( array(
	/* long list of parameters here */
), $atts, 'gmaps_plus_single' ));
~~~