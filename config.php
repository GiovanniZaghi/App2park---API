<?php
require 'environment.php';

global $config;
$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "https://qa.app2park.com/api/");
	$config['dbname'] = 'qaapp2parkdb';
	$config['host'] = 'app2park-db.czfynb5irn0q.us-east-1.rds.amazonaws.com';
	$config['dbuser'] = 'admin';
	$config['dbpass'] = '6gXSoNMCTjhk4JOWlQEK';
	$config['jwt_secret_key'] = "abC123!";
} else {
	define("BASE_URL", "https://www.app2park.com/api/");
	$config['dbname'] = 'app2parkdb';
	$config['host'] = 'app2park-db.czfynb5irn0q.us-east-1.rds.amazonaws.com';
	$config['dbuser'] = 'admin';
	$config['dbpass'] = '6gXSoNMCTjhk4JOWlQEK';
	$config['jwt_secret_key'] = "abC123!";
}

global $db;
try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
	$db->exec("set names utf8");
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}