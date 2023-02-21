<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['username'] ))
{
  header( 'Location: index.php' );
  exit();
}
if( !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == true )
{
  header( 'Location: index.php' );
  exit();
}

//Receives form data from student_new and inserts it into the student table
$username = $_SESSION['username'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$banner_id = $_POST['banner_id'];
$hours = $_POST['hours'];
$grad_month = $_POST['grad_month'];
$grad_year = $_POST['grad_year'];
$error = false;

$name_regex = '/^[a-zA-Z\-\'\.\s]+$/';

if( !preg_match( '/^[a-z]+[0-9]+$/', $username))
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
else if( !preg_match( '/^\d{9}$/', $banner_id ))
{
	$error = true;
}
else if( !preg_match( '/^\d+$/', $hours ))
{
	$error = true;
}
else if( !preg_match( '/^[ADM][a-z]{2,7}$/', $grad_month ))
{
	$error = true;
}
else if( !preg_match( '/^\d{4}$/', $grad_year ))
{
	$error = true;
}

if($error)
{
  header('Location: index.php');
  exit();
}

include('db.php');
$db = get_connection();
$st = $db->prepare('insert into student
                    (username, first_name, last_name, banner_id, hours, grad_month, grad_year, last_login )
                     values
                    (:username, :first_name, :last_name, :banner_id, :hours, :grad_month, :grad_year, now())');
$st->bindParam(':username', $username);
$st->bindParam(':first_name', $first_name);
$st->bindParam(':last_name', $last_name);
$st->bindParam(':banner_id', $banner_id);
$st->bindParam(':hours', $hours);
$st->bindParam(':grad_month', $grad_month);
$st->bindParam(':grad_year', $grad_year);
$st->execute();

$id = $db->lastInsertId();
$_SESSION['id'] = $id;
header('Location: student_home.php' );
exit();
?>
