<?php
   # Only show the widget if the user is logged into a valid account.
   if($validUser)
   {
      # Retrieve the statistics for the logged in user to display in
      # the account information widget.
      $userStats = getUserStats($username, $connection);
      $rank = $userStats[0];
      $wins = $userStats[1];
      $losses = $userStats[2];
      $average = $userStats[3];
?>

<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband" height="31px" width="48px" />
      <h2>Account Information</h2>
   </div>
   
   <div class="widgetContent">
      <div class="widgetContentSection">
         <p>Welcome, <?php echo("$name"); ?>.</p>
         <img src="includes/images/graphics/body/widgetSeparator.png" class="separator" />
      </div>
      
      
      <?php
         # If the account logged in has active, unaccepted challenges, display a notification.
         if($hasChallenges)
         {
      ?>
      
      <div class="widgetContentSection">
         
         <div class="notification">
            <p class="small">You have a new challenge!</p>
            <a href="?p=challengeInfo" class="small">view challenges</a>
         </div>
         
         <img src="includes/images/graphics/body/widgetSeparator.png" class="separator" />
      </div>
      
      <?php
         }
         
         # If the account logged in has an active, accepted challenge, display the challenge info.
         elseif(hasActiveChallenge($username, $connection))
         {
            # Get the information for the challenge.
            $challenge = getActiveChallenge($username, $connection);
         
      ?>
      
      <div class="widgetContentSection">
      
         <p>Active Challenge:</p>
         <p class="small indent">Opponent: <?php echo($challenge[0]); ?></p>
         <p class="small indent">Date: <?php echo($challenge[1]); ?></p>
         <p class="small indent">Time: <?php echo($challenge[2]); ?></p>
         
         <p class="small centerText"><a href="?p=reportScores">report scores</a></p>
         
         <img src="includes/images/graphics/body/widgetSeparator.png" class="separator" />
      </div>
      
      <?php
         }
      ?>
      
      <div class="widgetContentSection">
         <p class="small indent">Rank: <?php echo($rank); ?></p>
         <p class="small indent">Wins: <?php echo($wins); ?></p>
         <p class="small indent">Losses: <?php echo($losses); ?></p>
         <p class="small indent">Average: <?php echo($average); ?></p>
         <img src="includes/images/graphics/body/widgetSeparator.png" class="separator" />
      </div>
      
      <div class="widgetContentSection">
         <p class="centerText small"><a href="?p=account">manage account</a></p>
      </div>
   </div>
</div>

<?php
   }
?>