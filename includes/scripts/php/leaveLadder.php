<?php
   # Include files required for the site to work properly.
   require_once("config.php");
   require_once("functions.php");
   
   # Set a flag to keep track of whether login was successful, this
   # allows for the display of an appopriate message later.
   $leaveSuccess = false;
   
   # Retrieve the account username.
   $username = $_POST['username'];
   
   # Get the rank of the account associated with the username.
   $rank = getUserStats($username, $connection);
   $rank = $rank[0];
   
   # To deactive that user account, the rank is made a negative number.
   # Find the lowest negative rank to determine what to set the user's
   # rank to.
   $getMinRank = mysqli_query($connection,
      "SELECT MIN(rank) FROM player");
   $minRank = mysqli_fetch_array($getMinRank);
   $minRank = $minRank[0];
   if($minRank > 0)
   {
      $minRank = 0;
   }
   
   # Update the deactivated account's rank to be the lowest rank in the
   # database.
   $newRank = $minRank -1;
   $leaveSuccess = mysqli_query($connection,
      "UPDATE player SET rank = '$newRank' WHERE username = '$username'") or die(mysqli_error($connection));
    
   # If the deactivation was successful, get and update the rank of 
   # every player ranked behind the deactivated account.
   if($leaveSuccess)
   {
      # Remove all challenges involving the player who left.
      $removeChallenges = mysqli_query($connection,
         "DELETE FROM challenge WHERE 
         challenger = '$username' OR
         challengee = '$username'");
   
      # Get all accounts ranked behind the deactivated account.
      $getAccounts = mysqli_query($connection,
         "SELECT * FROM player WHERE rank > $rank") or die(mysqli_error($connection));
      
      # Update the rank of each account.
      while($account = mysqli_fetch_array($getAccounts))
      {
         # Get required account information.
         $newRank = $account['rank'] - 1;
         $username = $account['username'];
         
         
         
         # Deactivate the account.
         $updateAccounts = mysqli_query($connection,
            "UPDATE player SET rank = '$newRank' WHERE username = '$username'") or die(mysqli_error($connection) . " ln 52");
      }
      
      # Destroy any active user sessions.
      session_start();
      unset($_SESSION['user']);
      session_write_close();
   }
?>

<!DOCTYPE html>
<html>
<head>
   <title>Wrath of Titans - Leave Ladder</title>
   
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
               if($leaveSuccess)
               {
                  echo("
                     <p>You have successfully left the ladder.</p>
                  ");
               }
               
               else
               {
                  echo("
                     <p>There was a problem removing you from the ladder.</p>
                  ");
               }
            ?>
            
            <p class='small' style='padding-top: 15px'>Please <a href='../../../index.php'>click here</a> if
               you are not automatically redirected.</p>
            <!--<script type='text/javascript'>
               setTimeout(function(){window.location = '../../../index.php';}, 3000);
            </script>-->
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