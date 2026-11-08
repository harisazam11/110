<?php
session_start();

include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve the form data
  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_p"];

  if ($password !== $confirm_password) {
    echo "Error: Password and confirm password do not match";
    exit;
  } else {

    if (!empty($email) && !empty($password) && !is_numeric($email)) {

      $sql = "select count(*) as c from register where username='$username' or email = '$email'";
      if($conn->query($sql)->fetch_assoc()['c']==0)
      {
            $sql = "INSERT INTO register (firstname, lastname, username, email, password) VALUES ('$firstname', '$lastname', '$username', '$email', '$password')";

            $result = mysqli_query($conn, $sql);
            $_SESSION['user_name'] = $email;
            echo "<script type= 'text/javascript'> alert('Successfully registered')</script>";
            header("location: ../index.php");
            die;
      }
      else{
        echo "<script type= 'text/javascript'> alert('Email or Username already In Use')</script>";
        echo "<script type='text/javascript'>window.location.href = '../signup.php';</script>";
        exit();
       // die;
      }
    } else {
      echo "<script type= 'text/javascript'> alert('Please enter valid values')</script>";
      header("location: ../signup.php");
    }

  }

}
?>