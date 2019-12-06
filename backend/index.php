<?php

require "../vendor/autoload.php";

use BambooHR\API\BambooAPI;
use BambooHR\API\BambooJSONHTTP;
use Dotenv\Dotenv;
use App\BambooHr;
use App\Request;
use App\Calendar;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$bhr = new BambooHr(getenv('BAMBOOHR_DOMAIN'), new BambooJSONHTTP());
$bhr->setSecretKey(getenv('BAMBOOHR_KEY'));

$request = new Request($_GET);

$date_start = $request->getAsDate('start_date');
$date_end = $request->getAsDate('end_date');

// $response = $bhr->getTimeOffPolicies(37);
// $response = $bhr->getTimeOffRequestsArr([
//     'employeeId' => 37,
//     'start' => '2019-12-01',
//     'end' => '2019-12-31',
// ]);
// $response = $bhr->getDirectory();

$response = $bhr->getWhosOut($date_start, $date_end);
if($response->isError()) {
   trigger_error("Error communicating with BambooHR: " . $response->getErrorMessage());
}

$data = $response->getContent();
if (!empty($data)) {
   $message = '';
   $data = Calendar::parseData($data);
}
else {
   $message = 'No data could be found.';
}
