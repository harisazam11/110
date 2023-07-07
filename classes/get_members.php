<?php
// Establish database connection
include('config.php');
// Get the project_id from the AJAX request
$projectId = $_GET['project_id'];

// Query members data from projectMembers and Users tables
$query = "SELECT pm.user_id, u.email, u.firstname, u.lastname, pm.role
          FROM projectMembers pm
          JOIN register u ON pm.user_id = u.user_id
          WHERE pm.project_id = '$projectId'
          order by pm.role desc";

$result = mysqli_query($conn, $query);

// Generate the HTML table with member information
$table = '<table>
<thead>
            <tr>
              <th>Member ID</th>
              <th>Email</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Role</th>
            </tr>
            </thead><tbody>';

while ($row = mysqli_fetch_assoc($result)) {
  $table .= '<tr>
               <td>' . $row['user_id'] . '</td>
               <td>' . $row['email'] . '</td>
               <td>' . $row['firstname'] . '</td>
               <td>' . $row['lastname'] . '</td>
               <td>' . $row['role'] . '</td>
             </tr>';
}

$table .= '</tbody></table>';

// Send the HTML table as the response
echo $table;

// Close the database connection
mysqli_close($conn);
?>
