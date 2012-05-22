<?php
$title=$_GET["q"];

  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'FMAP';
  require_once('header.php');

  require_once('appvars.php');
  require_once('includes/connectvars.php');

  // Show the navigation menu
  require_once('navmenu.php');


  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


  //include the refrence arrays
  require_once('arrays.php');
        
        if (!$dbc)
          {
          die('Could not connect: ' . mysql_error());
          }


        $result="SELECT * FROM FMAP_TA WHERE title = '$title'";

        $result = mysqli_query($dbc, $query);

  echo "<div id='ta_entry'>";


echo "<h2>Technical Assistance Entry:</h2>";

  $row = mysqli_fetch_array($result);

        // Display selected TA ID
        $staff_id = $row['staff_id'];
        $contact_id_entry = $row['contact_id_entry'];
        $state_id = $row['state_id'];
        $title2 = $row['title'];

        echo '<b>Title: </b>' . $title2 . '<br /><br />';
        echo '<b>Tags: </b>' . $row['tags'] . '<br /><br />';
        echo '<blockquote><b>Notes: </b>' . $row['notes'] . '<br /></blockquote>';
        echo '<b>Staff ID: </b>' . $staff_array[$staff_id] . '<br /><br />';
        echo '<b>Contact ID: </b>' . $contact_array[$contact_id_entry] . '<br /><br />';
        echo '<b>State ID: </b>' . $state_array[$state_id] . '<br /><br />';



echo "</div>";
?>
<form action="mail.php" method="POST">
<input type="submit" value="Send"><input type="reset" value="Clear">

</form>
<?php

        $query="SELECT * FROM FMAP_TA WHERE state_id = '$state_id' ";

        $result = mysqli_query($dbc, $query);

echo "<div id='more_entries'>";

echo "<h2>Other Entries for Selected State:</h2>";

while($row = mysqli_fetch_array($result))
  {


  echo "<a target='_blank' href='getphp.php?q=" . $row['ta_id'] . "'>" . $row['title'] . "</a>" . " | ". $row['created_date'] . " | " . $row['tags'] . " | " . $staff_array[$staff_id];
  echo "<br />";

  }
echo "</div>";



mysqli_close($dbc);
?>



<?php
require_once('footer.php');
?>