<?php
$q=$_GET["q"];

// Start the session
// require_once('startsession.php');

//app vars  
  require_once('appvars.php');
  require_once('includes/connectvars.php');





  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  require_once('arrays.php');
        
        if (!$dbc)
          {
          die('Could not connect: ' . mysqli_error());
          }


        $query="SELECT * FROM FMAP_TA WHERE state_id = '".$q."'";

        $result = mysqli_query($dbc, $query);

echo "<div id='state_menu'>";

echo "<h2>Other Entries for Selected State:</h2>";

echo "<b>Select any records you wish to tie to this TA Entry</b><br />";

while($row = mysql_fetch_array($result))
  {

    $staff_id = $row['staff_id'];

  echo "<input type='checkbox' name='related[]' id= 'related[]' value='" . $row['ta_id'] . "' /> " . "<a target='_blank' href='single_entry.php?q=" . $row['ta_id'] . "'>" . $row['title'] . "</a>" . " | ". $row['created_date'] . " | " . $row['title'] . " | " . $staff_array[$staff_id];
  
  echo "<br />";

  }
echo "</div>";


?>