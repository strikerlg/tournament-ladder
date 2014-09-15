<?php
   # Include files required for the site to work properly.
   require_once("config.php");
   require_once("functions.php");
   
   # Set a flag to keep track of whether login was successful, this
   # allows for the display of an appopriate message later.
   $loginSuccess = false;
   
   # Clean the inputs received from the user.
   $username = cleanInputs($_POST['username'], $connection);
   $password = cleanInputs($_POST['password'], $connection);
   
   # Hash the password for database comparison.
   $hashedPassword = hashPass($username, $password);
   
   # Check the user information against the information in the databse,
   # searching for a valid user.
   $validUser = checkUser($username, $hashedPassword, $connection);
   
   # If a valid user was found, set a user session.
   if($validUser)
   {
      # Set the user sessions.
      setUserSession($username, $hashedPassword);
      
      # Since the user has now successfully been logged in, set the success
      # flag to show login success.
      $loginSuccess = true;
   }
?>

<!DOCTYPE html>
<html>
<head>
   <title>Wrath of Titans - Login</title>
   
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
               # If the user was successfully logged into their account, welcome them
               # back to the website and redirect them back to the home page.
               if($loginSuccess)
               {
                  $name = getName($username, $connection);
                  echo("
                     <p>Welcome back, $name!</p>
                        
                     <p class='small' style='padding-top: 15px'>Please <a href='../../../index.php'>click here</a> if
                        you are not automatically redirected.</p>
                     <script type='text/javascript'>
                        setTimeout(function(){window.location = '../../../index.php';}, 3000);
                     </script>
                  ");
               }
               
               # If the login process was unsuccessful, notify the user of the problem and
               # redirect them back to the login page.
               else
               {
                  echo("
                     <p>You have entered an invalid username or password.</p>
                     <p class='small' style='padding-top: 15px'>Please <a href='../../../index.php?p=login'>click 
                        here</a> if you are not automatically redirected.</p>
                     <script type='text/javascript'>
                         setTimeout(function(){window.location = '../../../index.php?p=login';}, 3000);
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