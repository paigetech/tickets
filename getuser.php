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
mysql_select_db("login", $dbc);
        if (!$dbc)
          {
          die('Could not connect: ' . mysql_error());
          }


        $sql="SELECT * FROM FMAP_TA WHERE state_id = 2";

$result = mysql_query($sql);

echo "<table border='1'>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['FirstName'] . "</td>";
  echo "<td>" . $row['LastName'] . "</td>";
  echo "<td>" . $row['Age'] . "</td>";
  echo "<td>" . $row['Hometown'] . "</td>";
  echo "<td>" . $row['Job'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($dbc);
?>