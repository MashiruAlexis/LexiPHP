<?php

// constants
define("BP_ERRORS", dirname(__FILE__));

// autoload
require_once 'autoload.php';

# run the autloader
\Errors\Autoload::boot();

# set the error handlers
\Errors\Controller\Handler::boot();