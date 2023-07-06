<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    session_start();
    $task = $_POST['task'];
    $deadline = $_POST['due_Time'] * 3600;
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    include('config.php');
    include('ProjectProgress.php');
    $project_id=0;
    //Check if Task Exists
    $sql = "Select * from tasks where task_name = '".$task."' and assigned_to = '".$user_id."'";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        $project_id=$result->fetch_assoc()['project_id'];
        //if task exists then update due_time of the task.
        $sql = "update tasks set time_required = '".$deadline."' where task_name = '".$task."' and assigned_to = $user_id";
        $result = $conn->query($sql);

    }
    else{

        //else i need to insert this task as Independent task
        $sql = "INSERT INTO tasks (task_name, assigned_to,user_email,status, time_required, time_spent,timer)
        VALUES ('$task', '$user_id','$user_name', 'To Do','$deadline','0','00:00:00')";
        $result = $conn->query($sql);
        if ($result) {
        // Get the project ID assigned to the newly inserted row
        $projectId = $conn->insert_id;
        }

    }
    header("location: ../time_tracker.php");
}


?>