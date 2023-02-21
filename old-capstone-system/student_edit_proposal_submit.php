<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == true )
{
  header( 'Location: index.php' );
  exit();
}
$pid = $_SESSION['pid'];
unset( $_SESSION['pid'] );

//Updates proposal with edited information

$error = false;

include( 'db.php' );
$db = get_connection();
$st = $db->prepare( 'select title, supervisor, company, description, status, proptype, other,
                     city, state, country
                     from proposal
                     where id = :pid');
$st->bindParam( ':pid', $pid );
$st->execute();
$results = $st->fetchAll();
if( count( $results ) > 1 || count( $results ) == 0 )
{
  header( 'Location: index.php' );
  exit();
}
$otitle = $results[0]['title'];
$osupervisor = $results[0]['supervisor'];
$ocompany = $results[0]['company'];
$odescription = $results[0]['description'];
$ostatus = $results[0]['status'];
$oproptype = $results[0]['proptype'];
$oother = $results[0]['other'];
$ocity = isset( $results[0]['city'] ) ? htmlentities( $results[0]['city'] ) : '';
$ostate = isset( $results[0]['state'] ) ? $results[0]['state'] : '0';
$ocountry = isset( $results[0]['country'] ) ? htmlentities( $results[0]['country'] ) : '';

$usa = isset( $_POST['usa_cb'] ) && $_POST['usa_cb'] == 'usa';

if( !isset( $_POST['supervisor'] ))
{
  $error = true;
}
else
{
  $supervisor = $_POST['supervisor'];
}

$title = isset( $_POST['title'] ) ? $_POST['title'] : $otitle;
$proptype = isset( $_POST['type'] ) ? $_POST['type'] : $oproptype;
$description = isset( $_POST['description'] ) ? $_POST['description'] : $odescription;
$other = isset( $_POST['other'] ) ? $_POST['other'] : $oother;
$company = isset( $_POST['company'] ) ? $_POST['company'] : $ocompany;
$note_text = isset( $_POST['note_text'] ) ? $_POST['note_text'] : '';
$city = isset( $_POST['city'] ) ? htmlentities( $_POST['city'] ) : $ocity;
$state = isset( $_POST['state'] ) ? $_POST['state'] : $ostate;
$country = isset( $_POST['country'] ) ? htmlentities( $_POST['country'] ) : $ocountry;

if( ($proptype == 1 || $proptype == 2) && ( !isset( $company ) || $company == '' ))
{
  $error = true;
}

if( $proptype == 6 && ( !isset($other) || $other == '' ))
{
  $error = true;
}

if( $usa && ( $city == '' || $state == 0 ))
{
  $error = true;
}

if( !$usa && $country == '' )
{
  $error = true;
}

$name_regex = '/^[a-zA-Z\-\'\.\s]+$/';

if( !preg_match($name_regex, $supervisor))
{
  $error = true;
}

if( !preg_match( $name_regex, $title ))
{
  $error = true;
}

if( $error )
{
  header("Location: student_error_page.php");
}

$updated = false;
if( $ostatus == 2 && $oproptype != $proptype )
{
  $db->exec( "update proposal set proptype = $proptype where id = $pid" );
  $updated = true;
}

if( $ostatus == 2 && $ocompany != $company )
{
  $st = $db->prepare( 'update proposal set company = :company
                       where id = :pid' );
  $st->bindParam( ':company', $company );
  $st->bindParam( ':pid', $pid );
  $st->execute();
  $updated = true;
}

if( $osupervisor != $supervisor )
{
  $st = $db->prepare( 'update proposal set supervisor = :supervisor
                       where id = :pid' );
  $st->bindParam( ':supervisor', $supervisor );
  $st->bindParam( ':pid', $pid );
  $st->execute();
  $updated = true;
}

if( $ostatus == 2 && $otitle != $title )
{
  $st = $db->prepare( 'update proposal set title = :title
                       where id = :pid' );
  $st->bindParam( ':title', $title );
  $st->bindParam( ':pid', $pid );
  $st->execute();
  $updated = true;
}

if( ($ocity != $city || $ostate != $state ) && $usa )
{
  $st = $db->prepare( 'update proposal set city = :city, state = :state, country = ""
                       where id = :pid' );
  $st->bindParam( ':city', $city );
  $st->bindParam( ':state', $state );
  $st->bindParam( ':pid', $pid );
  $st->execute();
  $updated = true;
}
else if( $ocountry != $country && !$usa )
{
  $st = $db->prepare( 'update proposal set country = :country, city = "", state = 0
                       where id = :pid' );
  $st->bindParam( ':country', $country );
  $st->bindParam( ':pid', $pid );
  $st->execute();
  $updated = true;
}

if( $ostatus == 2 && $odescription != $description )
{
  $st = $db->prepare( 'update proposal set description = :description
                       where id = :pid' );
  $st->bindParam( ':description', $description );
  $st->bindParam( ':pid', $pid );
  $st->execute();
  $updated = true;
}

if( $ostatus == 2 && $oother != $other )
{
  $st = $db->prepare( 'update proposal set other = :other
                       where id = :pid' );
  $st->bindParam( ':other', $other );
  $st->bindParam( ':pid', $pid );
  $st->execute();
  $updated = true;
}

if( $note_text != '' )
{
  $st = $db->prepare( 'insert into proposal_notes (date, proposal_id, note, author_id)
                       values (now(), :pid, :note, :author_id)' );
  $st->bindParam( ':pid', $pid );
  $st->bindParam( ':note', $note_text );
  $st->bindParam( ':author_id', $_SESSION['id'] );
  $st->execute();
  $updated = true;
}

if( $updated )
{
  $db->exec( "update proposal set date_last_edited = now() where id = $pid" );
}

/*
    $to = $to . $username . "@truman.edu";

    //Displays the username of the professor who made the edits and on what date they were made
    $info = "Edited by " . $_SESSION['username'] . " on " .
        htmlspecialchars($date) . "<br /><br />";
    $message = $info . "<br />" . $message;

    //Send email

    $subject = "Edit Made to " . htmlspecialchars($name) . "'s Capstone Proposal";

    $message = "The following edits were made to " . htmlspecialchars($name) . "'s Capstone Proposal:<br /><br /><br />" .
        $message . "<br /><br />DO NOT REPLY TO THIS EMAIL<br />
        For questions, contact your advisor or the computer science department";

    $message = wordwrap($message, 140);

    $headers = 'From: CapstoneSystem' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    mail($to, $subject, $message, $headers);
*/

header( "Location: student_edit_proposal.php?pid=$pid" );
?>
