<?php
 session_start();
 $activeItem = 'a3'; // Replace 'a1' with the appropriate active item for each page

// Store the active item in session storage
$_SESSION['activeItem'] = $activeItem;
   include("classes/config.php");
?>


<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>


<?php
$startDate = "";
$endDate = "";
  // Retrieve user ID from session
  $uid = $_SESSION['user_id'];

  // Check if form is submitted for filtering
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Prepare the WHERE clause for filtering
    $whereClause = "assigned_to = '$uid'";

    // Check if start date is provided
    if (!empty($_GET["start_date"])) {
      $startDate = $_GET["start_date"];
      $whereClause .= " AND created_on >= '$startDate'";
    }

    // Check if end date is provided
    if (!empty($_GET["end_date"])) {
      $endDate = $_GET["end_date"];
      $whereClause .= " AND created_on <= '$endDate'";
    }

    // Check if status is provided
    if (!empty($_GET["status"]) && $_GET["status"] != "Status") {
      $status = $_GET["status"];
      $whereClause .= " AND status = '$status'";
    }
    if (!empty($_GET["project_id"]) && $_GET["project_id"] != "3") {
      $proj = $_GET["project_id"];
      if($proj==1)
      $whereClause .= " AND project_id is null";
      else 
      $whereClause .= " AND project_id is not null";
    }
    // Construct the SQL query with the WHERE clause
    $query = "SELECT * FROM tasks WHERE $whereClause and time_required!=0";
  } else {
    // If form is not submitted, retrieve all tasks for the user
    $query = "SELECT * FROM tasks WHERE assigned_to = '$uid' and time_required!=0";
  }

  $result = $conn->query($query);
    // $uid= $_SESSION['user_id'];
    // $columns= "select * from tasks where assigned_to = '$uid' and time_required!=0;";
    
    // $result = $conn->query($columns);
?>


<div class="container">
    <div class="title">
      <span class="heading">Time Tracker</span>
    </div>

    <form action="classes/tracker.php" method="post">
      <div class="task-bar">
        <!-- <div class="add-label" contenteditable="true" id="holder">
        <div class="label">Add task to track time</div>
      </div> -->
      <input type="text" class="label" id="tid" name="taskid" value="" style="display:none" />
       
        <div class="add-label">
          <input type="text" class="label" id="label" name="task" placeholder="Add task to track time" required />
        </div>

        <div class="add-due">
          <div class="due">
            <div class="iconadd" style="display: flex; align-items: center">
              <input class="label" id="time-picker" placeholder="Add task due (in hours)" type="number" name="due_Time" 
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

   
  <div class="filter-bar">  
    <form id="filter" action="" method="GET">
    <div class="filteration">
      <span class="fx1">Filter </span>
     
        <div class="flex">     
              <input type="date" name="start_date" placeholder="from">
              <input type="date" name="end_date" placeholder="Till">
          
        </div>
        <div class="flex">
          <span class="fx3">
            <select name="status" style="width: 100px; height: 30px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;">
              <option value="Status">Status</option>
              <option value="To Do">To Do</option>
              <option value="Doing">Doing</option>
              <option value="Done">Done</option>
            </select>
          </span>
        </div>
        <div class="flex">
          <span class="fx4">
              <select name="project_id" style="width: 150px; height: 30px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;">
              <option value="3">Project Type</option>
              <option value="1">No Project</option>
              <option value="2">Project</option>
            </select>
          </span>
        </div>
        <div class="flex">
          <span class="fx5">
            <input id="apply-button" type="submit" value="Apply" />
          </span>
        </div>
      </form>
    </div>
  </div>
  <br/><br/>
  <div class="project-list">
    <?php
    echo '<p5 style="font-size:14px;margin-left: 20px;" class="fx1">' . $startDate . " - " . $endDate . '</p5>';
    ?>
    <div class="task-list">
        <!-- <div class="project-name">Name</div> -->
        <table>
          <thead>
            <tr>
              <th>Task</th>
              <th>Project</th>
              <th>Due</th>
              
              <th>%</th>
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
                $i=0;
                // Output a dropdown menu for each project name
                while ($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td style="display:none" id="task-id-'.$i.'">' . $row['task_id'] . '</td>';
                  echo '<td>' . $row['task_name'] . '</td>';
                  $sql= "select project_name from projects where project_id = '".$row['project_id']."';";
                  $r = $conn->query($sql);
                  if($r->num_rows>0)
                  echo '<td>' . $r->fetch_assoc()['project_name'] . '</td>';
                  else
                      echo '<td>No Project</td>';
                  echo '<td>' . ($row['time_required']) / 3600 .'</td>';
                  if($row['time_spent']!='0')
                    echo '<td id="percentage-'.$i.'">' .$row['time_spent'].'</td>';
                  else
                    echo '<td id="percentage-'.$i.'">0%</td>';
                  echo '<td id="timer-'.$i.'">'.$row['timer'].'</td>';

                  echo  '<td style="text-align: center">
                      <button onclick="startStopWatch('.$i.','.$row['time_required'].',\''.$row['timer'].'\',1)" id="startbtn-'.$i.'" style="border: none; background: none;display:block;">
                        <img src="images/play (Stroke).png" alt="" style="width: 12px; height: 12px; margin-left: 0" />
                      </button>
                      <button onclick="startStopWatch('.$i.','.$row['time_required'].',\''.$row['timer'].'\',0)" id="stopbtn-'.$i.'" style="border: none; background: none;display:none;">
                      <img src="images/Vector.png" alt="" style="width: 12px; height: 12px; margin-left: 0" />
                    </button>
                    </td>
                  </td>
                      <td style="text-align: center">
                        <button  onclick="EditClicked('.$row['task_id'].',\''.$row['task_name'].'\','.$row['time_required'].')" id="update-btn-'.$i.'"  style="border: none; background: none;">
                          <img src="images/icon.png" alt="" style="width: 15px; height: 15px; margin-left: 0px" />
                        </button>
                        <form method="POST" action="classes/deleteTask.php">
                        <input type="text" name="taskId" value="'.$row['task_id'].'" required style="display:none;"/>
                        <button type="submit" id="del-btn-'.$i.'"  style="border: none; background: none;">
                        <img src="images/del.png" alt="" style="width: 15px; height: 15px; margin-left: 0px" />
                      </button>
                      </form>
                      </td>';
                  echo '</tr>';
                  $i++;
                    }
                  }else{
                    }
                    ?>
            </tbody>
        </table>
      </div>
    </div>
    <div class="overlay" id="overlay">
      <div class="form-container">
        <h2>Update Task Time</h2>
        <hr />
        <form action="classes/edittimer.php" method="POST" class="create-form">
          <div class="filteration">
          <input type="text" name="utid"  id="utid" placeholder="Task Name" class="input"  style="display:none;" required readonly/>
          
            <input type="text" name="ulabel"  id="ulabel" placeholder="Task Name" class="input" required readonly/>
            <input type="text" name="utime" id="utime" class="input" placeholder="Update Time Required" />
          </div>
          <input type="submit" value="Submit" id="create-project">
        </form>
      </div>
    </div>
</div>
   <script src="js/app.js"></script>
   <?php include "templates/footer.php"; ?>