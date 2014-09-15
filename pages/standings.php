<?php
   # Only show the player standings if the user is logged into a valid account.
   if($validUser)
   {
      # Get the information required to show the current player standings.
      $playerInfo = getPlayerStandings($username, $rank, $connection);
   

?>
<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband" height="31px" width="48px" />
      
      <h2>Current Player Standings</h2>
   </div>
   
   <div class="widgetContent">
      <p class="centerText small italic">Click on a player's name to view their statistics.</p>
   
      <table>
         <thead>
            <td class='noStyleCell'></td>
            <td>Rank</td>
            <td>Contestant</td>
         </thead>
         <tbody>
         <form method="POST" action="?p=challenge" id="challengeForm">
            <input type="hidden" name="challengee" id="challengee" value="" />
         </form>
         <form method="POST" action="?p=stats" id="statsForm">
            <input type="hidden" name="player" id="player" value="" />
         </form>
         
         <?php
            # List each active player in the ladder.
            foreach($playerInfo as $currentPlayer)
            {
               $currentName = $currentPlayer['name'];
               $currentRank = $currentPlayer['rank'];
               $currentUser = $currentPlayer['username'];
               $challenge = $currentPlayer['challenge'];
               
               # Begin the table row.
               echo("
                  <tr>
               ");
               
               # If the player can be challenged, show an active challenge button.
               if($challenge)
               {
                  echo("
                     <td class='noStyleCell'>
                        <button type='button' 
                              class='inputButton challengeButton'
                              onclick=\"document.getElementById('challengee').value = '$currentUser'; document.getElementById('challengeForm').submit();\">
                           Challenge
                        </button>
                     </td>
                  ");
               }
               
               # If the player cannot be challenged, show a disabled challenge button.
               else
               {
                  echo("
                     <td class='noStyleCell'>
                        <button type='button' class='inputButtonDisabled challengeButton' disabled>Challenge</button>
                     </td>
                  ");
               }
               
               # Show the player information.
               echo("
                     <td>$currentRank</td>
                     <td>
                        <a onClick=\"document.getElementById('player').value = '$currentUser'; document.getElementById('statsForm').submit();\">
                           $currentName
                        </a>
                     </td>
                  </tr>
               ");
            }
         ?>
         
         </tbody>
      </table>
   </div>
</div>
   
   
<?php
   }
   
   # If not logged in, show an access denied page.
   else
   {
      include("accessDenied.php");
   }
?>