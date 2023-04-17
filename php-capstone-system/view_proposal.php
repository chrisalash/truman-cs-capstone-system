<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['is_faculty'] ) || !isset( $_SESSION['id'] ))
{
  header( 'Location: index.php' );
  exit();
}

if( !isset( $_GET['pid'] ) && !preg_match( '/^\d+$/', $_GET['pid'] ))
{
  header( 'Location: index.php' );
  exit();
}
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

$st = $db->prepare( 'select date_created, date_last_edited, date_preapproved, date_completed,
                            s.username, concat_ws(" ", s.first_name, s.last_name) as name, s.banner_id,
                            grad_month, grad_year, hours, proptype, pt.description as typedesc, company,
                            supervisor, title, p.description, ps.description as status, other,
                            concat_ws(" ", p1.first_name, p1.last_name) as p1name,
                            concat_ws(" ", p2.first_name, p2.last_name) as p2name,
                            concat_ws(" ", p3.first_name, p3.last_name) as p3name,
                            city, abbrev, country
                     from proposal as p
                     join student as s on s.id = student_id
                     join propstatus as ps on ps.id = p.status
                     join proptype as pt on pt.id = p.proptype
                     left join professor as p1 on p1.id = professor1_id
                     left join professor as p2 on p2.id = professor2_id
                     left join professor as p3 on p3.id = professor3_id
                     left join _state as st on p.state = st.id
                     where p.id = :pid');
$st->bindParam( ':pid', $_GET['pid'] );
$st->execute();
$proposal = $st->fetchAll();

if( count($proposal) != 1 )
{
  if( $_SESSSION['is_faculty'] )
  {
    header( 'Location: faculty_error_page.php' );
    exit();
  }
  else
  {
    header( 'Location: student_error_page.php' );
    exit();
  }
}

$date_created = $proposal[0]['date_created'];
$date_last_edited = $proposal[0]['date_last_edited'];
$date_preapproved = $proposal[0]['date_preapproved'];
$date_completed = $proposal[0]['date_completed'];
$username = $proposal[0]['username'];
$name = htmlentities($proposal[0]['name']);
$banner_id = $proposal[0]['banner_id'];
$grad_month = $proposal[0]['grad_month'];
$grad_year = $proposal[0]['grad_year'];
$hours = $proposal[0]['hours'];
$typedesc = $proposal[0]['typedesc'];
$proptype = $proposal[0]['proptype'];
$company = htmlentities($proposal[0]['company']);
$supervisor = htmlentities($proposal[0]['supervisor']);
$title = htmlentities($proposal[0]['title']);
$description = htmlentities($proposal[0]['description']);
$status = $proposal[0]['status'];
$other = $proposal[0]['other'];
$p1name = $proposal[0]['p1name'];
$p2name = $proposal[0]['p2name'];
$p3name = $proposal[0]['p3name'];
if( isset( $proposal[0]['country'] ))
{
  $location = htmlentities( $proposal[0]['country'] );
}
elseif( $proposal[0]['city'] == '' )
{
  $location = '';
}
else
{
  $location = htmlentities( $proposal[0]['city'] ) . ', ' . $proposal[0]['abbrev'];
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

if( $_SESSION['is_faculty'] )
{
  include('faculty_top.php');
}
else
{
  include('student_top.php');
}
?>

   <p id="head2text" class="left100">View Proposal</p>
   <div id="view_prop">
    <p class="results"><span class="bold">Username: </span><?= $username ?></p>
    <p class="results"><span class="bold">Name:</span> <?= $name ?></p>
    <p class="results"><span class="bold">Banner ID: </span><?= $banner_id ?></p>

    <p class="results"><span class="bold">Cumulative Hours (including classes in progress): </span>
    <?= $hours ?>
    </p>

    <p id="hours_err_message" class="error"></p>

    <p class="results"><span class="bold">Expected Graduation Date: </span>
    <?= $grad_month ?> <?= $grad_year == 0 ? 1990 : $grad_year ?>
    </p>

    <p class="results"><span class="bold">Capstone Type: </span><?= $typedesc ?></p>

<?php if( $proptype == 6 ) : ?>
  <p class="results"><span class="bold">Description for &lsquo;Other&rsquo;: </span><?= $other ?></p>
<?php endif; ?>

<?php if( $proptype == 1 || $proptype == 2 ) : ?>
   <p class="results"><span class="bold">Company or Organization: </span><?= $company ?></p>
<?php endif; ?>

  <p><span class="bold">Location: </span><?= $location ?></p>

    <p class="results"><span class="bold">Experience Supervisor: </span> <?= $supervisor ?></p>

    <p class="results"><span class="bold">Capstone Title: </span><?= $title ?></p>

    <p class="results"><span class="bold">Experience Description: </span></p>

    <p class="results"><textarea wrap="soft" rows="15" cols="80" id="description"
    name="description" disabled><?= $description ?></textarea></p>

<?php
  $note_num = 0;
    foreach($notes as $note)
    { ?>
      <hr>Note <?= $note_num ?> added by <?= $note['name'] ?> on <?= date('F j, Y g:i:s A', strtotime($note['date'])) ?><br /><br />
        <?= nl2br($note['note']) ?> <br />
        <hr>
      <?php
      $note_num++;
    } ?>

    <p class="results"><span class="bold">Status: </span><?= $status ?></p>

<?php
// FIXME: hard-coded reference to status: 1 = active, 2 = inactive
$st = $db->prepare( 'select concat_ws(" ", first_name, last_name) as name, id, status
                     from professor
                     order by last_name, first_name' );
$st->execute();
$profs = $st->fetchAll();
?>
    <p class="results"><span class="bold">Professor 1: </span><?= $p1name ?> </p>
    <p class="results"><span class="bold">Professor 2: </span><?= $p2name ?> </p>
    <p class="results"><span class="bold">Professor 3: </span><?= $p3name ?> </p>
</div> <!-- view_prop -->
<?php include("bottom.php"); ?>
