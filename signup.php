<?php
  // Insert the page header
  $page_title = 'Sign Up';
  require_once('header.php');

  //Insert the Navigation
  require_once('navmenu.php');


  require_once('appvars.php');
  require_once('includes/connectvars.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $level = mysqli_real_escape_string($dbc, trim($_POST['level']));


    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM FMAP_staff WHERE username = '$username'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO FMAP_staff (username, password, join_date, first_name, last_name, email, level) VALUES ('$username', SHA1('$password1'), NOW(), '$first_name', '$last_name', '$email', '$level')";
        mysqli_query($dbc, $query);

        // Confirm success with the user
        require_once('header.php');
        require_once('navmenu.php');

        echo '<p>Your new account has been successfully created.</p>';
        echo '<p>The following User has been entered.<p>';
        echo '<p><b> Username: </b>' . $username . '</p>';
        echo '<p><b> Full Name: </b>' . $first_name . ' ' . $last_name . '</p>';
        echo '<p><b> Email: </b>' . $email . '</p>';




        require_once('footer.php');


        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
        echo '<p class="error">An account already exists for this username. Please use a different address.</p>';
        $username = "";
      }
    }
    else {
      echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p><br />';
      echo $username . "   " . $password1  . "   " . $password2;
    }
  }

  mysqli_close($dbc);
?>

  <p>Please enter your username, details and desired password</p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Registration Info</legend>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
      <label for="password1">Password:</label>
      <input type="password" id="password1" name="password1" /><br />
      <label for="password2">Password (retype):</label>
      <input type="password" id="password2" name="password2" /><br />
      <label for="first_name">First Name:</label>
      <input type="text" id="first_name" name="first_name" value="<?php if (!empty($first_name)) echo $first_name; ?>" /><br />
      <label for="last_name">Last Name:</label>
      <input type="text" id="last_name" name="last_name" value="<?php if (!empty($last_name)) echo $last_name; ?>" /><br />
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>" /><br />
      <label for="level">Level:</label>
      <input type="text" id="level" name"level" value="3" /><br />
    </fieldset>
    <input type="submit" value="Sign Up" name="submit" />
  </form>

<?php
  // Insert the page footer
  require_once('footer.php');
?>
