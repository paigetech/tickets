<?php
  // Generate the navigation menu
  echo '<hr />';
  if (isset($_SESSION['username'])) {
    echo '<a href="index.php">Home</a> | ';
    echo '<a href="logout.php">Log Out (' . $_SESSION['username'] . ')</a> | ';
  }
  else {
    echo '<a href="login.php">Log In</a> | ';
  }



echo '<a href="enter_ta.php">Enter TA</a> | ';
echo '<a href="enter_contact.php">Add a Client</a> | ';

  if ($_SESSION['level'] = 3) {
    echo '<a href="admin.php">Admin</a> | ';
    echo '<a href="signup.php">Add User</a> | ';
    echo '<a href="report.php">Reports</a> | ';

  }
  else {
    echo '<a href="login.php">Log In</a> | ';
  }

  echo '<hr />';

?>
