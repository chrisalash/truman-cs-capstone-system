<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == true )
{
  header( 'Location: index.php' );
  exit();
}
$minyear = 2000;
$maxyear = date('Y') + 6;

include('db.php');
$db = get_connection();
$st = $db->prepare('select first_name, last_name, banner_id, hours, grad_month, grad_year
                    from student
                    where id = :sid' );
$st->bindParam( ':sid', $_SESSION['id'] );
$st->execute();
$results = $st->fetchAll();
if( count( $results ) != 1 )
{
  header( 'Location: index.php' );
  exit();
}
$info = $results[0];
include('student_top.php');

//Allows student to change their personal information
?>

  <p id="head2text" class="left95">Edit Personal Info</p>

  <div id="update_info">

  <?php if( isset( $_GET['update'] )) : ?>

    <p>Please confirm your information:</p>

  <?php endif; ?>

  <?php if( isset( $_GET['ok'] )): ?>

    <p>Information updated!</p>

  <?php endif; ?>
  </div> <!-- update_info -->


    <div id="login">
      <form name="stu_edit_form" action="student_edit_info_submit.php" method="post" >
    <p><label for="first_name">First Name: </label>
    <input type="text" size="20" id="first_name" name="first_name"
           value="<?= htmlspecialchars($info['first_name']) ?>"
           required="required" pattern="[A-Za-z][A-Za-z.' -]+" /></p>

    <p><label for="last_name">Last Name: </label>
    <input type="text" size="20" id="last_name" name="last_name"
           value="<?= htmlspecialchars($info['last_name']) ?>"
           required="required" pattern="[A-Za-z][A-Za-z.' -]+" /></p>

  <p><label for="banner_id">Banner ID: </label>
  <input type="text" size="10" maxlength="9" id="banner_id" name="banner_id"
     pattern="0\d{8}" required="required" value="<?= $info['banner_id'] ?>" /></p>

  <p><label for="hours">Total Credit Hours (including courses in progress): </label>
  <input type="number" max="200" min="50" id="hours" name="hours" required="required"
    value="<?= $info['hours'] ?>" /></p>

  <p><label for="grad_month">Planned Graduation: </label>
  <select id="grad_month" name="grad_month" required="required">
  <option value="0">Month</option>
  <option value="May" <?= $info['grad_month'] == 'May' ? 'selected="selected"' : '' ?>>May</option>
  <option value="December" <?= $info['grad_month'] == 'December' ? 'selected="selected"' : '' ?>>December</option>
  <option value="August" <?= $info['grad_month'] == 'August' ? 'selected="selected"' : '' ?>>August</option>
  </select>
  &nbsp;&nbsp;
  <select id="grad_year" name="grad_year" required="required">
  <option value="0">Year</option>
  <?php for( $year = $minyear; $year <= $maxyear; $year++ ) : ?>
   <option value="<?= $year ?>" <?= $info['grad_year'] == $year ? 'selected="selected"' : '' ?>><?= $year ?></option>
  <?php endfor; ?>
  </select></p>

    <button type="submit" id="submit">Submit</button>
    </form>
  </div>

 <script src="student_validate.js"></script>
<?php include("bottom.php"); ?>
