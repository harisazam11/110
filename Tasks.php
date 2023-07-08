<?php

session_start();

$project_id = $_GET['pid'];
   $curr_user_id = $_SESSION['user_id'];
   include('classes/config.php');
   $sql = "select * from projects where project_id = '$project_id'";
   $row = $conn->query($sql)->fetch_assoc();
   if($row['access']==0 && $row['created_by']!=$curr_user_id)
    header("location: mytasks.php");

    
?>

<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>
<?php
   
   
?>
    <div class="container" id="layout2">
      <div class="title">
        <div class="project-bar">
          <div class="add-heading">Project: 
          <?php
            include("classes/config.php");

            // Retrieve project names from the database table
            $sql = "SELECT project_name FROM projects where project_id = $project_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // Output a dropdown menu for each project name
              while ($row = $result->fetch_assoc()) {
                echo  $row['project_name'];
              }
            } 
            // Close the database connection
            $conn->close();
          ?>

          </div>
        </div>
      </div>

      <div class="project-list" >
      <div class="pro-list" style="background:transparent;border:0px solid transparent;">
         <div class="tab-buttons">
            <button class="tab-button" onclick="openTab(event, 'tab1')"><b>Tasks</b></button>
            <button class="tab-button" onclick="openTab(event, 'tab2')"><b>Access</b></button>
            <button class="tab-button" onclick="openTab(event, 'tab3')"><b>Team</b></button>
        </div>
        
        <!-- Tab content -->
        <div class="tab-content" style="padding:0px;"  id="tab1">
        <div class="project-task"  id="p-task">
            <form action="classes/createtask.php" enctype="multipart/form-data" method="post">
              <div class="cl-bar" 
              <?php 
              include('classes/config.php');
              $sql = "select count(*) as c from projects where project_id='$project_id 'and created_by = $curr_user_id";
              if($conn->query($sql)->fetch_assoc()['c']==0)
                echo 'style="display:none;"';
              ?>
              >
                <input
                    type="text"
                    style="display:none;"
                    class="label"
                    id="t-pid"
                    name="t-pid"
                    value="<?php echo "$project_id";?>"
                    required
                  />
                <div class="add-label">
                  <input
                    type="text"
                    class="label"
                    id="t-name"
                    name="t-name"
                    placeholder="Add new task"
                    oninput="check()"
                    required
                  />
                </div>

                <div class="add-due">
                  
                  <select class="label"
                    id="t-user"
                    name="t-user">
                    <?php
                    include("classes/config.php");

                    // Retrieve project names from the database table
                    $sql = "SELECT user_id,email FROM projectMembers where project_id=$project_id";
                    $result = $conn->query($sql);
        
                    if ($result->num_rows > 0) {
                      // Output a dropdown menu for each project name
                      while ($row = $result->fetch_assoc()) {
                        echo '<option value='.$row['user_id'].','.$row['email'].'>'.$row['email'].'</option>';
                      }
                    } 
                    // Close the database connection
                    $conn->close();
                    ?>
                  </select>
                </div>

                <div class="add-deadline">
                  <input
                    type="date"
                    class="label"
                    id="t-deadline"
                    name="t-deadline"
                    placeholder="Add deadline"
                    oninput="check()"
                    required
                  />
                </div>
                <div class="add-deadline">
                  <input
                    type="file"
                    class="label"
                    id="t-file"
                    name="t-file"
                    placeholder="Select File"
                    oninput="check()"
                    style='margin-top:12px;'
                  />
                </div>
                <div class="add-btn">
                  <div class="label">
                    <input id="t-add" style="margin-right:10px;" type="submit" value="Add"  />
                  </div>
                </div>
              </div>
            </form>

            <hr class="hr" />

            <div class="cl-bar1">
              <div class="border1">
                <div class="box header">
                  <div class="fx2" id="">To Do</div>
                </div>
                <table>
                  <thead></thead>
                  <tbody id="pt-table-body1" class="mybody">
                    
                        <?php
                        include("classes/config.php");

                        // Retrieve project names from the database table
                        $sql = "SELECT * FROM tasks where project_id=$project_id and status ='To Do';";
                        $result = $conn->query($sql);
            
                        if ($result->num_rows > 0) {
                          // Output a dropdown menu for each project name
                          while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['task_name'] .'</td>';
                            echo '</tr>';
                          }
                        } 
                        ?>
                  </tbody>
                </table>
              </div>

              <div class="border2">
                <div class="box header">
                  <div class="fx2" id="">Doing</div>
                </div>

                <table>
                  <thead></thead>
                  <tbody id="pt-table-body2" class="mybody">
                  <?php
                        include("classes/config.php");

                        // Retrieve project names from the database table
                        $sql = "SELECT * FROM tasks where project_id=$project_id and status ='Doing';";
                        $result = $conn->query($sql);
            
                        if ($result->num_rows > 0) {
                          // Output a dropdown menu for each project name
                          while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['task_name'] .'</td>';
                            echo '</tr>';
                          }
                        } 
                        ?>
                  </tbody>
                </table>
              </div>

              <div class="border3">
                <div class="box header">
                  <div class="fx2" id="">Done</div>
                </div>
                <table>
                  <thead></thead>
                  <tbody id="pt-table-body3" class="mybody">

                  <?php
                        include("classes/config.php");

                        // Retrieve project names from the database table
                        $sql = "SELECT * FROM tasks where project_id=$project_id and status ='Done';";
                        $result = $conn->query($sql);
            
                        if ($result->num_rows > 0) {
                          // Output a dropdown menu for each project name
                          while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['task_name'] .'</td>';
                            echo '</tr>';
                          }
                        } 
                        ?>

                  </tbody>
                </table>
              </div>
            </div>

            <hr class="hr" />

            <div class="project-list">
              <div class="task-list">
                <table>
                  <thead>
                    <tr>
                      <td>Task</td>
                      <td>Assined to</td>
                      <td>Status</td>
                      <td>Deadline</td>
                      <td>Files</td>
                    </tr>
                  </thead>
                  <tbody id="p-table-body" class="mybody">
                  <?php
                        include("classes/config.php");

                        // Retrieve project names from the database table
                        $sql = "SELECT * FROM tasks where project_id='$project_id';";
                        $result = $conn->query($sql);
            
                        if ($result->num_rows > 0) {
                          // Output a dropdown menu for each project name
                          while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['task_name'] .'</td>';
                            echo '<td>' . $row['user_email'] . '</td>';
                            echo '<td>' . $row['status'] . '</td>';
                            echo '<td>' . $row['due_date'].'</td>';
                            if($row["file"] != NULL)
                                echo '<td><a href="'.$row["file"].'" style="color:blue;" download>Download File</a></td>';
                            else
                                echo '<td>No Files</td>';
                            echo '</tr>';
                          }
                        } 
                        ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        
        <div class="tab-content" id="tab2">
       
        <div class="visibility">
              <h4>Visibility:</h4>
              <form action="" style="margin-bottom: 15px; background:white; padding:20px;">
                <input type="radio" id="private" name="access" value="Private" style="margin-left: 0">
                <label for="private" class="radio-label">Private</label>
                <input type="radio" id="public" name="access" value="Public" style="margin-left: 20px">
                <label for="public" class="radio-label">Public</label>

                <?php
                // Retrieve the access value from the projects table based on the project_id
                $accessQuery = "SELECT access FROM projects WHERE project_id = '$project_id'";
                $accessResult = mysqli_query($conn, $accessQuery);

                if (mysqli_num_rows($accessResult) > 0) {
                    $row = mysqli_fetch_assoc($accessResult);
                    $access = $row['access'];

                    // Select the appropriate radio button based on the access value
                    if ($access == 0) {
                        echo '<script>document.getElementById("private").checked = true;</script>';
                    } else {
                        echo '<script>document.getElementById("public").checked = true;</script>';
                    }
                }
                ?>

                <?php
                // Check if the current user is the creator of the project
                $creatorQuery = "SELECT created_by FROM projects WHERE project_id = '$project_id'";
                $creatorResult = mysqli_query($conn, $creatorQuery);

                if (mysqli_num_rows($creatorResult) > 0) {
                    $row = mysqli_fetch_assoc($creatorResult);
                    $createdBy = $row['created_by'];

                    // Show the update privacy button if the current user is the creator
                    if ($curr_user_id == $createdBy) {
                        echo '<button type="button" onclick="updatePrivacy()">Update Privacy</button>';
                    }
                }
                ?>

            </form>


              <hr />
            </div>
      
        </div>
        
        <div class="tab-content" id="tab3" href="xteams">
                <input type='text' value='<?php echo $curr_user_id;?>' id='current_user_id' style='display:none;'/>
            <div class="project-task" id="p-addUser" 
            
            <?php 
              include('classes/config.php');
              $sql = "select count(*) as c from projects where project_id='$project_id 'and created_by = $curr_user_id";
              if($conn->query($sql)->fetch_assoc()['c']==0)
                echo 'style="display:none;"';
              ?>

            >
                <form action="classes/addProjectMember.php" method="post">
                  <div class="cl-bar">
                  <input
                        type="text"
                        class="label"
                        id="pagename"
                        name="pagename"
                        value='123'
                        style="display:none"
                      />
                  <input
                        type="text"
                        class="label"
                        id="t-project-id"
                        name="t-project-id"
                        value='<?php echo $project_id; ?>'
                        style="display:none"
                      />
                    <div class="add-label">
                      <input
                        type="text"
                        class="label"
                        id="t-email"
                        name="t-email"
                        placeholder="Add new Member"
                        oninput="check()"
                        required
                      />
                    </div>

                    <div class="add-due">
                      
                      <select class="label"
                        id="t-role"
                        name="t-role">
                        <option value='employee'>Employee</option>
                        <option value='manager'>Manager</option>
                      </select>
                    </div>
                    <div class="add-btn">
                      <div class="label">
                        <input style="margin-top:32px;" id="t-add" type="submit" value="Add"  />
                      </div>
                    </div>
                  </div>
                </form>
            </div>
            <br/><br/>
            <div class="project-list">
              <div class="pro-list"  >
                <!-- Members table -->
                <div id="membersTable">
                </div>
              </div>
            </div>
      
      
        </div>
      </div>
    </div>


  </div>
    <script>
      // Get all radio buttons by name
      const radioButtons = document.querySelectorAll('input[name="access"]');

      // Add event listener to each radio button
      radioButtons.forEach(function (radioButton) {
        radioButton.addEventListener("change", function () {
          // Reset color for all radio buttons
          radioButtons.forEach(function (rb) {
            rb.nextElementSibling.style.color = "";
          });

          // Change color of selected radio button value
          if (this.checked) {
            this.nextElementSibling.style.color = "black";
          }
        });
      });
    </script>
    <script>
      const sidebarToggle = document.getElementById("sidebarToggle");
      const sidebar = document.querySelector(".sidebar");

      sidebarToggle.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the default behavior of the <a> tag
        if (sidebar.classList.contains("active")) {
          sidebar.classList.remove("active");
        } else {
          sidebar.classList.add("active");
        }
      });
    </script>

     <script>
      showMembers();
      function showMembers() {
        var projectId = document.getElementById("t-pid").value;
        var currUserId = document.getElementById("current_user_id").value;
        
        // AJAX request to fetch members data
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("membersTable").innerHTML = this.responseText;
          }
        };
        xhr.open("GET", "classes/get_members.php?project_id=" + projectId, true);
        xhr.send();
      }
      function updatePrivacy() {
          var projectId = <?php echo $project_id; ?>;
          var access = document.querySelector('input[name="access"]:checked').value;

          // Make an AJAX request
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "classes/update_privacy.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
              if (xhr.readyState == 4 && xhr.status == 200) {
                  // Handle the response here if needed
                  alert(xhr.responseText);
              }
          };
          xhr.send("projectId=" + projectId + "&access=" + access);
      }

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