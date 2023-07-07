<?php
// Assuming you have established the database connection
include('config.php');
if(isset($_GET['project_id'])) {
    $projectId = $_GET['project_id'];
if($projectId!=-1){
    // Retrieve project details
    $projectQuery = "SELECT p.project_name, p.created_by, p.percentage, p.team, p.deadline, 
                            COUNT(*) as totalTasks,
                            COUNT(CASE WHEN t.status = 'Done' THEN 1 END) AS totalCompletedTasks,
                            COUNT(CASE WHEN t.status != 'Done' AND t.due_date < CURDATE() THEN 1 END) AS totalLateTasks,
                            COUNT(CASE WHEN t.status = 'To Do' AND t.due_date > CURDATE() THEN 1 END) AS totalPendingTasks,
                            COUNT(CASE WHEN t.status = 'Doing' AND t.due_date > CURDATE() THEN 1 END) AS totalOnGoingTasks
                    FROM projects p
                    LEFT JOIN tasks t ON p.project_id = t.project_id
                    WHERE p.project_id = '$projectId'";
    $projectResult = mysqli_query($conn, $projectQuery);
    $projectData = mysqli_fetch_assoc($projectResult);

    // Retrieve project manager's name
    $managerQuery = "SELECT CONCAT(u.firstName, ' ', u.lastName) AS managerName
                    FROM register u
                    WHERE u.user_id = '{$projectData['created_by']}'";
    $managerResult = mysqli_query($conn, $managerQuery);
    $managerData = mysqli_fetch_assoc($managerResult);

    // Construct the HTML output
    
    //$output = '<td style="margin-left:30px;"><b>Project Name:</b> ' . $projectData['project_name'] . '</td>';
    $output = '<table><tr><td style="margin-left:30px;"><b>Manager:</b> ' . $managerData['managerName'] . '</td>';
    $output .= '<td style="margin-left:30px;"><b>Project Percentage:</b> ' . $projectData['percentage'] . '%</td>';
    $output .= '<td style="margin-left:30px;"><b>Total Users:</b> ' . $projectData['team']+1 . '</td>';
    $output .= '</tr><tr><td style="margin-left:30px;"><b>Total Tasks:</b> ' . ($projectData['totalTasks'] ).'</td>';
    $output .= '<td style="margin-left:30px;"><b>Deadline:</b> ' . $projectData['deadline'] . '</td>';
    $output .= '<td style="margin-left:30px;"><b>Total Completed Tasks:</b> ' . $projectData['totalCompletedTasks'] . '</td>';
    $output .= '</tr><tr><td style="margin-left:30px;"><b>Total Late Tasks:</b> ' . $projectData['totalLateTasks'] . '</td>';
    $output .= '<td style="margin-left:30px;"><b>Total Pending Tasks:</b> ' . $projectData['totalPendingTasks'] . '</td>';
    $output .= '<td style="margin-left:30px;"><b>Total Ongoing Tasks:</b> ' . $projectData['totalOnGoingTasks'] . '</td>';
    $output .= '</tr></table>';
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
     

     $taskCountQuery = "SELECT COUNT(*) AS pendingTasks FROM tasks WHERE project_id IS NULL AND assigned_to = $userId and status='To Do'";
     $taskCountResult = mysqli_query($conn, $taskCountQuery);
     $taskCountData = mysqli_fetch_assoc($taskCountResult);
     $totalPendingTasks = $taskCountData['pendingTasks'];


     $taskCountQuery = "SELECT COUNT(*) AS ongoingTasks FROM tasks WHERE project_id IS NULL AND assigned_to = $userId and status = 'Doing'";
     $taskCountResult = mysqli_query($conn, $taskCountQuery);
     $taskCountData = mysqli_fetch_assoc($taskCountResult);
     $totalOngoingTasks = $taskCountData['ongoingTasks'];


     $taskCountQuery = "SELECT COUNT(*) AS doneTasks FROM tasks WHERE project_id IS NULL AND assigned_to = $userId and status = 'Done'";
     $taskCountResult = mysqli_query($conn, $taskCountQuery);
     $taskCountData = mysqli_fetch_assoc($taskCountResult);
     $totaldoneTasks = $taskCountData['doneTasks'];

     // Calculate the total percentage
     $totalPercentage = ($totalTimeSpent / $totalTasks);

     // Construct the HTML output
   
    $output = '<table><tr><td style="margin-left:30px;"><b>Total Percentage:</b> ' . $totalPercentage. '%</td>';
    $output .= '<td style="margin-left:30px;"><b>Total Tasks:</b> ' . $totalTasks . '</td>';
    $output .= '<td style="margin-left:30px;"><b>Total Completed Tasks:</b> ' .  $totaldoneTasks. '</td>';
    $output .= '</tr><tr><td style="margin-left:30px;"><b>Total ongoing Tasks:</b> ' . $totalOngoingTasks . '</td>';
    $output .= '<td style="margin-left:30px;"><b>Total Pending Tasks:</b> ' . $totalPendingTasks . '</td>';
    $output .= '</tr></table>';
    echo $output;
}
}

// Close the database connection
mysqli_close($conn);
?>
