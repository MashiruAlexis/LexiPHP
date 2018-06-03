<?php
namespace Errors;

// constants
define("BP_ERRORS", dirname(__FILE__));
define("DS", DIRECTORY_SEPARATOR);

// autoload
require_once 'autoload.php';
\Errors\Autoload::boot();

// we need this things
use Errors\Controller\Logger as Logger;
use Errors\Controller\Session as Session;
use Errors\Controller\Config;

Session::start();
$config = new Config;
define('SYS_CONFIG', $config->get("system"));
Logger::log( $_SESSION );