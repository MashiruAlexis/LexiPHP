<?php

include_once "app/Core.php";
// Core::app();

$hash = Core::getSingleton("frontend/action");
$hash->setPageTitle("TestPage");
$hash->render();