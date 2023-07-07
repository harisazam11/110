<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>
<?php
   $project_id = $_GET['pid'];
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

      <div class="projecr-detail">
        <div class="filteration">
          <a
            href="#p-task"
            class="tabs cl-active"
            id="proTask"
            style="margin-left: 20px"
          >
            <div>
              <span class="fx5">Tasks</span>
            </div>
          </a>

          <a href="#p-access" class="tabs" id="proAccess">
            <div>
              <span class="fx5">Access</span>
            </div>
          </a>

          <a href="#p-team" class="tabs" id="proTeam">
            <div>
              <span class="fx5">Team</span>
            </div>
          </a>

          <a href="#p-files" class="tabs" id="proFiles">
            <div>
              <span class="fx5">Files</span>
            </div>
          </a>
        </div>

        <div class="page">
          <div class="project-task" id="p-task">
            <form action="classes/createtask.php" method="post">
              <div class="cl-bar">
                <input
                    type="text"
                    style="visibility:hidden;"
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

                <div class="add-btn">
                  <div class="label">
                    <input id="t-add" type="submit" value="Add"  />
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
                  <tbody id="pt-table-body1">
                    
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
                  <tbody id="pt-table-body2">
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
                  <tbody id="pt-table-body3">

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
                    </tr>
                  </thead>
                  <tbody id="p-table-body">
                  <?php
                        include("classes/config.php");

                        // Retrieve project names from the database table
                        $sql = "SELECT * FROM tasks where project_id=$project_id;";
                        $result = $conn->query($sql);
            
                        if ($result->num_rows > 0) {
                          // Output a dropdown menu for each project name
                          while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['task_name'] .'</td>';
                            echo '<td>' . $row['user_email'] . '</td>';
                            echo '<td>' . $row['status'] . '</td>';
                            echo '<td>' . $row['due_date'].'</td>';
                            echo '</tr>';
                          }
                        } 
                        ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="project-access" id="p-access" style="display: none">
            <div class="visibility">
              <h4>Visibility:</h4>
              <form action="" style="margin-bottom: 15px">
                <input
                  type="radio"
                  id="private"
                  name="access"
                  value="Private"
                  style="margin-left: 0"
                />
                <label for="private" class="radio-label">Private</label>
                <input
                  type="radio"
                  id="public"
                  name="access"
                  value="Public"
                  style="margin-left: 20px"
                />
                <label for="public" class="radio-label">Public</label>
              </form>

              <hr />
            </div>
          </div>

          <div class="project-team" id="p-team" style="display: none">
            <div class="visibility">
              <h4>Team</h4>
              <a href="memberOverlay" class="ancher-tag" id="memberLink">
                <div style="display: flex">
                  <img
                    class="imagey"
                    src="/sources/images/plus-blue.svg"
                    alt=""
                  />
                  <span class="image-text">Add member</span>
                </div>
              </a>

              <div class="overlayy" id="memberOverlay">
                <div class="overlay-content" id="memberOverlayContent">
                  <!-- Members list or "No members added" message goes here -->
                </div>
              </div>
            </div>

            <div class="project-list">
              <div class="task-list">
                <table>
                  <thead>
                    <tr>
                      <td>Name</td>
                      <td>Role</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody id="p-table-body"></tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="project-files" id="p-files" style="display: none">
            <div class="visibility">
              <h4>File and attachments</h4>
              <form
                action="upload.php"
                method="POST"
                enctype="multipart/form-data"
              >
                <input type="file" name="file" />
                <input type="submit" value="Upload" />
              </form>

              <div class="project-list" style="margin: 25px 0">
                <table>
                  <thead>
                    <tr>
                      <td>Files</td>
                    </tr>
                  </thead>
                  <tbody id="p-table-body"></tbody>
                </table>
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

    <?php include "templates/footer.php"; ?>