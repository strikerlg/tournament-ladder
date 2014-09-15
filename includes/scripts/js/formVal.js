/**
 * Makes sure that all input in the upper login form is valid.
 */
function valUpperLogin()
{
   // Assume the input is valid.
   var validLogin = true;
   
   // Check that a username has been entered.
   if(document.getElementById("headerUser").value == "username" || 
      document.getElementById("headerUser").value == "")
   {
      $("#headerUser").css("border", "1px solid #ff4b4b");
      validLogin = false;
   }
   else
   {
      $("#headerUser").css("border", "1px solid #0b0b0b");
   }
      
   // Check that a password has been entered.
   if(document.getElementById("headerPass").value == "password" || 
      document.getElementById("headerPass").value == "")
   {
      $("#headerPass").css("border", "1px solid #ff4b4b");
      validLogin = false;
   }
   else
   {
      $("#headerPass").css("border", "1px solid #0b0b0b");
   }
   
   return validLogin;
}


/**
 * Makes sure that all input in the main login form is valid.
 */
function valMainLogin()
{
   // Assume the input is valid.
   var validLogin = true;
   
   // Check that a username has been entered.
   if(document.getElementById("username").value == "")
   {
      $("#username").css("border", "1px solid #ff4b4b");
      $("#usernameError").css("display", "inline");
      validLogin = false;
   }
   else
   {
      $("#username").css("border", "1px solid #0b0b0b");
      $("#usernameError").css("display", "none");
   }
      
   // Check that a password has been entered.
   if(document.getElementById("password").value == "")
   {
      $("#password").css("border", "1px solid #ff4b4b");
      $("#passwordError").css("display", "inline");
      validLogin = false;
   }
   else
   {
      $("#password").css("border", "1px solid #0b0b0b");
      $("#passwordError").css("display", "none");
   }
   
   return validLogin;
}


/**
 * Makes sure that all input in the registration form is valid.
 */
function valRegister()
{
   var validInput = true;
   var emailRegEx = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,4}/;
   var phoneRegEx = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
   
   // Check for a valid username. A valid username is non-empty.
   if(document.getElementById("username").value == "")
   {
      $("#username").css("border", "1px solid #ff4b4b");
      $("#usernameError").css("display", "inline");
      validInput = false;
   }
   else
   {
      $("#username").css("border", "1px solid #0b0b0b");
      $("#usernameError").css("display", "none");
   }
   
   // Check for a valid name. A valid name is non-empty.
   if(document.getElementById("name").value == "")
   {
      $("#name").css("border", "1px solid #ff4b4b");
      $("#nameError").css("display", "inline");
      validInput = false;
   }
   else
   {
      $("#name").css("border", "1px solid #0b0b0b");
      $("#nameError").css("display", "none");
   }
   
   // Check that the passwords match and are valid.
   if(document.getElementById("password").value == "")
   {
      $("#password").css("border", "1px solid #ff4b4b");
      $("#passwordError").css("display", "inline");
      validInput = false;
   }
   else if(document.getElementById("password").value !=
      document.getElementById("confPass").value)
   {
      $("#password").css("border", "1px solid #ff4b4b");
      $("#confPass").css("border", "1px solid #ff4b4b");
      $("#passwordError").css("display", "none");
      $("#confPassError").css("display", "inline");
      validInput = false;
   }
   else
   {
      $("#password").css("border", "1px solid #0b0b0b");
      $("#confPass").css("border", "1px solid #0b0b0b");
      $("#passwordError").css("display", "none");
      $("#confPassError").css("display", "none");
   }
   
   // Check that the email addresses match and are valid.
   if(document.getElementById("email").value == "" || 
      !document.getElementById("email").value.match(emailRegEx))
   {
      $("#email").css("border", "1px solid #ff4b4b");
      $("#emailError").css("display", "inline");
      validInput = false;
   }
   else if(document.getElementById("email").value !=
      document.getElementById("confEmail").value)
   {
      $("#email").css("border", "1px solid #ff4b4b");
      $("#confEmail").css("border", "1px solid #ff4b4b");
      $("#emailError").css("display", "none");
      $("#confEmailError").css("display", "inline");
      validInput = false;
   }
   else
   {
      $("#email").css("border", "1px solid #0b0b0b");
      $("#confEmail").css("border", "1px solid #0b0b0b");
      $("#emailError").css("display", "none");
      $("#confEmailError").css("display", "none");
   }
   
   // Check that the phone number is valid. North American numbers only.
   if(document.getElementById("phone").value == "" ||
      !document.getElementById("phone").value.match(phoneRegEx))
   {
      $("#phone").css("border", "1px solid #ff4b4b");
      $("#phoneError").css("display", "inline");
      validInput = false;
   }
   else
   {
      $("#phone").css("border", "1px solid #0b0b0b");
      $("#phoneError").css("display", "none");
   }
   
   return validInput;
}


/**
 * Makes sure that dates received for challenges are valid.
 */
function valChallengeDate()
{
   var validInput = true;
   var date = document.getElementById("date").value;
   var time = document.getElementById("time").value;
   var dateRegEx = /^\d{4}\-\d{2}\-\d{2}$/;
   var timeRegEx = /^\d{2}:\d{2}$/;
   
   // Check for a valid date format.
   if(date == "" || !date.match(dateRegEx))
   {
      $("#date").css("border", "1px solid #ff4b4b");
      $("#dateError").css("display", "inline");
      validInput = false;
   }
   else
   {
      $("#date").css("border", "1px solid #0b0b0b");
      $("#dateError").css("display", "none");
   }
   
   // Check for a valid time format.
   if(time == "" || !time.match(timeRegEx))
   {
      $("#time").css("border", "1px solid #ff4b4b");
      $("#timeError").css("display", "inline");
      validInput = false;
   }
   else
   {
      $("#time").css("border", "1px solid #0b0b0b");
      $("#timeError").css("display", "none");
   }
   
   return validInput;
}


/**
 * Makes sure that all input for game score reports is valid.
 */
 function valGameScores()
 {
   var validInput = true;
   
   var games = new Array();
   games[0] = new Array(document.getElementById("game1player").value, document.getElementById("game1opponent").value);
   games[1] = new Array(document.getElementById("game2player").value, document.getElementById("game2opponent").value);
   games[2] = new Array(document.getElementById("game3player").value, document.getElementById("game3opponent").value);
   games[3] = new Array(document.getElementById("game4player").value, document.getElementById("game4opponent").value);
   games[4] = new Array(document.getElementById("game5player").value, document.getElementById("game5opponent").value);
   
   // Validate each game.
   for(var i = 0; i < games.length; i++)
   {
      validateGame(games[i][0], games[i][1], (i + 1));
   }
   
   function validateGame(player, opponent, gameNum)
   {
      // Only require data for first three games.
      if(gameNum <= 3 || (gameNum > 3 && (player != "" || opponent != "")))
      {
         if(player == "" || opponent == "" || isNaN(player) || isNaN(opponent))
         {
            if(player == "" || isNaN(player))
            {
               $("#game" + gameNum + "player").css("border", "1px solid #ff4b4b");
            }
            else
            {
               $("#game" + gameNum + "player").css("border", "1px solid #0b0b0b");
            }
            
            if(opponent == "" || isNaN(opponent))
            {
               $("#game" + gameNum + "opponent").css("border", "1px solid #ff4b4b");
            }
            else
            {
               $("#game" + gameNum + "opponent").css("border", "1px solid #0b0b0b");
            }
            
            $("#game" + gameNum + "error1").css("display", "inline");
            $("#game" + gameNum + "error2").css("display", "none");
            $("#game" + gameNum + "error3").css("display", "none");
            
            validInput = false;
         }
         // Max score must be at least 15
         else if(player < 15 && opponent < 15)
         {
            $("#game" + gameNum + "player").css("border", "1px solid #ff4b4b");
            $("#game" + gameNum + "opponent").css("border", "1px solid #ff4b4b");
            $("#game" + gameNum + "error1").css("display", "none");
            $("#game" + gameNum + "error2").css("display", "inline");
            $("#game" + gameNum + "error3").css("display", "none");
         }
         // Must win by 2
         else if((player > 15 || opponent > 15) &&
            (Math.abs(player - opponent) < 2))
         {
            $("#game" + gameNum + "player").css("border", "1px solid #ff4b4b");
            $("#game" + gameNum + "opponent").css("border", "1px solid #ff4b4b");
            $("#game" + gameNum + "error1").css("display", "none");
            $("#game" + gameNum + "error2").css("display", "none");
            $("#game" + gameNum + "error3").css("display", "inline");
         }
         
         else
         {
            $("#game" + gameNum + "player").css("border", "1px solid #0b0b0b");
            $("#game" + gameNum + "opponent").css("border", "1px solid #0b0b0b");
            $("#game" + gameNum + "error1").css("display", "none");
            $("#game" + gameNum + "error2").css("display", "none");
            $("#game" + gameNum + "error3").css("display", "none");
         }
      }
      
      else
      {
         $("#game" + gameNum + "player").css("border", "1px solid #0b0b0b");
         $("#game" + gameNum + "opponent").css("border", "1px solid #0b0b0b");
         $("#game" + gameNum + "error1").css("display", "none");
         $("#game" + gameNum + "error2").css("display", "none");
         $("#game" + gameNum + "error3").css("display", "none");
      }
      
      validInput = false;
   }
   
   return validInput;
 }