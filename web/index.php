<?php require "../backend/index.php"; ?>
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