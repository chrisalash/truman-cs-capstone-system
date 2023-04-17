<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['username'] ) || !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] )
{
  header( 'Location: index.php' );
  exit();
}

include('student_top.php');
include('db.php');
//Form for student to submit capstone proposals?>
<div id="create_prop">
    <p id="sub_header">Capstone Pre-Approval Form</p>

    <form name="app_form" action="student_create_proposal_submit.php" method="post" >

  <p><label for="type">Capstone Type: </label>
  <select name="type" id="type" required>
        <option disabled selected value>Select One</option>
<?php
$db = get_connection();
$states = array( array('id' => 0, 'name' => 'Select State'));
$st = $db->prepare( 'select id, name from _state' );
$st->execute();
$states = array_merge( $states, $st->fetchAll(PDO::FETCH_ASSOC) );

$st = $db->prepare( 'select id, description from proptype' );
$st->execute();
$types = $st->fetchAll();
foreach( $types as $row ): ?>
  <option value="<?= $row['id'] ?>" ><?= $row['description'] ?></option>
<?php endforeach; ?>
      </select>

  <div id="other_div">
  <p><label for="other">Description for &lsquo;Other&rsquo;: </label>
     <input type="text" id="other" name="other" size="30" pattern="[A-Za-z .'-]+" /></p>
  </div>

      <div id="org_div">
        <p><label for="company">Company or Organization: </label>
        <input type="text" id="company" name="company" size="30" pattern="[A-Za-z .'-]+" /></p>
      </div>

  <p>Physical location of student during capstone experience</p>
  <p><label for="usa_cb">Inside US</label> <input type="checkbox" name="usa_cb" id="usa_cb" value="usa" checked /><br />
  <label for="non_usa_cb">Outside US</label> <input type="checkbox" value="non_usa" name="non_usa_cb" id="non_usa_cb" />
  </p>

  <div id="usa_div"  >
    <p><label for="city">City: </label>
    <input name="city" id="city" type="text" pattern="[A-Za-z .'-]+" size="25" />
    &nbsp;&nbsp;&nbsp;
    <label for="state">State: </label><select id="state" name="state">
    <?php foreach( $states as $row ): ?>
      <option value="<?= $row['id'] ?>" <?= $row['id'] == 29 ? 'selected' : '' ?> ><?= $row['name'] ?></option>
    <?php endforeach; ?>
    </select>
    </p>
  </div>

  <div id="non_usa_div" >
  <p><label for="country">Country: </label>
  <input type="text" name="country" id="country" pattern="[A-Za-z -]+" size="25" />
  </p>
  </div>


    <p><label for="supervisor">Experience Supervisor: </label>
    <input type="text" id="supervisor" name="supervisor" required="required" pattern="[A-Za-z .'-]+" /></p>

    <p><label for="title">Capstone Title: </label>
    <input type="text" id="title" name="title" size="40" required="required" pattern="[A-Za-z .'-]+" /></p>

    <p><label for="description">Experience Description: </label></p>

    <p><textarea wrap="soft" rows="15" cols="80" id="description" name="description" required="required" ></textarea></p>

      <p id="prop_submit_button"><button id="submit" name="submit" type="submit">Submit</button></p>

      </form>
    </div> <!-- create_prop -->
<script src="student_create_proposal.js"></script>
<?php include("bottom.php"); ?>
