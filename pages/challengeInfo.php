<?php
   # Only show the challenge information if the user is logged into a valid account.
   if($validUser)
   {
?>

<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband" height="31px" width="48px" />
      
      <h2>Challenge Information</h2>
   </div>
   
   <div class="widgetContent">
      <form action="includes/scripts/php/acceptChallenge.php" id="acceptForm" method="POST">
         <input type="hidden" name="challenger" id="acceptChallenger" value="" />
         <input type="hidden" name="challengee" id="acceptChallengee" value="<?php echo($username); ?>" />
         <input type="hidden" name="time" id="acceptTime" value="" />
      </form>
      <form action="includes/scripts/php/rejectChallenge.php" id="rejectForm" method="POST">
         <input type="hidden" name="challenger" id="rejectChallenger" value="" />
         <input type="hidden" name="challengee" id="rejectChallengee" value="<?php echo($username); ?>" />
         <input type="hidden" name="time" id="rejectTime" value="" />
      </form>
   
   <?php
      # If there are active, unaccepted challenges for the user, show the information
      # for each challenge.
      if(hasChallenges($username, $connection))
      {
   ?>
      <table>
         <thead>
            <tr>
               <td class="noStyleCell"></td>
               <td>Challenger</td>
               <td>Date Issued</td>
               <td>Date Scheduled</td>
            </tr>
         </thead>
         <tbody>
         <?php
         
            # Get the information for each challenge.
            $challenges = getReceivedChallenges($username, $connection);
            
            # Display the information for each challenge.
            foreach($challenges as $challenge)
            {
               $challengerName = $challenge[0];
               $challengeIssued = $challenge[1];
               $challengeSchedule = $challenge[2];
               $challengerUsername = $challenge[3];
               $challengeTime = $challenge[4];
            
               echo("
                  <tr>
                     <td class='noStyleCell'>
                        <p class='small'>
                           <a onclick=\"
                              document.getElementById('acceptChallenger').value = '$challengerUsername';
                              document.getElementById('acceptTime').value = '$challengeTime';
                              document.getElementById('acceptForm').submit();\">
                              accept
                           </a> 
                           <span class='lightgrey'>||</span>
                           <a onclick=\"
                              document.getElementById('rejectChallenger').value = '$challengerUsername';
                              document.getElementById('rejectTime').value = '$challengeTime';
                              document.getElementById('rejectForm').submit();\">
                              reject
                           </a>
                        </p>
                     </td>
                     <td>
                        $challengerName
                     </td>
                     <td>
                        $challengeIssued
                     </td>
                     <td>
                        $challengeSchedule
                     </td>
                  </tr>
               ");
            }
         ?>
         </tbody>
      </table>
   <?php
      }   
      # If there are no active, unaccepted challenges, notify the user.
      else
      {
         echo("
            <p class='centerText'>There are no ouststanding challenges to display.</p>
         ");
      }
   ?>
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