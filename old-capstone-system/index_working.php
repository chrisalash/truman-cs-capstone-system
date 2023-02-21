<?php
  error_reporting(E_ALL);
//  ini_set("display_errors", "1");

  //Page that forces user to login, then redirects the user to the
  //appropriate site, student or faculty

if( $_SERVER['HTTP_HOST'] == 'localhost' && 
    isset( $_GET['uname'] ) && 
    preg_match( '/^[a-z][A-Za-z0-9]+$/', $_GET['uname']))
{
  session_start();
  $username = $_GET['uname'];
}
else
{
  // Load the settings from the central config file
  require_once('config.php');

  // Load the CAS lib
  require_once($phpcas_path . '/CAS.php');

  // Enable debugging
  //phpCAS::setDebug();

  // Initialize phpCAS
  phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

  // For production use set the CA certificate that is the issuer of the cert
  // on the CAS server and uncomment the line below
  // phpCAS::setCasServerCACert($cas_server_ca_cert_path);
  // For quick testing you can disable SSL validation of the CAS server.
  // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
  // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
  phpCAS::setNoCasServerValidation();

  // force CAS authentication
  phpCAS::forceAuthentication();

  // at this step, the user has been authenticated by the CAS server
  // and the user's login name can be read with phpCAS::getUser().
  $username = phpCAS::getUser();
}

$_SESSION['username'] = $username;

// determine whether user is 1st-time student, returning student, or
// faculty
include('db.php');
$db = get_connection();
$st = $db->prepare( 'select id, first_name, last_name, status from professor
                     where username = :username' );
$st->bindParam( ':username', $username );
$st->execute();
$prof_results = $st->fetchAll();

if( count( $prof_results ) > 1 )
{
  exit();
}
else if( count( $prof_results ) == 1 )
{
  $_SESSION['first_name'] = $prof_results[0]['first_name'];
  $_SESSION['last_name'] = $prof_results[0]['last_name'];
  $_SESSION['status'] = $prof_results[0]['status'];
  $_SESSION['id'] = $prof_results[0]['id'];
  $_SESSION['is_faculty'] = true;
  header('Location: faculty_home.php');
  exit();
}
else
{
  $_SESSION['is_faculty'] = false;
  $st = $db->prepare( 'select id, first_name, last_name, datediff(now(), last_login) as daysago
                       from student
                       where username = :username' );
  $st->bindParam( ':username', $username );
  $st->execute();
  $stu_results = $st->fetchAll();

  if( count( $stu_results ) > 1 )
  {
    exit();
  }
  else if( count( $stu_results ) == 1 )
  {
    $_SESSION['first_name'] = $stu_results[0]['first_name'];
    $_SESSION['last_name'] = $stu_results[0]['last_name'];
    $_SESSION['id'] = $stu_results[0]['id'];
    $db->exec( 'update student set last_login = now() where id = ' . $_SESSION['id'] );
    if( !isset( $stu_results[0]['daysago'] ) || $stu_results[0]['daysago'] > 180 )
    {
      header('Location: student_edit_info.php?update=1' );
      exit();
    }
    else
    {
      header('Location: student_home.php');
      exit();
    }
  }
  else
  {
    header('Location: student_new.php');
    exit();
  }
}
?>
