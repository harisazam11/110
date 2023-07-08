<?php
include("config.php");
// Retrieve the projectId and userId from the AJAX request
$projectId = $_GET['projectId'];
$userId = $_GET['userId'];

// Query members from the ProjectMembers table
$membersQuery = "SELECT user_id, email FROM ProjectMembers WHERE project_id = '$projectId'";
$membersResult = mysqli_query($conn, $membersQuery);

$options = '';
if (mysqli_num_rows($membersResult) > 0) {
    while ($row = mysqli_fetch_assoc($membersResult)) {
        $options .= '<option value="' . $row['user_id'] . '">' . $row['email'] . '</option>';
    }
}

// Return the member options
echo $options;

// Close the database connection
mysqli_close($conn);
?>
