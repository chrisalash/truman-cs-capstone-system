<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['username'] ))
{
  //  header( 'Location: index.php' ); this would be an infinite loop
  exit();
}
$minyear = date('Y');
$maxyear = $minyear + 6;

//User directed here from home page if they do not have an entry in either student or professor table

include('student_new_top.php');
//The Student Home page is where students are directed after logging in. If they have one
//or more proposals, they are displayed alongside radio buttons, and when chosen, the
//student is sent to the view proposal page. If the student has no proposals, it says so
//and there is a link to the student_form.php page?>

    <div id="main_create">
      <p id="create_header">Create New Account</p>

      <form name="create_account" action="student_new_submit.php" method="post">
      <p><span class="bold">Username: </span><?= $_SESSION['username'] ?></p>

        <p><label for="first_name">First Name: </label>
        <input type="text" size="20" id="first_name" name="first_name"
           pattern="[A-Za-z][A-Za-z.' -]+" required="required" autofocus="autofocus"/></p>

        <p><label for="last_name">Last Name: </label>
        <input type="text" size="20" id="last_name" name="last_name"
           pattern="[A-Za-z][A-Za-z.' -]+" required="required" /></p>

        <p><label for="banner_id">Banner ID: </label>
        <input type="text" size="10" maxlength="9" id="banner_id" name="banner_id"
           pattern="\d{9}" required="required" placeholder="9 digits" /></p>

        <p><label for="hours">Total Credit Hours (including courses in progress): </label>
        <input type="number" max="200" min="50" id="hours" name="hours" required="required" /></p>

        <p><label for="grad_month">Planned Graduation: </label>
        <select id="grad_month" name="grad_month" required="required">
        <option value="0">Month</option>
        <option value="May">May</option>
        <option value="December">December</option>
        <option value="August">August</option>
        </select>
        &nbsp;&nbsp;
        <select id="grad_year" name="grad_year" required="required">
        <option value="0">Year</option>
          <?php for( $year = $minyear; $year <= $maxyear; $year++ ) : ?>
        <option value="<?= $year ?>"><?= $year ?></option>
          <?php endfor; ?>
        </select></p>

        <p><button name="submit" type="submit">Submit</button></p>
    </form>

</div> <!-- main_create -->
<?php include("bottom.php"); ?>
