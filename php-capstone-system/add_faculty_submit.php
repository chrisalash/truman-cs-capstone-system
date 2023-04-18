<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == false )
{
  header( 'Location: index.php' );
  exit();
}

//Receives form data from faculty_add_faculty and inserts it into the professors table

$username = $_POST['username'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$error = false;

$name_regex = '/^[a-zA-Z\-\'\.\s]+$/';

if( !preg_match( '/^[a-z][a-z0-9]*$/', $username))
{
  $error = true;
}
else if(!preg_match($name_regex, $first_name))
{
  $error = true;
}
else if(!preg_match($name_regex, $last_name))
{
  $error = true;
}

if($error)
{
  header('Location: faculty_error_page.php');
}
else
{
  include('faculty_top.php');
  include('db.php');
  $db = get_connection();
?>
<script> document.title = "Add Faculty Member-Submission"; </script>
<?php
  $st = $db->prepare('insert into professor (username, first_name, last_name, status)
                      values (:username, :first_name, :last_name, 1)');
  $st->bindParam(':username', $username);
  $st->bindParam(':first_name', $first_name);
  $st->bindParam(':last_name', $last_name);
  $st->execute();
?>
  <div id="main_div">
  <p id="announcement">Faculty Member Added!</p>
  </div> <!-- main_div -->
<?php
}
include('bottom.php'); ?>
