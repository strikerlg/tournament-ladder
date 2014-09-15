<?php
   # Destroy any active user sessions.
   session_start();
   unset($_SESSION['user']);
   session_write_close();
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
            <p>You have been logged out of your account.</p>
               
            <p class='small' style='padding-top: 15px'>Please <a href='../../../index.php'>click here</a> if
               you are not automatically redirected.</p>
            <script type='text/javascript'>
               setTimeout(function(){window.location = '../../../index.php';}, 3000);
            </script>
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