<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();

include('db.php');
//Updates posted personal information into the corresponding faculty
//member's row in the professors table

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];

  $name_regex = '/^[a-zA-Z\-\'\.\s]+$/';
  $status_regex = '/^\d$/';

  $error = false;
if( !isset($_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == false )
  {
    $error = true;
  }
  else if( !preg_match($name_regex, $first_name))
  {
    $error = true;
  }
  else if( !preg_match($name_regex, $last_name))
  {
    $error = true;
  }

  if($error)
  {
    header('Location: faculty_error_page.php');
  }
  else
  {
    $db = get_connection();
    $st = $db->prepare( 'update professor
                         set last_name = :last_name,
                             first_name = :first_name
                         where id = :id' );
    $st->bindParam( ':last_name', $last_name );
    $st->bindParam( ':first_name', $first_name );
    $st->bindParam( ':id', $_SESSION['id'] );
    $st->execute();

    $_SESSION['last_name'] = $last_name;
    $_SESSION['first_name'] = $first_name;
include('faculty_top.php');
?>
    <div id="main_div">
    <p id="announcement">Personal Info Updated!</p>
    </div> <!-- main_div -->
<?php
  }

include('bottom.php'); ?>
