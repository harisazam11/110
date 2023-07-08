<?php

session_start();

include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve the form data
  $task_id = $_POST["taskId"];
  $user_id = $_SESSION["user_id"];
  //fetch project id and then fetch project details from that id to get created_by field to see if this is the owner of the project whose task currently active is
  $sql = "select * from tasks where task_id = $task_id limit 1";
  $result = $conn->query($sql);
  $project_id = $result->fetch_assoc()['project_id'];

  $sql = "select * from projects where project_id = '$project_id'";
  $result = $conn->query($sql);
  $proj_created_by = $result->fetch_assoc()['created_by'];
  $sql = "delete from tasks where task_id = '$task_id' and (project_id is NULL or assigned_to = '$proj_created_by');";
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