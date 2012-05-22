<?php
  // Insert the page header
  $page_title = 'Sign Up';
  require_once('header.php');
  require_once('navmenu.php');
  require_once('appvars.php');
  require_once('includes/connectvars.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $tagAutoComplete = mysqli_real_escape_string($dbc, trim($_POST['tagAutoComplete']));



    if (!empty($tagAutoComplete)) {

        // The username is unique, so insert the data into the database
        $query = "INSERT INTO FMAP_test (name) VALUES ( '$tagAutoComplete')";

        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>Tag has been added. '. $tagAutoComplete . '</p>';

        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
        echo '<p class="error">error' . $tagAutoComplete . '</p>';
        $username = "";
      }

  }


?>

  <p>Please enter contact details</p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Registration Info</legend>
					<div id="tags" class="ui-helper-clearfix">
						<input id="tagAutoComplete" name="tagAutoComplete"  type="text">
					</div>
    </fieldset>
    <input type="submit" value="Sign Up" name="submit" />

  </form>

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
					
					//define select handler - this is where the clearing out is coming from
					//change: function() {
						
						//prevent 'to' field being updated and correct position
						//$("#tagAutoComplete").val("").css("top", 2);
					//}
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

<?php
  // Close the connection to the Database
    mysqli_close($dbc);
  // Insert the page footer
  require_once('footer.php');
?>
