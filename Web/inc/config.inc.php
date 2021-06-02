<?php

$login = "admin";
$pass = "admin";
$db = "mock_restaurant";
$cluster = "@cluster0.lz00r.mongodb.net";

define("MONGO_DB_USER","admin");
define("MONGO_DB_PASS","admin");
define("MONGO_DB_NAME","mock_restaurant");
define("MONGO_DB_HOST","@cluster0.lz00r.mongodb.net/");

define('DEFAULT_URL',"mongodb+srv://$login:$pass$cluster/$db?retryWrites=true&w=majority");


define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_NAME','Lab10');
define('DB_PASS','');

/*
$mongoDb = "mongodb+srv://admin:admin@cluster0.lz00r.mongodb.net/mock_restaurant?retryWrites=true&w=majority";
 'mongodb+srv://admin:admincluster0.lz00r.mongodb.net/mock_restaurant?retryWrites=true&w=majority'
#2 - Define os filtros que vão definir a query:
$filter = [
    'author' => $author
];
Se não há filtro, deixa vazio
$filter = [];

#3 - Define os campos que serão extraídos do MongoDB
$options = ["projection" => [
    'isbn' => $isbn
]];
*/