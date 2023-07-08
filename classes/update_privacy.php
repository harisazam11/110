<?php
include('config.php');
// Retrieve the projectId and access from the AJAX request
$projectId = $_POST['projectId'];
$access = ($_POST['access'] == "Private") ? 0 : 1;

// Update the access value in the projects table
$updateQuery = "UPDATE projects SET access = $access WHERE project_id = '$projectId'";
$result = mysqli_query($conn, $updateQuery);

// Close the database connection
mysqli_close($conn);

// Send a response back to the JavaScript function (optional)
echo "Privacy updated successfully!";
?>
