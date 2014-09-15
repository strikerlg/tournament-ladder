<?php
   # Include files required for the site to work properly.
   require_once("includes/scripts/php/config.php");
   require_once("includes/scripts/php/functions.php");
   
   # Get some information that will be needed to render the page properly.
   $validUser = userAuth($connection);
   
   # If a page has been requested, get the information for it.
   if(isset($_GET['p']))
   {
      $page = getPage($_GET['p']);
      $pageTitle = getPageTitle($_GET['p']);
   }
   else
   {
      $page = "home.php";
      $pageTitle = "- Home";
   }
   
   # If the user is logged into a valid account, get information needed to
   # display the page.
   if($validUser)
   {
      # Get the account's username from the active session.
      session_start();
      $username = $_SESSION['user'][0];
      session_write_close();
      
      # Get the name associated with the user's account.
      $name = getName($username, $connection);
      
      # Determine if there are any active, unaccepted challenges for the
      # account.
      $hasChallenges = hasChallenges($username, $connection);
   }
?>

<!DOCTYPE html>
<html>
<head>
   <title>Wrath of Titans <?php echo($pageTitle); ?></title>
   
   <!-- CSS Inclusion -->
      <link href="includes/styles/reset.css" rel="stylesheet" type="text/css" />
      <link href="includes/styles/main.css" rel="stylesheet" type="text/css" />
   <!-- /End CSS Inclusion -->
   
   <!-- Javascript Inclusion -->
      <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
      <script src="includes/scripts/js/formVal.js"></script>
      <script src="includes/scripts/js/functions.js"></script>
   <!-- /End Javascript Inclusion -->
</head>
<body>
<div id="container">
   <!-- Website Header -->
   <div id="header">
      <div id="headerBar">
         <?php
            # If there are valid user sessions, welcome the user and show the logout button.
            if($validUser)
            {
               echo("
                  <div class='floatRight'>
                     <p>
                        Welcome, $name. <span class='grey'>||</span> 
                        <a href='includes/scripts/php/logout.php'>logout</a>
                     </p>
                  </div>
               ");
            }
            
            # If there is not a valid session, show the login and register buttons.
            else
            {
               echo("
                  <div id='headerBarButtons' class='floatRight'>
                     <button type='button' class='inputButton' 
                        id='headerLogButton' value='Login' 
                        onclick='animateLogin();'>Login</button>
                     <a href='?p=register'><button type='button' class='inputButton' value='Register'>Register</button></a>
                  </div>
               ");
            }
         ?>
      </div>
      
      <div id="headerTitle">
         <img src="includes/images/graphics/header/logo.png" />
      </div>
      
      <div id="headerBarLogin">
         <div id="headerLogin">
            <form action="includes/scripts/php/login.php" method="POST" onsubmit="return valUpperLogin();">
               <div class="inputContainer">
                  <input type="text" name="username" id="headerUser" class="input loginUser" value="username" onfocus="loginFieldFocus(this);" onblur="loginFieldBlur(this);" />
               </div>
               
               <div class="inputContainer">
                  <input type="password" name="password" id="headerPass" class="input loginPass" value="password" onfocus="loginFieldFocus(this);" onblur="loginFieldBlur(this);" />
               </div>
               
               <div class="inputContainer">
                  <input type="submit" value="Login" class="inputButton" />
               </div>
            </form>
         </div>
      </div>
   </div>
   <!-- /End Header -->
   
   <!-- Website Main Body -->
   <div id="body">
   
      <!-- Website Navigation -->
      <div id="nav">
         <?php 
            # Include the navigation module.
            include("modules/nav/nav.php");
         ?>
      </div>
      <!-- /End Navigation -->
      
      <!-- Sidebar -->
      <div id="sidebar" class="floatLeft">
         <?php 
            // Include sidebar modules.
            include("modules/accInfo/accInfo.php");
            include("modules/activity/activity.php");
         ?>
      </div>
      <!-- /End Sidebar -->
      
      <div id="mainContent" class="floatRight">
         <?php
            # Include the requested website page.
            include("pages/$page");
         ?>
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