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
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
    $address1 = mysqli_real_escape_string($dbc, trim($_POST['address1']));
    $address2 = mysqli_real_escape_string($dbc, trim($_POST['address2']));
    $mailing_state = mysqli_real_escape_string($dbc, trim($_POST['mailing_state']));
    $state_id = mysqli_real_escape_string($dbc, trim($_POST['state_id']));
    $lead_contact = mysqli_real_escape_string($dbc, trim($_POST['lead_contact']));


    if (!empty($first_name) && !empty($last_name) && !empty($email)) {
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM FMAP_contact WHERE email = '$email'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO FMAP_contact ( created_date, first_name, last_name, email, phone, address1, address2, mailing_state, state_id, lead_contact) VALUES ( NOW(), '$first_name', '$last_name', '$email', '$phone', '$address1', '$address2', '$mailing_state', '$state_id', '$lead_contact')";

        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>New Contact has been added with the following details.</p>';
        echo 'Name:' . $first_name . ' ' .$last_name . '  Email: ' . $email . ' state id:' . $state_id ;

        require_once('footer.php');

        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
        echo '<p class="error">An account already exists for this email, ' . '$email' . '. Please use a different address.</p>';
        $username = "";
      }
    }
    else {
      echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
    }
  }


?>

  <p>Please enter contact details</p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Registration Info</legend>
      <label for="first_name">First Name:</label>
      <input type="text" id="first_name" name="first_name" value="<?php if (!empty($first_name)) echo $first_name; ?>" /><br />
      <label for="last_name">Last Name:</label>
      <input type="text" id="last_name" name="last_name" value="<?php if (!empty($last_name)) echo $last_name; ?>" /><br />
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>" /><br />
      <label for="phone">Phone:</label>
      <input type="text" id="phone" name="phone" value="<?php if (!empty($phone)) echo $phone; ?>" /><br />
      <label for="address1">Address One:</label>
      <input type="text" id="address1" name="address1" value="<?php if (!empty($address1)) echo $address1; ?>" /><br />
      <label for="address2">Address Two:</label>
      <input type="text" id="address2" name="address2" value="<?php if (!empty($address2)) echo $address2; ?>" /><br />
<label for="mailing_state">Mailing State:</label>
<?php 
//Dropdown for mailing states
//Gnerate the dropdown lists
echo '<select id="mailing_state" name="mailing_state">';
 // Retrieve the state data from MySQL
  $query = "SELECT name, short_name, state_id FROM FMAP_state";
  $result = mysqli_query($dbc, $query);


  while ($row = mysqli_fetch_array($result)) {
    // generate the select list
    $state_name = $row['name'];
    $state_abr = $row['short_name'];
    $state_id = $row['state_id'];
  
    echo '<option value="' . $state_abr . '">' . $state_abr . '</option>';

  }

echo '</select>';
?>
<br />
<label for="ta_state">State For TA:</label>
  <?php 
//Dropdown for states
//Gnerate the dropdown lists
echo '<select id="state_id" name="state_id">';
 // Retrieve the state data from MySQL
  $query = "SELECT name, short_name, state_id FROM FMAP_state";
  $result = mysqli_query($dbc, $query);


  while ($row = mysqli_fetch_array($result)) {
    // generate the select list
    $state_name = $row['name'];
    $state_abr = $row['short_name'];
    $state_id = $row['state_id'];
  
    echo '<option value="' . $state_id .'">' . $state_name . '</option>';

  }

echo '</select>';
?>
<br />
      <label for="lead_contact">Lead Contact:</label><br />
      <input type="radio" name="lead_contact" value="1" /> Yes<br />
      <input type="radio" name="lead_contact" value="0" /> No<br />
    </fieldset>
    <input type="submit" value="Sign Up" name="submit" />

  </form>

<?php
  // Close the connection to the Database
    mysqli_close($dbc);
  // Insert the page footer
  require_once('footer.php');
?>
