<?php
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

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $state_id = mysqli_real_escape_string($dbc, trim($_POST['state_id']));
    $tag_id = mysqli_real_escape_string($dbc, trim($_POST['tag_id']));
    $staff_id = mysqli_real_escape_string($dbc, trim($_POST['staff_id']));

    if (!empty($state_id)) {
        // if a State was selected show the following

        echo '<b>State you are running the report for: </b>' . $state_array[$state_id] . '<br /><br />';

                $query = "SELECT * FROM FMAP_TA WHERE state_id = $state_id";

                require_once('ta_report.php');

      } elseif (!empty($tag_id)) {

                echo '<b>Tag you are running the report for: </b>' . $tag_array[$tag_id] . '<br /><br />';

                $query = "SELECT * FROM FMAP_TA WHERE tags LIKE $tag_id";

                require_once('ta_report.php');

      } elseif (!empty($staff_id)) {

                echo '<b>State you are running the report for: </b>' . $state_array[$state_id] . '<br /><br />';

                $query = "SELECT * FROM FMAP_TA WHERE staff_id = $staff_id";

                require_once('ta_report.php');

      }
    else {
      echo '<p class="error">You must enter all of the Technial Assistance Details.</p>';

    }
  } else {

  ?>

<!-- FMAP_TA input form -->
<form method="post">

  <label for="state_id">Select a State for the report:</label>
  <?php 
//Dropdown for states
//Generate the dropdown lists
echo '<select id="state_id" name="state_id">';
echo '<option value="">Select State</a>';
 // Retrieve the state data from MySQL
  $query = "SELECT name, state_id FROM FMAP_state";
  $result = mysqli_query($dbc, $query);


  while ($row = mysqli_fetch_array($result)) {
    // generate the select list
    $state_name = $row['name'];
    $state_id = $row['state_id'];

  
    echo '<option value="' . $state_id .'">' . $state_name . '</option>';

  }

echo '</select>';
?>
<br />
Or 
<br />
<label for="tags">Select a Tag for the report:</label>

  <?php 
//Dropdown for states
//Generate the dropdown lists
echo '<select id="tag_id" name="tag_id">';
echo '<option value="">Select a Tag</a>';
 // Retrieve the state data from MySQL
  $query = "SELECT name, tag_id FROM FMAP_tags";
  $result = mysqli_query($dbc, $query);


  while ($row = mysqli_fetch_array($result)) {
    // generate the select list
    $tag_name = $row['name'];
    $tag_id = $row['tag_id'];

  
    echo '<option value="' . $tag_id .'">' . $tag_name . '</option>';

  }

echo '</select>';
?>  
<br />
Or
<br />
  <label for="staff_id">Select Staff Member for Report:</label>
  <?php 
//Dropdown for staff_id

//Generate the dropdown lists
echo '<select id="staff_id" name="staff_id">';
echo '<option value="">Select Staff</a>';
 // Retrieve the state data from MySQL
  $query = "SELECT first_name, last_name, user_id FROM FMAP_staff";
  $result = mysqli_query($dbc, $query);


  while ($row = mysqli_fetch_array($result)) {
    // generate the select list
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $staff_id = $row['user_id'];
  
    echo '<option value="' . $staff_id . '">' . $first_name . ' ' . $last_name . '</option>';

  }

echo '</select>';
?>

<br />
<br />

<input type="submit" name="submit" value="submit" />
</form>

<?php
}
  // Insert the page footer
  require_once('footer.php');
?>