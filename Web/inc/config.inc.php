<?php
$today = date("Y-m-d");
define("DATA_OUTPUT","inc/data/".$today.".csv");

define("MONGO_DB_USER","admin");
define("MONGO_DB_PASS","admin");
define("MONGO_DB_NAME","aioRestaurants");
define("MONGO_DB_HOST","@cluster0.usuw1.mongodb.net");