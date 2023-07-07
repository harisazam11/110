<?php
// Assuming you have established the database connection
include('config.php');
if(isset($_GET['project_id'])) {
    $projectId = $_GET['project_id'];
if($projectId!=-1){
    // Retrieve project details
    $projectQuery = "SELECT  p.percentage FROM projects p
                    WHERE p.project_id = '$projectId'";
    $projectResult = mysqli_query($conn, $projectQuery);
    $projectData = mysqli_fetch_assoc($projectResult);


    // Construct the HTML output
    $output ='<div class="ui-widgets">
    <div class="ui-values">'.$projectData['percentage'].'%</div>
    <div class="ui-labels">Percentage</div>
       </div>'; 
    echo $output;
}
else{
    session_start();
     // Retrieve task counts and total percentage for the current user
     $userId = $_SESSION['user_id'];

     // Retrieve task counts where project_id is NULL and assigned_to column matches the current user
     $taskCountQuery = "SELECT COUNT(*) AS totalTasks FROM tasks WHERE project_id IS NULL AND assigned_to = $userId";
     $taskCountResult = mysqli_query($conn, $taskCountQuery);
     $taskCountData = mysqli_fetch_assoc($taskCountResult);
     $totalTasks = $taskCountData['totalTasks'];

     // Retrieve total time spent on tasks for the current user
     $timeSpentQuery = "SELECT SUM(time_spent) AS totalTimeSpent FROM tasks WHERE project_id IS NULL AND assigned_to = $userId";
     $timeSpentResult = mysqli_query($conn, $timeSpentQuery);
     $timeSpentData = mysqli_fetch_assoc($timeSpentResult);
     $totalTimeSpent = $timeSpentData['totalTimeSpent'];
     
     // Calculate the total percentage
     $totalPercentage = ($totalTimeSpent / $totalTasks);

     // Construct the HTML output
    $output ='<div class="ui-widgets">
    <div class="ui-values">'.$totalPercentage.'%</div>
    <div class="ui-labels">Percentage</div>
       </div>'; 
    echo $output;
}
}

// Close the database connection
mysqli_close($conn);
?>
