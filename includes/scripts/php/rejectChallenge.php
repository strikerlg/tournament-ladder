<?php
   # Include files required for the site to work properly.
   require_once("config.php");
   require_once("functions.php");
   
   # Retrieve the information for the challenge to remove.
   $challenger = $_POST['challenger'];
   $challengee = $_POST['challengee'];
   $time = $_POST['time'];
   
   # Remove the challenge from the database.
   $removeChallenge = mysqli_query($connection,
      "DELETE FROM challenge WHERE
         challenger = '$challenger' AND
         challengee = '$challengee' AND
         scheduled = '$time'");
?>

<!DOCTYPE html>
<html>
<head>
   <title>Wrath of Titans - Remove Challenge</title>
   
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
               if($removeChallenge)
               {
                  echo("
                     <p>The challenge was successfully rejected.</p>
                  ");
               }
               else
               {
                  echo("
                     <p>The challenge could not be rejected Please try again.</p>
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