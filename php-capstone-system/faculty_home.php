<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == false )
{
  header( 'Location: index.php' );
  exit();
}
include('faculty_top.php');
include('db.php');
$db = get_connection();

$firstname = isset($_POST['firstname']) && $_POST['firstname'] != '' ? $_POST['firstname'] : false;
$lastname = isset($_POST['lastname']) && $_POST['lastname'] != '' ? $_POST['lastname'] : false;
$company = isset($_POST['company']) && $_POST['company'] != '' ? $_POST['company'] : false;
$proptype = isset( $_POST['proptype'] ) && preg_match( '/^\d+$/', $_POST['proptype'] ) && $_POST['proptype'] != '0' ? $_POST['proptype'] : false;
$prof1 = isset( $_POST['prof1'] ) && preg_match( '/^\d+$/', $_POST['prof1'] ) && $_POST['prof1'] != '0' ? $_POST['prof1'] : false;
$propstatus = isset( $_POST['propstatus'] ) && preg_match( '/^\d+$/', $_POST['propstatus'] ) && $_POST['propstatus'] != '0' ? $_POST['propstatus'] : false;

$active = isset( $_POST['submit'] ) && $_POST['submit'] == 'submit' ;
  //&& ( $firstname || $lastname || $company || $proptype || $prof1 || $propstatus );

if( $active )
{
  $sql = 'select p.id as pid, concat_ws(" ", s.first_name, s.last_name) as sname, p.status,
          substring(title, 1, 75) as title, ps.description
          from proposal as p
          join student as s on s.id = p.student_id
          join propstatus as ps on ps.id = p.status
          left join professor as prof on prof.id = professor1_id where 1 = 1';

  if( $firstname )
  {
    $sql .= ' and s.first_name like :firstname ';
  }

  if( $lastname )
  {
    $sql .= ' and s.last_name like :lastname ';
  }

  if( $company )
  {
    $sql .= ' and company like :company ';
  }

  if( $proptype )
  {
    $sql .= ' and proptype = :proptype ';
  }

  if( $prof1 )
  {
    $sql .= ' and professor1_id = :prof1 ';
  }

  if( $propstatus )
  {
    $sql .= ' and p.status = :propstatus ';
  }

  if( $_POST['order'] == 'name' )
  {
    $sql .= ' order by s.last_name, s.first_name' ;
  }
  else
  {
    $sql .= ' order by date_created desc';
  }
  $st = $db->prepare( $sql );
  if( $firstname )
  {
    $st->bindValue( ':firstname', $firstname . '%' );
  }
  if( $lastname )
  {
    $st->bindValue( ':lastname', $lastname . '%' );
  }
  if( $company )
  {
    $st->bindValue( ':company', $company . '%' );
  }
  if( $proptype )
  {
    $st->bindParam( ':proptype', $proptype );
  }
  if( $prof1 )
  {
    $st->bindParam( ':prof1', $prof1 );
  }
  if( $propstatus )
  {
    $st->bindParam( ':propstatus', $propstatus );
  }
  $st->execute();
  $results = $st->fetchAll();
}
else
{
  $results = array();
}
?>
 <p id="head2text" class="left100">Faculty Home</p>

<div id=search_bar>
  <p><label for="qsearch">Student Search<br />Last Name:&nbsp;&nbsp;&nbsp; </label>
  <input autofocus="autofocus" type="text" id="qsearch" name="qsearch" size="10"/></p>
<hr />
<form action="faculty_home.php" method="post" id="fullsearch">
  <p><span class="bold">Full Search (fields ANDed): </span></p>
<p><label for="firstname">First Name: </label>
<input name="firstname" id="firstname" type="text" pattern="[A-Za-z][A-Za-z .'-]*" size="15"
  value="<?= $firstname ? $firstname : '' ?>"/></p>

<p><label for="lastname">Last Name: </label>
<input name="lastname" id="lastname" type="text" pattern="[A-Za-z][A-Za-z .'-]*" size="15"
  value="<?= $lastname ? $lastname : '' ?>"/></p>

<p><label for="company">Company: </label>
<input name="company" id="company" type="text" pattern="[A-Za-z][A-Za-z .'-]*" size="15"
  value="<?= $company ? $company : '' ?>"/></p>

<p><label for="proptype">Type: </label>
<select name="proptype" id="proptype">
<option value="0">Any Type</option>
<?php
$db = get_connection();
$st = $db->prepare( 'select id, description from proptype' );
$st->execute();
$proptypes = $st->fetchAll();
foreach( $proptypes as $row ): ?>
  <option value="<?= $row['id'] ?>" <?= $proptype && $proptype == $row['id'] ? 'selected="selected"' : '' ?>><?= $row['description'] ?></option>
<?php endforeach; ?>
</select>

<p><label for="propstatus">Status: </label>
<select name="propstatus" id="propstatus">
<option value="0">Any Status</option>
<?php
$db = get_connection();
$st = $db->prepare( 'select id, description from propstatus order by sortorder' );
$st->execute();
$statuses = $st->fetchAll();
foreach( $statuses as $row ): ?>
  <option value="<?= $row['id'] ?>" <?= $propstatus && $propstatus == $row['id'] ? 'selected="selected"' : '' ?>><?= $row['description'] ?></option>
<?php endforeach; ?>
</select>

<p><label for="prof1">Chair: </label>
<select name="prof1" id="prof1">
<option value="0">Any Professor</option>
<?php
$db = get_connection();
$st = $db->prepare( 'select concat_ws( " ", first_name, last_name) as p1name, id
                     from professor order by last_name, first_name' );
$st->execute();
$profs = $st->fetchAll();
foreach( $profs as $row ): ?>
  <option value="<?= $row['id'] ?>" <?= $prof1 && $prof1 == $row['id'] ? 'selected="selected"' : '' ?>><?= $row['p1name'] ?></option>
<?php endforeach; ?>
</select>

<p><label for="order">Order: </label>
<select name="order" id="order">
  <option selected="selected" value="name">By Name (last, first)</option>
  <option value="date">By Date (new &rarr; old)</option></select></p>

<p class="center"><button type="submit" id="submit" name="submit" value="submit">Search</button>
&nbsp;&nbsp;&nbsp;<button type="button" id="reset">Reset</button></p>
</form>
</div> <!-- search_bar -->

<div id=search_results>
<table id="proptable"><tbody id="proptablebody">
<?php if( count( $results ) > 0 ) : ?>

  <tr><th class="table_button">&nbsp;</th><th>Student</th><th>Title</th><th>Status</th></tr>
  <?php foreach( $results as $row ):
    $pid = $row['pid']; ?>
    <tr>
      <td class="table_button"><a href="faculty_edit_proposal.php?pid=<?= $pid ?>">Edit</a></td>
      <td class="name"><?= $row['sname'] ?></td>
      <td class="title"><?= $row['title'] ?></td>
      <td class="status"><?= htmlentities($row['description']) ?></td>
    </tr>
    <?php endforeach;
endif; ?>
</tbody>
</table>
</div> <!-- search_results -->

  <script src="quicksearch.js"></script>
 <?php include( 'bottom.php' ); ?>
