<?php
$q=$_GET["q"];

  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'FMAP';
  require_once('header.php');

  require_once('appvars.php');
  require_once('connectvars.php');

  // Show the navigation menu
  require_once('navmenu.php');



  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
        
  //include the refrence arrays (must be included after the $dbc)
  require_once('arrays.php');

 // Retrieve the TA data from MySQL
  $query = "SELECT * FROM FMAP_TA WHERE ta_id = '".$q."'";
  $result = mysqli_query($dbc, $query);


  while ($row = mysqli_fetch_array($result)) { 

    //define the default values for the edit
        $edit_title = $row['title'];

        $edit_notes = $row['notes'];
        $edit_staff_id = $row['staff_id'];
        $edit_contact_id = $row['contact_id'];
        $edit_state_id = $row['state_id'];
        $edit_summary = $row['summary'];
        $edit_completed = $row['completed'];
        $edit_hours = $row['hours'];
        $edit_follow_up= $row['follow_up'];
        $edit_related_ta = $row['related_ta'];

        $edit_tags_array = explode(',' , $row['tags']);

        $last_edit = $row['last_edit'];

  }

//inserting the new edits
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

    //do some form checking
    if (!empty($title) && !empty($tags) && !empty($contact_id_entry)) {

        // insert the new data for the ta_id
        $query = "INSERT INTO FMAP_TA ( last_edit, title, tags, notes, staff_id, contact_id, state_id, summary, completed, hours, follow_up, relatedTA) VALUES ( NOW(), '$title', '$tags', '$notes', '$staff_id', '$contact_id_entry', '$state_id', '$summary', '$completed', '$hours', '$follow_up', '$related_array') WHERE ta_id = '".$q."'";


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
        echo '<b>Tags: </b>' . $tags . '<br /><br />';
        echo '<b>Notes: </b><blockquote>' . $notes . '<br /></blockquote>';
        echo '<b>Staff ID: </b>' . $staff_array[$staff_id] . '<br /><br />';
        echo '<b>contact ID: </b>' . $contact_array[$contact_id_entry] . '<br /><br />';
        echo '<b>State ID: </b>' . $state_array[$state_id] . '<br /><br />';

        echo '<b>New Tags Entered:</b>' . $new_tags_string . '<br /><br />';

        echo '<b>Related TA IDs:</b>' . $related_array . '<br /><br />';

        echo "<a target='_blank' href='email.php?q=" . $title . "'>" . "Email to Lead Contact" . "</a>";

        require_once('footer.php');


        mysqli_close($dbc);
        exit();
      }  
    else {
      echo '<p class="error">You must enter all of the Technial Assistance Details.</p>';
      echo $title . " " . $tags . " " . $contact_id_entry;
    }}

?>



<script type="text/javascript">
function showUser(str)
{
if (str=="")
  {
  document.getElementById("relatedTA").innerHTML="";
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
    document.getElementById("relatedTA").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getstate.php?q="+str,true);
xmlhttp.send();
}
</script>


<!-- FMAP_TA input form -->
<form method="post">
    <label for="state_id">State for TA:</label>
<?php 
//Generate the dropdown lists
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
  <input type="text" id="title" name="title" value='<?php echo $edit_title; ?>' /> <br />

      
  <!-- tags IDs -->

<?php 
          //Selection for Tags
           // Retrieve the tag data from MySQL
            $query = "SELECT * FROM FMAP_tags";
            $result = mysqli_query($dbc, $query);

            echo '<label for="tags">Tags:</label>';
            echo '<div id="tags">';

            while ($row = mysqli_fetch_array($result)) {
              // generate the select list
              $tag_id = $row['tag_id'];
              $tag_name = $row['name'];

              if (in_array($tag_id, $edit_tags_array)) {
                echo '<input type="checkbox" name="tags[]" id="' . $tag_id . '" value="' . $tag_id . '" checked="checked" >' . $tag_name . '</option>';
              }
            else{
              echo '<input type="checkbox" name="tags[]" id="' . $tag_id . '" value="' . $tag_id . '" >' . $tag_name . '</option>';
            } 
            }
            echo '</div>';

?>

  <!-- add new Tags -->
  <p>Please input a comma seperated list for any Tags you would like to add that aren't listed</p>
  <label for="new_tags">New Tags:</label>

  <input type="text" id="new_tags" name="new_tags"><br /><br />

  <!-- Summary -->

  <label for="summary">Summary:</label>

  <textarea name="summary" id="summary" cols="50" rows="10"><?php echo $edit_summary; ?></textarea><br />

  <!-- Notes -->

  <label for="notes">Internal Notes:</label>

  <textarea name="notes" cols="50" rows="10"><?php echo $edit_notes; ?></textarea><br />

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

    if($edit_staff_id = $staff_id){
      echo '<option value="' . $staff_id . '" selected="selected">' . $first_name . ' ' . $last_name . '</option>';
    } else {
    echo '<option value="' . $staff_id . '">' . $first_name . ' ' . $last_name . '</option>';
  }
  }

echo '</select>';
?>

<br />

  <label for="state_contact">State Contact:</label>
 <?php 
//Dropdown for staff_id
//Generate the dropdown lists
echo '<select id="contact_id_entry" name="contact_id_entry">';
echo '<option value="">Select Contact</a>';
 // Retrieve the state data from MySQL
  $query = "SELECT first_name, last_name, contact_id FROM FMAP_contact";
  $result = mysqli_query($dbc, $query);


  while ($row = mysqli_fetch_array($result)) {
    // generate the select list
    $contact_first_name = $row['first_name'];
    $contact_last_name = $row['last_name'];
    $contact_id = $row['contact_id'];
  
    if($edit_contact_id = $contact_id){
      echo '<option value="' . $contact_id . '" selected="selected">' . $contact_first_name . ' ' . $contact_last_name . ' ' . $contact_id . '</option>';
    } else {
      echo '<option value="' . $contact_id . '">' . $contact_first_name . ' ' . $contact_last_name . ' ' . $contact_id . '</option>';
    }

  }

echo '</select>';
?>

<br />
<!-- completed/pending -->
<label for="completed">Completed:</label>
<?php
if ($edit_completed = 0) {
  echo '<input type="checkbox" name="complete" value="1" checked="checked">Completed <br />';
} else {
  echo '<input type="checkbox" name="complete" value="1">Completed <br />';
}

?>
<!-- hours -->
<label for="hours">Hours Taken:</label>
<input type="text" id="hours" name="hours" value=<?php echo $edit_hours; ?>> <br />

<!-- completed/pending -->
<label for="follow_up">Follow Up:</label>
<?php
 if ($edit_follow_up = 1) {
   echo '<input type="checkbox" name="follow_up" value="1" checked="checked" >Yes<br />';
 } else {
 echo '<input type="checkbox" name="follow_up" value="1">Yes<br />';
}
?>
<div id="relatedTA"></div>
<input type="submit" name="submit" value="submit" />
</form>

<?php
require_once('footer.php');
?>