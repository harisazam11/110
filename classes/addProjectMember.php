<?php

include('config.php');

// Retrieve form inputs
$tProjectId = $_POST['t-project-id'];
$tEmail = $_POST['t-email'];
$tRole = $_POST['t-role'];

// Check if the user already exists in the ProjectMembers table for the current project
$checkQuery = "SELECT COUNT(*) AS count FROM ProjectMembers WHERE email = '$tEmail' AND project_id = '$tProjectId'";
$checkResult = mysqli_query($conn, $checkQuery);
$row = mysqli_fetch_assoc($checkResult);
$count = $row['count'];

if ($count > 0) {
  // User already exists in the project
  echo "<script type= 'text/javascript'> alert('User is already a member of this project.')</script>";
 // echo "User is already a member of this project.";
  // You can redirect or show an error message as needed

  if(isset($_POST['pagename']))
    header("location: ../tasks.php?pid=$tProjectId");
  else
    header("location: ../teams.php?pid=$tProjectId");
  exit;
}

// Retrieve user ID from the Users table based on the user email
$userQuery = "SELECT user_id FROM Register WHERE email = '$tEmail' LIMIT 1";
$userResult = mysqli_query($conn, $userQuery);
$userRow = mysqli_fetch_assoc($userResult);
$userId = $userRow['user_id'];

// Insert the user into the ProjectMembers table
$insertQuery = "INSERT INTO ProjectMembers (user_id, email, role, project_id) VALUES ('$userId', '$tEmail', '$tRole', '$tProjectId')";
$insertResult = mysqli_query($conn, $insertQuery);

if ($insertResult) {
  // User added successfully
  echo "User added to the project.";
  echo "<script type= 'text/javascript'> alert('User added to the project.')</script>";
  header("location: ../teams.php?pid=$tProjectId");
  // You can redirect or show a success message as needed
} else {
  // Error occurred while adding the user
  //echo "Error adding user to the project: " . mysqli_error($conn);
  echo "<script type= 'text/javascript'> alert('Error adding user to the project: " . mysqli_error($conn)."')</script>";
 
  // You can redirect or show an error message as needed
}

// Close the database connection
mysqli_close($conn);
?>