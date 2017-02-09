function signup(){
  var username = document.signform.username.value;
  var ck_username = /^[A-Za-z0-9_]{6,20}$/;
  var email = document.signform.email.value;
  var pnumber = document.signform.pnumber.value;
  var accnumber = document.signform.accnumber.value;
  var accname = document.signform.accname.value;
  var bank = document.signform.bank.value;
  var password = document.signform.password.value;
  var rpassword = document.signform.rpassword.value;

  if ((username == null || username == "") || (email == null || email == "") || (pnumber == null || pnumber == "")){
    alert("please fill in all fields, as all fields are required.");
    return false;
  }
  if ((accnumber == null || accnumber == "") || (accname == null || accname == "") || (password == null || password == "")){
    alert("please fill in all fields, as all fields are required.");
    return false;
  }
  if ((rpassword == null || rpassword == "") || (bank == null || bank == "")){
    alert("please fill in all fields, as all fields are required.");
    return false;
  }
  if (!ck_username.test(username)) {
    alert("username can contain alphabets and numbers no special characters except underscore('_') min 6 and max 20 characters. ")
    return false;
  }
  var atposition = email.indexOf("@");
  var dotposition = email.lastIndexOf(".");
  if (atposition < 1 || dotposition < atposition + 2 || dotposition + 2 >= email.length){
    alert("Please enter a valid e-mail address");
    return false;
  }
  if (isNaN(pnumber) || (pnumber.length > 11 || pnumber.length < 11)){
    alert("please enter a valid 11 digit phone number, i.e 080-00-00-0000");
    return false;
  }
  if (isNaN(accnumber)){
    alert("please enter a valid account number");
    return false;
  }
  if(password.length < 6){
    alert("Password must be at least 6 characters long.");
    return false;
  }
  if(password != rpassword){
    alert("password must be same!");
    return false;
  }
 //  if (bank == null || bank == ""){
 //   alert("nothing was selected");
 //   return false;
 // }
 // else {
 //   alert(bank + " was selected");
 // }
}

function login(){
  var username = document.logform.username.value;
  var ck_username = /^[A-Za-z0-9_]{6,20}$/;
  var password = document.logform.password.value;
  if (username == null || username == ""){
    alert("Username field cannot be empty");
    return false;
  }
  if (!ck_username.test(username)) {
    alert("please enter a valid username, username must be atleast 6 characters long")
    return false;
  }
  if (password == null || password == ""){
    alert("Password field cannot be empty");
    return false;
  }
}
