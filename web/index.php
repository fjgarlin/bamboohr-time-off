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

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <title>Who's out</title>
</head>
<body>
   <div class="container">
      <h1>Who's out</h1>
      <hr>
      <form action="" class="row">
         <div class="col">
            <div class="row">
               <div class="col input-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text">From</span>
                  </div>
                  <input class="form-control" type="date" name="start_date" placeholder="Start date" value="<?php print $date_start; ?>" />
               </div>
               <div class="col input-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text">To</span>
                  </div>
                  <input class="form-control" type="date" name="end_date" placeholder="End date" value="<?php print $date_end; ?>" />
               </div>
            </div>
         </div>
         <div class="col">
            <input class="btn btn-primary" type="submit" value="Check who's out" />
         </div>
      </form>
      <hr>

      <?php if ($message): ?>
         <p><?php print $message; ?></p>
      <?php endif; ?>

      <?php if ($data): ?>
         <div class="row row-cols-1 row-cols-md-1">
            <?php foreach ($data as $date => $people): ?>
               <div class="col">
                  <div class="card">
                     <h5 class="card-header"><?php print $date; ?></h5>
                     <div class="card-body">
                        <p class="card-text">
                           <ul>
                              <?php foreach ($people as $person): ?>
                                 <li><?php print $person; ?></li>
                              <?php endforeach; ?>
                           </ul>
                        </p>
                     </div>
                  </div>
               </div>
            <?php endforeach; ?>
         </div>
      <?php endif; ?>
   </div>
</body>
</html>