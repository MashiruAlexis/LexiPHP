<?php
namespace Errors;

// autoload
require_once 'error.php';

$make = new \Errors\Controller\Logger;

$make->log(["car", "sex", "death"], true);