<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['username'] ) || !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] )
{
  header( 'Location: index.php' );
  exit();
}

$sid = $_SESSION['id'];
$username = $_SESSION['username'];
$error = false;
$errmsg = '';
if( !isset( $_POST['supervisor'] ))
{
  $error = true;
  $errmsg = 'Missing supervisor';
}
else
{
  $supervisor = $_POST['supervisor'];
}

if( !isset( $_POST['title'] ))
{
  $error = true;
  $errmsg = 'Missing Title';
}
else
{
  $title = $_POST['title'];
}

if( !isset( $_POST['type'] ) || $_POST['type'] == 0 )
{
  $error = true;
  $errmsg = 'Missing Type';
}
else
{
  $type = $_POST['type'];
}

if( !isset( $_POST['description'] ))
{
  $error = true;
  $errmsg = 'Missing Description';
}
else
{
  $description = $_POST['description'];
}

$other = isset( $_POST['other'] ) ? $_POST['other'] : '';
$company = isset( $_POST['company'] ) ? $_POST['company'] : '';

if( ($type == 1 || $type == 2) && $company == '' )
{
  $error = true;
  $errmsg = 'Type-Company Mismatch';
}

$state = isset( $_POST['state'] ) ? $_POST['state'] : 0;
$city = isset( $_POST['city'] ) ? htmlentities( $_POST['city'] ) : '';
$country = isset( $_POST['country'] ) ? htmlentities( $_POST['country'] ) : '';

$usa = isset( $_POST['usa_cb'] ) && $_POST['usa_cb'] == 'usa';

if( $usa && ( $city == '' || $state == 0 ))
{
  $error = true;
  $errmsg = 'Missing US City';
}

if( !$usa && $country == '' )
{
  $error = true;
  $errmsg = 'Missing Country';
}

include("db.php");
$db = get_connection();

$st = $db->prepare( 'select now() as curdate,
                     concat_ws(" ", first_name, last_name) as name, banner_id,
                     hours, grad_month, grad_year
                     from student where id = :sid' );
$st->bindParam( ':sid', $sid );
$st->execute();
$results = $st->fetchAll();
if( count( $results ) != 1 )
{
  $error = true;
  $errmsg = 'Missing Student ID';
}

if( $error )
{
  header('Location: student_error_page.php');
  exit();
}

$curdate = $results[0]['curdate'];
$name = $results[0]['name'];
$banner_id = $results[0]['banner_id'];
$hours = $results[0]['hours'];
$grad_date = $results[0]['grad_month'] . ' ' . $results[0]['grad_year'];

$st = $db->prepare( 'select description from proptype where id = :type' );
$st->bindParam( ':type', $type );
$st->execute();
$type_description = $st->fetchAll()[0]['description'];

$fields = 'title, supervisor, date_created, student_id, description, status, proptype';
$values = ':title, :supervisor, now(), :sid, :description, 2, :type';

if( $company != '' )
{
  $fields .= ', company';
  $values .= ', :company';
}

if( $other != '' )
{
  $fields .= ', other';
  $values .= ', :other';
}

if( $usa )
{
  $fields .= ', city, state';
  $values .= ', :city, :state';
}
else
{
  $fields .= ', country';
  $values .= ', :country';
}

$st = $db->prepare( 'insert into proposal (' . $fields . ') values (' . $values . ')' );
$st->bindParam( ':title', $title );
$st->bindParam( ':supervisor', $supervisor );
$st->bindParam( ':sid', $sid );
$st->bindParam( ':description', $description );
$st->bindParam( ':type', $type );
if( $company != '' )
{
  $st->bindParam( ':company', $company );
}

if( $other != '' )
{
  $st->bindParam( ':other', $other );
}

if( $usa )
{
  $st->bindParam( ':city', $city );
  $st->bindParam( ':state', $state );
}
else
{
  $st->bindParam( ':country', $country );
}

$st->execute();
header('Location: student_home.php');
?>
