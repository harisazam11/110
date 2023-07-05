<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $user = $_POST['t-user'];
    $deadline = $_POST['t-deadline'];
    $name = $_POST['t-name'];
    $project_id = $_POST['t-pid'];
    $uid = explode(",", $user)[0];
    $umail = explode(",", $user)[1];
    include('config.php');

    $sql = "INSERT INTO tasks (task_name,project_id, assigned_to,user_email,status, due_date, time_required, time_spent)
    VALUES ('$name', '$project_id', '$uid','$umail', 'To Do','$deadline','0','0')";
    $result = $conn->query($sql);
    if ($result) {
    // Get the project ID assigned to the newly inserted row
    $projectId = $conn->insert_id;
    $conn->close();
    header("location: ../project.php");
    }
    else{
        $conn->close();
        header("location: ../project.php");
    }
}
?>