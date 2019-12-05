<?php

require "../vendor/autoload.php";

use BambooHR\API\BambooAPI;
use BambooHR\API\BambooJSONHTTP;
use Dotenv\Dotenv;
use App\BambooHr;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$bhr = new BambooHr("amazee", new BambooJSONHTTP());
$bhr->setSecretKey(getenv('BAMBOOHR_KEY'));

$response = $bhr->getTimeOffPolicies(37);
// $response = $bhr->getTimeOffRequestsArr([
//     'employeeId' => 37,
//     'start' => '2019-12-01',
//     'end' => '2019-12-31',
// ]);
// $response = $bhr->getTimeOffBalances(37, '2019-12-31');
// $response = $bhr->getDirectory();
// $response = $bhr->getWhosOut('2019-12-01', '2019-12-31');
// $response = $bhr->getTimeOffTypes();
if($response->isError()) {
   trigger_error("Error communicating with BambooHR: " . $response->getErrorMessage());
}

$json = $response->getContent();
var_dump($json);
