<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();
if( !isset( $_SESSION['is_faculty'] ) || $_SESSION['is_faculty'] == false )
{
  echo '';
  exit();
}

include('db.php');
$db = get_connection();
$srch = $_GET['srch'];

if( !preg_match('/^[A-Za-z][ \'A-Za-z-]*$/', $srch) )
{
  echo '';
  exit();
}

$st = $db->prepare( 'select p.id as pid, concat_ws(" ", first_name, last_name) as name, p.status,
               substring(title, 1, 75) as title, ps.description as status_description
               from proposal as p
               join student as s on s.id = p.student_id
               join propstatus as ps on ps.id = p.status
               where last_name like :srch
               order by last_name, first_name' );
$st->bindValue( ':srch', $srch . '%' );
$st->execute();
$results = $st->fetchAll();
if( count( $results ) > 0 ):?>
  <tr><th class="table_button">&nbsp;</th><th>Student</th><th>Title</th><th>Status</th></tr>
  <?php foreach( $results as $row ):
    $pid = $row['pid'];
    if( $row['status'] == 1 ) // 1 is Completed
    {
      $target_page = 'view_proposal.php';
      $action = 'View';
    }
    else
    {
      $target_page = 'faculty_edit_proposal.php';
      $action = 'Edit';
    }
?>
    <tr>
      <td class="table_button"><a href="<?= $target_page . '?pid=' . $pid ?>"><?= $action ?></a></td>
      <td class="name"><?= htmlspecialchars($row['name']) ?></td>
      <td class="title"><?= htmlspecialchars($row['title']) ?></td>
      <td class="status"><?= $row['status_description'] ?></td>
    </tr>
    <?php endforeach;
  endif; ?>
