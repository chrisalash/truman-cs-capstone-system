<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['username'] ) || !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == true )
{
  header( 'Location: index.php' );
  exit();
}

include('db.php');
$db = get_connection();

$st = $db->prepare( 'select p.id, substring(title, 1, 75) as title, date_created,
                         status, ps.description as stat_desc
                     from proposal as p
                     join propstatus as ps on p.status = ps.id
                     where student_id = :sid
                     order by date_created' );
$st->bindParam( ':sid', $_SESSION['id'] );
$st->execute();
$proposals = $st->fetchAll();

include('student_top.php');

//The Student Home page is where students are directed after logging
//in. If they have one or more proposals, they are displayed
?>
<p id="head2text" class="left103">My Proposals</p>

<?php if( count( $proposals ) == 0 ) : ?>
	 <div id="no_prop_div">
    <p class="center" id="announcement">You have no proposals.</p>
  	 </div>
<?php else: ?>

	<form name="stu_prop_form" action="student_view_proposal.php" method="post">
	<div id="prop_results">
    <table>
    <tr><th></th><th>Title</th><th>Date Created</th><th>Status</th></tr>
       <?php foreach( $proposals as $row ) : ?>
       <tr>
       <?php if( $row['status'] == 1 ) : ?>
       	<td class="table_button"><a href="view_proposal.php?pid=<?= $row['id'] ?>">View</a></td>
       <?php else: ?>
	       <td class="table_button"><a href="student_edit_proposal.php?pid=<?= $row['id'] ?>">Edit</a></td>
	    <?php endif; ?>
       <td class="title"><?= $row['title'] ?></td>
       <td class="date"><?= $row['date_created'] ?></td>
       <td class="status"><?= $row['stat_desc'] ?></td>
       </tr>
       <?php endforeach; ?>
    </table>
    </div>
    </form>

<?php endif; ?>

  <div id="create_prop_button">
    <button type="button" onclick="location.href='student_create_proposal.php';">Create New Proposal</button>
  </div>

<?php include( 'bottom.php' ); ?>
