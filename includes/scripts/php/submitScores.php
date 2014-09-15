<?php
   # Certain files are required, or the site will fail to work properly.
   require_once("config.php");
   require_once("functions.php");
   
   # Set the timezone for the date() function
   date_default_timezone_set("America/Los_Angeles");
   
   # Set a script success flag.
   $reportSuccess = true;
   
   # Get the player and their opponent, and the challenger.
   $player = $_POST['player'];
   $opponent = $_POST['opponent'];
   $challenger = $_POST['challenger'];
   
   # Set the game played date.
   $datePlayed = date("Y-m-d H:i:s");
   
   # Add each of the games from the form to the game array.
   $games = array();
   $games[0] = array($_POST['game1player'], $_POST['game1opponent']);
   $games[1] = array($_POST['game2player'], $_POST['game2opponent']);
   $games[2] = array($_POST['game3player'], $_POST['game3opponent']);
   if($_POST['game4player'] != "")
   {
      # Only add this game if scores were submitted.
      $games[3] = array($_POST['game4player'], $_POST['game4opponent']);
   }
   if($_POST['game5player'] != "")
   {
      # Only add this game if scores were submitted.
      $games[4] = array($_POST['game5player'], $_POST['game5opponent']);
   }
   
   # For each game, determine who won and input the data into the database.
   for($i = 0; $i < count($games); $i++)
   {
      $playerScore = $games[$i][0];
      $opponentScore = $games[$i][1];
      $gameNumber = $i + 1;
      
      # Determine who was the winner.
      if($playerScore > $opponentScore)
      {
         $winner = $player;
         $loser = $opponent;
         $winnerScore = $playerScore;
         $loserScore = $opponentScore;
      }
      else
      {
         $winner = $opponent;
         $loser = $player;
         $winnerScore = $opponentScore;
         $loserScore = $playerScore;
      }
      
      # Add the game to the database.
      $addGame = mysqli_query($connection,
         "INSERT INTO game (winner, loser, played, number, winner_score, loser_score)
            VALUES ('$winner', '$loser', '$datePlayed', '$gameNumber', '$winnerScore', '$loserScore')") or die(mysqli_error($connection) . " ln 62: Game " . ($i + 1));
            
      # If adding the game failed, set a marker.
      if(!$addGame)
      {
         $reportSuccess = false;
      }
   }
   
   # Remove the challenge from the database and adjust ranks if needed.
   if($reportSuccess)
   {
      # Remove the only challenge in the database that is associated with
      # both accounts.
      $reportSuccess = mysqli_query($connection,
         "DELETE FROM challenge WHERE
            (challenger = '$player' AND challengee = '$opponent') OR
            (challenger = '$opponent' AND challengee = '$player')") or die(mysqli_error($connection) . " ln 79");
            
      # Determine if the ranks need to be adjusted.
      if($reportSuccess)
      {
         # Get the match results.
         $getMatchInfo = mysqli_query($connection,
            "SELECT * FROM match_view WHERE 
               played = '$datePlayed'") or die(mysqli_error($connection) . "ln 87");
         $matchInfo = mysqli_fetch_array($getMatchInfo);
               
         # If the winner was the challenger, then the ranks need to be switched.
         if($matchInfo['winner'] == $challenger)
         {
            $matchWinner = $matchInfo['winner'];
            $matchLoser = $matchInfo['loser'];
         
            # Get the rank for the winner and the loser.
            $winnerRank = getUserStats($matchWinner, $connection);
            $winnerRank = $winnerRank[0];
            $loserRank = getUserStats($matchLoser, $connection);
            $loserRank = $loserRank[0];
            
            /*# Update the winner's rank to the loser's rank.
            $updateWinner = mysqli_query($connection,
               "UPDATE player SET rank = '$loserRank' WHERE username = '$matchWinner'") or die(mysqli_error($connection) . " ln 104");
               
            # Update the loser's rank to the winner's rank.
            $updateLoser = mysqli_query($connection,
               "UPDATE player SET rank = '$winnerRank' WHERE username = '$matchLoser'") or die(mysqli_error($connection) . " ln 108");
               
            if(!$updateWinner || !$updateLoser)
            {
               $reportSuccess = false;
            }
            
            $reportSuccess = mysqli_query($connection,
               "UPDATE player AS p1
                  JOIN player as p2 ON
                  (p1.username = '$matchWinner' AND p2.username = '$matchLoser')
                  SET
                  p1.rank = p2.rank,
                  p2.rank = p1.rank");*/
                  
                  
            # Remove the winner's rank, and then switch the two ranks.
            $removeWinner = mysqli_query($connection,
               "UPDATE player SET rank = NULL WHERE username = '$matchWinner'") or die(mysqli_error($connection));
            $updateLoser = mysqli_query($connection,
               "UPDATE player SET rank = '$winnerRank' WHERE username = '$matchLoser'") or die(mysqli_error($connection));
            $updateWinner = mysqli_query($connection,
               "UPDATE player SET rank = '$loserRank' WHERE username = '$matchWinner'") or die(mysqli_error($connection));
         }
      }
   }
?>

<!DOCTYPE html>
<html>
<head>
   <title>Wrath of Titans - Report Scores</title>
   
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
               if($reportSuccess)
               {
                  echo("
                     <p>You have successfully reported scores for the challenge.</p>
                  ");
               }
               else
               {
                  echo("
                     <p>The scores could not be reported. Please try again.</p>
                  ");
               }
               
               # Redirect the user back to the home page.
               echo("
                  <p class='small' style='padding-top: 15px'>Please <a href='../../../index.php'>click here</a> if
                     you are not automatically redirected.</p>");
                  /*<script type='text/javascript'>
                     setTimeout(function(){window.location = '../../../index.php';}, 3000);
                  </script>
               ");*/
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