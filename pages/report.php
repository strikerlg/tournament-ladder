<?php
   # Only show the challenge form if the user is logged into a valid account.
   if($validUser)
   {
      # Only show the form to report scores if the user has an active challenge.
      if(hasActiveChallenge($username, $connection))
      {
         # Get the information for the active challenge.
         $challenge = getActiveChallenge($username, $connection);
         
         $challengerName = $challenge[0];
         $challenger = $challenge[3];
         $opponent = $challenge[5];
?>

<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband"  />
      <h2>Report Challenge Scores</h2>
   </div>
   
   <div class="widgetContent">
      <p class="centerText italic">Report scores for your games against <?php echo($challengerName); ?>.</p>
      <p class="centerText italic small">Required fields are marked with <span class="red">*</span></p>
   
      <div id="errors" class="centerText">
      </div>
   
      <form action="includes/scripts/php/submitScores.php" method="POST" onsubmit="return valGameScores()">
         <input type="hidden" name="player" id="player" value="<?php echo($username); ?>" />
         <input type="hidden" name="opponent" id="opponent" value="<?php echo($opponent); ?>" />
         <input type="hidden" name="challenger" id="challenger" value="<?php echo($challenger); ?>" />
            
         <table>
            <tr>
               <td class="noStyleCell"></td>
               <td class="noStyleCell">Your Score:</td>
               <td class="noStyleCell">Opponent Score:</td>
               <td class="mainError noStyleCell"></td>
            </tr>
            
            <tr>
               <td class="noStyleCell">
                  <label>Game 1<span class="red">*</span>:</label>
               </td>
               <td class="noStyleCell">
                  <input type="text" class="input" name="game1player" id="game1player" />
               </td>
               <td class="noStyleCell">
                  <input type="text" class="input" name="game1opponent" id="game1opponent" />
               </td>
               <td class="noStyleCell">
                  <p id="game1error1" class="error small italic">Enter scores.</p>
                  <p id="game1error2" class="error small italic">Min high score is 15</p>
                  <p id="game1error3" class="error small italic">Must win by 2.</p>
               </td>
            </tr>
            
            <tr>
               <td class="noStyleCell">
                  <label>Game 2<span class="red">*</span>:</label>
               </td>
               <td class="noStyleCell">
                  <input type="text" class="input" name="game2player" id="game2player" />
               </td>
               <td class="noStyleCell">
                  <input type="text" class="input" name="game2opponent" id="game2opponent" />
               </td>
               <td class="noStyleCell">
                  <p id="game2error1" class="error small italic">Enter scores.</p>
                  <p id="game2error2" class="error small italic">Min high score is 15</p>
                  <p id="game2error3" class="error small italic">Must win by 2.</p>
               </td>
            </tr>
            
            <tr>
               <td class="noStyleCell">
                  <label>Game 3<span class="red">*</span>:</label>
               </td>
               <td class="noStyleCell">
                  <input type="text" class="input" name="game3player" id="game3player" />
               </td>
               <td class="noStyleCell">
                  <input type="text" class="input" name="game3opponent" id="game3opponent" />
               </td>
               <td class="noStyleCell">
                  <p id="game3error1" class="error small italic">Enter scores.</p>
                  <p id="game3error2" class="error small italic">Min high score is 15</p>
                  <p id="game3error3" class="error small italic">Must win by 2</p>
               </td>
            </tr>
            
            <tr>
               <td class="noStyleCell">
                  <label>Game 4:</label>
               </td>
               <td class="noStyleCell">
                  <input type="text" class="input" name="game4player" id="game4player" />
               </td>
               <td class="noStyleCell">
                  <input type="text" class="input" name="game4opponent" id="game4opponent" />
               </td>
               <td class="noStyleCell">
                  <p id="game4error1" class="error small italic">Enter scores.</p>
                  <p id="game4error2" class="error small italic">Min high score is 15</p>
                  <p id="game4error3" class="error small italic">Must win by 2</p>
               </td>
            </tr>
            
            <tr>
               <td class="noStyleCell">
                  <label for="game5">Game 5:</label>
               </td>
               <td class="noStyleCell">
                  <input type="text" class="input" name="game5player" id="game5player" />
               </td>
               <td class="noStyleCell">
                  <input type="text" class="input" name="game5opponent" id="game5opponent" />
               </td>
               <td  class="noStyleCell">
                  <p id="game5error1" class="error small italic">Enter scores.</p>
                  <p id="game5error2" class="error small italic">Min high score is 15</p>
                  <p id="game5error3" class="error small italic">Must win by 2</p>
               </td>
            </tr>
         </table>
         
         <div class="buttonContainer">
            <input type="submit" value="Report" class="inputButton" />
         </div>
      </form>
   </div>
</div>

<?php
      }
      
      # If no active challenge, notify the user.
      else
      {
?>

<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband"  />
      <h2>Report Challenge Scores</h2>
   </div>
   
   <div class="widgetContent">
      <p class="centerText italic" style="margin-top: 15px">There is no active challenge to report scores for.</p>
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