<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>
<?php
 session_start();
  include("classes/config.php");
  $uid= $_SESSION['user_id'];
  $columns= "select * from tasks where assigned_to = '$uid';";
  
  $result = $conn->query($columns);
?>

  <div class="container">
    <div class="title">
      <span class="heading">Time Tracker</span>
    </div>

    <form action="process.php" method="post">
      <div class="task-bar">
        <!-- <div class="add-label" contenteditable="true" id="holder">
        <div class="label">Add task to track time</div>
      </div> -->
        <div class="add-label">
          <input type="text" class="label" id="label" name="task" placeholder="Add task to track time" required />
        </div>

        <div class="add-due">
          <div class="due">
            <div class="iconadd" style="display: flex; align-items: center">
              <input class="label" id="time-picker" placeholder="Add task due (in hours)" type="text" name="due_Time" 
                required />
              
              <div id="display"></div>
            </div>
          </div>
        </div>

        <div class="add-btn">
          <div class="label">
            <input id="add-button" type="Submit" value="Add" />
          </div>
        </div>
      </div>
    </form>
    <?php
    
    ?>

    <div class="filter-bar">
      <div class="filteration">
        <span class="fx1">Filter </span>
        <div class="flex">
          <span class="fx2">Range</span>
        </div>
        <div class="flex">
          <span class="fx3">Status</span>
        </div>
        <div class="flex">
          <span class="fx4">Team</span>
        </div>
        <div class="flex">
          <span class="fx5">
            <input id="apply-button" type="submit" value="Apply" disabled />
          </span>
        </div>
      </div>
    </div>

    <div class="project-list">
      <div class="head">
        <div class="date">Date</div>
      </div>
      <div class="task-list">
        <!-- <div class="project-name">Name</div> -->
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Task</th>
              <th>Project</th>
              <th>Due</th>
              <th>%</th>
              <th>Status</th>
              <th>00:00:00</th>
              <th>Start</th>
              <th style="text-align: center">
                <img src="images/ellipsis.png" alt="" style="width: 3px; height: 12px; margin-left: 0" />
              </th>
            </tr>
          </thead>
          <tbody id="task-table-body">
            <?php
               if ($result->num_rows > 0) {
                // Output a dropdown menu for each project name
                while ($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td>' . $row['task_id'] .'</td>';
                  echo '<td>' . $row['task_name'] . '</td>';
                  echo '<td>' . $row['project_id'] . '</td>';
                  echo '<td>' . $row['due_date'].'</td>';
                  if($row['time_required']!='0')
                  echo '<td>' . $row['time_spent']/$row['time_required'] .'</td>';
                  else
                  echo '<td>0%</td>';
                  echo '<td>' . $row['status'].'</td>';
                  echo '</tr>';
                    }
                  }else{
                    }
                    ?>
            
          </tbody>
        </table>
      </div>
    </div>
    <div class="dropdown-menu" id="dropdown-menu">
      <div class="delete">
        <a href="#" class="delete">Delete</a>
      </div>
      <hr />
      <div class="delete">
        <a href="#" class="edit">Edit</a>
      </div>
      <hr />
      <div class="view-team">
        <a href="#" class="view-team">View Team</a>
      </div>
    </div>
  </div>
   <script src="app.js"></script> 
   <?php include "templates/footer.php"; ?>