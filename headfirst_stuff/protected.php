<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'Edit Profile';
  require_once('header.php');

  require_once('appvars.php');
  require_once('connectvars.php');

  // Show the navigation menu
  require_once('navmenu.php');

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  } else {
    echo '<h1>Logged In Data</h1>';
  }



  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>
