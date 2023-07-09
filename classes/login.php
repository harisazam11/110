<?php
session_start();
include("config.php");

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
          header("location: ../project.php");
          die;
        }
      }
      else{
        echo "<script type= 'text/javascript'> alert('Incorrect username or password');</script>";
        header("location: ../index.php");
      }
    }
    else{
    echo "<script type= 'text/javascript'> alert('Incorrect username or password');</script>";
    header("location: ../index.php");
    }

  } else {
    echo "<script type= 'text/javascript'> alert('Incorrect username or password');</script>";
    header("location: ../index.php");
  }
}
?>
