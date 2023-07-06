<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    session_start();
    $taskid = $_POST['utid'];
    $deadline = $_POST['utime'] * 3600;
    $task_name = $_POST['ulabel'];
    include('config.php');
    include('ProjectProgress.php');
    //Check if Task Exists
    $sql = "Select * from tasks where task_name = '".$task_name."' and task_id =$taskid";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        //re calculate percentage and status
        $row = $result->fetch_assoc();
        $timespent = $row['timer'];
        $timerArr = explode(':', $timespent);
        $timerSeconds = ((int)$timerArr[0] * 3600) + ((int)$timerArr[1] * 60) + (int)$timerArr[2];
        
        // Calculate percentage of time spent
        $percentage = round(($timerSeconds / $deadline) * 100,2);
        echo $percentage;
        // Determine status based on timer and time spent
        $status = ($timerSeconds >= $deadline) ? 'Done' : 'Doing';
  
        //if task exists then update due_time of the task.
        $sql = "update tasks set time_spent = '$percentage', status = '$status' ,time_required = '$deadline' where task_name = '".$task_name."' and task_id =$taskid";
        $result = $conn->query($sql); 
        header("location: ../time_tracker.php");
    }
   
}


?>