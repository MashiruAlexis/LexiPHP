<?php

include_once "app/Core.php";
// Core::app();

$hash = Core::getSingleton("hash/encrypt");
echo $hash->encode("hello World!");