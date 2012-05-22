<?php
$q=$_GET["q"];

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
  $dbc = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


  //include the refrence arrays
  require_once('arrays.php');

  mysql_select_db("login", $dbc);
        
        if (!$dbc)
          {
          die('Could not connect: ' . mysql_error());
          }


        $sql="SELECT * FROM FMAP_TA WHERE ta_id = '".$q."'";

$result = mysql_query($sql);

echo "<div id='ta_entry'>";

echo "<h2>Technical Assistance Entry:</h2>";

while($row = mysql_fetch_array($result))
  {

        // Display selected TA ID
        $staff_id = $row['staff_id'];
        $contact_id_entry = $row['contact_id_entry'];
        $state_id = $row['state_id'];

        echo '<b>Title: </b>' . $row['title'] . '<br /><br />';
        echo "<h2><a target='_blank' href='edit_entry.php?q=" . $row['ta_id'] . "'>Edit</a></h2>";
        echo '<b>Tags: </b>' . $tag_array[$row['tags']] . '<br /><br />';
        echo '<b>Staff ID: </b>' . $staff_array[$staff_id] . '<br /><br />';
        echo '<b>Contact ID: </b>' . $contact_array[$contact_id_entry] . '<br /><br />';
        echo '<b>State ID: </b>' . $state_array[$state_id] . '<br /><br />';
        echo '<b>Notes: </b><blockquote>' . $row['notes'] . '<br /></blockquote>';



  }
echo "</div>";

$sql="SELECT * FROM FMAP_TA WHERE state_id = '$state_id' ";

$result = mysql_query($sql);

echo "<div id='more_entries'>";

echo "<h2>Other Entries for Selected State:</h2>";

while($row = mysql_fetch_array($result))
  {


  echo "<a target='_blank' href='getphp.php?q=" . $row['ta_id'] . "'>" . $row['title'] . "</a>" . " | ". $row['created_date'] . " | " . $row['tags'] . " | " . $staff_array[$staff_id];
  echo "<br />";

  }
echo "</div>";



mysql_close($dbc);
?>



<?php
require_once('footer.php');
?>