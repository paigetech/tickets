<?php

        $result = mysqli_query($dbc, $query);

        $array = array();

        foreach ($array as $value){
          echo $value . " ";
        }

        while ($row = mysqli_fetch_array($result)) {
       // set the variables from the result
          $ta_id = $row['ta_id'];
          $created_date = $row['created_date'];
          $last_edit = $row['last_edit'];
          $title = $row['title'];
          //create the tag array from the Tag field of the TA table 
          $tags = explode(',' , $row['tags']);
          $notes = $row['notes'];
          $staff_id = $row['staff_id'];
          $contact_id = $row['contact_id'];
          $state_id = $row['state_id'];

          echo '<div id="border">';
          
          //create the title as a clickable link
          echo "<h2><a target='_blank' href='single_entry.php?q=" . $row['ta_id'] . "'>" . $title . "</a></h2>";
  
          echo '<h3>Created: ' . $created_date . '</h3><br />';
          echo '<h3>Last Edited: ' . $last_edit . '</h3><br />';

          echo '<h3>Tags:</h3> ';
          foreach ($tags as $key => $value) {
            echo $tag_array[$value];
          }
          echo '<br />';
          
          echo '<h3>Notes:</h3><p>' . $notes . '</p>';
          echo '<h3>Staff:</h3> ' . $staff_array[$staff_id] . '<br />';
          echo '<h3>State Contact:</h3> ' . $contact_array[$contact_id] . '<br />';
          echo '<h3>State:</h3> ' . $state_array[$state_id] . '<br />';
          echo '</div>';

          //push tags onto the tag array

          array_push($array, $tags);

        }
        ?>