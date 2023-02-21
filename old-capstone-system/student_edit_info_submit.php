<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();

//Updates student personal information

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$banner_id = $_POST['banner_id'];
$hours = $_POST['hours'];
$grad_month = $_POST['grad_month'];
$grad_year = $_POST['grad_year'];

$name_regex = '/^[A-Za-z][a-zA-Z\-\'\.\s]+$/';

$error = false;
if( !isset($_SESSION['id'] ))
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
else if( !preg_match( '/^0\d{8}$/', $banner_id ))
{
  $error = true;
}
else if( !preg_match( '/^\d{2,3}$/', $hours ))
{
  $error = true;
}
else if( !( $grad_month == 'May' || $grad_month == 'December' || $grad_month == 'August' ))
{
  $error = true;
}
else if( !preg_match( '/^2\d{3}$/', $grad_year ))
{
  $error = true;
}

if($error)
{
  header("Location: student_error_page.php");
  exit();
}

include('db.php');

$db = get_connection();
$st = $db->prepare( 'update student
                     set last_name = :last_name,
                     first_name = :first_name,
                     banner_id = :banner_id,
                     hours = :hours,
                     grad_month = :grad_month,
                     grad_year = :grad_year
                     where id = :id' );
$st->bindParam( ':last_name', $last_name );
$st->bindParam( ':first_name', $first_name );
$st->bindParam( ':banner_id', $banner_id );
$st->bindParam( ':hours', $hours );
$st->bindParam( ':grad_month', $grad_month );
$st->bindParam( ':grad_year', $grad_year );
$st->bindParam( ':id', $_SESSION['id'] );
$st->execute();

$_SESSION['last_name'] = $last_name;
$_SESSION['first_name'] = $first_name;

header( 'Location: student_edit_info.php?ok=y' );
?>
