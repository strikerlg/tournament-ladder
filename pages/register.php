<div class="widget">
   <div class="widgetTitle">
      <img src="includes/images/graphics/body/titleBand.png" class="goldband" height="31px" width="48px" />
      
      <h2>Register Account</h2>
   </div>
   
   <div class="widgetContent">
      <p class="small italic">All fields are required.</p>
   
      <form action="includes/scripts/php/register.php" method="POST" onsubmit="return valRegister();">
         <div class="inputContainer">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="input" />
            <div class="error small italic" id="usernameError">Please enter a username.</div>
         </div>
         
         <div class="inputContainer">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="input" />
            <div class="error small italic" id="nameError">Please enter your name.</div>
         </div>
         
         <div class="inputContainer">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="input" />
            <div class="error small italic" id="passwordError">Please enter a password.</div>
            <div class="error small italic" id="confPassError">The passwords do not match.</div>
         </div>
         
         <div class="inputContainer">
            <label for="confPass">Confirm Password:</label>
            <input type="password" name="confPass" id="confPass" class="input" />
         </div>
         
         <div class="inputContainer">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" class="input" />
            <div class="error small italic" id="emailError">Please enter a valid email address.</div>
            <div class="error small italic" id="confEmailError">The email addresses do not match.</div>
         </div>
         
         <div class="inputContainer">
            <label for="confEmail">Confirm Email:</label>
            <input type="text" name="confEmail" id="confEmail" class="input" />
         </div>
         
         <div class="inputContainer">
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" class="input" />
            <div class="error small italic" id="phoneError">Please enter a valid phone number.</div>
         </div>
         
         <div class="inputContainer">
            <input type="submit" value="Register" class="inputButton" />
         </div>
      </form>
   </div>
</div>