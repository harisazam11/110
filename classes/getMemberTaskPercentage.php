<?php
// Assuming you have established the database connection
include('config.php');
if(isset($_GET['project_id'])) {
    $projectId = $_GET['project_id'];
    if(isset($_GET['member_id'])) 
        $memberId = $_GET['member_id'];
if($projectId!=-1){
    // Retrieve project details
    $projectQuery = "SELECT  SUM(CAST(time_spent AS DECIMAL(10,2)))/Count(*) as percent FROM tasks
                    WHERE project_id = '$projectId' and assigned_to = '$memberId'";
    $projectResult = mysqli_query($conn, $projectQuery);
    $projectData = mysqli_fetch_assoc($projectResult);


    // Construct the HTML output
    $output ='<div class="ui-widgets">
    <div class="ui-values" style="margin-top:40px;">'.round($projectData['percent'],2).'%</div>
    <div class="ui-labels">Percentage</div>
       </div>'; 
    echo $output;
}
else{
    
    echo '';
}
}

// Close the database connection
mysqli_close($conn);
?>
