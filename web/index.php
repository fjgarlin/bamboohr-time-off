<?php

require "../vendor/autoload.php";

use \BambooHR\API\BambooAPI;
use \BambooHR\API\BambooJSONHTTP;
use \Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$bhr = new BambooAPI("amazee", new BambooJSONHTTP());
$bhr->setSecretKey(getenv('BAMBOOHR_KEY'));

$response = $bhr->getWhosOut();
if($response->isError()) {
   trigger_error("Error communicating with BambooHR: " . $response->getErrorMessage());
}

$json = $response->getContent();
var_dump($json);
