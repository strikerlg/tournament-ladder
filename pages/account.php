<?php
   # Only show the account management page if the user is logged into a 
   # valid account.
   if($validUser)
   {
   
?>

<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband"  />
      <h2>Account Management</h2>
   </div>
   
   <div class="widgetContent">
      <form action="includes/scripts/php/leaveLadder.php" id="leaveForm" method="POST">
         <input type="hidden" name="username" id="username" value="<?php echo($username); ?>" />
      </form>
   
      <p style="margin: 5px 0 0 10px">Your statistics:</p>
   
      <table style="margin: 0 5px 5px 5px">
         <tr>
            <td>Rank:</td>
            <td><?php echo($rank); ?></td>
         </tr>
         <tr>
            <td>Wins:</td>
            <td><?php echo($wins); ?></td>
         </tr>
         <tr>
            <td>Losses:</td>
            <td><?php echo($losses); ?></td>
         </tr>
         <tr>
            <td>Average:</td>
            <td><?php echo($average); ?></td>
         </tr>
      </table>
      
      <p style="margin-top: 10px" class="centerText"><a onclick="leaveLadderVerification();">leave ladder</a></p>
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