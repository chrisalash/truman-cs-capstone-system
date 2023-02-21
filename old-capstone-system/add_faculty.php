<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['first_name'] ) ||
    !isset( $_SESSION['last_name'] ) ||
    !isset( $_SESSION['status'] ) ||
    !isset( $_SESSION['id'] ))
{
  header( 'Location: index.php' );
  exit();
}
include('faculty_top.php');
include('db.php');
$db = get_connection();

//Form allowing a new faculty member to be entered into the professor table
?>
    <script> document.title = "Add Faculty Member"; </script>
    <p id="head2text" class="left103">Add New <br />Faculty Member</p>

      <script type="text/javascript" src="faculty_validate.js"></script>
    <form name="add_fac_form" action="add_faculty_submit.php"
          method="post" onsubmit="return validate()">
      <p><label for="username">Username: </label>
      <input type="text" size="10" id="username" name="username" /></p>
      <p id="user_err_message" class="error"></p>
      <p><label for="first_name">First Name: </label>
      <input type="text" size="15" id="first_name" name="first_name" /></p>
      <p id="first_err_message" class="error"></p>
      <p><label for="last_name">Last Name: </label>
      <input type="text" size="20" id="last_name" name="last_name" /></p>
      <p id="last_err_message" class="error"></p>
      <p><input name="submit" type="submit" value="Submit"/></p>
    </form>

<?php include("bottom.php"); ?>
