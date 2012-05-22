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

					  
					    echo '<input type="checkbox" name="tags[]" id="' . $tag_id . '" value="' . $tag_id . '" >' . $tag_name . '</option>';

					  }
					  echo '</div>';


				?><br />