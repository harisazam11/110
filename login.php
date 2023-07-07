<?php
session_start();
include("classes/config.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve input data from the login form
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Query the database to check if the user exists
    $sql = "SELECT * FROM register WHERE username = '$inputUsername'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        // Verify the password
        if ($inputPassword === $storedPassword) {
            // Password is correct, create a session
            $_SESSION['user_id'] = $row['user_id'];

            // Redirect to the user profile page
            header("Location: settings.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Efficiency Monitoring System</title>
  <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div class="login_link">
    Don't have an account? <a href="signup.php"> Sign up</a>
  </div>

  <div class="sign">
    <h3>Log in</h3>
    <hr />

    <form action="" method="POST" class="signup-form">
      <div class="filteration">
        <input type="text" name="username" placeholder="username" class="input" required />
      </div>
      <div class="filteration">
        <input type="password" name="password" placeholder="Password" class="input" required />
      </div>
      <div class="pass"><a href="reset.html">Forget Password?</a></div>
      <div>
        <input type="submit" value="LOG IN" class="create" />
      </div>
    </form>
  </div>
</body>

    