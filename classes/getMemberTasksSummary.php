<?php
// Assuming you have established the database connection
include('config.php');
if(isset($_GET['project_id'])) {
    $projectId = $_GET['project_id'];
if(isset($_GET['member_id'])) 
    $member_id = $_GET['member_id'];
if($projectId!=-1){
    // Retrieve project details
    $projectQuery = "SELECT  SUM(CAST(time_spent AS DECIMAL(10,2)))/Count(*) as Percent,
                            COUNT(*) as totalTasks,
                            COUNT(CASE WHEN status = 'Done' THEN 1 END) AS totalCompletedTasks,
                            COUNT(CASE WHEN status != 'Done' AND due_date < CURDATE() THEN 1 END) AS totalLateTasks,
                            COUNT(CASE WHEN status = 'To Do' AND due_date >= CURDATE() THEN 1 END) AS totalPendingTasks,
                            COUNT(CASE WHEN status = 'Doing' AND due_date >= CURDATE() THEN 1 END) AS totalOnGoingTasks
                    From tasks 
                    WHERE project_id = '$projectId' and assigned_to = '$member_id'";
    $projectResult = mysqli_query($conn, $projectQuery);
    $projectData = mysqli_fetch_assoc($projectResult);

    // Construct the HTML output
    
    //$output = '<td style="margin-left:30px;"><b>Project Name:</b> ' . $projectData['project_name'] . '</td>';
    $output = '<table><tr>';
    $output .= '<td style="margin-left:30px;"><b>Percentage:</b> ' . $projectData['Percent'] . '%</td>';
    $output .= '<td style="margin-left:30px;"><b>Total Tasks:</b> ' . $projectData['totalTasks'] . '</td>';
    $output .= '</tr><tr><td style="margin-left:30px;"><b>Total Completed Tasks:</b> ' . $projectData['totalCompletedTasks'] . '</td>';
    $output .= '<td style="margin-left:30px;"><b>Total Late Tasks:</b> ' . $projectData['totalLateTasks'] . '</td>';
    $output .= '</tr><tr><td style="margin-left:30px;"><b>Total Pending Tasks:</b> ' . $projectData['totalPendingTasks'] . '</td>';
    $output .= '<td style="margin-left:30px;"><b>Total Ongoing Tasks:</b> ' . $projectData['totalOnGoingTasks'] . '</td>';
    $output .= '</tr></table>';
    echo $output;
}
else{
    session_start();
     // Retrieve task counts and total percentage for the current user
    
    echo '';
}
}

// Close the database connection
mysqli_close($conn);
?>
