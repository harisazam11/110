<?php

session_start();

include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve the form data
  $task_id = $_POST["taskId"];
  $user_id = $_SESSION["user_id"];
  $sql = "delete from tasks where task_id = $task_id and project_id is NULL;";
      $result = $conn->query($sql);
      if($result)
      {echo "<script type= 'text/javascript'> alert('Successfully registered')</script>";
      header("location: ../time_tracker.php");
      die;
      }
     else {
      echo "<script type= 'text/javascript'> alert('You Cannot Delete this Task')</script>";

    }

}

?>