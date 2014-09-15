<?php
   # Include files required for the site to work properly.
   require_once("config.php");
   require_once("functions.php");
   
   # Set the timezone for the date() function
   date_default_timezone_set("America/Los_Angeles");
   
   # Retrieve the input and clean it for database insertion.
   $challenger = cleanInputs($_POST['challenger'], $connection);
   $challengee = cleanInputs($_POST['challengee'], $connection);
   $issueDate = date("Y-m-d");
   
   # Convert the times received to a timestamp for insertion into the database.
   $scheduleDate = cleanInputs($_POST['date'], $connection);
   $scheduleTime = cleanInputs($_POST['time'], $connection);
   $challengeDate = $scheduleDate . " " . $scheduleTime;
   
   # Before attempting to insert the challenge, perform one final
   # check to make sure that the given date is valid.
   $toCheck = split("-", $scheduleDate);
   $validDate = checkDate($toCheck[1], $toCheck[2], $toCheck[0]);
   
   if($validDate)
   {
      # Insert the new challenge into the database.
      $challengeSuccess = mysqli_query($connection, 
         "INSERT INTO challenge (challenger, challengee, issued, scheduled) 
            VALUES ('$challenger', '$challengee', '$issueDate', '$challengeDate')");
   }
   
   else
   {
      $challengeSuccess = false;
   }
?>

<!DOCTYPE html>
<html>
<head>
   <title>Wrath of Titans - Issue Challenge</title>
   
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
               # If the challenge was issued successfully, notify the user and redirect 
               # to the player standings. page.
               if($challengeSuccess)
               {
                  $challengeeName = getName($challengee, $connection);
               
                  echo("
                     <p>Congratulations! You have successfully issued a challenge to $challengeeName.</p>
                        
                     <p class='small' style='padding-top: 15px'>Please <a href='../../../index.php?p=standings'>click here</a> if
                        you are not automatically redirected.</p>
                     <script type='text/javascript'>
                        setTimeout(function(){window.location = '../../../index.php?p=standings';}, 3000);
                     </script>
                  ");
               }
               
               # If the challege was not successful, notify the user and redirect them back
               # to the standings page.
               else
               {
                  if(!$validDate)
                  {
                     echo("
                        <p>The date entered was invalid.
                     ");
                  }
                  else
                  {
                     echo("
                        <p>The challenge could not be issued.</p>
                     ");
                  }
                  
                  echo("
                     <p class='small' style='padding-top: 15px'>Please <a href='../../../index.php?p=standings'>click 
                        here</a> if you are not autmotically redirected.</p>
                     <script type='text/javascript'>
                         setTimeout(function(){window.location = '../../../index.php?p=standings';}, 3000);
                     </script>
                  ");
               }
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