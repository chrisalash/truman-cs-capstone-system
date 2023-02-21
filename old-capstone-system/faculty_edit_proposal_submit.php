<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['is_faculty'] ) ||
    $_SESSION['is_faculty'] == false ||
    !isset( $_SESSION['pid'] ))
{
  header( 'Location: index.php' );
  exit();
}
$pid = $_SESSION['pid'];
unset( $_SESSION['pid'] );

//Updates proposal with edited information

include('db.php');
$db = get_connection();
$st = $db->prepare( 'select title, supervisor, company, description, status, proptype, other,
                     professor1_id, professor2_id, professor3_id, city, state, country
                     from proposal
                     where id = :pid');
$st->bindParam( ':pid', $pid );
$st->execute();
$results = $st->fetchAll();
if( count( $results ) > 1 || count( $results ) == 0 )
{
  header( 'Location: faculty_error_page.php' );
  exit();
}
$otitle = $results[0]['title'];
$osupervisor = $results[0]['supervisor'];
$ocompany = $results[0]['company'];
$odescription = $results[0]['description'];
$ostatus = $results[0]['status'];
$oproptype = $results[0]['proptype'];
$oother = $results[0]['other'];
$oprofessor1_id = $results[0]['professor1_id'];
$oprofessor2_id = $results[0]['professor2_id'];
$oprofessor3_id = $results[0]['professor3_id'];
$ocity = isset( $results[0]['city'] ) ? htmlentities( $results[0]['city'] ) : '';
$ostate = isset( $results[0]['state'] ) ? $results[0]['state'] : '0';
$ocountry = isset( $results[0]['country'] ) ? htmlentities( $results[0]['country'] ) : '';

$error = false;

if( !isset( $_POST['supervisor'] ))
{
  $error = true;
}
else
{
  $supervisor = $_POST['supervisor'];
}

$status = isset( $_POST['status'] ) ? $_POST['status'] : $ostatus;
$title = isset( $_POST['title'] ) ? $_POST['title'] : $otitle;
$proptype = isset( $_POST['type'] ) ? $_POST['type'] : $oproptype;
$description = isset( $_POST['description'] ) ? $_POST['description'] : $odescription;
$other = isset( $_POST['other'] ) ? $_POST['other'] : $oother;
$company = isset( $_POST['company'] ) ? $_POST['company'] : $ocompany;
$note_text = isset( $_POST['note_text'] ) ? $_POST['note_text'] : '';
$professor1 = isset( $_POST['professor1'] ) ? $_POST['professor1'] : $oprofessor1_id;
$professor2 = isset( $_POST['professor2'] ) ? $_POST['professor2'] : $oprofessor2_id;
$professor3 = isset( $_POST['professor3'] ) ? $_POST['professor3'] : $oprofessor3_id;
$city = isset( $_POST['city'] ) ? htmlentities( $_POST['city'] ) : $ocity;
$state = isset( $_POST['state'] ) ? $_POST['state'] : $ostate;
$country = isset( $_POST['country'] ) ? htmlentities( $_POST['country'] ) : $ocountry;

$usa = isset( $_POST['usa_cb'] ) && $_POST['usa_cb'] == 'usa';

if( $usa && ( $city == '' || $state == 0 ))
{
  $error = true;
}

if( ($proptype == 1 || $proptype == 2) && ( !isset( $company ) || $company == '' ))
{
  $error = true;
}

if( $proptype == 6 && ( !isset($other) || $other == '' ))
{
  $error = true;
}

$name_regex = '/^[A-Za-z][a-zA-Z\-\'\.\s]+$/';

if( !preg_match( $name_regex, $supervisor ))
{
  $error = true;
}

if( !preg_match( $name_regex, $city ))
{
  $error = true;
}

if( !preg_match( $name_regex, $country ))
{
  $error = true;
}

if( !preg_match( $name_regex, $title ))
{
  $error = true;
}

if( ($status == '1' || $status == '3') &&
    ($professor1 == '0' || $professor2 == '0' || $professor3 == '0'))
{
  $error = true;
}

if( $error )
{
  header("Location: faculty_error_page.php");
}

$updated = false;
if( $ostatus == 2 && $oproptype != $proptype )
{
  $db->exec( "update proposal set proptype = $proptype where id = $pid" );
  $updated = true;
}

//FIXME: when everything is stable, restore the following line
//if( $ostatus == 2 && $ocompany != $company )
if( $ocompany != $company )
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

//if( $ostatus == 2 && $otitle != $title )
if( $otitle != $title )
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

// FIXME: should restore this line in production
//if( $ostatus == 2 && $odescription != $description )
if( $odescription != $description )
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

if( $oprofessor1_id != $professor1 )
{
  $db->exec( "update proposal set professor1_id = $professor1 where id = $pid" );
  $updated = true;
}

if( $oprofessor2_id != $professor2 )
{
  $db->exec( "update proposal set professor2_id = $professor2 where id = $pid" );
  $updated = true;
}

if( $oprofessor3_id != $professor3 )
{
  $db->exec( "update proposal set professor3_id = $professor3 where id = $pid" );
  $updated = true;
}

if( $ostatus == 2 && $status == 3 )
{
  $db->exec( "update proposal set date_preapproved = now(), status = 3 where id = $pid" );
}

if( $ostatus == 3 && $status == 1 )
{
  $db->exec( "update proposal set date_completed = now(), status = 1 where id = $pid" );
}

if( $ostatus != 1 && $status == 4 )
{
    $db->exec( "update proposal set status = 4 where id = $pid" );
}

/*
$message = $message . "<li>Capstone description was changed from:<br /><br />\""
  . nl2br(htmlspecialchars($row['description'])) . "\"<br /><br /> to:<br /><br />\""
  . nl2br(htmlspecialchars($field['value'])) . "\"<br /><br /></li>";
    foreach(get_professors() as $professor)
    {
      if($professor['id'] == $professor1_id || $professor['id'] == $professor2_id ||
     $professor['id'] == $professor3_id)
      {
    if($professor['status'] == 'Active')
    {
      $to = $to . $professor['username'] . "@truman.edu, ";
    }
      }
    }

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

header( 'Location: faculty_edit_proposal.php?pid=' . $pid );
?>
