<?php
   # Only show the challenge form if the user is logged into a valid account.
   if($validUser)
   {
      # Only show the form if a player is selected.
      if(isset($_POST['challengee']))
      {
         # Retrieve the submitted player
         $player = $_POST['challengee'];
         
         # Get information for the player
         $playerName = getName($player, $connection);
?>

<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband"  />
      <h2>Issue Challenge for: <?php echo($playerName); ?></h2>
   </div>
   
   <div class="widgetContent">
      <p class="centerText italic">Please choose a date and time for the challenge.</p>
   
      <div id="errors"></div>
   
      <form action="includes/scripts/php/issueChallenge.php" method="POST" onsubmit="return valChallengeDate();">
         <input type="hidden" name="challenger" id="challenger" value="<?php echo($username); ?>" />
         <input type="hidden" name="challengee" id="challengee" value="<?php echo($player); ?>" />
         
         <div class="inputContainer">
            <label for="date">Date <br /> <span class="small">(YYYY-MM-DD)</small>: </label>
            <input type="text" class="input" name="date" id="date"/>
            <div class="error small italic" id="dateError">Please enter a valid date.</div>
         </div>
         
         <div class="inputContainer">
            <label for="time">Time <br /><span class="small">(24hr: HH:MM)</small>:</label>
            <input type="text" class="input" name="time" id="time" />
            <div class="error small italic" id="timeError">Please enter a valid time.</div>
         </div>
         
         <div class="buttonContainer">
            <input type="submit" value="Challenge" class="inputButton challengeButton" />
         </div>
      </form>
   </div>
</div>

<?php
      }
      
      # If no player selected, notify the user.
      else
      {
?>
     
<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband"  />
      <h2>Issue Challenge - Error</h2>
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