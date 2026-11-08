
<!DOCTYPE html>
<?php
session_start();
include("classes/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $email = $_POST["email"];
  $password = $_POST["password"];

  if (!empty($email) && !empty($password) && !is_numeric($email)) {

    $query = "select * from register  where email = '$email' limit 1";
    $result = mysqli_query($conn, $query);

    if ($result) {

      if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);

        if ($user_data['password'] == $password) {
            $_SESSION['user_name'] = $email;
			      $_SESSION['user_id'] = $user_data['user_id'];
         //   echo "<script type= 'text/javascript'> alert(".$_SESSION['user_id'].")</script>";
          header("location: project.php");
          die;
        }
      }
      else{
        echo "<script type= 'text/javascript'> alert('Incorrect username or password');</script>";
       // header("location: ../index.php");
      }
    }
    else{
    echo "<script type= 'text/javascript'> alert('Incorrect username or password');</script>";
  //  header("location: ../index.php");
    }

  } else {
    echo "<script type= 'text/javascript'> alert('Incorrect username or password');</script>";
  //  header("location: ../index.php");
  }
}
?>

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
        <input type="text" name="email" placeholder="Email" class="input" required />
      </div>
      <div class="filteration">
        <input type="password" name="password" placeholder="Password" class="input" required />
      </div>
      <div>
        <input type="submit" value="LOG IN" class="create" />
      </div>
    </form>
  </div>
</body>

</html>