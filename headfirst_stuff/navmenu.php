<?php
  // Generate the navigation menu
  echo '<hr />';
  if (isset($_SESSION['username'])) {
    echo '<a href="index.php">Home</a>; ';
    echo '<a href="logout.php">Log Out (' . $_SESSION['username'] . ')</a>';
  }
  else {
    echo '<a href="login.php">Log In</a>; ';
  }



echo '<a href="enter_ta.php">Enter TA</a>';
echo '<a href="add_client.php">Add a Client</a>';
echo '<a href="reports.php">Reports</a>';

  echo '<hr />';

?>
