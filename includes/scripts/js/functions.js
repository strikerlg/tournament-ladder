/**
 * Animates the header login panel, making it visible. And registers
 * an event to hide it again.
 */
function animateLogin()
{
   // Change the login container to visible, and slide the panel into view.
   $("#headerBarLogin").css("visibility", "visible");
   $("#headerLogin").animate(
     {top: "+=105px", 
      right: "-=82px"}, 
      150
   );
   
   // Register a click event for the document. This determines if the click was
   // outside the login panel, hiding the panel if it is.
   $(document).click(function(e){
      // Set the containe to hide to a variable.
      var loginContainer = $("#headerBarLogin");
      
      // If the element clicked is not the element to hide, any of its
      // children, the button that shows it, and if the element to hide
      // is actually visible, hide the element by sliding out of view.
      if(!loginContainer.is(e.target) && 
         loginContainer.has(e.target).length === 0 &&
         e.target.id != "headerLogButton"
         && loginContainer.css("visibility") == "visible")
      {
         $("#headerLogin").stop().animate(
           {top: "-=105px",
            right: "+=82px"},
            300
         );
         loginContainer.css("visibility", "hidden");
      }
      
      // Prevent the click event from stacking up in the DOM.
      e.stopImmediatePropagation();
   });
}


/**
 * Makes sure the user really wants to leave the ladder, then submits the
 * form.
 */
 function leaveLadderVerification()
 {
   var leave = confirm("Are you sure you want to leave the ladder?");
   
   if(leave)
   {
      $("#leaveForm").submit();
   }
 }
 
 function loginFieldFocus(field)
 {
   if(field.id == "headerUser" && field.value == "username" ||
      field.id == "headerPass" && field.value == "password")
   {
      field.value = "";
      field.style.color = "#ffffff";
   }
 }
 function loginFieldBlur(field)
 {
   if(field.value == "")
   {
      field.style.color = "#787878";
   
      if(field.id == "headerUser")
      {
         field.value = "username";
      }
      else if(field.id == "headerPass")
      {
         field.value = "password";
      }
   }
 }