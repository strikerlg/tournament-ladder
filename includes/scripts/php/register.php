<?php
   # Include files required for the site to work properly.
   require_once("config.php");
   require_once("functions.php");
   
   # Set a flag to keep track of whether registration was successful, this
   # allows for the display of an appopriate message later.
   $registerSuccess = true;


   # Retreive the user input and clean it for database insertion
   $username = cleanInputs($_POST['username'], $connection);
   $playerName = cleanInputs($_POST['name'], $connection);
   $phone = cleanInputs($_POST['phone'], $connection);
   $email = cleanInputs($_POST['email'], $connection);
   $password = cleanInputs($_POST['password'], $connection);
   
   # Hash the password for storage in the database.
   $hashedPassword = hashPass($username, $password);
   
   # Determine whether there are accounts that use the same username or
   # email address.
   $sameUsername = mysqli_num_rows(mysqli_query($connection,
      "SELECT * FROM player WHERE username = '$username'")) != 0;
   $sameEmail = mysqli_num_rows(mysqli_query($connection,
      "SELECT * FROM player WHERE email = '$email'")) != 0;
      
   # If no accounts were found using the same username or eamil address,
   # continue with the registration process.
   if(!$sameUsername && !$sameEmail)
   {
      # Determine what the new account's initial rank should be. This equals
      # the lowest rank in the ladder plus 1.
      $getRanks = mysqli_query($connection, "SELECT MAX(rank) FROM player");
      $maxRank = mysqli_fetch_array($getRanks);
      $maxRank = $maxRank[0];
      $newRank = $maxRank + 1;
      
      # Insert the new user into the database, using the boolean return result
      # from the query to determine whether registration of the account was
      # successful. 
      $registerSuccess = mysqli_query($connection,
         "INSERT INTO player (name, email, phone, rank, username, password)
            VALUES ('$playerName', '$email', '$phone', '$newRank', '$username', '$hashedPassword')");
            
      # If the account registration has been successfull, log the user into their
      # new user account.
      if($registerSuccess)
      {
         # Set the user sessions.
         setUserSession($username, $hashedPassword);
      }
   }
   
   # If there were accounts found using the same information, registration was
   # unsuccessful.
   else
   {
      $registerSuccess = false;
   }
?>

<!DOCTYPE html>
<html>
<head>
   <title>Wrath of Titans - Register</title>
   
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
               # If account registration was successful, alert the user, remind them of their
               # username, and redirect them to the home page.
               if($registerSuccess)
               {
                  echo("
                     <p>Congratulations! You have succesfully registered an account with
                        the username: $username.</p>
                        
                     <p class='small' style='padding-top: 15px'>Please <a href='../../../index.php'>click here</a> if
                        you are not automatically redirected.</p>
                     <script type='text/javascript'>
                        setTimeout(function(){window.location = '../../../index.php';}, 3000);
                     </script>
                  ");
               }
               
               # If account registration was not successful, notify the user of the problem,
               # and redirect them back to the registration page.
               else
               {
                  # If the username AND email address are already registered to a different
                  # account, tell the user that they are already taken.
                  if($sameUsername && $sameEmail)
                  {
                     echo("
                        <p>The username and email address that you have chosen are already
                           taken.</p>
                     ");
                  }
                  
                  # If the username is already registered to a different account, tell the
                  # user that it is already taken.
                  elseif($sameUsername)
                  {
                     echo("
                        <p>The username that you have chosen is already taken.</p>
                     ");
                  }
                  
                  # If the email address is already registered to a different account, tell
                  # the user that it is already taken.
                  elseif($sameEmail)
                  {
                     echo("
                        <p>The email address that you have chosen is already taken.</p>
                     ");
                  }
                  
                  # If an undetermined error has occured with account registration, tell the
                  # user that registration failed, and ask them to try again.
                  else
                  {
                     echo("
                        <p>The account could not be registered. Please try again.</p>
                     ");
                  }
                  
                  # Redirect the user back tot he registration page.
                  echo("
                     <p class='small' style='padding-top: 15px'>Please <a href='../../../index.php?p=register'>click 
                        here</a> if you are not autmotically redirected.</p>
                     <script type='text/javascript'>
                         setTimeout(function(){window.location = '../../../index.php?p=register';}, 3000);
                     </script>
                  ");
               }
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