<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['first_name'] ) ||
    !isset( $_SESSION['last_name'] ) ||
    !isset( $_SESSION['id'] ))
{
  header( 'Location: index.php' );
  exit();
}

if( !isset( $_POST['professor'] ) || !preg_match( '/^\d+$/', $_POST['professor'] ))
{
  header( 'Location: index.php' );
  exit();
}

$id2edit = $_POST['professor'];
include('db.php');

$db = get_connection();
$st = $db->prepare( 'select concat_ws(" ", first_name, last_name ) as name, status
                     from professor where id = :id' );
$st->bindParam( ':id', $id2edit );
$st->execute();
$prof2edit = $st->fetchAll();

if( count( $prof2edit ) != 1 )
{
  header( 'Location: index.php' );
  exit();
}
include('faculty_top.php');?>
  <p id="head2text" class="left95">Modify Status for <br />
  <?= htmlspecialchars( $prof2edit[0]['name'] ) ?></p>

  <form name="edit_fac_form" action="change_prof_status.php" method="post">
      <input type="hidden" name="professor" value="<?= $id2edit ?>" />
      <p><label for="newstatus">Status: </label>
      <select name="newstatus" id="newstatus">
<?php
$st = $db->prepare( 'select id, description from profstatus' );
$st->execute();
$results = $st->fetchAll();
foreach( $results as $row ): ?>
  <option value="<?= $row['id'] ?>" <?= $prof2edit[0]['status'] == $row['id'] ? ' selected="selected" ' : '' ?>> <?= $row['description'] ?></option>
<?php endforeach; ?>
    </select> </p>
    <p><button type="submit">Submit</button></p>
  </form>

<?php include("bottom.php"); ?>
