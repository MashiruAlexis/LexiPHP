<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

if (version_compare(phpversion(), '5.4.0', '<')===true) {
    echo  '<div style="font:12px/1.35em arial, helvetica, sans-serif;">
<div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
<h3 style="margin:0; font-size:1.7em; font-weight:normal; text-transform:none; text-align:left; color:#2f2f2f;">
Whoops, it looks like you have an invalid PHP version.</h3></div><p>Sorry for breaking it to  you, there\'s no way for you to fix this aside from installing the required php version.</p></div>';
    exit;
}

require_once "app/Core.php";

/**
 *	Root Directory
 */
define("ROOT", getcwd() . DIRECTORY_SEPARATOR);

/**
 *	Lets add vendor here [if we need php packages this will autoload them]
 */
// $vendor = BP . DS . "vendor" . DS . "autoload.php";
// if( file_exists($vendor) ) {
// 	include_once $vendor;
// }

/**
 *	Lets add vendor here [if we need php packages this will autoload them]
 */
$vendor = BP . DS . "app" . DS . "code" . DS . "modules" . DS . "toggl" . DS . "Toggl.php";
if( file_exists($vendor) ) {
	include_once $vendor;
}

$f1 = BP . DS . "app" . DS . "code" . DS . "modules" . DS . "toggl" . DS . "Classloader.php";
if( file_exists($f1) ) {
	include_once $f1;
}

/**
 *	Instantiate Core
 */
Core::app();