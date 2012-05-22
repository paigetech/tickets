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

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
    $tags = mysqli_real_escape_string($dbc, trim($_POST['tags']));
    $notes = mysqli_real_escape_string($dbc, trim($_POST['notes']));
    $staff_id = mysqli_real_escape_string($dbc, trim($_POST['staff_id']));
    $contact_id = mysqli_real_escape_string($dbc, trim($_POST['contact_id']));
    $state_id = mysqli_real_escape_string($dbc, trim($_POST['state_id']));



    if (!empty($title) && !empty($tags) && !empty($contact_id)) {
      // Make sure a TA with the same title isn't already in the DB
      $query = "SELECT * FROM FMAP_TA WHERE title = '$title'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO FMAP_TA ( created_date, title, tags, notes, staff_id, contact_id, state_id) VALUES ( NOW(), '$title', '$tags', '$notes', '$staff_id', '$contact_id', '$state_id')";

        mysqli_query($dbc, $query);

        // Confirm success with the user

        require_once('header.php');
        require_once('navmenu.php');

        echo '<p>Technical Assistance has been added to the Database with the following details.</p>';
        echo 'Title: ' . $title . '<br />';
        echo 'Tags: ' . $tags . '<br />';
        echo 'Notes: ' . $notes . '<br />';
        echo 'Staff ID' . $staff_id . '<br />';
        echo 'contact ID' . $contact_id . '<br />';
        echo 'State ID' . $state_id . '<br />';

        require_once('footer.php');

        mysqli_close($dbc);
        exit();
      }
    }
    else {
      echo '<p class="error">You must enter all of the Technial Assistance Details.</p>';
    }
  }

?>
<div id="container">
		<div id="formWrap">
			<form id="Form" action="#" method="post">
				<fieldset>
					<legend>New TA Form</legend>
					<span>New TA</span>

					<label for="title">Title:</label>
					<input type="text" id="title" name="title">

					<!-- Tag Auto Complete Section -->
					<label id="tagLabel">Tag:</label>
					<div id="tags" class="ui-helper-clearfix">
						<input id="tagAutoComplete" type="text">
					</div>

					<label for="notes">Notes:</label>
					<textarea id="notes" name="notes" rows="5" cols="50"></textarea>

					<label for="contact_id">Contact:</label>
						<?php 
							//Dropdown for contact
							//Gnerate the dropdown lists
							echo '<select id="contact_id" class="dropdown">';
							 // Retrieve the state data from MySQL
							  $query = "SELECT first_name, last_name, contact_id FROM FMAP_contact";
							  $result = mysqli_query($dbc, $query);


							  while ($row = mysqli_fetch_array($result)) {
							    // generate the select list
							    $contact_first_name = $row['first_name'];
							    $contact_last_name = $row['last_name'];
							    $contact_id = $row['contact_id'];
							  
							    echo '<option value="$contact_id">' . $contact_first_name . ' ' . $contact_last_name . '</option>';

							  }

							echo '</select>';
						?>

						<label for="staff_id">Staff:</label>
						  <?php 
								//Dropdown for staff_id
								//Gnerate the dropdown lists
								echo '<select id="staff_id" class="dropdown">';
								 // Retrieve the state data from MySQL
								  $query = "SELECT first_name, last_name, user_id FROM FMAP_staff";
								  $result = mysqli_query($dbc, $query);


								  while ($row = mysqli_fetch_array($result)) {
								    // generate the select list
								    $first_name = $row['first_name'];
								    $last_name = $row['last_name'];
								    $staff_id = $row['staff_id'];
								  
								    echo '<option value="$staff_id">' . $first_name . ' ' . $last_name . '</option>';

								  }

								echo '</select>';
							?>

							<label for="state_id">State:</label>
							  <?php 
									//Dropdown for states
									//Gnerate the dropdown lists
									echo '<select id="state_id" class="dropdown">';
									 // Retrieve the state data from MySQL
									  $query = "SELECT name, short_name FROM FMAP_state";
									  $result = mysqli_query($dbc, $query);


									  while ($row = mysqli_fetch_array($result)) {
									    // generate the select list
									    $state_name = $row['name'];
									    $state_abr = $row['short_name'];
									  
									    echo '<option value="$state_abr">' . $state_name . '</option>';

									  }

									echo '</select>';
								?>


							<input type="submit" name="submit" value="submit" />

				</fieldset>
			</form>
		</div>
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){
				
				//attach autocomplete
				$("#tagAutoComplete").autocomplete({
					
					//define callback to format results
					source: function(req, add){
					
						//pass request to server
						$.getJSON("tags.php?callback=?", req, function(data) {
							
							//create array for response objects
							var suggestions = [];
							
							//process response
							$.each(data, function(i, val){								
								suggestions.push(val.name);
							});
							
							//pass array to callback
							add(suggestions);
						});
					},
					
					//define select handler
					select: function(e, ui) {
						
						//create formatted friend
						var friend = ui.item.value,
							span = $("<span id='selectedTag'>").text(friend),
							a = $("<a>").addClass("remove").attr({
								href: "javascript:",
								title: "Remove " + friend
							}).text("x").appendTo(span);
						
						//add friend to friend div
						span.insertBefore("#tagAutoComplete");
					},
					
					//define select handler
					change: function() {
						
						//prevent 'to' field being updated and correct position
						$("#tagAutoComplete").val("").css("top", 2);
					}
				});
				
				//add click handler to tags div
				$("#tags").click(function(){
					
					//focus 'to' field
					$("#tagAutoComplete").focus();
				});
				
				//add live handler for clicks on remove links
				$(".remove", document.getElementById("tags")).live("click", function(){
				
					//remove current friend
					$(this).parent().remove();
					
					//correct 'to' field position
					if($("#tags span").length === 0) {
						$("#tagAutoComplete").css("top", 0);
					}				
				});				
			});
		</script>
</div>
<?php
  // Insert the page footer
  require_once('footer.php');
?>