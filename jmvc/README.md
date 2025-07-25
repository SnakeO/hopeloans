To install JMVC, include this line in your `functions.php` file:

`require_once(ABSPATH . '/jmvc/app/start.php');`

--

Make sure that all autoload files are generated. First `cd` into the `jmvc` dir, then run: 

`composer dump-autoload`

--


To call an AJAX method, you can use this URL format:

`http://website.com/wp-admin/admin-ajax.php?action=pub_controller&path=TheController/functionToCall/param1/param2`

