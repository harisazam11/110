<?php

    $project_id = $_GET['pid'];
    include('config.php');
    echo "$project_id";
    
    // sql to delete a record
    $sql = "DELETE FROM Projects WHERE project_id=$project_id";
    $sql1 = "DELETE FROM projectmembers WHERE project_id=$project_id";
    $sql2 = "DELETE FROM tasks WHERE project_id=$project_id";
    

    if ($conn->query($sql) === TRUE) {
        echo "Project deleted successfully";
        if ($conn->query($sql1) === TRUE) {
            echo "projectmembers deleted successfully";
            if ($conn->query($sql2) === TRUE) {
                echo "tasks deleted successfully";
            }
        }
    } else {
        echo "Error deleting record: ";
    }

    $conn->close();
    header("location: ../project.php");

?>