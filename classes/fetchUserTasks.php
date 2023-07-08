

                    <?php
// Establish database connection
include('config.php');
// Get the project_id from the AJAX request
$projectId = $_GET['project_id'];
session_start();
$uid = $_GET['member_id'];
// Query members data from projectMembers and Users tables
$query = "";

    $query = "SELECT *
          FROM tasks
          Where project_id = '$projectId' and assigned_to = '$uid'";
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
