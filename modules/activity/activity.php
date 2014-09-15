<?php
   # Get the most recent ladder activity to display in the activity widget.
   //$activity = getLadderAcitivity($connection);
?>

<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband"  />
      <h2>Recent Activity</h2>
   </div>
   
   <div class="widgetContent">
      <?php
         # Show recent activity if the user is logged into a valid account and
         # there is activity to show.
         if($validUser && count($activity) > 0)
         {
      ?>
   
   
      <?php
         }
         
         # If the user is not logged into a valid account, or there is no activity
         # to show, tell the user that there is no recent activity.
         else
         {
      ?>
      
      <p class="small centerText" style="margin: 15px;">No Recent Activity</p>
      
      <?php
         }
      ?>
   </div>
</div>