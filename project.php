<?php include "templates/header.php"; ?>
<?php include "templates/sidebar.php"; ?>

  <div class="overlay" id="overlay">
    <div class="form-container">
      <h2>Create New Project</h2>
      <hr />
      <form action="classes/createproject.php" method="POST" class="create-form">
        <div class="filteration">
          <input type="text" name="projectName" placeholder="Project Name" class="input" required />
          <input type="text" name="teamMembers" class="input" placeholder="Add Team Members" />
          
        </div>

        <div class="filteration">
          <div class="input" style="padding-right: 2px">
            <label class="access">Access: </label>
            <input type="radio" id="private" name="access" <?php if (isset($access) && $access=="private") echo "checked";?> value="Private" />
            <label for="private" class="radio-label">Private</label>
            <input type="radio" id="public" name="access" <?php if (isset($access) && $access=="public") echo "checked";?> value="Public" />
            <label for="public" class="radio-label">Public</label>
          </div>
        </div>
        <div class="filteration">
          <div class="input" style="
                display: inline-flex;
                align-items: center;
                margin-bottom: 15px;
                padding-right: 2px;
              ">
            <label for="deadline" style="margin-right: 12px">Deadline:
            </label>
            <input type="date" name="deadline" id="deadline" /><br><br>
          </div>
        </div>
        <input type="submit" value="Submit" id="create-project">
      </form>
    </div>
  </div>
  <div class="container">
    <div class="title">
      <div class="project-bar">
        <div class="add-heading">Project</div>

        <div class="add-btnp">
          <div class="label">
            <input id="add-project-button" type="submit" value="Create New Project" />
          </div>
        </div>
      </div>
    </div>

    <div class="filter-bar">
      <div class="filteration">
        <span class="fx1">Filter </span>
        <div class="flex">
          <span class="fx2">All</span>
        </div>
        <div class="flex">
          <span class="fx3">Status</span>
        </div>
        <div class="flex">
          <span class="fx4">Access</span>
        </div>
        <div class="flex">
          <span class="fx5">
            <input id="apply-button" class="pro-apply" type="submit" value="Apply" disabled />
          </span>
        </div>
      </div>
    </div>
    <div class="search-bar">
      <div class="icon">
        <img style="margin: 8px" src="images/search.svg" alt="" />
      </div>
      <div class="find">
        <div class="search">Search</div>
      </div>
    </div>

    <br/><br/>
    <div class="project-list">
      <div class="pro-list">
        <table>
          <thead>
            <tr>
              <td>Project name</td>
              <td>Total Members</td>
              <td>Access</td>
              <td>Deadline</td>
              <td>Status</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>
          <?php
           include("classes/config.php");

            // Retrieve project names from the database table
            $sql = "SELECT project_id, project_name, team, access, deadline,status FROM projects";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // Output a dropdown menu for each project name
              while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['project_name'] . '</td>';
                // Display the rest of the project information
                echo '<td>'. $row['team'] . '</td>';
                if($row['access']==0)
                {echo '<td>private</td>';}
                else{
                  echo '<td>public</td>';
                }
                echo '<td>' . $row['deadline'] . '</td>';
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
  

  <?php include "templates/footer.php"; ?>