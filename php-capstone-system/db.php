<?php
//Variables to connect to the database
$GLOBALS['conn_info'] = "mysql:host=localhost;dbname=capstone2";
$GLOBALS['u_name'] = "root";
$GLOBALS['p_word'] = "qn!PxDf0^6V53d";

function get_connection()
{
  $db = new PDO($GLOBALS['conn_info'], $GLOBALS['u_name'], $GLOBALS['p_word']);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $db;
}
?>
