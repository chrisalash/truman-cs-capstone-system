<?php
  //Faculty_top is included at the top of almost every faculty
  //page. It includes the navigation bar, favicon, stylesheet, and the
  //starting code for an HTML file.
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Capstone Faculty</title>
    <link rel="stylesheet" type="text/css" href="capstone_style.css"/>
    <meta charset="utf-8" />
    <link rel="icon" href="images/bulldog.png">
  </head>

   <body>
   <div id="webpage">
   <div id="header">
   <a href="http://wp-internal.truman.edu/cs/" target="_blank">
   <img id="cslogo" src="images/logo_trajan.jpg" alt="CS Logo" height="150"
   width="200" /></a>
   <p id="headtext">CS Capstones</p>
   </div> <!-- header -->

  <div id="head2"></div>

  <div id="menubar">
  <ul id="navigation">
     <li><a href="faculty_home.php">Home</a></li>
     <li><a href="faculty_edit_info.php">Edit Personal Info</a></li>
     <li><a href="administer_faculty.php">Administer Faculty</a></li>
     <li><a href="logout.php">Log Out</a></li>
     <li><a href="http://localhost:5173/">Presentations</a></li>
   </ul>
  </div> <!-- menu_bar -->
