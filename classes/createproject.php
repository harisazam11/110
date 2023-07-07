<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $projectName = $_POST['projectName'];
    $teamMembers = $_POST['teamMembers'];
    $access = $_POST['access'];
    $deadline = $_POST['deadline'];

    // Save form data in HTML
    $html = '<div class="project-name">' . $projectName . '</div>';
    include('config.php');
    // Create the table if it doesn't exist
    // $sql = "CREATE TABLE `projects` (
    //     `project_id` int(11) NOT NULL,
    //     `project_name` varchar(255) NOT NULL,
    //     `team` varchar(255) NOT NULL,
    //     `access` tinyint(1) NOT NULL,
    //     `deadline` date NOT NULL,
    //     `Status` text NOT NULL
    //   )";
    // $conn->query($sql);
    //split Team Members Field Based on Comma and then for each Value check if it is valid email
    //address then add that user to team members group
    $emailAddresses = explode(",", $teamMembers);

    // Initialize variables for counting and storing valid user IDs
        $count = 0;
        $userIds = [];
        $userMs=[];
        // Iterate through each email address
        foreach ($emailAddresses as $email) {
            $email = trim($email); // Remove leading/trailing whitespace

            // Check if the value is a valid email address
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Check if the email exists in the users table and fetch the corresponding user ID
                $query = "SELECT user_id FROM register WHERE email = '$email'";
                // Execute the query and fetch the result (assuming you have a database connection established)
                $result = $conn->query($query);
                
                if ($result->num_rows > 0) {
                    // Email exists in users table, fetch the user ID
                    $row = $result->fetch_assoc();
                    $userIds[] = $row['user_id'];
                    $userMs[] = $email;
                    $count++;
                }
            }
        }
        //Current User Data
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
    // Insert the form data into the database table
    // $sql = "INSERT INTO projects (project_name, team, access, deadline,Status,created_by)
    //         VALUES ('$projectName', '$count', '$access', '$deadline','To Do','$user_id')";
    //         $result = $conn->query($sql);

            

if ($access == 'Private') {
    $accessValue = 0;
} elseif ($access == 'Public') {
    $accessValue = 1;
} else {
    // Handle the case where no access value is selected
    $accessValue = 0; // or set it to a default value of your choice
}

// Insert the form data into the database table
$sql = "INSERT INTO projects (project_name, team, access, deadline, Status, created_by)
        VALUES ('$projectName', '$count', '$accessValue', '$deadline', 'To Do', '$user_id')";
$result = $conn->query($sql);


    if ($result) {
        // Get the project ID assigned to the newly inserted row
        $projectId = $conn->insert_id;
        
        $insertQuery = "INSERT INTO projectMembers (user_id, project_id,email, role)
                            VALUES ('$user_id', '$projectId','$user_name', 'manager')";
            $insertResult = $conn->query($insertQuery);
        // Insert data into the projectMembers table
        for($i=0;$i<$count;$i++) {
            $role = "employee";
            $userId=$userIds[$i];
            $userM=$userMs[$i];
            // Insert the user ID, project ID, and role into the projectMembers table
            $insertQuery = "INSERT INTO projectMembers (user_id, project_id,email, role)
                            VALUES ('$userId', '$projectId','$userM', '$role')";
            $insertResult = $conn->query($insertQuery);
            $notification_text = "You are Added in Project: ".$projectName." by $user_name";
            $sql = "Insert into notifications (not_text,user_id,user_email,project_id)
              values('$notification_text',$userId,'$userM',$projectId)";
            $rs= $conn->query($sql);
            if (!$insertResult) {
                // Handle the error if the insertion fails
                echo "Failed to insert data into projectMembers table.";
                // You may choose to roll back the project creation process here
                break;
            }
        }
       
        echo "Successfully Created Project";
    } else {
        echo "<script type= 'text/javascript'> alert(Error: " . $sql . "<br>" . $conn->error.")</script>;";
    }

    // Close the database connection
    $conn->close();
    header("location: ../project.php");
}
?>