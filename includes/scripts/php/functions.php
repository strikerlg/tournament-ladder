<?php
#*****************************************************************************#
#  CLEAN INPUTS                                                               #
#  Cleans user inputs received from a form for entry into the database.       #
#                                                                             #
#  inputString - The string to clean                                          #
#  connection  - The database connection we're working with.                  #
#                                                                             #
#  RETURNS: The cleaned input.                                                #
#*****************************************************************************#
function cleanInputs($inputString, $connection)
{
   # Run a series of sanitization functions on the received string, and send
   # it back.
   return trim(mysqli_real_escape_string($connection, stripslashes(htmlspecialchars($inputString))));
}


#*****************************************************************************#
#  HASH PASSWORD                                                              #
#  Hashes the password for comparison with the database.                      #
#                                                                             #
#  username - The username received from the web page.                        #
#  password - The password to hash.                                           #
#                                                                             #
#  RETURNS: The hashed password.                                              #
#*****************************************************************************#
function hashPass($username, $password)
{
   # Define a hash salt, which is itself a hashed string. The salt adds
   # more data to the string to be hashed, with the intent to (hopefully)
   # improve password security.
   $salt = "4f73c273a6cf184dd5a7534a746d305580a2203a";

   # Hash the password using SHA-1, and send it back.
   return sha1($username . " : " . $password . " : " . $salt);
}


#*****************************************************************************#
#  CHECK USER                                                                 #
#  Checks whether a user exists with the given information.                   #
#                                                                             #
#  username   - The username to look for.                                     #
#  hashedPass - The password hash to look for.                                #
#  connection - The connection to the database to look in.                    #
#                                                                             #
#  RETURNS: True if a user exists.                                            #
#*****************************************************************************#
function checkUser($username, $hashedPass, $connection)
{
   # Search for the user account in the database.
   $checkDB = mysqli_query($connection, "SELECT * FROM player WHERE username = '$username' AND password = '$hashedPass' AND rank > 0");

   # There should only be one user found. Send back a boolean based on number of
   # rows found.
   return mysqli_num_rows($checkDB) == 1;
}

#*****************************************************************************#
#  USER AUTHENTICATION                                                        #
#  Checks whether valid user sessions exist.                                  #
#                                                                             #
#  connection - The connection to the database to look in.                    #
#                                                                             #
#  RETURNS: True if a valid user sessions.                                    #
#*****************************************************************************#
function userAuth($connection)
{
   $validUser = false;
   session_start();
      
   # Check for a user session set by the website.
   if(isset($_SESSION['user']))
   {
      # Get the username and password stored in the session.
      $username = $_SESSION['user'][0];
      $password = $_SESSION['user'][1];
      
      # Check whether the information stored in the session matches up to a
      # valid user account.
      $validUser = checkUser($username, $password, $connection);
   }
   
   session_write_close();
   return $validUser;
}


#*****************************************************************************#
#  GET NAME                                                                   #
#  Gets the name associated with the given account.                           #
#                                                                             #
#  username - The username of the account to get the name for                 #
#  connection - The connection to the database to look in.                    #
#                                                                             #
#  RETURNS: The name registered with the account given.                       #
#*****************************************************************************#
function getName($username, $connection)
{
   # Get the username from the database.
   $getName = mysqli_query($connection, "SELECT name FROM player WHERE username = '$username'");
   $name = mysqli_fetch_array($getName);
   
   return($name['name']);
}


#*****************************************************************************#
#  GET USER STATS                                                             #
#  Gets the statistics for the given user.                                    #
#                                                                             #
#  username - The username of the account to get the name for                 #
#  connection - The connection to the database to look in.                    #
#                                                                             #
#  RETURNS: An array containing the statistics for the user:                  #
#              * Rank                                                         #
#              * Wins                                                         #
#              * Losses                                                       #
#              * Average                                                      #
#*****************************************************************************#
function getUserStats($username, $connection)
{
   # Retrieve the information from the database, and insert it into an array.
   $getRank = mysqli_query($connection, "SELECT rank FROM player WHERE username = '$username'");
   $getWins = mysqli_query($connection, "SELECT COUNT(winner) FROM game WHERE winner = '$username'");
   $getLosses = mysqli_query($connection, "SELECT COUNT(loser) FROM game WHERE loser = '$username'");
   
   # Retrieve the user's rank.
   $rank = mysqli_fetch_array($getRank);
   $rank = $rank['rank'];
   
   # Retrieve the user's win count.
   $wins = mysqli_fetch_array($getWins);
   $wins = $wins[0];
   
   # Retrieve the user's loss count.
   $losses = mysqli_fetch_array($getLosses);
   $losses = $losses[0];
   
   # Calculate the user's average of wins and losses.
   if($wins + $losses == 0)
   {
      # If there are no games played, then the average should just be 0.
      $average = 0;
   }
   else
   {
      # Calculate the average, using a two-decimal format.
      $average = number_format(($wins / ($wins + $losses)) * 100, 2, ".", "");
   }
   
   # Return an array containing the statistics.
   return array($rank, $wins, $losses, $average);
}


#*****************************************************************************#
#  GET PAGE                                                                   #
#  Determines the appropriate page file based on the requested page filename. #
#                                                                             #
#  page - The page to look for.                                               #
#                                                                             #
#  RETURNS: The filename of the page to display.                              #
#              error.php - if no valid page is found.                         #
#*****************************************************************************#
function getPage($page)
{
   # Since there is a finite list of valid pages for this website, determine
   # if the requested page is in that list using a switch statement. Sets the
   # filename if the request matches a page, or defaults to 'error.php' if no
   # match.
   switch($page)
   {
      case "about":
         $filename = "about.php";
         break;
      case "account":
         $filename = "account.php";
         break;
      case "challenge";
         $filename = "challenge.php";
         break;
      case "challengeInfo";
         $filename = "challengeInfo.php";
         break;
      case "login":
         $filename = "login.php";
         break;
      case "register":
         $filename = "register.php";
         break;
      case "reportScores":
         $filename = "report.php";
         break;
      case "standings":
         $filename = "standings.php";
         break;
      case "stats":
         $filename = "stats.php";
         break;
      default:
         $filename = "error.php";
   }
   
   return $filename;
}


#*****************************************************************************#
#  GET PAGE TITLE                                                             #
#  Determines the appropriate title for the requested page.                   #
#                                                                             #
#  page - The page to look for.                                               #
#                                                                             #
#  RETURNS: The title of the page requested, prefixed with "- " to separate   #
#           it from the main title of the website.                            #
#              Error - if no valid page is found.                             #
#*****************************************************************************#
function getPageTitle($page)
{
   # Choose the page title based on the given page, defaulting to "Error" if no
   # matches are found.
   switch($page)
   {
      case "about":
         $pageTitle = "- About";
         break;
      case "account":
         $pageTitle = "- Account Management";
         break;
      case "challenge";
         $pageTitle = "- Issue Challenge";
         break;
      case "challengeInfo";
         $pageTitle = "- Challenge Information";
         break;
      case "login":
         $pageTitle = "- Login";
         break;
      case "register":
         $pageTitle = "- Register";
         break;
      case "reportScores":
         $pageTitle = "- Report Scores";
         break;
      case "standings":
         $pageTitle = "- Player Standings";
         break;
      case "stats":
         $pageTitle = "- Player Statistics";
         break;
      default:
         $pageTitle = "- Error";
   }
   
   return $pageTitle;
}


#*****************************************************************************#
#  GET PLAYER STANDINGS                                                       #
#  Gets standings information for all active players in the database.         #
#                                                                             #
#  username- The username of the user currently logged in.                    #
#  userRank - The rank of the user currently logged in.                       #
#  connection - The connection to the database to look in.                    #
#                                                                             #
#  RETURNS: An array of arrays containing information for each active player. #
#*****************************************************************************#
function getPlayerStandings($username, $userRank, $connection)
{
   # Get all active users from the database.
   $getUsers = mysqli_query($connection, "SELECT * FROM player WHERE rank > 0 ORDER BY rank") or die(mysqli_error($connection));
   
   # Add all users to an array that includes their name and rank.
   $contestants = array();
   while($playerInfo = mysqli_fetch_array($getUsers))
   {
      # Determine if the current contestant is able to be challenged by the
      # player who is currently logged in. A player can be challenged if they
      # are within three ranks above a user, have no active challenges, and the
      # challenging player has no active challenges.
      $canChallenge = $playerInfo['rank'] < $userRank && 
         $playerInfo['rank'] >= $userRank - 3 &&
         !hasActiveChallenge($playerInfo['username'], $connection) &&
         !hasActiveChallenge($username, $connection);
      
      $contestants[] = array("name" => $playerInfo['name'],
         "username" => $playerInfo['username'],
         "rank" => $playerInfo['rank'], 
         "challenge" => $canChallenge);
   }
   
   return $contestants;
}


#*****************************************************************************#
#  SET USER SESSION                                                           #
#  Sets a new user session to log a user into the site.                       #
#                                                                             #
#  username - The username to store in the session.                           #
#  hashedPassword - The password to store in the session.                     #
#*****************************************************************************#
function setUserSession($username, $hashedPassword)
{
   # Set the session to destroy itself on browser exit.
   session_set_cookie_params(0);
   
   # Begin writing to a session.
   session_start();
   
   # Set the session data to the user's username and the hash of their password.
   $_SESSION['user'] = array($username, $hashedPassword);
   
   # End writing to the session.
   session_write_close();
}


#*****************************************************************************#
#  HAS CHALLENGES                                                             #
#  Determines if the given user has any outstanding, unaccepted challenges.   #
#                                                                             #
#  username - The username of the user to check challenges for.               #
#  connection - The connection to the database to look in.                    #
#                                                                             #
#  RETURNS: True if any outstanding challenges exist.                         #
#*****************************************************************************#
function hasChallenges($username, $connection)
{
   # Submit a database query for all active, unaccepted challenges where the
   # user is the challengee.
   $getChallenges = mysqli_query($connection,
      "SELECT * FROM challenge WHERE challengee = '$username' AND accepted IS NULL");
      
   # If any rows were found in the query, then challenges exist.
   return mysqli_num_rows($getChallenges) > 0;
}


#*****************************************************************************#
#  HAS ACTIVE CHALLENGE                                                       #
#  Determines if the given user has an active, accepted challenge.            #
#                                                                             #
#  username - The username of the user to check challenges for.               #
#  connection - The connection to the database to look in.                    #
#                                                                             #
#  RETURNS: True if an accepted challenge exists.                             #
#*****************************************************************************#
function hasActiveChallenge($username, $connection)
{
   # Submit a database query for an accepted challenge.
   $getChallenge = mysqli_query($connection,
      "SELECT * FROM challenge WHERE 
         (challengee = '$username' OR challenger = '$username') AND 
         accepted IS NOT NULL");
   
   # If one row was found, then there is an accepted challenge.
   return mysqli_num_rows($getChallenge) == 1;
}


#*****************************************************************************#
#  GET ACTIVE CHALLENGE                                                       #
#  Gets the information for an active, accepted challenge.                    #
#                                                                             #
#  username - The username of the user to check challenges for.               #
#  connection - The connection to the database to look in.                    #
#                                                                             #
#  RETURNS: An array containing information for the requested challenge.      #
#*****************************************************************************#
function getActiveChallenge($username, $connection)
{
   # Set the timezone for the date() function
   date_default_timezone_set("America/Los_Angeles");

   # Submit a database query for the accepted challenge.
   $getChallenge = mysqli_query($connection,
      "SELECT * FROM challenge WHERE 
         (challengee = '$username' OR challenger = '$username') AND 
         accepted IS NOT NULL");
   
   # Retrieve the information from the query result.
   $challengeInfo = mysqli_fetch_array($getChallenge);
   
   # Determine whose name should be sent.
   if($username == $challengeInfo['challenger'])
   {
      $name = getName($challengeInfo['challengee'], $connection);
      $opponent = $challengeInfo['challengee'];
   }
   else
   {
      $name = getName($challengeInfo['challenger'], $connection);
      $opponent = $challengeInfo['challenger'];
   }
   
   $date = $challengeInfo['scheduled'];
   $scheduledDate = date("F j, Y", strtotime($date));
   $scheduledTime = date("g:i a", strtotime($date));
   
   return array($name, $scheduledDate, $scheduledTime, $challengeInfo['challenger'], $date, $opponent);  
}


#*****************************************************************************#
#  GET RECEIVED CHALLENGES                                                    #
#  Gets all available unaccepted challenges for the given user.               #
#                                                                             #
#  username - The username of the user to get challenges for.                 #
#  connection - The connection to the database to look in.                    #
#                                                                             #
#  RETURNS: An array containing information for each challenge.               #
#*****************************************************************************#
function getReceivedChallenges($username, $connection)
{
   $challenges = array();
   
   # Set the timezone for the date() function
   date_default_timezone_set("America/Los_Angeles");
   
   # Submit a database query for all challenges where the given user is the
   # challengee.
   $getChallenges = mysqli_query($connection,
      "SELECT * FROM challenge WHERE challengee = '$username'");
      
   # Add each challenge into the challenges array.
   while($challenge = mysqli_fetch_array($getChallenges))
   {
      # Get the challenger's name.
      $challenger = getName($challenge['challenger'], $connection);
      
      # Format the date issued
      $issueDate = $challenge['issued'];
      $issueDate = date("F j, Y", strtotime($issueDate));
      
      # Format the scheduled date.
      $scheduledDate = $challenge['scheduled'];
      $scheduledDate = date("F j, Y", strtotime($scheduledDate)) . " at " . date("g:i a", strtotime($scheduledDate));
      
      $challenges[] = array($challenger, $issueDate, $scheduledDate, $challenge['challenger'], $challenge['scheduled']);
   }
   
   return $challenges;
}
?>