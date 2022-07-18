/*
|------------------------------------------------------------------------------------
| Validate auth templates
|------------------------------------------------------------------------------------
*/
//To validate admin form
function validate() {
  var strUsername = document.getElementById("email").value;
  document.getElementById("email").value = strUsername.trim();
}