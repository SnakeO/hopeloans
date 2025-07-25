<?php 
	header("Content-type: text/javascript");

	session_start();
	$session_id = session_id();

	// cached?
	if( file_exists("/tmp/globaljs_$session_id") ) {
		echo "// cached\n";
		echo file_get_contents("/tmp/globaljs_$session_id");
		return;
	}

	ob_start();

	define('WP_USE_THEMES', false);
	require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php'); 
?>

function site_url(url)
{
	return '<?=site_url('/')?>' + url;
}

function controller_url(url, env, module)
{
	if( env == null ) {
		env = 'admin';
	}

	if( env != 'admin' && env != 'public' && env != 'pub' && env != 'resource' ) {
		console.log('bad controller_url environment: ' + env);
		return false;
	}

	url = url.split('/');

	var controller = url.shift();
	var func = url.shift();

	if( !controller || !func ) {
		console.log('missing controller or function', controller, func);
		return false;
	}

	var params = url.length > 0 ? '/' + url.join('/') : '';
	var module_qs = module ? "&module=" + module : '';

	var site_url_function = site_url;

	if( !module ) {
		return site_url_function.apply(this, ["controller/" + env + "/" + controller + "/" + func + params])
	}

	return site_url_function.apply(this, ["hmvc_controller/" + env + "/" + module + "/" + controller + "/" + func + params])
}

function session_id()
{
	return '<?=$session_id?>';
}

// query string.. call it like this:
// var signed_request = qs('signed_request')
function qs(name) 
{
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

<?php

	$res = ob_get_contents();
	ob_end_clean();

	echo $res;

	// cache for later
	file_put_contents("/tmp/globaljs_$session_id", $res);

?>