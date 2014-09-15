<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband" height="31px" width="48px" />
      
      <h2>Login</h2>
   </div>
   
   <div class="widgetContent">
      <form action="includes/scripts/php/login.php" method="POST" onsubmit="return valMainLogin();">
         <div class="inputContainer">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="input" />
            <div class="error small italic" id="usernameError">Please enter a username.</div>
         </div>
         
         <div class="inputContainer">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="input" />
            <div class="error small italic" id="passwordError">Please enter a password.</div>
         </div>
         
         <div class="inputContainer">
            <input type="submit" value="Login" class="inputButton" />
         </div>
         
         <p class="small italic">
            <a href="?p=passReset">I forgot my password...</a>
         </p>
      </form>
   </div>
</div>