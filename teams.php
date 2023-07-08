<?php 
session_start();
$activeItem = 'a6'; // Replace 'a1' with the appropriate active item for each page

// Store the active item in session storage
$_SESSION['activeItem'] = $activeItem;
$loggedInUserId = $_SESSION['user_id'];

if (isset($_GET['pid'])) {

  $selectedProjectId = $_GET['pid'];
} else {
  // If pid is not set, set the selected project ID to the first item in the dropdown
  $selectedProjectId = '';
}
?>
<?php
 include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>
<div class="container">
<div class="title">
      <div class="project-bar">
        <div class="add-heading">Project Teams</div>
      </div>
    </div>
    <div class="filter-bar"> 
     
         <div  id="filter" >
            <div class="filteration">
                <!-- Dropdown list -->
                <span class="fx1"><label for="project">Select Project:</label></span>

                        <?php
                            
                            $options = '';
                            $roles = '';
                            // Query projects from the Projects table
                            $projectQuery = "SELECT p.project_id, p.project_name, p.created_by
                            FROM Projects p
                            LEFT JOIN ProjectMembers pm ON p.project_id = pm.project_id
                            WHERE (p.access = 1 AND (pm.user_id = '$loggedInUserId' AND pm.role = 'employee'))
                            OR (p.access = 1 AND p.created_by = '$loggedInUserId')
                            OR (p.access = 0 AND p.created_by = '$loggedInUserId')
                            GROUP BY p.project_id, p.project_name";
                            $projectResult = mysqli_query($conn, $projectQuery);
                            // Check if any projects are available
                            if (mysqli_num_rows($projectResult) > 0) {
                          //    echo "<script type= 'text/javascript'> alert(".$selectedProjectId." )</script>";
                              
                           
                            while ($row = mysqli_fetch_assoc($projectResult)) {
                              
                              if($row['project_id']==$selectedProjectId){
                                $options = $options . '<option  value="' . $row['project_id'] . '" selected>' . $row['project_name'] . '</option>';
                            
                                $roles = $roles . '<option  value="' . $row['created_by'] . '" selected>' . $row['created_by'] . '</option>';
                            
                                }
                                else{
                                  $options = $options . '<option value="' . $row['project_id'] . '">' . $row['project_name'] . '</option>';
                                $roles = $roles . '<option value="' . $row['created_by'] . '">' . $row['created_by'] . '</option>';
                            
                                }
                                }
                            } else {
                            $options = $options.'<option disabled>No Projects Found</option>';
                            $options = $options.'<option disabled>No Roles Found</option>';
                            }

                            // Close the database connection
                            mysqli_close($conn);
                        ?>

                        <input type='text' style="display:none;" id="current_user_id" value='<?php echo $loggedInUserId;?>'/>
                        <select style="margin:0px 20px; width:200px; height:100%; font-size:15px;padding:5px;" id="project" name="project">
                            <?php echo $options;?>
                        </select>
                        <select  style="display:none;margin:0px 20px; width:200px; height:100%; font-size:15px;padding:5px;" id="roles" name="roles">
                            <?php echo $roles;?>
                        </select>
                        <button style="background:lightgray; border:1px solid gray; padding:5px;"  onclick="showMembers()">Show Members</button>
                  
            </div>
        </div>
    </div>
   
        <div class="project-task" id="p-addUser">
            <form action="classes/addProjectMember.php" method="post">
              <div class="cl-bar">
              <input
                    type="text"
                    class="label"
                    id="t-project-id"
                    name="t-project-id"
                    placeholder="Project Id"
                    oninput="check()"
                    required
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
    <script>
      // Function to set the first project as the default selection
      function setDefaultProject() {
        var projectDropdown = document.getElementById("project");
          // Set the first project as the default selection
          if (projectDropdown.options.length > 0) {
         //   projectDropdown.selectedIndex = 0;
          }
          showMembers();
        }

      // Execute the function on page load
      setDefaultProject();

      function showMembers() {
        var projectId = document.getElementById("project").value;
        document.getElementById("roles").selectedIndex= document.getElementById("project").selectedIndex;
        adminId=document.getElementById("roles").value;
        var currUserId = document.getElementById("current_user_id").value;
        //alert(currUserId+ " "+adminId);
        if(adminId==currUserId){
            document.getElementById("p-addUser").style.display="block";
            document.getElementById("t-project-id").value = projectId;
        }
        else{
            document.getElementById("p-addUser").style.display="none";
        }
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
    </script>



<?php include "templates/footer.php"; ?>