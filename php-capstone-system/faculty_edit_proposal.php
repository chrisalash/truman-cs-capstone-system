<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == false )
{
  header( 'Location: index.php' );
  exit();
}

if( !isset( $_GET['pid'] ) && !preg_match( '/^\d+$/', $_GET['pid'] ))
{
  header( 'Location: faculty_home.php' );
  exit();
}
$_SESSION['pid'] = $_GET['pid'];
include('db.php');

//Faculty members can edit the proposal of a student except when it is completed. Only
//faculty members have the ability to add Professors 1-3, to change the status to
//Pre-approved or Completed, and to edit the proposal during the "Pre-approved" stage.
//The student who wrote the proposal as well as Professors 1-3 will receive an email
//describing the edits made to the proposal
$db = get_connection();

$states = array( array('id' => 0, 'name' => 'Select State'));
$st = $db->prepare( 'select id, name from _state' );
$st->execute();
$states = array_merge( $states, $st->fetchAll(PDO::FETCH_ASSOC) );

$st = $db->prepare( 'select date_created, date_last_edited, date_preapproved, date_completed,
                            s.username, concat_ws(" ", s.first_name, s.last_name) as name, s.banner_id,
                            proptype, company, supervisor, title, hours, grad_month, grad_year,
                            p.description, status, other,
                            professor1_id, professor2_id, professor3_id,
                            city, state, country
                     from proposal as p
                     join student as s on s.id = student_id
                     where p.id = :pid');
$st->bindParam( ':pid', $_GET['pid'] );
$st->execute();
$proposal = $st->fetchAll();

if( count($proposal) != 1 )
{
  header( 'Location: faculty_error_page.php' );
  exit();
}

$date_created = $proposal[0]['date_created'];
$date_last_edited = $proposal[0]['date_last_edited'];
$date_preapproved = $proposal[0]['date_preapproved'];
$date_completed = $proposal[0]['date_completed'];
$username = $proposal[0]['username'];
$name = htmlentities($proposal[0]['name']);
$banner_id = $proposal[0]['banner_id'];
$proptype = $proposal[0]['proptype'];
$company = htmlentities($proposal[0]['company']);
$supervisor = htmlentities($proposal[0]['supervisor']);
$title = htmlentities($proposal[0]['title']);
$description = htmlentities($proposal[0]['description']);
$status = $proposal[0]['status'];
$other = $proposal[0]['other'];
$prof1_id = $proposal[0]['professor1_id'];
$prof2_id = $proposal[0]['professor2_id'];
$prof3_id = $proposal[0]['professor3_id'];
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

include('faculty_top.php');
?>
  <p id="head2text" class="left103">Edit Proposal</p>

    <form name="fac_prop_form" method="post" action="faculty_edit_proposal_submit.php" >
    <p class="results"><span class="bold">Username: </span><?= $username ?></p>
    <p class="results"><span class="bold">Name:</span> <?= $name ?></p>
    <p class="results"><span class="bold">Banner ID: </span><?= $banner_id ?></p>

    <p class="results"><span class="bold">Total Hours (including classes in progress): </span>
    <?= $hours ?>
    </p>

    <p id="hours_err_message" class="error"></p>

    <p class="results"><span class="bold">Expected Graduation Date: </span>
    <?= $grad_month ?> <?= $grad_year == 0 ? 1990 : $grad_year ?>
    </p>

  <p class="results"><span class="bold">Creation Date: </span>
  <?= $date_created ?></p>

  <p class="results"><span class="bold">Pre-Approval Date: </span>
  <?= $date_preapproved ?></p>

  <p class="results"><span class="bold">Completion Date: </span>
  <?= $date_completed ?></p>

  <p class="results"><span class="bold">Last Updated: </span>
  <?= $date_last_edited ?></p>

    <p class="results"><span class="bold">Capstone Type: </span>
    <select name="type" id="type">
<?php
  $st = $db->prepare( 'select id, description from proptype' );
$st->execute();
$types = $st->fetchAll();
foreach( $types as $row ): ?>
  <option value="<?= $row['id'] ?>" <?= $row['id'] == $proptype ? 'selected="selected"' : '';?>><?= $row['description'] ?></option>
<?php endforeach; ?>
  </select></p>

  <div id="other_div">
  <p class="results"><label for="other">Description for &lsquo;Other&rsquo;: </label>
     <input type="text" id="other" name="other" size="30" value="<?= $other ?>" pattern="[A-Za-z .'-]+" /></p>
  </div>

  <div id="org_div">
        <p><label for="company">Company or Organization: </label>
        <input type="text" id="company" name="company" size="30" value="<?= $company ?>" pattern="[A-Za-z .'-]+" /></p>
  </div>

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
  <input type="text" name="country" id="country" pattern="[A-Za-z .-]+" size="25" value="<?= $country ?>" />
  </p>
  </div>

    <p class="results"><label for="supervisor">Experience Supervisor: </label>
    <input type="text" id="supervisor" name="supervisor" value="<?= $supervisor ?>" required="required" pattern="[A-Za-z .'-]+" /></p>

    <p class="results"><label for="title">Capstone Title: </label>
    <input type="text" id="title" name="title" size="40" value="<?= $title ?>" required="required" pattern="[A-Za-z .'-]+" /></p>

    <p class="results"><label for="description">Experience Description: </label></p>

    <p class="results"><textarea wrap="soft" rows="15" cols="80" id="description" name="description"
          required="required" ><?= htmlentities($description) ?></textarea></p>

<?php
  $note_num = 1;
    foreach($notes as $note)
    { ?>
      <hr>Note <?= $note_num ?> added by <?= $note['name'] ?> on <?= $note['date'] ?><br /><br />
        <?= nl2br(htmlentities($note['note'])) ?> <br />
        <hr>
      <?php
      $note_num++;
    } ?>

<div id="add_note_div">
<p class="results"><label for="note_text">New Note</label><br />
<textarea id="note_text" name="note_text" rows="15" cols="80"></textarea></p>
<p><button type="button" id="add_note_cancel">Cancel Note</button></p>
</div> <!-- add_note_div -->

<p><button id="add_note_button" type="button">Add New Note</button></p>

    <p class="results"><label for="status">Status: </label>
    <select name="status" id="status">
      <option value="2" <?= $status == 2 ? 'selected="selected"' : '' ?><?= $status == 3 || $status == 1 ? 'disabled="disabled"' : '' ?>>Awaiting Pre-approval</option>
      <option value="3" <?= $status == 3 ? 'selected="selected"' : '' ?><?= $status == 1 ? 'disabled="disabled"' : '' ?>>Pre-approved</option>
      <option value="1" <?= $status == 2 ? 'disabled="disabled"' : '' ?>>Completed</option>
      <option value="4" <?= $status == 4 ? 'selected="selected"' : '' ?>>Inactivated</option>
    </select></p>

<?php
// FIXME: hard-coded reference to status 1: active
$st = $db->prepare( 'select concat_ws(" ", first_name, last_name) as name, id, status
                     from professor
                     order by status, last_name, first_name' );
$st->execute();
$profs = $st->fetchAll();
?>
    <p class="results"><label for="professor1">Professor 1: </label>
  <select name="professor1" id="professor1" <?= $status != 3 ? 'disabled="disabled"' : '' ?>>
      <option value="0">Select</option>
      <?php
      foreach($profs as $prof): ?>
         <option value="<?= $prof['id'] ?>" <?= $prof['id'] == $prof1_id ? 'selected="selected"': '';?> <?= $prof['status'] == 2 ? 'disabled="disabled"' : '' ?> >
        <?= $prof['name'] ?> </option>
      <?php endforeach; ?>
    </select></p>

    <p class="results"><label for="professor2">Professor 2: </label>
    <select name="professor2" id="professor2" <?= $status != 3 ? 'disabled="disabled"' : '' ?>>
      <option value="0">Select</option>
      <?php
      foreach($profs as $prof): ?>
        <option value="<?= $prof['id'] ?>" <?= $prof['id'] == $prof2_id ? 'selected="selected"': '';?> <?= $prof['status'] == 2 ? 'disabled="disabled"' : '' ?> >
        <?= $prof['name'] ?> </option>
      <?php endforeach; ?>
    </select></p>

    <p class="results"><label for="professor3">Professor 3: </label>
    <select name="professor3" id="professor3" <?= $status != 3 ? 'disabled="disabled"' : '' ?>>
      <option value="0">Select</option>
      <?php
      foreach($profs as $prof): ?>
        <option value="<?= $prof['id'] ?>" <?= $prof['id'] == $prof3_id ? 'selected="selected"': '';?> <?= $prof['status'] == 2 ? 'disabled="disabled"' : '' ?> >
        <?= $prof['name'] ?> </option>
      <?php endforeach; ?>
    </select></p>

    <button id="submit" name="submit" type="submit">Submit</button>
    </form>
    <script src="faculty_edit_proposal.js"></script>

<?php include("bottom.php"); ?>
