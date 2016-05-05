<?php

include_once "app/Core.php";

$pass1 = "Ramon Alexis Celis";
$pass2 = "block";

$base = Core::getSingleton("hash/base64");
echo $base->encode($pass1);