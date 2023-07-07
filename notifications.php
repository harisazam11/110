
<?php session_start(); include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>

<div class="container">
    <div class="project-list">
      <div class="pro-list">
        <table>
          <thead>
            <tr>
              <td>Notification</td>
              <td>Date</td>
              <td>View</td>
            </tr>
          </thead>
          <tbody>
          <?php
           include("classes/config.php");
            
            $uid=$_SESSION['user_id'];
            // Retrieve project names from the database table
            $sql = "SELECT * FROM notifications where user_id = $uid order by not_id desc";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // Output a dropdown menu for each project name
              while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['not_text'] . '</td>';
                // Display the rest of the project information
                echo '<td>'. $row['created'] . '</td>';
                if($row['task_id']!=NULL)
                    echo '<td><a href="mytasks.php?tid='.$row["task_id"].'">View</a></td>';
                else
                    echo '<td><a href="tasks.php?pid='.$row["project_id"].'">View</a></td>';
                echo '</tr>';
              }
            } 
            // Close the database connection
            $conn->close();
          ?>
          </tbody>
        </table>
      </div>
    </div>
</div>


<?php include "templates/footer.php"; ?>