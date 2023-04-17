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

if( !isset( $_POST['newstatus'] ) || !preg_match( '/^\d+$/', $_POST['newstatus'] ))
{
  header( 'Location: index.php' );
  exit();
}

if( !isset( $_POST['professor'] ) || !preg_match( '/^\d+$/', $_POST['professor'] ))
{
  header( 'Location: index.php' );
  exit();
}

include('db.php');
$db = get_connection();
$st = $db->prepare( 'update professor set status = :status where id = :id' );
$st->bindParam( ':id', $_POST['professor'] );
$st->bindParam( ':status', $_POST['newstatus'] );
$st->execute();
include('faculty_top.php');
?>
  <div id="main_div">
  <p id="announcement">Faculty Status Updated!</p>
  </div> <!-- main_div -->
<?php include("bottom.php"); ?>
