<?php

function updateProjectStatus() {
    include("config.php");
    $sqlp= "select project_id from Projects";
    $res= $conn->query($sqlp);
    if($res->num_rows>0){
        while($r=$res->fetch_assoc()){
            $projectId = $r['project_id'];
        
            // Fetch all tasks for the project
            $sql = "SELECT time_spent FROM tasks WHERE project_id = '$projectId'";
            $result = $conn->query($sql);
        
            $totalTasks = $result->num_rows;
            $completedTasks = 0;
            $totalPercentage = 0;
        
            while ($row = $result->fetch_assoc()) {
            $percentage = $row['time_spent'];
        
            // Check if the task is 100% completed
            if ($percentage == 100) {
                $completedTasks++;
            }
        
            $totalPercentage += $percentage;
            }
        
            // Calculate project completion percentage
            $projectPercentage = $totalTasks > 0 ? round(($totalPercentage / ($totalTasks * 100)) * 100) : 0;
        
            // Update project status
            if ($projectPercentage>=100) {
            $status = 'Done';
            } elseif ($projectPercentage == 0) {
            $status = 'To Do';
            } else {
            $status = 'Doing';
            }
        
            // Update the project's completion percentage and status in the database
            $sql = "UPDATE projects SET percentage = '$projectPercentage', status = '$status' WHERE project_id = '$projectId'";
            $conn->query($sql);
        }
    }
    return $projectPercentage;
  }


  updateProjectStatus() 
?>