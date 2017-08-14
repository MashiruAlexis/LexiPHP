<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */


/*
|--------------------------------------------------------------------------
| All autoloader
|--------------------------------------------------------------------------
|
|	Commands that are listed in here will be executable on the terminal.
*/
return [

	/*
	|--------------------------------------------------------------------------
	|	Console Autoloader
	|--------------------------------------------------------------------------
	|
	| Autoloader for console script.
	*/
	'console' => "app/code/base/console/autoload.php",

	/*
	|--------------------------------------------------------------------------
	|	Toggl Autoloader
	|--------------------------------------------------------------------------
	|
	| Autoloader for toggl module.
	*/
	'toggl' => "app/code/modules/toggl/Classloader.php",

	/*
	|--------------------------------------------------------------------------
	|	Middleware Autoloader
	|--------------------------------------------------------------------------
	|
	| Autoloader for middleware
	*/
	'middleware' => "app/code/middleware/autoload.php",
];