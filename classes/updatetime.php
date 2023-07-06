<?php
// Assuming you have a database connection established

function updateTaskData($taskID, $timespent, $timeRequired) {
  // Convert timer to seconds
  $timerArr = explode(':', $timespent);
  $timerSeconds = ((int)$timerArr[0] * 3600) + ((int)$timerArr[1] * 60) + (int)$timerArr[2];
  echo $timerSeconds;
  
  // Calculate percentage of time spent
  $percentage = round(($timerSeconds / $timeRequired) * 100,2);
  echo $percentage;
  // Determine status based on timer and time spent
  $status = ($timerSeconds >= $timeRequired) ? 'Done' : 'Doing';
  

  // TODO: Update the 'time_spent', 'timer', 'status' fields in the 'tasks' table for the specified taskID
  include('config.php');
  include('ProjectProgress.php');
    //Check if Task Exists
    $sql = "UPDATE tasks SET time_spent='$percentage' , timer = '$timespent', status = '$status' WHERE task_id = $taskID";
    $result = $conn->query($sql);
  // Return the updated status
  return $status;
}

// Example usage:
$taskID = $_POST['taskID']; // Get the task ID from the frontend
$timer = $_POST['timespent']; // Get the timer value from the frontend
$timeRequired = $_POST['timeRequired']; // Get the time required value from the frontend

$status = updateTaskData($taskID, $timer, $timeRequired);

// Return the updated status to the frontend
echo $status;
?>
