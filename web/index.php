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

$bhr = new BambooHr("fjgarlin", new BambooJSONHTTP());
$bhr->setSecretKey(getenv('BAMBOOHR_KEY'));

$request = new Request($_GET);

$date_start = $request->get('start_date');
if (!strtotime($date_start)) {
   $date_start = date('Y-m-d');
}
$date_end = $request->get('start_end');
if (!strtotime($date_end)) {
   $date_end = date('Y-m-d', strtotime('+1 month'));
}


// $response = $bhr->getTimeOffPolicies(37);
// $response = $bhr->getTimeOffRequestsArr([
//     'employeeId' => 37,
//     'start' => '2019-12-01',
//     'end' => '2019-12-31',
// ]);
// $response = $bhr->getTimeOffBalances(37, '2019-12-31');
// $response = $bhr->getDirectory();
$response = $bhr->getWhosOut($date_start, $date_end);
// $response = $bhr->getTimeOffTypes();
if($response->isError()) {
   trigger_error("Error communicating with BambooHR: " . $response->getErrorMessage());
}

$data = $response->getContent();
if (!empty($data)) {
   $message = '';
   $data = Calendar::parseData($data);
}
else {
   $message = 'No data couuld be found.';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <!-- Latest compiled and minified CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

   <!-- Optional theme -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

   <!-- Latest compiled and minified JavaScript -->
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

   <title>Who's out</title>
</head>
<body>
   <div class="container">
      <h1>Who's out</h1>
      <hr>
      <form action="" class="well form-inline">
         <div class="form-group">
            <input class="form-control" type="date" name="start_date" placeholder="Start date" value="<?php print date('Y-m-d') ?>" /> to 
            <input class="form-control" type="date" name="end_date" placeholder="End date" value="<?php print date('Y-m-d', strtotime('+1 month')) ?>" />
         </div>
         <div class="form-group">
            <input class="btn btn-primary" type="submit" value="Check who's out" />
         </div>
      </form>
      <hr>

      <?php if ($message): ?>
         <p><?php print $message; ?></p>
      <?php endif; ?>

      <?php if ($data): ?>
         <?php foreach ($data as $date => $people): ?>
            <h3><?php print $date; ?></h3>
            <ul>
               <?php foreach ($people as $person): ?>
                  <li><?php print $person; ?></li>
               <?php endforeach; ?>
            </ul>
            <hr>
         <?php endforeach; ?>
      <?php endif; ?>
   </div>
</body>
</html>