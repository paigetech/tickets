
<?php

 // Connect to the database 
 $dbc2 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

//create the translation Array for State Names
$query = "SELECT state_id, name FROM FMAP_state";
$result = mysqli_query($dbc2, $query);
$state_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $state_array[$row['state_id']] = $row['name'];
}

//create the translation Array for contacts
$query = "SELECT contact_id, first_name, last_name FROM FMAP_contact";
$result = mysqli_query($dbc2, $query);
$contact_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $contact_array[$row['contact_id']] = $row['first_name'] . ' ' . $row['last_name'];
}

//create the translation Array for Staff
$query = "SELECT user_id, first_name, last_name FROM FMAP_staff";
$result = mysqli_query($dbc2, $query);
$staff_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $staff_array[$row['user_id']] = $row['first_name'] . ' ' . $row['last_name'];
}

//create the translation Array for Tag Names
$query = "SELECT name, tag_id FROM FMAP_tags";
$result = mysqli_query($dbc2, $query);
$tag_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $tag_array[$row['tag_id']] = $row['name'];
}

//echo var_dump($state_array);

?>