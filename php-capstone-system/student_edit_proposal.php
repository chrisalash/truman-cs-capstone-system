<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == true )
{
  header( 'Location: index.php' );
  exit();
}

if( !isset( $_GET['pid'] ) && !preg_match( '/^\d+$/', $_GET['pid'] ))
{
  header( 'Location: index.php' );
  exit();
}
$_SESSION['pid'] = $_GET['pid'];
include('db.php');

$db = get_connection();

// make sure this student owns this proposal
if( !$_SESSION['is_faculty'] )
{
  $st = $db->prepare( 'select count(*) as cnt from proposal where id = :pid and student_id = :sid');
  $st->bindParam( ':pid', $_GET['pid'] );
  $st->bindParam( ':sid', $_SESSION['id'] );
  $st->execute();
  if( $st->fetchAll(PDO::FETCH_ASSOC)[0]['cnt'] != 1 )
  {
    header( 'Location: student_home.php' );
    exit();
  }
}

$states = array( array('id' => 0, 'name' => 'Select State'));
$st = $db->prepare( 'select id, name from _state' );
$st->execute();
$states = array_merge( $states, $st->fetchAll(PDO::FETCH_ASSOC) );

$st = $db->prepare( 'select date_created, date_last_edited, date_preapproved, date_completed,
                            s.username, concat_ws(" ", s.first_name, s.last_name) as name,
                            s.banner_id, pt.description as typedesc,
                            proptype, company, supervisor, title, hours, grad_month, grad_year,
                            p.description, p.status, ps.description as statusdesc, other,
                            concat_ws(" ", p1.first_name, p1.last_name) as p1name,
                            concat_ws(" ", p2.first_name, p2.last_name) as p2name,
                            concat_ws(" ", p3.first_name, p3.last_name) as p3name,
                            city, state, country
                     from proposal as p
                     join student as s on s.id = student_id
                     join propstatus as ps on ps.id = p.status
                     join proptype as pt on pt.id = p.proptype
                     left join professor as p1 on p1.id = professor1_id
                     left join professor as p2 on p2.id = professor2_id
                     left join professor as p3 on p3.id = professor3_id
                     where p.id = :pid');
$st->bindParam( ':pid', $_GET['pid'] );
$st->execute();
$proposal = $st->fetchAll();

if( count($proposal) != 1 )
{
  header( 'Location: student_error_page.php' );
  exit();
}

$date_created = $proposal[0]['date_created'];
$date_last_edited = $proposal[0]['date_last_edited'];
$date_preapproved = $proposal[0]['date_preapproved'];
$date_completed = $proposal[0]['date_completed'];
$username = $proposal[0]['username'];
$name = htmlentities($proposal[0]['name']);
$banner_id = $proposal[0]['banner_id'];
$typedesc = $proposal[0]['typedesc'];
$proptype = $proposal[0]['proptype'];
$company = htmlentities($proposal[0]['company']);
$supervisor = htmlentities($proposal[0]['supervisor']);
$title = htmlentities($proposal[0]['title']);
$description = htmlentities($proposal[0]['description']);
$status = $proposal[0]['status'];
$statusdesc = $proposal[0]['statusdesc'];
$other = $proposal[0]['other'];
$p1name = $proposal[0]['p1name'];
$p2name = $proposal[0]['p2name'];
$p3name = $proposal[0]['p3name'];
$hours = $proposal[0]['hours'];
$grad_month = $proposal[0]['grad_month'];
$grad_year = $proposal[0]['grad_year'];
$city = isset( $proposal[0]['city'] ) ? htmlentities( $proposal[0]['city'] ) : '';
$state = isset( $proposal[0]['state'] ) ? $proposal[0]['state'] : '0';
$country = isset( $proposal[0]['country'] ) ? htmlentities( $proposal[0]['country'] ) : '';

$usa = $country == '';

$state_selected = $state;
if( $state == 0 && $city == '' && $country == '' ) // nothing is selected
{
  $state_selected = 29; // default to Mo
}

// FIXME: the following query only works if the id space of faculty is completely disjoint
// from that of students
$st = $db->prepare( 'select pn.date, note, concat_ws(" ", first_name, last_name) as name
                     from proposal_notes as pn
                     join professor as p on pn.author_id = p.id
                     where proposal_id = :pid1
                     union
                     select pn.date, note, concat_ws(" ", first_name, last_name) as name
                     from proposal_notes as pn
                     join student as s on pn.author_id = s.id
                     where proposal_id = :pid2
                     order by date' );
$st->bindParam( ':pid1', $_GET['pid'] );
$st->bindParam( ':pid2', $_GET['pid'] );
$st->execute();
$notes = $st->fetchAll();

include('student_top.php');
?>

  <p id="head2text" class="left103">Edit Proposal</p>

    <form name="fac_prop_form" method="post" action="student_edit_proposal_submit.php" >
    <p id="results"><span class="bold">Username: </span><?= $username ?></p>
    <p id="results"><span class="bold">Name:</span> <?= $name ?></p>
    <p id="results"><span class="bold">Banner ID: </span><?= $banner_id ?></p>

    <p id="results"><span class="bold">Cumulative Hours (including classes in progress): </span>
    <?= $hours ?>
    </p>

    <p id="results"><span class="bold">Expected Graduation Date: </span>
    <?= $grad_month ?> <?= $grad_year == 0 ? 1990 : $grad_year ?>
    </p>

  <p id="results"><span class="bold">Creation Date: </span>
  <?= $date_created ?></p>

  <p id="results"><span class="bold">Pre-Approval Date: </span>
  <?= $date_preapproved ?></p>

  <p id="results"><span class="bold">Completion Date: </span>
  <?= $date_completed ?></p>

  <p id="results"><span class="bold">Last Updated: </span>
  <?= $date_last_edited ?></p>

  <p id="results"><span class="bold">Capstone Type: </span>

<?php if( $status == 2) : ?>
  <select name="type" id="type">
  <?php
  $st = $db->prepare( 'select id, description from proptype' );
  $st->execute();
  $types = $st->fetchAll();
  foreach( $types as $row ): ?>
    <option value="<?= $row['id'] ?>" <?= $row['id'] == $proptype ? 'selected="selected"' : '';?>><?= $row['description'] ?></option>
  <?php endforeach; ?>
  </select>
<?php else: ?>
  <span id="type"><?= $typedesc ?></span>
<?php endif; ?>
</p>

<?php if( $status == 2 ) : ?>
  <div id="other_div">
    <p id="results"><span class="bold">Description for &ldquo;Other&rdquo;: </span>
       <input type="text" id="other" name="other" size="30" value="<?= $other ?>"
              pattern="[A-Za-z .'-]+" />
  </div>

  <div id="org_div">
    <p id="results"><span class="bold">Company or Organization: </span>
      <input type="text" id="company" name="company" size="30"
             value="<?= $company ?>" pattern="[A-Za-z .'-]+" />
  </div>
<?php else: ?>
  <?php if( $proptype == 6 ): ?>
    <p id="results"><span class="bold">Description for &ldquo;Other&rdquo;: </span>
    <?= $other ?></p>
  <?php elseif( $proptype == 1 || $proptype == 2 ) :?>
    <p id="results"><span class="bold">Company or Organization: </span><?= $company ?></p>
  <?php endif; ?>
<?php endif; ?>

  <p>Physical location of student during capstone experience</p>
  <p><label for="usa_cb">Inside US</label> <input type="checkbox" name="usa_cb" id="usa_cb" value="usa" <?= $usa ? 'checked' : '' ?> /><br />
  <label for="non_usa_cb">Outside US</label> <input type="checkbox" value="non_usa" name="non_usa_cb" id="non_usa_cb" <?= $usa ? '' : 'checked' ?> />
  </p>

  <div id="usa_div" <?= $usa ? 'style="display: block"' : 'style="display: none"' ?> >
    <p><label for="city">City: </label>
    <input name="city" id="city" type="text" pattern="[A-Za-z .'-]+" size="25" value="<?= $city ?>" />
    &nbsp;&nbsp;&nbsp;
    <label for="state">State: </label><select id="state" name="state">
    <?php foreach( $states as $row ): ?>
      <option value="<?= $row['id'] ?>" <?= $state_selected == $row['id'] ? 'selected' : '' ?> <?= $row['id'] == 0 ? 'disabled' : '' ?> ><?= $row['name'] ?></option>
    <?php endforeach; ?>
    </select>
    </p>
  </div>

  <div id="non_usa_div" <?= $usa ? 'style="display: none"' : 'style="display: block"' ?> >
  <p><label for="country">Country: </label>
  <input type="text" name="country" id="country" pattern="[A-Za-z -]+" size="25" value="<?= $country ?>" />
  </p>
  </div>

    <p id="results"><label for="supervisor">Experience Supervisor: </label>
    <input type="text" id="supervisor" name="supervisor" value="<?= $supervisor ?>" required="required" pattern="[A-Za-z .'-]+" /></p>

    <p id="results"><span class="bold">Capstone Title: </span>
    <?php if( $status == 2 ) : ?>
    <input type="text" id="title" name="title" size="40" value="<?= $title ?>" required="required" pattern="[A-Za-z .'-]+" />
    <?php else: ?>
    <?= $title ?>
    <?php endif; ?></p>

    <p id="results"><label for="description">Experience Description: </label></p>
    <p id="results">

    <textarea wrap="soft" rows="15" cols="80" id="description" name="description"
           required="required" <?= $status == 2 ? '' : 'disabled="disabled"' ?>><?= htmlentities($description) ?></textarea></p>

<?php
  $note_num = 1;
    foreach($notes as $note) :?>
      <hr>Note <?= $note_num ?> added by <?= $note['name'] ?> on <?= $note['date'] ?><br /><br />
      <?= nl2br(htmlentities($note['note'])) ?> <br />
        <hr>
      <?php
      $note_num++;
    endforeach; ?>

<div id="add_note_div">
<p id="results"><label for="note_text">New Note</label><br />

<textarea wrap="soft" id="note_text" name="note_text" rows="15" cols="70"></textarea></p>
<p><button type="button" id="add_note_cancel">Cancel Note</button></p>
</div>

<p><button id="add_note_button" type="button">Add New Note</button></p>

    <p id="results"><span class="bold">Status: </span><?= $statusdesc ?></p>

<?php if( $status != 2 ) : ?>
  <p id="results"><span class="bold">Professor 1: </span><?= $p1name ?></p>
  <p id="results"><span class="bold">Professor 2: </span><?= $p2name ?></p>
  <p id="results"><span class="bold">Professor 3: </span><?= $p3name ?></p>
<?php endif; ?>

    <p><button id="submit" name="submit" type="submit">Save Information</button></p>
<?php if( $status == 2 ): ?>
        <p><button id="print" name="print" type="button">Print Pre-Approval Form</button></p>
<?php endif; ?>
    </form>
    <script src="student_edit_proposal.js"></script>
<?php include("bottom.php"); ?>
