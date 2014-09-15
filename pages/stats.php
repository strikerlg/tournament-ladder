<?php
   # Only show the challenge form if the user is logged into a valid account.
   if($validUser)
   {
      # Only display the page if a player has been selected.
      if(isset($_POST['player']))
      {
         # Retrieve the submitted player
         $player = $_POST['player'];
         
         # Get information for the player
         $playerName = getName($player, $connection);
         
         # Get the statistics for the requested player.
         $playerStats = getUserStats($player, $connection);
         
         $playerRank = $playerStats[0];
         $playerWins = $playerStats[1];
         $playerLosses = $playerStats[2];
         $playerAvg = $playerStats[3];
?>

<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband"  />
      <h2>Statistics For <?php echo($playerName);?></h2>
   </div>
   
   <div class="widgetContent">
   
      <table>
         <tr>
            <td>Rank:</td>
            <td><?php echo($playerRank); ?></td>
         </tr>
         <tr>
            <td>Wins:</td>
            <td><?php echo($playerWins); ?></td>
         </tr>
         <tr>
            <td>Losses:</td>
            <td><?php echo($playerLosses); ?></td>
         </tr>
         <tr>
            <td>Average:</td>
            <td><?php echo($playerAvg); ?></td>
         </tr>
      </table>
   
   </div>
</div>

<?php

      }

      # If a player has not been selected, notify the user.
      else
      {
?>

<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband"  />
      <h2>Player Statistics - Error</h2>
   </div>
   
   <div class="widgetContent">
      <p>No player has been selected. Please visit the <a href='?p=standings'>player 
         standings</a> and choose a player to view statistics for.</p>
   </div>
</div>

<?php
      }
   }

   # If not logged in, show an access denied page.
   else
   {
      include("accessDenied.php");
   }
?>