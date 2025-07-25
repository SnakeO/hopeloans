<?php

/*
	composer require maknz/slack
	composer require guzzlehttp/guzzle:~6.0
	composer require predis/predis

	composer dump-autoload
 */

@session_start();

// path to this system folder
define('JSYS', __DIR__ . '/') ;

// path to the jmvc root
define('JMVC', realpath(__DIR__ . '/../') . '/');

// load in the system
require_once(JMVC . 'vendor/autoload.php');

// little bit of init
JConfig::init();

// kv store
$store_config = JConfig::get('kvstore');

if( $store_config['type'] == 'redis' ) 
{
	Predis\Autoloader::register();
	$redis = new Predis\Client();
	JBag::set('kvstore', $redis);
}
else if( $store_config['type'] == 'sqlite' ) 
{
	$nsql = new NoSQLite\NoSQLite('jmvc.sqlite');
	$store = $nsql->getStore('jmvc');
	JBag::set('kvstore', $store);
}

JLog::init();
JControllerAjax::init();
DevAlert::init();

define('THEME', get_stylesheet_directory_uri());
define('JMVC_URL', site_url('/jmvc/'));

add_action('wp_enqueue_scripts', function()
{
	// wordpress ajax helper
	wp_localize_script( 'jquery', 'Ajax', array('url' => admin_url( 'admin-ajax.php' )) );
	wp_localize_script( 'jquery', 'Site', array('url' => site_url('')) );
	wp_localize_script( 'jquery', 'Theme', array('url' => THEME) );

	global $post;
	if( $post ) { 
		wp_localize_script( 'jquery', 'Post', (array)$post );
	}
	
	wp_enqueue_script('jmvc-global-helpers', JMVC_URL . 'assets/js/global.js.php', [], '01212015');
});
