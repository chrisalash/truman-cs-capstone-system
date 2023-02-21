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

//Allows a faculty member to choose a professor from the list to edit (change status)
//or add a new faculty member ?>

	<script> document.title="Administer Faculty"; </script>
	<p id="head2text" class="left95">Administer Faculty</p>

	<script src="faculty_administer.js"></script>
	<form name="adm_fac_form" method="post" action="edit_faculty.php">
		<p><label for="professor">Professor: </label>
		<select name="professor" id="professor" required="required">
		<option value="0">Select</option>
<?php
$db = get_connection();
$st = $db->prepare( 'select id, concat_ws(" ", first_name, last_name ) as name, status
                     from professor
                     order by last_name, first_name' );
$st->execute();
$results = $st->fetchAll();

foreach( $results as $row ): ?>
  <option value="<?= $row['id']?>"><?= htmlspecialchars($row['name']) ?></option>
<?php endforeach; ?>
</select></p>
<p id="err_message" class="error" ></p>
<p>
    <button type="submit" onclick="return validate()">Edit</button>
</p>
</form>
<form  name="adm_fac_form" method="post" action="add_faculty.php">
    <button type="submit">Add New Faculty Member</button>
</form>

<?php include("bottom.php"); ?>
