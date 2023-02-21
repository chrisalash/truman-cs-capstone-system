<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['first_name'] ) ||
    !isset( $_SESSION['last_name'] ) ||
    !isset( $_SESSION['id'] ))
{
  header( 'Location: index.php' );
  exit();
}
include('faculty_top.php');
include('db.php');
$db = get_connection();
//Allows faculty member to change their personal information (first and last name, status)
?>

  <script> document.title="Edit Personal Info"; </script>

  <p id="head2text" class="left100">Edit Personal Info</p>

    <script type="text/javascript" src="faculty_validate.js"></script>
    <form name="fac_edit_form" action="faculty_edit_info_submit.php"
        method="post" onsubmit="return validate()">
    	<p><label for="first_name">First Name: </label>
    	<input type="text" size="15" id="first_name" name="first_name"
           value="<?= htmlspecialchars($_SESSION['first_name']) ?>" /></p>
    	<p id="first_err_message" class="error"></p>
    	<p><label for="last_name">Last Name: </label>
    	<input type="text" size="20" id="last_name" name="last_name"
           value="<?= htmlspecialchars($_SESSION['last_name']) ?>"/></p>
    	<p id="last_err_message" class="error"></p>
    	<button type="submit">Submit</button>
    </form>

<?php include("bottom.php"); ?>
