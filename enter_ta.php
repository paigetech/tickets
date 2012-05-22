<?php

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

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
    if (isset($_POST['tags'])){
      $tags = implode(',', $_POST['tags']);  
    }
    $notes = mysqli_real_escape_string($dbc, trim($_POST['notes']));
    $staff_id = mysqli_real_escape_string($dbc, trim($_POST['staff_id']));
    $contact_id_entry = mysqli_real_escape_string($dbc, trim($_POST['contact_id_entry']));
    $state_id = mysqli_real_escape_string($dbc, trim($_POST['state_id']));
    $summary = mysqli_real_escape_string($dbc, trim($_POST['summary']));
    $completed = mysqli_real_escape_string($dbc, trim($_POST['completed']));
    $hours = mysqli_real_escape_string($dbc, trim($_POST['hours']));
    $follow_up = mysqli_real_escape_string($dbc, trim($_POST['follow_up']));
    
    if (isset($_POST['related'])) {
      $related_array = implode(',', $_POST['related']);
    }

    $new_tags_array = explode(',' , $_POST['new_tags']);
    $new_tags_string = $_POST['new_tags'];


    if (!empty($title) && (!empty($tags) or !empty($new_tags_string)) && !empty($contact_id_entry)) {
      // Make sure a TA with the same title isn't already in the DB
      $query = "SELECT * FROM FMAP_TA WHERE title = '$title'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO FMAP_TA ( created_date, title, tags, notes, staff_id, contact_id, state_id, summary, completed, hours, follow_up) VALUES ( NOW(), '$title', '$tags', '$notes', '$staff_id', '$contact_id_entry', '$state_id', '$summary', '$completed', '$hours', '$follow_up')";


        //loop through the entered tags and put them in the tag table
        foreach($new_tags_array as $new_tags) 
          {
            //check for existing tags and don't insert those
            $q = "SELECT * FROM FMAP_tags WHERE name = '$new_tags'";
            $data2 = mysqli_query($dbc, $q) OR die(mysqli_error());

                  if (mysqli_num_rows($data2) == 0){

                      $insert="INSERT INTO FMAP_tags (name) VALUES ('$new_tags')";

                      mysqli_query($dbc, $insert) OR die(mysqli_error());

                        } 
                        
          }
        mysqli_query($dbc, $query);



        // Confirm success with the user

        require_once('header.php');
        require_once('navmenu.php');


        echo '<p>Technical Assistance has been added to the Database with the following details.</p>';
        echo '<b>Title: </b>' . $title . '<br /><br />';
        echo '<b>Tags: </b>' . $tags . ' ' . $new_tags_string . '<br /><br />';
        echo '<b>Notes: </b><blockquote>' . $notes . '<br /></blockquote>';
        echo '<b>Staff ID: </b>' . $staff_array[$staff_id] . '<br /><br />';
        echo '<b>contact ID: </b>' . $contact_array[$contact_id_entry] . '<br /><br />';
        echo '<b>State ID: </b>' . $state_array[$state_id] . '<br /><br />';

        echo '<b>New Tags Entered:</b>' . $new_tags_string . '<br /><br />';

        echo "<a target='_blank' href='email.php?q=" . $title . "'>" . "Email to Lead Contact" . "</a>";

        require_once('footer.php');


        mysqli_close($dbc);
        exit();
      }  else {
        echo "title already in use";
      } }
    else {
      echo '<p class="error">You must enter all of the Technial Assistance Details.</p>';
      echo "title:" . $title . " tags:" . $tags . " contact:" . $contact_id_entry . "<br />";
    }
    }
?>

<!-- Javascript for dynamic related TA menu "popup" -->
<script type="text/javascript">
function showUser(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getstate.php?q="+str,true);
xmlhttp.send();
}
</script>

<!-- javascript for the Dynamic State Contact -->
<script type="text/javascript">
function showUser(str)
{
if (str=="")
  {
  document.getElementById("state_contact").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("state_contact").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getcontact.php?q="+str,true);
xmlhttp.send();
}
</script>

<!-- FMAP_TA input form -->
<form method="post">
    <label for="state_id">State for TA:</label>
<?php 
//Generate the dropdown list of States
echo '<select id="state_id" name="state_id" onchange="showUser(this.value)">';
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
  <!-- title -->
  <label for="title">Title:</label>
  <input type="text" id="title" name="title" /> <br />

      
  <!-- tags IDs -->

  <?php require_once('tag_include.php'); ?>

  <!-- add new Tags -->
  <p>Please input a comma seperated list for any Tags you would like to add that aren't listed</p>
  <label for="new_tags">New Tags:</label>

  <input type="text" id="new_tags" name="new_tags"><br /><br />

  <!-- Summary -->

  <label for="summary">Summary:</label>

  <textarea name="summary" id="summary" cols="50" rows="10"></textarea><br />

  <!-- Notes -->

  <label for="notes">Internal Notes:</label>

  <textarea name="notes" cols="50" rows="10"></textarea><br />

  <label for="staff_id">Staff performing TA:</label>
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

  <label for="state_contact">State Contact:</label>
    <span id="state_contact">
      <!-- <select id="state_contact_pre"><option>Please Select A State</option></select> -->
    </span>

<br />
<!-- completed/pending -->
<label for="completed">Completed:</label>
<input type="checkbox" name="complete" value="1">Completed <input type="checkbox" name="complete" value="0">Pending<br />

<!-- hours -->
<label for="hours">Hours Taken:</label>
<input type="text" id="hours" name="hours" /> <br />

<!-- completed/pending -->
<label for="follow_up">Follow Up:</label>
<input type="checkbox" name="follow_up" value="follow_up">Yes<br />

<input type="submit" name="submit" value="submit" />
</form>
<br />
<div id="txtHint"></div>

</body>
</html>

<?php
require_once('footer.php');
?>