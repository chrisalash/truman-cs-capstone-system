<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == true )
{
  header( 'Location: index.php' );
  exit();
}

if( !isset( $_SESSION['pid'] ) && !preg_match( '/^\d+$/', $_SESSION['pid'] ))
{
  header( 'Location: index.php' );
  exit();
}
include('db.php');

$db = get_connection();
$st = $db->prepare( 'select now() as curdate, s.username, concat_ws(" ", s.first_name, s.last_name) as name,
                            s.banner_id, pt.description as typedesc, concat_ws(" ", grad_month, grad_year) as grad_date,
                            company, supervisor, title, hours,
                            p.description, other, city, abbrev, country
                     from proposal as p
                     join student as s on s.id = student_id
                     join proptype as pt on pt.id = p.proptype
                     left join _state as st on p.state = st.id
                     where p.id = :pid');
$st->bindParam( ':pid', $_SESSION['pid'] );
$st->execute();
$proposal = $st->fetchAll();

if( count($proposal) != 1 )
{
  header( 'Location: student_error_page.php' );
  exit();
}
$curdate = $proposal[0]['curdate'];
$username = $proposal[0]['username'];
$name = $proposal[0]['name'];
$banner_id = $proposal[0]['banner_id'];
$typedesc = $proposal[0]['typedesc'];
$company = $proposal[0]['company'];
$supervisor = $proposal[0]['supervisor'];
$title = $proposal[0]['title'];
$hours = $proposal[0]['hours'];
$description = $proposal[0]['description'];
$other = $proposal[0]['other'];
$grad_date = $proposal[0]['grad_date'];
$city = isset( $proposal[0]['city'] ) ? $proposal[0]['city'] : '';
$abbrev = isset( $proposal[0]['abbrev'] ) ? $proposal[0]['abbrev'] : '';
$country = isset( $proposal[0]['country'] ) ? $proposal[0]['country'] : '';

$location = $city != '' ? $city . ', ' . $abbrev : $country;
?>
  <!DOCTYPE html>
  <html>
    <head>
      <title>Print Pre-approval Form</title>
      <link rel="stylesheet" type="text/css" href="capstone_style.css"/>
      <meta charset="utf-8" />
    </head>

    <body>
    <div id="preapprov_prop">
    <p id="prop_header">Computer Science Capstone Pre-approval Form</p>
    <p id="prop_sub_header">Print this out and obtain the signatures of three computer science faculty members.<br />
    Return the form to Professor 1 for your proposal to be pre-approved.</p>

    <p><span class="prop_bold">Date: </span><?= $curdate ?></p>
    <p><span class="prop_bold">Username: </span><?= $username ?></p>
    <p><span class="prop_bold">Name: </span><?= $name ?></p>
    <p><span class="prop_bold">Banner ID: </span><?= $banner_id ?> </p>
    <p><span class="prop_bold">Cumulative Hours: </span><?= $hours ?></p>
    <p><span class="prop_bold">Expected Graduation Date: </span><?= $grad_date ?></p>
    <p><span class="prop_bold">Capstone Type: </span><?= $typedesc ?></p>
  <?php if( $other != '' ) : ?>
    <p><span class="prop_bold">Other Description: </span><?= $other ?></p>
  <?php endif; ?>
    <?php if( $company != '' ) : ?>
    <p><span class="prop_bold">Company or Organization: </span><?= $company ?></p>
  <?php endif; ?>

    <p><span class="prop_bold">Location: </span><?= $location ?></p>

    <p><span class="prop_bold">Capstone Supervisor: </span><?= htmlspecialchars($supervisor) ?></p>
    <p><span class="prop_bold">Title: </span><?= htmlspecialchars($title) ?></p>
    <p>
      <span class="prop_bold">Description:</span><br /><br />
      <?= nl2br(htmlspecialchars($description)) ?> <br /><br /><br />
    </p>
    <p>
      <span class="prop_bold">CS Faculty Approval Signatures:</span> <br /><br /><br /><br />
      Professor 1: _____________________________________ Date: ___________________<br /><br /><br />
      Professor 2: _____________________________________ Date: ___________________<br /><br /><br />
      Professor 3: _____________________________________ Date: ___________________<br /><br /><br />
    </p><br /></p>
  <p class="center"><a href="student_home.php">Home Page</a></p>
  </div> <!-- preapprov_prop -->

  </body>
</html>
