 <?php
$q=$_GET["q"];

// Start the session'
//  require_once('startsession.php');

//app vars  
  require_once('appvars.php');
  require_once('includes/connectvars.php');


//setup the select list
echo '<select id="contact_id_entry" name="contact_id_entry">';
echo '<option value="">Select Contact</a>';

  // Connect to the database 
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

  require_once('arrays.php');

        
        if (!$dbc)
          {
          die('Could not connect: ' . mysqli_error());
          }

//pull the data that relates to our "q"
$query="SELECT first_name, last_name, contact_id FROM FMAP_contact WHERE state_id = '".$q."'";

$result = mysqli_query($dbc, $query);

  while ($row = mysqli_fetch_array($result)) {
    // generate the select list
    $contact_first_name = $row['first_name'];
    $contact_last_name = $row['last_name'];
    $contact_id = $row['contact_id'];
  
    echo '<option value="' . $contact_id . '">' . $contact_first_name . ' ' . $contact_last_name . '</option>';


  }
  //close the select list
  echo '</select>';



?>


