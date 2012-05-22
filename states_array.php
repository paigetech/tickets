<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'FMAP';
  require_once('header.php');

  require_once('appvars.php');
  require_once('connectvars.php');

  // Show the navigation menu
  require_once('navmenu.php');



  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

    //include the refrence arrays
  require_once('arrays.php');
?>

<?php 

  $state_id = 1 ;

  echo $state_array[$state_id]; 

  ?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>