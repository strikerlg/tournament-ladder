<?php
   # Include files required for the site to work properly.
   require_once("config.php");
   require_once("functions.php");
   
   # Set the timezone for the date() function
   date_default_timezone_set("America/Los_Angeles");
   
   # Retrieve the information for the challenge to accept.
   $challenger = cleanInputs($_POST['challenger'], $connection);
   $challengee = cleanInputs($_POST['challengee'], $connection);
   $challengeDate = $_POST['time'];
   $acceptDate = date("Y-m-d");
   
   # Add an accepted date to the challenge to accept.
   $acceptSuccess = mysqli_query($connection,
      "UPDATE challenge SET accepted = '$acceptDate' WHERE 
         challenger = '$challenger' AND 
         challengee = '$challengee' AND 
         scheduled = '$challengeDate'") or die(mysqli_error($connection));
   
   # If the update to accept the selected challenge was successful, remove all
   # other challenges for the challengee from the database.
   if($acceptSuccess)
   {
      # Remove other challenges for the challengee and challengerfrom the database.
      $acceptSuccess = mysqli_query($connection,
         "DELETE FROM challenge WHERE 
            (challengee = '$challengee' OR 
            challengee = '$challenger' OR
            challenger = '$challengee' OR
            challenger = '$challenger') AND 
            accepted IS NULL") or die(mysqli_error($connection));
   }
?>

<!DOCTYPE html>
<html>
<head>
   <title>Wrath of Titans - Accept Challenge</title>
   
   <!-- CSS Inclusion -->
      <link href="../../styles/reset.css" rel="stylesheet" type="text/css" />
      <link href="../../styles/main.css" rel="stylesheet" type="text/css" />
   <!-- /End CSS Inclusion -->
</head>
<body>
<div id="container">

   <!-- Website Header -->
   <div id="header">
      <div id="headerBar">
      </div>
      
      <div id="headerTitle">
         <img src="../../images/graphics/header/logo.png" />
      </div>
   </div>
   <!-- /End Header -->
   
   <!-- Website Main Body -->
   <div id="body" style="background: none;">
      <div class="widget" style="width: 300px; min-height: 75px; margin: auto; background: #202026; border: 1px solid #0b0b0b;">
         <div class="widgetTitle">
            <img src="../../images/graphics/body/titleBand.png" class="goldband"  />
            <h2>Redirecting...</h2>
         </div>
         
         <div class="widgetContent" style="padding: 5px;">
            <?php
               # Notify the user of the results.
               if($acceptSuccess)
               {
                  echo("
                     <p>You have successfully accepted the challenge.</p>
                  ");
               }
               else
               {
                  echo("
                     <p>The challenge could not be accepted. Please try again.</p>
                  ");
               }
               
               # Redirect the user back to the challenge info page.
               echo("
                  <p class='small' style='padding-top: 15px'>Please <a href='../../../index.php?p=challengeInfo'>click here</a> if
                     you are not automatically redirected.</p>
                  <script type='text/javascript'>
                     setTimeout(function(){window.location = '../../../index.php?p=challengeInfo';}, 3000);
                  </script>
               ");
            ?>
         </div>
      </div>
   </div>
   <!-- /End Main Body -->
   
   <!-- Website Footer -->
   <div id="footer">
   </div>
   <!-- /End Footer -->
</div>
</body>
</html>