<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */
if (version_compare(phpversion(), '5.5.0', '<')===true) {
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
 *	Instantiate Core
 */
Core::app();