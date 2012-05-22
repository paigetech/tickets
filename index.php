<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'FMAP';
  require_once('header.php');

  require_once('appvars.php');
  require_once('includes/connectvars.php');


  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    //ask them to log in and provide a link
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    //call the footer
    require_once('footer.php');
    //end all the code on the page
    exit();
  } else 
//everything a logged in user should see

  // Show the navigation menu
  require_once('navmenu.php');
  { ?>
<h1>This is a logged in user's view</h1>
<?php  }
//close the connection to the DB
    mysqli_close($dbc);
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>