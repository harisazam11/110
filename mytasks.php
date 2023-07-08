<?php
session_start();
?>
<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>
<style>
    .ui-widgets {
    position: relative;
    display: inline-block;
    width: 10rem;
    height: 10rem;
    border-radius: 9rem;
    margin:1.5rem;
    border: 1.2rem solid palegreen;
    box-shadow: inset 0 0 7px grey;
    border-left-color: lightblue;
    border-top-color:lightblue ;
    border-right-color: lightblue;
    border-bottom-color: lightblue ;
    text-align: center;
    box-sizing: border-box;
}
  
/* Apply css properties to the second
    child of ui-widgets class */
.ui-widgets:nth-child(2) {
    border-top-color:lightblue ;
    border-right-color: lightblue;
    border-left-color: lightblue;
    border-bottom-color: lightblue;
}
  
/* Apply css properties to ui-widgets
   class and ui-values class */
.ui-widgets .ui-values {
    top: 45px;
    position: absolute;
    left: 10px;
    right: 0;
    font-weight: 700;
    font-size: 1.5rem;
}
  
/*  Apply css properties to ui-widgets 
class and ui-labels class */
.ui-widgets .ui-labels {
    left: 0;
    bottom: -16px;
    text-shadow: 0 0 4px grey;
    color:black;
    position: absolute;
    width: 100%;
    font-size: 14px;
}


</style>
<div class="container">
    <div class="title">
      <div class="project-bar">
        <div class="add-heading">My Tasks</div>
      </div>
    </div>
            <!-- Circular progress bar with dynamic progress percentage -->
            <div class="ui-widgets" style="margin-top:-100px; margin-left:80%;">
                <div class="ui-values">
                <?php
                 include("classes/config.php");
                 $uid = $_SESSION['user_name'];
                    $sql = "select sum(time_spent) as s1, count(*) as c from tasks where user_email = '$uid'"; 
                    $res= $conn->query($sql);
                    if($res->num_rows>0){
                        $row = $res->fetch_assoc();
                        $per=$row['s1'];
                        $c=$row['c'];
                        echo round($per/$c,2)."%";
                        
                    }
                ?>

                </div>
                <div class="ui-labels">Timespent</div>
            </div>

    <div class="project-list" style="margin-top:-60px">
      <div class="pro-list" style="background:transparent;border:0px solid transparent;">
         <div class="tab-buttons">
            <button class="tab-button" onclick="openTab(event, 'tab1')"><b>Recent Tasks</b></button>
            <button class="tab-button" onclick="openTab(event, 'tab2')"><b>On Going Tasks</b></button>
            <button class="tab-button" onclick="openTab(event, 'tab3')"><b>Completed Tasks</b></button>
        </div>
        
        <!-- Tab content -->
        <div class="tab-content" id="tab1">
            <table>
            <thead>
                <tr>
                <td>Task Name</td>
                <td>Deadline</td>
                <td>Project</td>
                <td>Status</td>
                <td>Action</td>
                </tr>
            </thead>
            <tbody class="mybody">
            <?php
                include("classes/config.php");
                $uid = $_SESSION['user_name'];
                
                // Retrieve project names from the database table
                $sql = "SELECT * FROM tasks where user_email = '$uid' and status='To Do' order by task_id desc";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                // Output Tasks
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['task_name'] . '</td>';
                    if($row['due_date']!= NULL){
                    $currentDate = date('Y-m-d'); // Current date
                    $dueDate = $row['due_date']; // Due date from the database
                    
                    // Convert dates to timestamps
                    $currentTimestamp = strtotime($currentDate);
                    $dueTimestamp = strtotime($dueDate);
                   // Compare the timestamps
                    if ($currentTimestamp < $dueTimestamp) 
                        echo '<td>'. $row['due_date'] . '</td>';
                    else 
                    echo '<td style="color:red;">'. $row['due_date'] . '</td>';
                    }
                    else{
                        echo '<td>'.($row['time_required'])/3600 .' Hour/s</td>';
                    }
                    
                    if($row['project_id']!=NULL){
                        $projId=$row['project_id'];
                        $psql = "select project_name from projects where project_id =$projId";
                        $pres= $conn->query($psql);
                        echo '<td>'.$pres->fetch_assoc()['project_name'].'</td>';
                    }
                    else
                        echo '<td>Open Task</td>';
                    echo '<td>' . $row['status'] . '</td>';
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
        
        <div class="tab-content" id="tab2">
        <table>
            <thead>
                <tr>
                <td>Task Name</td>
                <td>Deadline</td>
                <td>Project</td>
                <td>Status</td>
                <td>Action</td>
                </tr>
            </thead>
            <tbody class="mybody">
            <?php
                include("classes/config.php");
                $uid = $_SESSION['user_name'];
                
                // Retrieve project names from the database table
                $sql = "SELECT * FROM tasks where user_email = '$uid' and status='Doing' order by task_id desc";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                // Output Tasks
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['task_name'] . '</td>';
                    if($row['due_date']!= NULL){
                    $currentDate = date('Y-m-d'); // Current date
                    $dueDate = $row['due_date']; // Due date from the database
                    
                    // Convert dates to timestamps
                    $currentTimestamp = strtotime($currentDate);
                    $dueTimestamp = strtotime($dueDate);
                   // Compare the timestamps
                    if ($currentTimestamp < $dueTimestamp) 
                        echo '<td>'. $row['due_date'] . '</td>';
                    else 
                    echo '<td style="color:red;">'. $row['due_date'] . '</td>';
                    }
                    else{
                        echo '<td>'.($row['time_required'])/3600 .' Hour/s</td>';
                    }
                    
                    if($row['project_id']!=NULL){
                        $projId=$row['project_id'];
                        $psql = "select project_name from projects where project_id =$projId";
                        $pres= $conn->query($psql);
                        echo '<td>'.$pres->fetch_assoc()['project_name'].'</td>';
                    }
                    else
                        echo '<td>Open Task</td>';
                    echo '<td>' . $row['status'] . '</td>';
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
        
        <div class="tab-content" id="tab3">
        <table>
            <thead>
                <tr>
                <td>Task Name</td>
                <td>Deadline</td>
                <td>Project</td>
                <td>Status</td>
                <td>Action</td>
                </tr>
            </thead>
            <tbody class="mybody">
            <?php
                include("classes/config.php");
                $uid = $_SESSION['user_name'];
                
                // Retrieve project names from the database table
                $sql = "SELECT * FROM tasks where user_email = '$uid' and status='Done' order by task_id desc";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                // Output Tasks
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['task_name'] . '</td>';
                    if($row['due_date']!= NULL){
                    $currentDate = date('Y-m-d'); // Current date
                    $dueDate = $row['due_date']; // Due date from the database
                    
                    // Convert dates to timestamps
                    $currentTimestamp = strtotime($currentDate);
                    $dueTimestamp = strtotime($dueDate);
                   // Compare the timestamps
                    if ($currentTimestamp < $dueTimestamp) 
                        echo '<td>'. $row['due_date'] . '</td>';
                    else 
                    echo '<td style="color:red;">'. $row['due_date'] . '</td>';
                    }
                    else{
                        echo '<td>'.($row['time_required'])/3600 .' Hour/s</td>';
                    }
                    
                    if($row['project_id']!=NULL){
                        $projId=$row['project_id'];
                        $psql = "select project_name from projects where project_id =$projId";
                        $pres= $conn->query($psql);
                        echo '<td>'.$pres->fetch_assoc()['project_name'].'</td>';
                    }
                    else
                        echo '<td>Open Task</td>';
                    echo '<td>' . $row['status'] . '</td>';
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
  <!-- Tab buttons -->
 
</div>
  <script>
    // Function to open the selected tab
    function openTab(evt, tabName) {
      // Hide all tab content
      var tabContents = document.getElementsByClassName("tab-content");
      for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = "none";
      }
      
      // Remove "active" class from tab buttons
      var tabButtons = document.getElementsByClassName("tab-button");
      for (var i = 0; i < tabButtons.length; i++) {
        tabButtons[i].className = tabButtons[i].className.replace(" active", "");
      }
      
      // Show the selected tab content and mark the button as active
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " active";
    }
    
    // Open the first tab by default
    document.getElementById("tab1").style.display = "block";
    document.getElementsByClassName("tab-button")[0].className += " active";
  </script>



<?php include "templates/footer.php"; ?>