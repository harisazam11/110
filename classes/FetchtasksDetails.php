

                    <?php
// Establish database connection
include('config.php');
// Get the project_id from the AJAX request
$projectId = $_GET['project_id'];
session_start();
$uid = $_SESSION['user_id'];
// Query members data from projectMembers and Users tables
$query = "";
if($projectId==-1){
    $query = "SELECT *
          FROM tasks
          Where project_id is NULL and assigned_to = $uid";
}
else
$query = "SELECT *
          FROM tasks
          Where project_id=$projectId";

$result = mysqli_query($conn, $query);

// Generate the HTML table with member information
$table='';
while ($row = mysqli_fetch_assoc($result)) {
  $table .= '<tr style="height:'.$row['time_spent'].'%">
                <th scope="row">'.$row['task_name'].'</th>
                <td><span>'.$row['time_spent'].'%</span></td>
            </tr>';
}

// Send the HTML table as the response
echo $table;

// Close the database connection
mysqli_close($conn);
?>
